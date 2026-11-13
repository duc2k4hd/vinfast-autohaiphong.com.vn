# KIỂM ĐỊNH CƠ SỞ DỮ LIỆU TOÀN DIỆN (DATABASE AUDIT V2)

## 1. Hiện Trạng Cấu Trúc Bảng (Schema Status)
Hệ thống gồm 17 migrations đã chạy thành công trong MySQL:
- `users`: Bảng quản trị viên.
- `settings`: Cấu hình hệ thống (15 bản ghi).
- `product_categories`: Phân loại xe (Ô tô điện du lịch, Xe thương mại).
- `products`: 15 dòng xe điện VinFast.
- `product_variants`: Bảng biến thể phiên bản/màu sắc (Hiện trạng: 0 bản ghi).
- `product_specifications`: 117 cặp Key-Value thông số kỹ thuật xe.
- `posts`: Bài viết tin tức (3 bản ghi).
- `media`: Quản lý tài nguyên media tập trung (18 bản ghi).
- `orders`, `order_items`, `payment_records`: Bảng xử lý đơn đặt cọc tiền mặt.
- `leads`: Bảng tiếp nhận thông tin khách hàng cần báo giá lăn bánh.
- `seo_metadata`: Bảng mở rộng cấu hình SEO theo trang/thực thể.
- `audit_logs`: Bảng nhật ký thao tác hệ thống.

## 2. Kế Hoạch Bổ Sung Dữ Liệu An Toàn
**Nguyên tắc bất khả xâm phạm:**
- **TUYỆT ĐỐI KHÔNG** chạy `migrate:fresh`, `db:wipe` hoặc xóa dữ liệu sản phẩm, media, bài viết hiện có.
- Mọi bổ sung đều thực hiện qua Seeder hoặc Migration thêm cột an toàn có kiểm tra `Schema::hasColumn()`.

## 3. Các Nhiệm Vụ Database Trong Đợt Nâng Cấp V2
1. **Nạp Dữ Liệu Biến Thể Cho Các Dòng Xe Chủ Lực (`product_variants`):**
   - VinFast VF 3: Phiên bản Tiêu chuẩn (Thuê pin / Kèm pin).
   - VinFast VF 5 Plus: Phiên bản Plus (Thuê pin / Kèm pin).
   - VinFast VF 6: Phiên bản Base / Plus.
   - VinFast VF 7: Phiên bản Base / Plus.
   - VinFast VF 8: Phiên bản Eco / Plus.
   - VinFast VF 9: Phiên bản Eco / Plus (6 chỗ / 7 chỗ).
2. **Đảm Bảo Tính Toàn Vẹn Khóa Ngoại:**
   - Không cho phép xóa vật lý sản phẩm nếu đang có `order_items` tham chiếu.
   - Không xóa file media nếu đang có `products.thumbnail_media_id` hoặc `posts.featured_media_id` sử dụng.

