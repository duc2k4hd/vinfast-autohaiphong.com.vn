# KẾ HOẠCH & LỘ TRÌNH NÂNG CẤP HỆ THỐNG V2 (UPGRADE ROADMAP)

## Lộ Trình Triển Khai Theo Từng Gate

### Giai Đoạn 1: Hoàn Tất Khảo Sát & Đối Chiếu (GATE 0 & GATE 6 Foundation)
- [x] Đọc và rà soát toàn bộ context, routes, migrations, models, views.
- [x] Tạo đủ 14 tài liệu trong `docs/upgrade-v2/` và `docs/upgrade-v2/qa/`.
- [x] Khảo sát thực tế mã nguồn SEO từ `E:\Project\Laravel\nobifashion.vn`.
- [x] Biên soạn bộ tài liệu so sánh và đối chiếu SEO tại `docs/upgrade-v2/seo/`.
- [x] Tích hợp và kích hoạt `evondevKit` tại `.agents/skills/evondevKit`.

### Giai Đoạn 2: Nâng Cấp Nền Tảng Admin & Design System (GATE 1, GATE 2)
- [x] Chuẩn hóa hệ thống Design System Admin theo `evondevKit` (màu trung tính, bo góc nhẹ, typography Open Sans, phẳng, sạch sẽ).
- [x] Thiết kế lại Sidebar có phân nhóm, Topbar có breadcrumb, Bảng dữ liệu có search, filter, status badge và phân trang server-side rõ ràng.
- [x] Xây dựng component xác nhận hành động (Confirm Dialog) thay thế alert thô.

### Giai Đoạn 3: Tích Hợp TinyMCE & Media Picker (GATE 4)
- [x] Cấu hình API Key qua `config/services.php` lấy từ `APP_TINYMCE_KEY`.
- [x] Tạo Blade Component `admin/components/editor.blade.php` tích hợp TinyMCE chính thức.
- [x] Tích hợp tính năng chèn ảnh từ Thư viện Media nội bộ vào nội dung.
- [x] Xây dựng middleware / helper làm sạch mã HTML (paste sanitizer) chống dính style rác.

### Giai Đoạn 4: Hoàn Thiện Nghiệp Vụ Admin & Biến Thể Xe (GATE 3)
- [x] Nạp và quản lý Biến thể (Variants: phiên bản, pin, màu sắc) cho 15 dòng xe.
- [x] Nâng cấp Dashboard với các chỉ số kinh doanh thực tế, biểu đồ xu hướng 7 ngày phẳng tối giản.
- [x] Nâng cấp quản lý Đơn cọc tiền mặt (In phiếu thu A4, đọc tiền bằng chữ tiếng Việt) và Leads báo giá (lọc, xóa spam lead).
- [x] Quản lý cài đặt cấu hình SEO trang chủ và thông tin showroom tự động làm mới cache.

### Giai Đoạn 5: Tinh Chỉnh Giao Diện Client & Tích Hợp SEO Nobi Fashion (GATE 5, GATE 6)
- [x] Tinh chỉnh Hero Slider (fetchpriority LCP), card xe, bộ chọn biến thể xe có phản hồi đổi giá tức thì.
- [x] Tích hợp công cụ phân tích SEO thời gian thực từ `nobifashion.vn` vào Admin.
- [x] Xây dựng trang HTML Sitemap bổ trợ cho XML Sitemap và mục lục bài viết tự động (TOC).
- [x] Tối ưu hóa mobile drawer với khối liên hệ nhanh và hotline trực tiếp.
- [x] Chuẩn hóa SVG icons trang pin & trạm sạc loại bỏ hoàn toàn emoji AI generic.

### Giai Đoạn 6: Kiểm Thử Toàn Diện & Nghiệm Thu (GATE 7, GATE 8, GATE 9)
- [x] Chạy kiểm thử hồi quy toàn bộ luồng Client & Admin (52 tests, 248 assertions PASS 100%).
- [x] Tối ưu hóa hiệu năng, Pint PSR-12, Vite build (<250ms).
- [x] Cập nhật nhật ký phiên và bàn giao commit mẫu tiếng Việt có dấu.

