# Phân Tích & Bảng Thành Phần Giao Diện (Reference Components) — vinfast-haiphong.com

## 1. Thành phần Dùng Chung (Global Shared Components)
- **Header Topbar (`.vinfast-autohaiphong_header_topbar`):**
  - Chứa địa chỉ showroom, giờ làm việc chi tiết (T2–T7 & Chủ nhật), 4 số hotline và liên kết Fanpage Facebook.
  - Phân tách bằng thanh ngăn cách mảnh `|`, nền surface xám nhẹ `#f8fafc`.
- **Header Main Navigation (`.vinfast-autohaiphong_header_main`):**
  - Thanh mảnh, tinh tế theo chuẩn thiết kế ảnh 2.
  - Logo chính thức `vinfast-haiphong.png` với kích thước 155x36px.
  - Menu phân cấp: `VinFast Hải Phòng`, `Ô Tô VinFast ˅` (Dropdown danh sách 15 xe), `Pin & Trạm Sạc`, `Tin Tức`, `Liên Hệ`.
  - Nút Mobile menu toggle chuyển đổi menu dạng trượt mượt mà.
- **Footer Section (`.vinfast-autohaiphong_footer_main`):**
  - Bố cục 4 cột: Thông tin đại lý 3S & 4 hotline chuyên trách; Danh sách dòng xe; Chính sách pháp lý; Form đăng ký tư vấn báo giá.
  - Dải bản quyền dưới cùng: Phương thức thanh toán duy nhất tiền mặt tại Showroom.
- **Floating CTA Widget (`.vinfast-autohaiphong_floating_wrapper`):**
  - Nút gọi hotline cố định góc phải màn hình (`tel:0988302882`).
  - Nút chat Zalo (`https://zalo.me/0988302882`).
- **Modal Báo Giá Lăn Bánh (`#vf-quote-modal`):**
  - Tự động nhận diện ID xe và tên xe khi bấm nút "Báo Giá Lăn Bánh" từ bất kỳ vị trí nào trên website.
  - Xác thực CSRF, thu thập họ tên, số điện thoại, ghi nhận consent vào database.

## 2. Thành phần Trang Chủ (Home Components)
- **Hero Banner Slider (`.vinfast-autohaiphong_home_hero`):**
  - Tích hợp 3 banner đồ họa thực tế của VinFast, hỗ trợ trượt tự động (autoplay 5s) và nút điều hướng chuyển slide trái/phải tinh tế.
- **Lưới Sản Phẩm Xe (`.vinfast-autohaiphong_home_grid`):**
  - Giới hạn chuẩn `max-width: 1200px`.
  - Thẻ card xe (`.vinfast-autohaiphong_home_car_card`): Ảnh đại diện 16:9, nhãn phân loại, tên xe liên kết chi tiết, khối giá niêm yết rõ ràng, đặc tính xe và 2 nút hành động (Báo Giá Lăn Bánh, Xem Chi Tiết).
- **Section Pin & Trạm Sạc (`.vinfast-autohaiphong_home_section_surface`):**
  - Nền xám nhẹ `#f8fafc`, 2 khối thống kê nổi bật (150.000+ cổng sạc, 10–25 phút sạc nhanh) và ảnh minh họa hạ tầng.
- **Section Tin Tức Mới Nhất:**
  - Lưới 3 cột bài viết, hiển thị ngày đăng, ảnh đại diện, tiêu đề và trích đoạn ngắn gọn.

## 3. Thành phần Trang Chi Tiết Dòng Xe (`/xe/{slug}`)
- **Breadcrumb Navigation:**
  - Điều hướng phân cấp: Trang chủ / Ô Tô VinFast / Tên dòng xe.
- **Gallery Ảnh Xe:**
  - Khung ảnh lớn và lưới 4 ảnh thumbnails phía dưới có tính năng nhấp đổi ảnh trực tiếp.
- **Bảng Thông Số Kỹ Thuật (Key-Value):**
  - Đặt ở **VỊ TRÍ ĐẦU TIÊN** trong phần nội dung xe để trích xuất và hiển thị siêu tốc.
  - Các dòng xen kẽ zebra shading nhẹ nhàng, phân tách nhãn (Key) và giá trị (Value).
- **Khối Mô Tả Chi Tiết (HTML Description):**
  - Trình bày bài viết giới thiệu thiết kế, nội thất, công nghệ pin và hệ thống an toàn ADAS.
- **Danh Sách Xe Cùng Phân Khúc (Related Cars):**
  - Lưới các mẫu xe liên quan giúp khách hàng dễ dàng tham khảo so sánh.

## 4. Thành phần Giỏ Hàng & Checkout Tiền Mặt
- **Giỏ Hàng (`/gio-hang`):**
  - Bảng danh sách xe đã chọn, số lượng, đơn giá tự động tính lại từ database, tổng tiền cọc tạm tính.
- **Thanh Toán Tiền Mặt (`/thanh-toan`):**
  - Form thu thập thông tin người đặt cọc (Họ tên, Điện thoại, Địa chỉ, Ghi chú).
  - Phương thức thanh toán duy nhất được khóa cố định: `cash` (Nộp tiền mặt trực tiếp tại Showroom VinFast Minh Đạo Hải Phòng - Số 1 Bạch Đằng).
  - Khóa bảo vệ idempotency key chống gửi trùng lặp đơn.
- **Trang Đặt Hàng Thành Công (`/dat-hang-thanh-cong/{order_number}`):**
  - Hiển thị mã đơn hàng dạng `VFHP-YYYYMMDD-XXXX`, tổng tiền cọc và bản đồ/hướng dẫn đến trực tiếp showroom nộp tiền mặt.

