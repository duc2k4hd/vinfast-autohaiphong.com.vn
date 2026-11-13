# Phân Tích Hành Vi Tương Tác (Reference Interactions) — vinfast-haiphong.com

## 1. Hành Vi Điều Hướng Menu (Navigation Interactions)
- **Hover / Active State:**
  - Menu item đổi màu sang xanh thương hiệu `#1464f4` với hiệu ứng chuyển tiếp mềm mại (transition: color 0.15s ease).
  - Mục trang hiện tại nhận class `.active` với đường viền gạch chân hoặc màu xanh nhận diện.
- **Dropdown Menu Xe Ô Tô:**
  - Kích hoạt khi rê chuột trên Desktop (hover intent) với độ trễ chuyển động vừa phải, đóng mượt mà khi rời chuột.
  - Trên Mobile: Nhấp để mở rộng danh sách dạng accordion trượt xuống.
- **Mobile Menu Toggle:**
  - Nhấp vào nút hamburger 3 gạch chuyển đổi icon sang dấu X đóng menu, mở thanh trượt điều hướng từ phải/trên xuống.
  - Tự động đóng menu khi nhấp vào vùng backdrop bên ngoài hoặc khi bấm chọn một liên kết.

## 2. Tương Tác Banner & Slider (Hero Slider Interactions)
- **Tự động chuyển slide (Autoplay):** Chu kỳ 5.000ms (5 giây) tự động chuyển sang banner kế tiếp.
- **Điều khiển thủ công:**
  - Hai nút mũi tên tròn điều hướng trái (`‹`) và phải (`›`) bán trong suốt, phóng to nhẹ khi hover (`transform: scale(1.05)`).
  - Tương tác vuốt chạm (touch swipe) hỗ trợ trên thiết bị di động.

## 3. Tương Tác Modal Báo Giá (Quote Modal Interactions)
- **Mở Modal:**
  - Nhấp vào bất kỳ nút "Báo Giá Lăn Bánh" nào trên trang chủ, danh mục hoặc chi tiết xe.
  - Tự động điền ID và Tên dòng xe tương ứng vào form popup mà không cần tải lại trang.
- **Đóng Modal:**
  - Nhấp vào nút đóng `&times;` ở góc trên bên phải.
  - Nhấp vào vùng nền mờ backdrop bên ngoài form.
  - Nhấn phím `Escape` trên bàn phím.
- **Xử lý Submit Form Báo Giá:**
  - Kiểm tra tính hợp lệ của định dạng số điện thoại Việt Nam (10–11 chữ số, đầu 03, 05, 07, 08, 09).
  - Vô hiệu hóa nút gửi (`disabled`) khi đang gửi nhằm chống click đúp.
  - Hiển thị thông báo thành công trực quan sau khi dữ liệu lưu vào database.

## 4. Tương Tác Gallery Ảnh Xe (Product Gallery Interactions)
- **Đổi Ảnh Chính:**
  - Rê chuột hoặc nhấp vào từng ảnh thumbnail nhỏ phía dưới khung ảnh lớn.
  - Ảnh chính cập nhật nguồn ảnh `src` ngay lập tức với hiệu ứng mờ dần nhẹ nhàng (`opacity fade`).
- **Phóng to xem chi tiết:**
  - Hỗ trợ xem hình ảnh độ phân giải cao khi người dùng tương tác trên desktop.

## 5. Tương Tác Đặt Cọc Tiền Mặt (Cash Checkout Interactions)
- **Giỏ Hàng & Cập Nhật Số Lượng:**
  - Người dùng có thể điều chỉnh số lượng xe muốn đặt cọc, bấm cập nhật để hệ thống tính lại tổng giá trị tiền cọc.
  - Nút xóa sản phẩm với hộp thoại xác nhận nhanh trước khi gỡ khỏi giỏ.
- **Bảo Vệ Đơn Hàng:**
  - Tạo `idempotency_key` duy nhất tại thời điểm tải form checkout.
  - Khi submit form thanh toán, khóa nút gửi và hiển thị trạng thái "Đang xử lý...", ngăn chặn người dùng gửi liên tiếp tạo nhiều đơn trùng lặp.
  - Chuyển hướng tức thì sang trang thành công kèm mã tra cứu đơn hàng duy nhất `VFHP-YYYYMMDD-XXXX`.

