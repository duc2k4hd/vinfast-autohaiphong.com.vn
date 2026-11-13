# KHẢO SÁT HIỆN TRẠNG HỆ THỐNG (CURRENT SYSTEM AUDIT V2)

## 1. Kết Quả Khảo Sát Mã Nguồn Hiện Tại
### 1.1. Cấu Trúc Tuyến Đường (Routes)
- Tổng số tuyến đường: 49 routes.
- Nhóm Client: 18 routes (Trang chủ, danh mục, phân trang `/o-to-vinfast/page/{page}`, chi tiết xe, giỏ hàng, đặt cọc tiền mặt, tin tức, liên hệ, chính sách, sitemap, robots).
- Nhóm Admin: 23 routes (Auth, dashboard, products, orders, leads, posts, media, settings).
- Tuyến API: 1 route (`/api/user`).

### 1.2. Cơ Sở Dữ Liệu Thực Tế
Dữ liệu đo đạc trực tiếp từ database MySQL:
- `users`: 1 bản ghi (Super Admin `admin@vinfast-autohaiphong.com.vn`).
- `products`: 15 dòng xe VinFast đầy đủ (`thumbnail_media_id`, giá niêm yết, giá khuyến mãi).
- `product_variants`: 0 bản ghi -> **Cần bổ sung seed/quản lý biến thể (phiên bản xe, màu sắc) cho các dòng xe chủ lực**.
- `product_specifications`: 117 cặp Key-Value chuẩn hóa.
- `posts`: 3 bài viết tin tức.
- `media`: 18 bản ghi tài nguyên ảnh tập trung.
- `orders`: 0 đơn hàng thực tế (sẵn sàng cho tiếp nhận đơn cọc).
- `leads`: 0 leads khách hàng (sẵn sàng cho form tư vấn).
- `settings`: 15 cấu hình hệ thống (hotline 4 số, giờ làm việc, địa chỉ, fanpage Facebook, SEO mặc định).

### 1.3. Kiểm Thử Baseline
- Kết quả chạy `php artisan test --compact`:
  - Số lượng bài test: **28 tests**
  - Số lượng assertions: **119 assertions**
  - Trạng thái: **100% Passed**
  - Thời gian thực thi: **1.57 giây**

### 1.4. Đánh Giá Điểm Yếu & Khoảng Cách Cần Nâng Cấp Lên V2
1. **Admin Editor:**
   - Hiện tại: Trang biên tập sản phẩm (`admin/products/edit.blade.php`) và bài viết (`admin/posts/edit.blade.php`) đang sử dụng thẻ `<textarea>` thô đơn giản cho phần nội dung mô tả chi tiết HTML.
   - Khoảng cách: Chưa có TinyMCE, chưa có công cụ chọn ảnh từ Thư viện Media trực tiếp trong khung soạn thảo, chưa có autosave và preview theo phong cách Client.
2. **Giao Diện Admin:**
   - Hiện tại: Thiết kế giao diện admin khá tối giản nhưng mang tính boilerplate.
   - Khoảng cách: Cần chuẩn hóa theo design system doanh nghiệp cao cấp (Stripe/Linear), bố cục bảng dữ liệu (Data Table) với toolbar tìm kiếm, lọc trạng thái, phân trang rõ ràng, modal xác nhận hành động hủy/xóa, và empty state chuyên nghiệp.
3. **Quản Lý Biến Thể (Variants):**
   - Hiện tại: Bảng `product_variants` chưa có dữ liệu và chưa có giao diện trực quan trong Admin để thêm/sửa màu sắc, phiên bản pin (Eco, Plus, Thuê pin, Mua đứt pin).
4. **Hệ Thống Phân Tích SEO Trong Admin:**
   - Hiện tại: Nhập thủ công các trường SEO title, description.
   - Khoảng cách: Cần học hỏi từ `nobifashion.vn` để bổ sung tính năng phân tích SEO trực tiếp (word count, reading time, keyword density, điểm tối ưu SEO) ngay khi đang viết bài hoặc chỉnh sửa xe.

