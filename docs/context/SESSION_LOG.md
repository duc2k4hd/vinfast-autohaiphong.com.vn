# Nhật Ký Các Phiên Làm Việc (Session Log) — VinFast Hải Phòng

## Phiên làm việc: 2026-11-13 10:45

### 1. Đã hoàn thành:
- **Kiểm tra môi trường:** Laravel 13.42.0, PHP 8.4.4, MySQL 8.0, Node.js v24.18.0, npm 11.16.0.
- **Audit website tham chiếu (`vinfast-haiphong.com`):**
  - Thu thập sitemap Rank Math (`page-sitemap.xml`, `product-sitemap.xml`, `post-sitemap.xml`, `category-sitemap.xml`).
  - Xác minh 15 dòng xe: VF 2, VF 3, VF 5, VF 6, VF 7, VF 8, VF 8 All New, VF 9, VF Wild, VF MPV 7, EC Van, Limo Green, Nerio Green, Herio Green, Minio Green.
  - Tạo 5 tài liệu trong `docs/audit/`: `REFERENCE_URL_INVENTORY.md`, `REFERENCE_PAGE_MATRIX.md`, `REFERENCE_DESIGN_TOKENS.md`, `REFERENCE_DATA_AUDIT.md`, `REFERENCE_UNVERIFIED.md`.
- **Thiết kế & Thực thi Cơ sở dữ liệu (Giai đoạn 2):**
  - 14 migration files bao gồm: `settings`, `roles`, `media`, `product_categories`, `products`, `product_variants`, `product_specifications`, `posts`, `content_tables`, `commerce_tables`, `crm_tables`, `seo_tables`, `import_tables`, `audit_logs`.
  - Tiền tệ lưu trữ dạng `BIGINT UNSIGNED` (VNĐ).
  - Tối ưu độ dài khóa trên `utf8mb4` (191 ký tự đối với trường unique).
  - Tạo tài liệu thiết kế: `docs/database/ERD.md`, `docs/database/SCHEMA.md`, `docs/database/INDEXES.md`.
- **Dịch vụ dùng chung (Shared Services):**
  - `SettingsService`: Singleton, in-memory memoization, nạp cấu hình `autoload`, cache 24h, xóa cache khi update.
  - `AppServiceProvider`: View Composer tự động truyền `$siteSettings` (chỉ trường public) vào `clients.*`.
  - `MediaService`: Upload tập trung, SHA256 checksum chống tải trùng, quản lý quan hệ đa hình `media_usages`.
  - Chạy `php artisan storage:link`.
  - Khởi tạo `InitialSettingsSeeder` và `InitialCarsSeeder` (nạp đủ 15 mẫu xe vào DB).
- **Quy tắc bắt buộc theo yêu cầu người dùng:**
  - Cập nhật quy ước vào `PROJECT_CONTEXT.md`: Toàn bộ class HTML trong Blade và CSS bắt buộc phải có tiền tố `vinfast-autohaiphong_` (cho Client) hoặc `vinfast-autohaiphong_admin_` (cho Admin).
  - Chuẩn hóa các class trong: `app.css`, `header.blade.php`, `footer.blade.php`, `quote-modal.blade.php`, `home/index.blade.php`.
- **Frontend & Assets:**
  - Cài đặt `npm install` (60 packages).
  - Cấu hình Vite tự nạp font **Open Sans** (các weight 300, 400, 500, 600, 700, 800) dưới dạng woff/woff2.
  - Chạy `npm run build` tạo `public/build/manifest.json`.
- **Kiểm thử & Định dạng:**
  - Viết `tests/Feature/HomeTest.php`: Kiểm tra trang chủ HTTP 200 OK, hiển thị đầy đủ tên xe, kiểm tra tiếp nhận lead lưu vào DB.
  - Chạy `php artisan test --compact --filter=HomeTest` -> **PASS (2 tests, 9 assertions, 499ms)**.
  - Chạy `vendor/bin/pint --format agent` -> Format code sạch sẽ 100%.

### 2. Vấn đề đã giải quyết:
- Lỗi MySQL key too long trên `utf8mb4` -> Chuẩn hóa trường string unique về 191 ký tự an toàn.
- Lỗi thiếu Vite manifest khi render view -> Chạy `npm install` và `npm run build` tạo manifest hoàn chỉnh.
- Lỗi thiếu bảng trong SQLite khi chạy test -> Thêm trait `RefreshDatabase` và nạp Seeder trong `setUp()`.

### 3. Công việc tiếp theo:
- Xây dựng trang danh mục sản phẩm `/o-to-vinfast/` (CatalogController, CatalogService, catalog/index.blade.php).
- Xây dựng trang chi tiết từng dòng xe `/xe/{slug}/` (ProductController, ProductService, gallery, bộ chọn phiên bản, màu xe, thông số kỹ thuật).
- Xây dựng giỏ hàng và đặt cọc tiền mặt duy nhất (`/gio-hang/`, `/thanh-toan/`).
- Xây dựng giao diện quản trị Admin (`/admin/dashboard`, `/admin/products`).
