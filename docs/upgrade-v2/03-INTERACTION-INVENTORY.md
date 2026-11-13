# BẢN ĐỒ TƯƠNG TÁC NGƯỜI DÙNG (INTERACTION INVENTORY V2)

## 1. Tương Tác Phía Client
- **Menu & Dropdown Header:**
  - Hover chuyển màu `#1464f4` mượt mà, dropdown hiển thị 15 dòng xe.
  - Mobile: Nút bấm mở drawer trượt sang từ cạnh phải hoặc hạ xuống từ trên, đóng khi chạm backdrop hoặc nhấn phím Escape.
- **Hero Slider:**
  - Chuyển slide tự động 5s, dừng khi rê chuột lên ảnh, 2 nút mũi tên chuyển slide có hiệu ứng phản hồi xúc giác nhẹ.
- **Bộ Lọc Danh Mục & Sắp Xếp Xe:**
  - Click chọn danh mục (Tất cả, Ô tô điện du lịch, Xe thương mại).
  - Dropdown sắp xếp theo giá thấp đến cao, cao đến thấp, mới nhất.
  - Cập nhật URL tham số mà không làm mất trạng thái bộ lọc đang chọn.
- **Bộ Chọn Biến Thể & Màu Sắc Xe (Variant Selector):**
  - Click chọn phiên bản (Ví dụ: VF 3 Tiêu chuẩn / VF 8 Eco / VF 8 Plus): Giá hiển thị tự động cập nhật tương ứng theo phiên bản.
  - Chọn màu sắc ngoại thất: Hiển thị viền active rõ ràng xung quanh ô màu.
- **Modal Báo Giá Lăn Bánh:**
  - Mở từ bất kỳ thẻ xe nào: Tự động gắn tên xe và ID xe.
  - Form validation: Bắt buộc số điện thoại hợp lệ (10 số, đầu 03, 05, 07, 08, 09), khóa nút khi đang gửi để tránh duplicate.
- **Giỏ Hàng & Checkout Tiền Mặt:**
  - Tăng/giảm số lượng xe cọc, cập nhật tổng tiền cọc tự động.
  - Nút "Đặt cọc tiền mặt ngay": Khóa nút và hiển thị trạng thái "Đang ghi nhận đơn cọc...", bảo vệ bằng `idempotency_key`.

## 2. Tương Tác Phía Admin
- **Sidebar Điều Hướng:**
  - Menu phân nhóm rõ ràng (Kinh doanh, Sản phẩm, Nội dung, Hệ thống).
  - Active indicator nổi bật mục đang chọn, hỗ trợ thu gọn trên màn hình hẹp.
- **Bảng Dữ Liệu (Data Tables):**
  - Ô tìm kiếm tức thì, lọc theo trạng thái (Đã xuất bản, Bản nháp, Chờ xác nhận, Đã thu tiền).
  - Phân trang server-side giữ nguyên tham số lọc.
  - Nút hành động xem/sửa/xóa có tooltip tiếng Việt rõ ràng.
- **Modal Xác Nhận Hành Động (Confirm Dialog):**
  - Khi xóa bài viết, xóa ảnh media, hoặc xác nhận đã nhận tiền mặt: Bật modal xác nhận rõ ràng, không dùng `alert()` mặc định của trình duyệt.
- **Khung Soạn Thảo TinyMCE:**
  - Toolbar trực quan, đầy đủ các định dạng H2, H3, Bold, Italic, Bullet, Numbered, Link, Table, Image.
  - Nút "Chèn ảnh từ thư viện" mở Media Picker popup, chọn ảnh và tự động chèn vào vị trí con trỏ chuột.
  - Tự động làm sạch mã nguồn HTML khi paste văn bản từ Word hoặc website khác.
  - Đếm số từ, ước tính thời gian đọc và hiển thị thanh cảnh báo SEO trực quan.

