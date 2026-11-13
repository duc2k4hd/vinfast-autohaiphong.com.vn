# TIÊU CHÍ NGHIỆM THU CHI TIẾT (ACCEPTANCE CRITERIA V2)

## 1. Tiêu Chí UI/UX & Giao Diện
- [ ] Tuân thủ triết lý `evondevKit`: Tối giản, thanh lịch, nền sáng, không màu mè, không gradient sặc sỡ, không card lòe loẹt.
- [ ] Phông chữ Open Sans chuẩn tiếng Việt hiển thị sắc nét trên mọi thiết bị.
- [ ] Giao diện Admin chuyên nghiệp, dễ sử dụng cho nhân viên không biết lập trình.
- [ ] Responsive hoàn hảo từ 360px (mobile) đến 1920px (desktop), không tràn ngang, không vỡ bảng.
- [ ] Ngôn ngữ giao diện tiếng Việt tự nhiên, lịch sự, không dùng từ dịch máy.

## 2. Tiêu Chí TinyMCE & Soạn Thảo
- [ ] Đọc API key từ `config('services.tinymce.key')` cấu hình trong `.env`, không hardcode.
- [ ] Hoạt động trơn tru trong trang sửa xe và bài viết.
- [ ] Tích hợp tính năng chèn ảnh từ Thư viện Media nội bộ vào bài viết.
- [ ] Tự động làm sạch mã HTML khi paste từ Word/Web mà không bị mất dấu tiếng Việt hay vỡ cấu trúc.
- [ ] Không rò rỉ script hay CSS của TinyMCE sang các trang Client.

## 3. Tiêu Chí SEO (Học Hỏi Nobi Fashion)
- [ ] Phân tích SEO thời gian thực trong Admin (đếm từ, thời gian đọc, cảnh báo thiếu meta).
- [ ] Thẻ Canonical tuyệt đối chính xác cho từng trang.
- [ ] Sitemap XML tự động cập nhật, có HTML sitemap hỗ trợ trải nghiệm duyệt.
- [ ] Structured Data JSON-LD hợp lệ (`AutoDealer`, `Car`).
- [ ] Robots.txt bảo vệ an toàn khu vực `/admin/` và `/dat-hang-thanh-cong/`.

## 4. Tiêu Chí Nghiệp Vụ & Độ Tin Cậy
- [ ] Bảo toàn 100% dữ liệu 15 dòng xe và 117 thông số kỹ thuật Key-Value.
- [ ] Thông số kỹ thuật nằm ở vị trí đầu tiên trên trang chi tiết xe.
- [ ] Thanh toán duy nhất bằng tiền mặt (`cash`) tại Showroom Số 1 Bạch Đằng, Hải Phòng.
- [ ] Bộ kiểm thử hồi quy tự động đạt 100% PASS không có lỗi chéo.
- [ ] Không tự ý chạy bất kỳ lệnh Git nào; chỉ cung cấp commit mẫu có dấu.

