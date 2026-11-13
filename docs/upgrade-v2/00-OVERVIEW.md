# TỔNG QUAN NÂNG CẤP HỆ THỐNG V2 (OVERVIEW V2) — VINFAST HẢI PHÒNG

## 1. Mục Tiêu Dự Án
Dự án **VinFast Hải Phòng V2** là bước nâng cấp toàn diện hệ thống hiện có trên nền tảng **Laravel 13, Blade, MySQL 8, Vite** theo định hướng:
- **Tiêu chuẩn thiết kế:** Tinh tế, tối giản, trung tính, sáng sủa, tiết chế theo triết lý của `evondevKit (ui-ux skill)`. Loại bỏ hoàn toàn cảm giác AI generic, gradient sặc sỡ, card/shadow dày đặc.
- **Trải nghiệm Admin:** Thiết kế giao diện như một phần mềm quản trị doanh nghiệp chuyên nghiệp (tham chiếu Stripe Dashboard, Shopify Admin, Linear), thao tác trực quan, dễ dùng cho nhân viên bán hàng và biên tập viên không có kiến thức kỹ thuật.
- **Trình soạn thảo TinyMCE:** Tích hợp TinyMCE chính hãng sử dụng API key `APP_TINYMCE_KEY` từ `.env` qua `config/services.php`, liên kết chặt chẽ với Thư viện Media nội bộ, hỗ trợ upload ảnh, làm sạch mã nguồn (HTML sanitizer) khi dán nội dung từ Word/Web, autosave và revision preview.
- **Học hỏi SEO từ Nobi Fashion (`E:\Project\Laravel\nobifashion.vn`):** Kế thừa kiến trúc phân tích SEO nội dung real-time (keyword density, reading time, content score), thẻ meta social mở rộng, schema JSON-LD, sitemap HTML/XML và security headers.
- **Độ tin cậy & Chống lỗi hồi quy (Regression Prevention):** Mở rộng bộ test suite từ baseline 28 tests lên hệ thống kiểm thử toàn diện Client & Admin liên thông, bảo toàn 100% dữ liệu 15 dòng xe, thông số kỹ thuật Key-Value và cơ chế thanh toán tiền mặt duy nhất tại Showroom Số 1 Bạch Đằng, Hải Phòng.

## 2. Thông Tin Nền Tảng & Môi Trường
- **Framework:** Laravel 13.17, PHP 8.3+ (hiện đang chạy PHP 8.4.4 CLI)
- **Cơ sở dữ liệu:** MySQL 8.0+ (`vinfast-autohaiphong`)
- **Frontend Stack:** Laravel Blade, CSS3, JavaScript ES6+, Vite 8, Tailwind CSS v4, Bun Font Open Sans
- **Editor:** TinyMCE (Tiny Cloud qua `APP_TINYMCE_KEY`)
- **Dự án đối chiếu SEO:** `E:\Project\Laravel\nobifashion.vn` (Đã xác minh tồn tại local)
- **UI/UX Skill:** `evondevKit` (Đã tích hợp trong `.agents/skills/evondevKit/skills/ui-ux`)
- **Tài khoản Admin Quản trị:** `admin@vinfast-autohaiphong.com.vn` (Mật khẩu: `VinfastHaiPhong@2026`)

## 3. Bản Đồ Các Cổng Kiểm Soát (Gate Matrix)
- **GATE 0:** Khảo sát hiện trạng toàn diện & Baseline metrics (Hoàn thành trong đợt này).
- **GATE 1:** Thiết kế & Design System V2 (Áp dụng evondevKit & Open Sans).
- **GATE 2:** Cải tiến nền tảng Admin (Sidebar, Topbar, Data Table, Modal, Toast).
- **GATE 3:** Nâng cấp các luồng nghiệp vụ Admin (Products, Variants, Orders, Leads, Settings).
- **GATE 4:** Tích hợp TinyMCE & Media Picker (Cho Sản phẩm & Tin tức).
- **GATE 5:** Tinh chỉnh toàn diện trải nghiệm Client (Homepage, Catalog, Detail, Cart, Cash Checkout).
- **GATE 6:** Tích hợp giải pháp SEO học hỏi từ Nobi Fashion.
- **GATE 7:** Tối ưu hóa hiệu năng & Query Profiling (Đo lường trước và sau cache).
- **GATE 8:** Kiểm thử hồi quy toàn diện (Full Regression Suite).
- **GATE 9:** Nghiệm thu & Bàn giao sản phẩm.

