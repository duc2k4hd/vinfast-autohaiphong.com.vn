# KIỂM ĐỊNH LUỒNG LÀM VIỆC CLIENT (CLIENT WORKFLOW AUDIT V2)

## 1. Hành Trình Khách Hàng (Customer Journeys)

### Journey 1: Tìm Hiểu Xe & Yêu Cầu Báo Giá Lăn Bánh
- **Luồng thao tác:**
  `Trang chủ (/)` -> `Xem danh mục xe (/o-to-vinfast)` -> `Trang chi tiết xe (/xe/vinfast-vf-3)` -> `Xem bảng thông số Key-Value đầu tiên` -> `Bấm nút Báo Giá Lăn Bánh` -> `Modal mở ra tự động điền VinFast VF 3` -> `Nhập tên và số điện thoại` -> `Gửi yêu cầu` -> `Hệ thống ghi nhận Lead và hiển thị thông báo thành công`.
- **Yêu cầu nâng cấp V2:**
  - Khóa nút gửi khi bấm tránh gửi đúp (anti-double submit).
  - Validation số điện thoại chặt chẽ ở cả frontend (JS regex) và backend (FormRequest).
  - Giữ lại dữ liệu đã nhập nếu xảy ra lỗi.

### Journey 2: Chọn Xe & Đặt Cọc Tiền Mặt Trực Tiếp Tại Showroom
- **Luồng thao tác:**
  `Trang chi tiết xe (/xe/{slug})` -> `Bấm Đặt Cọc Ngay (/dat-coc-ngay?product_id=...)` -> `Form thanh toán tiền mặt (/thanh-toan)` -> `Hiển thị rõ thông báo: Hình thức thanh toán duy nhất là Tiền mặt tại Showroom VinFast Minh Đạo (Số 1 Bạch Đằng)` -> `Nhập họ tên, điện thoại, địa chỉ` -> `Bấm Hoàn Tất Đặt Cọc` -> `Chuyển sang trang thành công (/dat-hang-thanh-cong/{order_number})`.
- **Yêu cầu nâng cấp V2:**
  - Duy trì `idempotency_key` trong form để chống bấm gửi đơn lặp lại.
  - Trang đặt cọc thành công hiển thị bản đồ chỉ đường, mã đơn cọc `VFHP-YYYYMMDD-XXXX` in đậm, số điện thoại hotline bộ phận bán hàng để khách gọi ngay khi đến showroom.

### Journey 3: Đọc Tin Tức, Cẩm Nang Pin & Trạm Sạc
- **Luồng thao tác:**
  `Menu Tin Tức (/chuyen-muc/tin-tuc)` -> `Chọn bài viết chi tiết` -> `Đọc nội dung bài viết định dạng chuẩn editorial` -> `Xem danh sách bài liên quan` -> `Xem liên kết tư vấn xe ở chân bài viết`.
- **Yêu cầu nâng cấp V2:**
  - Layout bài viết thanh lịch, phông chữ Open Sans chuẩn 16px, chiều cao dòng 1.75 giúp đọc lâu không mỏi mắt.
  - Hiển thị ngày đăng, tác giả và thời gian đọc ước tính (ví dụ: "🕒 4 phút đọc").
  - Mục lục tự động (Table of Contents - TOC) nếu bài viết dài có nhiều thẻ H2, H3.

