# KẾ HOẠCH & LỘ TRÌNH NÂNG CẤP HỆ THỐNG V2 (UPGRADE ROADMAP)

## Lộ Trình Triển Khai Theo Từng Gate

### Giai Đoạn 1: Hoàn Tất Khảo Sát & Đối Chiếu (GATE 0 & GATE 6 Foundation)
- [x] Đọc và rà soát toàn bộ context, routes, migrations, models, views.
- [x] Tạo đủ 14 tài liệu trong `docs/upgrade-v2/` và `docs/upgrade-v2/qa/`.
- [x] Khảo sát thực tế mã nguồn SEO từ `E:\Project\Laravel\nobifashion.vn`.
- [x] Biên soạn bộ tài liệu so sánh và đối chiếu SEO tại `docs/upgrade-v2/seo/`.
- [x] Tích hợp và kích hoạt `evondevKit` tại `.agents/skills/evondevKit`.

### Giai Đoạn 2: Nâng Cấp Nền Tảng Admin & Design System (GATE 1, GATE 2)
- Chuẩn hóa hệ thống Design System Admin theo `evondevKit` (màu trung tính, bo góc nhẹ, typography Open Sans, phẳng, sạch sẽ).
- Thiết kế lại Sidebar có phân nhóm, Topbar có breadcrumb, Bảng dữ liệu có search, filter, status badge và phân trang server-side rõ ràng.
- Xây dựng component xác nhận hành động (Confirm Dialog) thay thế alert thô.

### Giai Đoạn 3: Tích Hợp TinyMCE & Media Picker (GATE 4)
- Cấu hình API Key qua `config/services.php` lấy từ `APP_TINYMCE_KEY`.
- Tạo Blade Component `admin/components/editor.blade.php` tích hợp TinyMCE chính thức.
- Tích hợp tính năng chèn ảnh từ Thư viện Media nội bộ vào nội dung.
- Xây dựng middleware / helper làm sạch mã HTML (paste sanitizer) chống dính style rác.

### Giai Đoạn 4: Hoàn Thiện Nghiệp Vụ Admin & Biến Thể Xe (GATE 3)
- Nạp và quản lý Biến thể (Variants: phiên bản, pin, màu sắc) cho 15 dòng xe.
- Nâng cấp Dashboard với các chỉ số kinh doanh thực tế, danh sách việc cần xử lý.
- Nâng cấp quản lý Đơn cọc tiền mặt và Leads báo giá với thao tác nhanh.

### Giai Đoạn 5: Tinh Chỉnh Giao Diện Client & Tích Hợp SEO Nobi Fashion (GATE 5, GATE 6)
- Tinh chỉnh Hero Slider, card xe, bộ chọn biến thể xe có phản hồi đổi giá tức thì.
- Tích hợp công cụ phân tích SEO thời gian thực từ `nobifashion.vn` vào Admin.
- Xây dựng trang HTML Sitemap bổ trợ cho XML Sitemap.

### Giai Đoạn 6: Kiểm Thử Toàn Diện & Nghiệm Thu (GATE 7, GATE 8, GATE 9)
- Chạy kiểm thử hồi quy toàn bộ luồng Client & Admin.
- Tối ưu hóa hiệu năng, Pint PSR-12, Vite build.
- Cập nhật nhật ký phiên và bàn giao commit mẫu tiếng Việt có dấu.

