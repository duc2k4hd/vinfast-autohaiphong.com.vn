# Giải Trình Thiết Kế Chỉ Mục (Database Indexes Strategy) — VinFast Hải Phòng

## 1. Nguyên Tắc Thiết Kế Chỉ Mục
- Đánh chỉ mục chính xác theo câu lệnh truy vấn thực tế (`WHERE`, `ORDER BY`, `JOIN`, `GROUP BY`).
- Tránh tạo chỉ mục dư thừa làm chậm thao tác `INSERT`/`UPDATE`.
- Ưu tiên chỉ mục kết hợp (Composite Index) có thứ tự: Cột lọc chính xác (`=`) đứng trước, cột phạm vi (`>`, `<`) hoặc sắp xếp (`ORDER BY`) đứng sau.
- Tối ưu hóa độ dài chỉ mục trên bảng mã `utf8mb4` (tối đa 191 ký tự đối với trường chuỗi duy nhất để đảm bảo an toàn với giới hạn 767/1000 bytes của MySQL).

---

## 2. Chi Tiết Các Chỉ Mục Trọng Yếu

### 2.1. Bảng `products`
| Chỉ mục | Các cột | Mục đích truy vấn |
| :--- | :--- | :--- |
| `PRIMARY` | `id` | Khóa chính |
| `UNIQUE` | `slug` | Truy vấn trang chi tiết xe `/xe/{slug}/` (tần suất cực cao) |
| `UNIQUE` | `sku` | Tra cứu mã sản phẩm nội bộ |
| `composite` | `['status', 'published_at']` | Lấy danh sách sản phẩm hợp lệ ra Client (`WHERE status = 'published' AND published_at <= NOW()`) |
| `composite` | `['category_id', 'status', 'sort_order']` | Lấy danh sách xe theo danh mục phân trang và sắp xếp đúng thứ tự |
| `composite` | `['featured', 'status']` | Lấy danh sách các dòng xe nổi bật hiển thị tại trang chủ |

### 2.2. Bảng `product_variants`
| Chỉ mục | Các cột | Mục đích truy vấn |
| :--- | :--- | :--- |
| `composite` | `['product_id', 'is_active', 'sort_order']` | Tải nhanh danh sách phiên bản/màu sắc của một xe khi hiển thị chi tiết |

### 2.3. Bảng `media` & `media_usages`
| Chỉ mục | Các cột | Mục đích truy vấn |
| :--- | :--- | :--- |
| `UNIQUE` | `uuid` | Định danh ảnh công khai |
| `index` | `checksum_sha256` | Chống tải trùng lặp hình ảnh khi nhập liệu tự động |
| `composite` | `['disk', 'folder_id', 'status']` | Quản trị viên duyệt thư viện ảnh theo thư mục |
| `composite` | `['usable_type', 'usable_id', 'role']` | Nạp trước (Eager loading) ảnh theo đối tượng (ví dụ: lấy thumbnail, gallery của sản phẩm) |

### 2.4. Bảng `posts`
| Chỉ mục | Các cột | Mục đích truy vấn |
| :--- | :--- | :--- |
| `UNIQUE` | `slug` | Truy vấn trang chi tiết bài viết `/chuyen-muc/tin-tuc/{slug}` |
| `composite` | `['status', 'published_at']` | Lọc bài viết đã phát hành cho trang tin tức và sitemap |
| `composite` | `['featured', 'status']` | Lấy bài viết tiêu điểm trên trang chủ |

### 2.5. Bảng `orders` & `order_items`
| Chỉ mục | Các cột | Mục đích truy vấn |
| :--- | :--- | :--- |
| `UNIQUE` | `order_number` | Tra cứu đơn hàng nhanh theo mã |
| `UNIQUE` | `idempotency_key` | Chống khách hàng gửi lặp đơn hàng khi mạng lag hoặc bấm đúp |
| `composite` | `['order_status', 'created_at']` | Quản trị viên lọc đơn hàng theo tiến độ thời gian |
| `index` | `customer_phone` | Tìm kiếm lịch sử đặt cọc/mua xe theo số điện thoại khách hàng |

### 2.6. Bảng `leads`
| Chỉ mục | Các cột | Mục đích truy vấn |
| :--- | :--- | :--- |
| `composite` | `['status', 'created_at']` | Admin theo dõi yêu cầu báo giá lăn bánh mới chưa xử lý |
| `composite` | `['type', 'status']` | Lọc lead theo loại (báo giá, lái thử, tư vấn) |
| `index` | `phone` | Tra cứu nhanh số điện thoại tránh trùng lặp lead |

### 2.7. Bảng `settings`
| Chỉ mục | Các cột | Mục đích truy vấn |
| :--- | :--- | :--- |
| `UNIQUE` | `key` | Đọc cấu hình nhanh chóng theo khóa duy nhất |
| `index` | `group` | Lấy tập hợp cấu hình theo từng phân nhóm trong trang quản trị |

