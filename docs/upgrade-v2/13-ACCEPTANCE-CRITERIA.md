# TIÊU CHÍ NGHIỆM THU CHI TIẾT (ACCEPTANCE CRITERIA V2)

## 1. Tiêu Chí UI/UX & Giao Diện
- [x] Tuân thủ triết lý `evondevKit`: Tối giản, thanh lịch, nền sáng, không màu mè, không gradient sặc sỡ, không card lòe loẹt.
- [x] Phông chữ Open Sans chuẩn tiếng Việt hiển thị sắc nét trên mọi thiết bị.
- [x] Giao diện Admin chuyên nghiệp, dễ sử dụng cho nhân viên không biết lập trình (Sidebar phân nhóm rõ ràng, Topbar breadcrumb, Confirm Dialog chuẩn Stripe/Linear).
- [x] Responsive hoàn hảo từ 360px (mobile) đến 1920px (desktop), không tràn ngang, không vỡ bảng.
- [x] Ngôn ngữ giao diện tiếng Việt tự nhiên, lịch sự, không dùng từ dịch máy.

## 2. Tiêu Chí TinyMCE & Soạn Thảo
- [x] Đọc API key từ `config('services.tinymce.key')` cấu hình trong `.env`, không hardcode.
- [x] Hoạt động trơn tru trong trang sửa xe và bài viết.
- [x] Tích hợp tính năng chèn ảnh từ Thư viện Media nội bộ vào bài viết.
- [x] Tự động làm sạch mã HTML khi paste từ Word/Web mà không bị mất dấu tiếng Việt hay vỡ cấu trúc qua `HtmlSanitizer`.
- [x] Không rò rỉ script hay CSS của TinyMCE sang các trang Client.

## 3. Tiêu Chí SEO (Học Hỏi Nobi Fashion)
- [x] Phân tích SEO thời gian thực trong Admin (đếm từ, thời gian đọc, cảnh báo thiếu meta, phân tích slug chuẩn Nobi Fashion).
- [x] Thẻ Canonical tuyệt đối chính xác cho từng trang.
- [x] Sitemap XML tự động cập nhật, có HTML sitemap (`/so-do-trang-web`) hỗ trợ trải nghiệm duyệt.
- [x] Structured Data JSON-LD hợp lệ (`AutoDealer`, `Car`, `NewsArticle`, `ItemList`, `BreadcrumbList`).
- [x] Robots.txt bảo vệ an toàn khu vực `/admin/` và `/dat-hang-thanh-cong/`.

## 4. Tiêu Chí Nghiệp Vụ & Độ Tin Cậy
- [x] Bảo toàn 100% dữ liệu 15 dòng xe, 117 thông số kỹ thuật Key-Value và 20 biến thể pin/phiên bản xe.
- [x] Thông số kỹ thuật nằm ở vị trí đầu tiên trên trang chi tiết xe.
- [x] Thanh toán duy nhất bằng tiền mặt (`cash`) tại Showroom Số 1 Bạch Đằng, Hải Phòng.
- [x] Bộ kiểm thử hồi quy tự động đạt 100% PASS (52/52 tests, 248 assertions) không có lỗi chéo.
- [x] Không tự ý chạy bất kỳ lệnh Git nào; chỉ cung cấp commit mẫu có dấu.
