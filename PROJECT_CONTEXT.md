# PROJECT_CONTEXT — VinFast Hải Phòng

## Tổng quan
Website VinFast Hải Phòng được xây dựng bằng Laravel 13, tái tạo độ trung thực cao nhất từ https://vinfast-haiphong.com/
Hệ thống bao gồm đầy đủ Client (khách hàng) và Admin (quản trị), cơ sở dữ liệu thật, quản lý media tập trung và phương thức thanh toán tiền mặt duy nhất.

## Trạng thái hiện tại
- Giai đoạn: Đang hoàn thiện Client UI & Admin Nền tảng
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

## Routes
- `routes/web.php`: Client routes (tiền tố route name `client.`)
- `routes/admin.php`: Admin routes (tiền tố route name `admin.`, middleware `web`, `auth:admin`)
- `routes/api.php`: API routes

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

## Tình trạng hoàn thành
### Giai đoạn 0 — Audit
- [x] URL inventory (`docs/audit/REFERENCE_URL_INVENTORY.md`)
- [x] Page matrix (`docs/audit/REFERENCE_PAGE_MATRIX.md`)
- [x] Design tokens (`docs/audit/REFERENCE_DESIGN_TOKENS.md`)
- [x] Data audit (`docs/audit/REFERENCE_DATA_AUDIT.md`)
- [x] Unverified items (`docs/audit/REFERENCE_UNVERIFIED.md`)

### Giai đoạn 1 — Foundation
- [x] Git init + local commits
- [x] Cài đặt Laravel Boost (AGENTS.md)
- [x] Cấu trúc thư mục Client/Admin/Shared
- [x] .env đồng bộ (vi_VN, APP_NAME, APP_URL)
- [x] Vite config (Open Sans, client/admin inputs)

### Giai đoạn 2 — Database Design & Migrations
- [x] Bảng `settings` & `InitialSettingsSeeder`
- [x] Bảng `roles`, `role_user`, `audit_logs`
- [x] Bảng `media_folders`, `media`, `media_usages`
- [x] Bảng `product_categories`, `products`, `product_variants`, `product_specifications`
- [x] Bảng `posts`, `post_categories`, `tags`
- [x] Bảng `pages`, `banners`, `menus`, `menu_items`
- [x] Bảng `carts`, `cart_items`, `orders`, `order_items`, `payment_records`
- [x] Bảng `leads`, `consent_records`, `contact_messages`
- [x] Bảng `seo_redirects`, `import_batches`, `import_items`
- [x] Tài liệu `docs/database/ERD.md`, `SCHEMA.md`, `INDEXES.md`

### Giai đoạn 3 — Shared Services
- [x] `SettingsService` (Request-level memoization + cache invalidation)
- [x] `AppServiceProvider` View Composer chia sẻ `$siteSettings` tới `clients.*`
- [x] `MediaService` (Upload tập trung, checksum SHA256 chống trùng, quản lý quan hệ đa hình)
- [x] Symlink `php artisan storage:link`

## Quyết định nghiệp vụ cốt lõi
1. **Thanh toán:** Duy nhất tiền mặt (`cash` only). Không có cổng thanh toán online.
2. **Font:** Open Sans duy nhất toàn hệ thống.
3. **SSR:** Blade Server-Side Rendering tối ưu SEO và tốc độ tải đầu trang.
4. **Hiệu năng:** Tối ưu hóa câu truy vấn trước, cache sau. Không để N+1.
5. **Class CSS/HTML:** Luôn có tiền tố `vinfast-autohaiphong_` hoặc `vinfast-autohaiphong_admin_`.

## Git Rules
- KHÔNG tự động push lên remote.
- Commit bằng tiếng Việt có dấu.
