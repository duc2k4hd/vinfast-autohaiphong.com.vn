# Lược Đồ Cơ Sở Dữ Liệu (Database Schema) — VinFast Hải Phòng

## 1. Nhóm Bảng Hệ Thống & Phân Quyền (System & RBAC)

### `settings`
| Cột | Kiểu | Ràng buộc | Mô tả |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED | PK, AI | Khóa chính |
| `key` | VARCHAR(100) | UNIQUE, NOT NULL | Khóa cấu hình (tiếng Anh snake_case) |
| `group` | VARCHAR(50) | INDEX, DEFAULT 'general' | Nhóm cấu hình (general, contact, company, seo...) |
| `type` | VARCHAR(20) | DEFAULT 'string' | Kiểu dữ liệu (string, integer, boolean, json, text) |
| `value` | LONGTEXT | NULL | Giá trị cấu hình |
| `is_public` | BOOLEAN | DEFAULT FALSE | Cho phép chia sẻ ra Client hay không |
| `autoload` | BOOLEAN | DEFAULT TRUE | Tự động tải khi khởi động ứng dụng |
| `description` | VARCHAR(500) | NULL | Diễn giải cấu hình |
| `updated_by` | BIGINT UNSIGNED | NULL | ID quản trị viên cập nhật |
| `created_at`, `updated_at` | TIMESTAMP | NULL | Thời gian tạo/cập nhật |

### `roles` & `role_user`
- `roles`: Quản lý các vai trò quản trị viên (`super_admin`, `admin`, `editor`, `staff`).
- `role_user`: Bảng pivot liên kết nhiều-nhiều giữa `users` và `roles`.

### `audit_logs`
- Ghi nhận lịch sử thao tác: `event` (login, logout, create, update, delete), `auditable_type`, `auditable_id`, `user_id`, `ip_address`, `old_values`, `new_values`.

---

## 2. Nhóm Bảng Media Quản Lý Tập Trung

### `media_folders`
- `id`, `name`, `path` (VARCHAR(191) UNIQUE), `parent_id` (FK tự liên kết).

### `media`
- `id`, `uuid` (UUID UNIQUE), `disk`, `folder_id` (FK), `path`, `filename`, `original_filename`, `extension`, `mime_type`, `file_size`, `width`, `height`, `checksum_sha256` (INDEX), `alt_text`, `title`, `caption`, `source_url`, `source_license`, `status`, `uploaded_by`, `metadata` (JSON), timestamps.

### `media_usages`
- `id`, `media_id` (FK), `usable_type`, `usable_id`, `role` (thumbnail, hero, gallery, variant, content, banner, og_image), `sort_order`.

---

## 3. Nhóm Bảng Danh Mục & Sản Phẩm Xe (Catalog)

### `product_categories`
- `id`, `name`, `slug` (VARCHAR(150) UNIQUE), `description`, `parent_id` (FK), `thumbnail_media_id` (FK), `status`, `sort_order`, `meta_title`, `meta_description`, timestamps, soft deletes.

### `products`
- `id`, `category_id` (FK), `sku` (VARCHAR(100) UNIQUE NULL), `name`, `slug` (VARCHAR(191) UNIQUE), `short_description`, `description_html`, `regular_price` (BIGINT UNSIGNED VND), `sale_price` (BIGINT UNSIGNED VND), `price_on_request` (BOOLEAN), `status` ('draft', 'published', 'archived'), `featured` (BOOLEAN), `sort_order`, `thumbnail_media_id` (FK), `published_at`, timestamps, soft deletes.

### `product_variants`
- `id`, `product_id` (FK CASCADE), `sku` (VARCHAR(100) UNIQUE NULL), `name` (tên phiên bản: Standard, Plus, Eco...), `color_code` (Hex), `color_name`, `regular_price` (BIGINT UNSIGNED), `sale_price` (BIGINT UNSIGNED), `is_available` (BOOLEAN), `is_active` (BOOLEAN), `sort_order`, `thumbnail_media_id` (FK), timestamps, soft deletes.

### `product_specification_groups` & `product_specifications`
- Lưu thông số kỹ thuật phân nhóm: Quãng đường di chuyển, Dung lượng pin, Công suất tối đa, Thời gian sạc, Kích thước tổng thể...

---

## 4. Nhóm Bảng Bài Viết & Nội Dung (Content & Blog)

### `posts`, `post_categories`, `post_category_relations`, `tags`, `post_tags`
- Quản lý bài viết tin tức, cẩm nang, trạm sạc với đầy đủ metadata SEO và quan hệ nhiều-nhiều.

### `pages`, `banners`, `menus`, `menu_items`
- Quản lý nội dung tĩnh, banner trang chủ (desktop/mobile) và cây điều hướng đa cấp.

---

## 5. Nhóm Bảng Thương Mại (Commerce — Tiền Mặt Duy Nhất)

### `carts` & `cart_items`
- Lưu giỏ hàng phiên hoặc theo người dùng, snapshot đơn giá khi đưa vào giỏ.

### `orders`
- `id`, `order_number` (VARCHAR(30) UNIQUE), `customer_name`, `customer_phone`, `customer_email`, `customer_note`, `subtotal` (BIGINT UNSIGNED), `discount_total` (BIGINT UNSIGNED), `total` (BIGINT UNSIGNED), `currency` (DEFAULT 'VND'), `payment_method` (DEFAULT 'cash' — TIỀN MẶT DUY NHẤT), `payment_status` ('unpaid', 'paid', 'refunded'), `order_status` ('pending', 'confirmed', 'processing', 'completed', 'cancelled'), `idempotency_key` (CHAR(64) UNIQUE chống gửi lặp), `consent_id` (FK), `utm_*`, timestamps, `confirmed_at`, `cancelled_at`.

### `order_items`
- Snapshot bất biến: `product_name`, `product_sku`, `variant_name`, `color_name`, `unit_price`, `quantity`, `line_total`.

### `payment_records`
- Ghi nhận lịch sử thu tiền mặt thực tế tại showroom, có `confirmed_by` và `received_at`.

---

## 6. Nhóm Bảng CRM & Khách Hàng Tiềm Năng (Leads)

### `leads`
- Lưu yêu cầu báo giá lăn bánh, tư vấn, đăng ký lái thử: `type`, `name`, `phone`, `email`, `product_id`, `variant_id`, `utm_*`, `status` ('new', 'contacted', 'qualified', 'converted', 'closed'), `assigned_to`, `message`, `consent_id`.

### `consent_records` & `contact_messages`
- Lưu trữ bằng chứng đồng ý xử lý dữ liệu và tin nhắn liên hệ.

---

## 7. Nhóm Bảng Nhập Liệu & SEO

### `seo_redirects`
- Chuyển hướng 301/302, theo dõi `hit_count`.

### `import_batches` & `import_items`
- Theo dõi lịch sử thu thập dữ liệu nguồn, rollback an toàn theo lô.

