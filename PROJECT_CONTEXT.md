# PROJECT_CONTEXT — VinFast Hải Phòng

## Tổng quan
Website VinFast Hải Phòng được xây dựng bằng Laravel 13, tái tạo độ trung thực cao nhất từ https://vinfast-haiphong.com/
Đơn vị vận hành: VinFast Minh Đạo Hải Phòng (Đại lý ủy quyền chính thức của VinFast Việt Nam).

## Thông tin liên hệ chính thức (Official Contact Info)
- **Hotline Bán hàng:** `0988 302 882`
- **Dịch vụ – Phụ tùng:** `0915 286 506`
- **CSKH Kinh doanh:** `0915 286 503`
- **CSKH Dịch vụ:** `0843 714 333`
- **Giờ làm việc:**
  - Thứ 2 – Thứ 7: Dịch vụ (7h50 – 17h00) | Kinh doanh (7h30 – 18h00)
  - Chủ nhật: Dịch vụ & phụ tùng nghỉ | Kinh doanh (7h00 – 18h00)
- **Fanpage Facebook:** `https://www.facebook.com/VinFastMinhDao`
- **Địa chỉ showroom:** Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng

## QUY TẮC GIT BẮT BUỘC (CRITICAL GIT RULES)
- **AI TUYỆT ĐỐI KHÔNG ĐƯỢC CHẠY BẤT KỲ LỆNH GIT NÀO** (không `git init`, `git add`, `git commit`, `git push`, `git checkout`...).
- Mọi thao tác git đều do NGƯỜI DÙNG tự tay thực hiện.
- AI chỉ có trách nhiệm chuẩn bị và hiển thị nội dung commit mẫu bằng tiếng Việt có dấu rõ ràng ở cuối mỗi báo cáo.

## QUY TẮC BẮT BUỘC ĐẶT TÊN CLASS HTML & CSS (PROJECT CONVENTION)
Mọi class HTML trong Blade template và file CSS bắt buộc phải có tiền tố phân loại phạm vi:
1. **Phía Client:** Bắt buộc bắt đầu bằng `vinfast-autohaiphong_`, phân chia theo từng trang và khối:
   - Khối dùng chung: `vinfast-autohaiphong_layout_`, `vinfast-autohaiphong_header_`, `vinfast-autohaiphong_footer_`, `vinfast-autohaiphong_modal_`, `vinfast-autohaiphong_btn_`, `vinfast-autohaiphong_card_`
   - Trang chủ: `vinfast-autohaiphong_home_` (ví dụ: `vinfast-autohaiphong_home_hero`, `vinfast-autohaiphong_home_grid`, `vinfast-autohaiphong_home_car_card`)
   - Trang danh mục: `vinfast-autohaiphong_catalog_` (ví dụ: `vinfast-autohaiphong_catalog_filter`, `vinfast-autohaiphong_catalog_grid`)
   - Trang chi tiết xe: `vinfast-autohaiphong_product_` (ví dụ: `vinfast-autohaiphong_product_gallery`, `vinfast-autohaiphong_product_specs`)
   - Trang giỏ hàng & thanh toán: `vinfast-autohaiphong_cart_`, `vinfast-autohaiphong_checkout_`
   - Trang tin tức: `vinfast-autohaiphong_blog_`
2. **Phía Admin:** Bắt buộc bắt đầu bằng `vinfast-autohaiphong_admin_`, phân chia theo từng trang:
   - `vinfast-autohaiphong_admin_dashboard_`
   - `vinfast-autohaiphong_admin_product_`
   - `vinfast-autohaiphong_admin_media_`
   - `vinfast-autohaiphong_admin_order_`
   - `vinfast-autohaiphong_admin_lead_`
   - `vinfast-autohaiphong_admin_settings_`

## Trạng thái hiện tại
- Giai đoạn: Hoàn thiện Client UI & Admin Nền tảng
- Khởi tạo: 2026-11-13
- Trạng thái DB: 14 migrations đã thực thi hoàn chỉnh (34 bảng)

## Công nghệ
- Backend: Laravel 13.42.0
- PHP: 8.4.4
- Database: MySQL 8.0+
- Template: Blade
- Build: Vite
- Font: Open Sans duy nhất toàn hệ thống

## Kiến trúc
- Client: `app/Http/Controllers/Client/`, `resources/views/clients/`, `resources/css/clients/`, `resources/js/clients/`
- Admin: `app/Http/Controllers/Admin/`, `resources/views/admin/`, `resources/css/admin/`, `resources/js/admin/`
- Shared: `app/Services/Shared/` (`SettingsService`, `MediaService`), `app/Models/`

## Quyết định nghiệp vụ cốt lõi
1. **Thanh toán:** Duy nhất tiền mặt (`cash` only). Không có cổng thanh toán online.
2. **Font:** Open Sans duy nhất toàn hệ thống.
3. **SSR:** Blade Server-Side Rendering tối ưu SEO và tốc độ tải đầu trang.
4. **Hiệu năng:** Tối ưu hóa câu truy vấn trước, cache sau. Không để N+1.
5. **Class CSS/HTML:** Luôn có tiền tố `vinfast-autohaiphong_` hoặc `vinfast-autohaiphong_admin_`.
