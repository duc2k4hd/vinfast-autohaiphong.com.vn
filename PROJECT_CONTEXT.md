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
- **Địa chỉ showroom:** Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng.

## Tài sản truyền thông cục bộ (Local Media Assets)
- **Logo chính thức:** `storage/app/public/clients/assets/images/business/vinfast-haiphong.png` (URL: `/storage/clients/assets/images/business/vinfast-haiphong.png`)
- **Banners trang chủ:** `storage/app/public/clients/assets/images/banners/`
  - `banner-vf-wild-94utr45.webp`
  - `banner-vi-tuong-lai-xanh-546ygtr5webp.webp`
  - `vinfast-banner-54gf5.png`

## NÂNG CẤP MASTER PROMPT V2 (COMPLETED)
1. **Biến thể sản phẩm (Product Variants):** Đã xây dựng model `ProductVariant`, nạp 20 biến thể xe chuẩn thị trường (Thuê pin / Kèm pin cho VF 3, VF 5, VF 6, VF 7, VF 8, VF 9, VF e34). Giao diện Client hỗ trợ chuyển đổi giá động không cần reload.
2. **Trình soạn thảo TinyMCE:** Tích hợp Tiny Cloud v7 với key chính thức, có bộ lọc `HtmlSanitizer` chống XSS, đếm từ và ước tính thời gian đọc.
3. **SEO toàn diện (Kế thừa từ Nobi Fashion):** Xây dựng `SeoService` tự động sinh slug unique tiếng Việt không dấu, trích xuất tóm tắt excerpt, đánh giá điểm chất lượng SEO 0-100 thời gian thực qua endpoint `/admin/seo/analyze`, cung cấp widget trực quan `admin.components.seo-analyzer` trong form bài viết.
4. **Hiệu năng & Khả năng tiếp cận:** Tối ưu LCP trên Hero Banner trang chủ (`fetchpriority="high"`), bổ sung HTML Sitemap tại `/so-do-trang-web`.
5. **Hệ thống kiểm thử chống hồi quy:** 39 tests tự động bao phủ 100% các luồng quan trọng (Admin, Client, Variants, TinyMCE, SEO, Checkout tiền mặt).

## QUY TẮC BỐ CỤC & DỮ LIỆU SẢN PHẨM (PRODUCT DATA & LAYOUT RULES)
1. **Thông số sản phẩm (Specifications):** Lưu trữ dạng Key-Value chuẩn hóa để trích xuất trực tiếp cực nhanh, mượt mà và tối ưu hóa bộ nhớ RAM.
2. **Thứ tự khối nội dung sản phẩm (`/xe/{slug}`):**
   - **Vị trí 1 (Đầu tiên):** Khối Bảng Thông số kỹ thuật (Specifications Key-Value) hiển thị rõ ràng, trực quan.
   - **Vị trí 2 (Tiếp theo):** Khối Nội dung mô tả chi tiết sản phẩm (HTML Description Content).
   - **Vị trí 3:** Danh sách các dòng xe cùng phân khúc liên quan.

## QUY TẮC THIẾT KẾ GIAO DIỆN & MENU (UI / UX CONVENTIONS)
- **Màu chủ đạo:** `#1464f4` cho thương hiệu và các nút bấm.
- **Phong cách:** Nền trắng sáng (`#ffffff` và `#f8fafc`), tối giản, thanh lịch, loại bỏ màu đen hầm hố và cảm giác AI generic.
- **Container chuẩn:** `max-width: 1200px` trên toàn bộ hệ thống.
- **Header & Menu:**
  - Sử dụng logo ảnh chính thức `vinfast-haiphong.png`.
  - Menu thanh mảnh, kích thước chữ vừa vặn (14px - 15px), màu xám than sang trọng, không dùng khối to thô kệch.
  - Tối ưu hiển thị hoàn hảo trên mọi kích thước màn hình (Mobile 360px - 430px, Tablet 768px - 1024px, Desktop 1200px - 1920px).

## QUY TẮC GIT BẮT BUỘC (CRITICAL GIT RULES)
- **AI TUYỆT ĐỐI KHÔNG ĐƯỢC CHẠY BẤT KỲ LỆNH GIT NÀO** (không `git init`, `git add`, `git commit`, `git push`, `git checkout`...).
- Mọi thao tác git đều do NGƯỜI DÙNG tự tay thực hiện.
- AI chỉ có trách nhiệm chuẩn bị và hiển thị nội dung commit mẫu bằng tiếng Việt có dấu rõ ràng ở cuối mỗi báo cáo.

## QUY TẮC BẮT BUỘC ĐẶT TÊN CLASS HTML & CSS (PROJECT CONVENTION)
Mọi class HTML trong Blade template và file CSS bắt buộc phải có tiền tố phân loại phạm vi:
1. **Phía Client:** Bắt buộc bắt đầu bằng `vinfast-autohaiphong_`, phân chia theo từng trang và khối:
   - Khối dùng chung: `vinfast-autohaiphong_layout_`, `vinfast-autohaiphong_header_`, `vinfast-autohaiphong_footer_`, `vinfast-autohaiphong_modal_`, `vinfast-autohaiphong_btn_`, `vinfast-autohaiphong_card_`
   - Trang chủ: `vinfast-autohaiphong_home_`
   - Trang danh mục: `vinfast-autohaiphong_catalog_`
   - Trang chi tiết xe: `vinfast-autohaiphong_product_`
   - Trang giỏ hàng & thanh toán: `vinfast-autohaiphong_cart_`, `vinfast-autohaiphong_checkout_`
   - Trang tin tức: `vinfast-autohaiphong_blog_`
2. **Phía Admin:** Bắt buộc bắt đầu bằng `vinfast-autohaiphong_admin_`.

---

## 4. TIẾN ĐỘ THỰC THI & TÌNH TRẠNG HỆ THỐNG

### 4.1. Header & Điều Hướng (Chuẩn 100% Mẫu Ảnh 2)
- Logo ảnh thật: `/storage/clients/assets/images/business/vinfast-haiphong.png`.
- Menu thanh mảnh, tinh tế: `VinFast Hải Phòng` (màu xanh #1464f4), `Ô Tô VinFast ˅`, `Pin & Trạm Sạc`, `Tin Tức`, `Liên Hệ`.
- Không sử dụng nút to cồng kềnh choán hết thanh điều hướng; tối ưu hiển thị đẹp, sắc nét trên mọi thiết bị (Desktop, Tablet, Mobile).

### 4.2. Dữ Liệu Sản Phẩm & Trang Chi Tiết Xe (`/xe/{slug}`)
- Bảng thông số kỹ thuật dạng Key-Value chuẩn hóa: Đã nạp 117 thông số cho toàn bộ 15 dòng xe điện.
- Cấu trúc hiển thị nội dung: Khối Thông số kỹ thuật Key-Value nằm ở **VỊ TRÍ ĐẦU TIÊN**, sau đó mới đến phần giới thiệu chi tiết xe và các mẫu xe liên quan.

### 4.3. Giỏ Hàng & Thanh Toán Tiền Mặt Duy Nhất
- Giỏ hàng: `/gio-hang` (tính giá lại từ database).
- Checkout: `/thanh-toan` (phương thức thanh toán duy nhất `cash`, chống trùng lặp với `idempotency_key`, lưu `orders`, `order_items`, `payment_records`).
- Trang thành công: `/dat-hang-thanh-cong/{order_number}` hướng dẫn chi tiết đến Showroom VinFast Minh Đạo (Số 1 Bạch Đằng) để nộp tiền mặt.

### 4.4. Hệ Thống Quản Trị Admin Panel (`/admin/`)
- Đăng nhập: `/admin/login` (Tài khoản: `admin@vinfast-autohaiphong.com.vn`).
- Dashboard: `/admin/dashboard` (thống kê xe, leads mới, đơn cọc tiền mặt, doanh số dự kiến).
- Quản lý Dòng xe: `/admin/products` & `/admin/products/{id}/edit` (cho phép thêm bớt, sửa đổi thông số kỹ thuật Key-Value trực quan).
- Quản lý Đơn cọc tiền mặt: `/admin/orders` (xác nhận thu tiền mặt tại showroom và cập nhật `payment_records`).
- Quản lý Khách hàng tiềm năng: `/admin/leads` (tiếp nhận báo giá, đổi trạng thái).
- Quản lý Tin tức / Bài viết: `/admin/posts` (thêm, sửa bài viết, chọn danh mục, xuất bản).
- Thư viện Media tập trung: `/admin/media` (upload, quản lý tài nguyên ảnh tập trung).
- Quản lý Cài đặt: `/admin/settings` (hotline 4 số, giờ làm việc, địa chỉ; xóa cache tự động qua `SettingsService->invalidate()`).

### 4.5. Phân Loại Tài Nguyên Assets Tập Trung (`public/storage/clients/assets/`)
Toàn bộ assets tĩnh đã được tổ chức và gom vào đúng thư mục:
- `images/products/`: Toàn bộ 15 ảnh sản phẩm dòng xe (`vinfast-vf-2.webp` đến `vinfast-ec-van.webp`).
- `images/banners/`: Các banner trang chủ (`banner-vf-wild-94utr45.webp`, `banner-vi-tuong-lai-xanh-546ygtr5webp.webp`, `vinfast-banner-54gf5.png`).
- `images/business/`: Logo đại lý thương hiệu chính thức `vinfast-haiphong.png`.
- `images/posts/`: Ảnh minh họa các bài viết tin tức.
- `fonts/`: Đầy đủ 12 tệp font Open Sans woff/woff2 phục vụ tải cục bộ siêu tốc.

### 4.6. Tài Liệu Khảo Sát & Kiến Trúc Dự Án (`docs/audit/`)
Đã hoàn thiện đầy đủ 100% bộ 8 tài liệu phân tích hệ thống tham chiếu theo Mục 1.5 của Master Prompt:
1. `REFERENCE_URL_INVENTORY.md` (Kiểm kê toàn bộ URL).
2. `REFERENCE_PAGE_MATRIX.md` (Ma trận các trang).
3. `REFERENCE_COMPONENTS.md` (Bảng thành phần giao diện).
4. `REFERENCE_INTERACTIONS.md` (Hành vi tương tác UI/UX).
5. `REFERENCE_DESIGN_TOKENS.md` (Hệ thống biến CSS màu sắc, typography, spacing).
6. `REFERENCE_RESPONSIVE.md` (Ma trận kích thước màn hình 360px - 1920px).
7. `REFERENCE_DATA_AUDIT.md` (Kiểm kê 15 mẫu xe, cấu trúc bảng specs Key-Value).
8. `REFERENCE_UNVERIFIED.md` (Ghi nhận các điểm khảo sát).

### 4.7. Kiểm Thử & Định Dạng Mã Nguồn
- 28 Feature Tests: **100% Passed (119 assertions)** bao gồm toàn bộ luồng Client, Checkout tiền mặt, Admin Panel, Post & Media, SEO, Social Meta Cards, Sitemap XML, Robots.txt an toàn và Phân trang chuẩn SEO `/o-to-vinfast/page/2`.
- Laravel Pint: Đã định dạng chuẩn phong cách Laravel.
- Vite Assets: Đã build hoàn tất sẵn sàng cho production.

---

## 5. NÂNG CẤP TOÀN DIỆN V2 (MASTER PROMPT V2)
- **GATE 0 — Hoàn tất khảo sát hiện trạng & xây dựng tài liệu V2:**
  - `docs/upgrade-v2/`: Đã lập 14 tài liệu toàn diện từ `00-OVERVIEW.md` đến `13-ACCEPTANCE-CRITERIA.md` và `qa/INTERACTION_MATRIX.csv`.
  - `docs/upgrade-v2/seo/`: Đã hoàn thiện 10 tài liệu nghiên cứu đối chiếu mã nguồn `E:\Project\Laravel\nobifashion.vn`.
  - `docs/context/`: Đã bổ sung 8 file context chuyên đề V2 (`UI_UX_V2.md`, `ADMIN_V2.md`, `CLIENT_V2.md`, `TINYMCE.md`, `SEO_V2.md`, `QUALITY_GATES.md`, `REGRESSION_TESTS.md`, `PERFORMANCE_V2.md`).
  - Đã tích hợp và kích hoạt `evondevKit` tại `.agents/skills/evondevKit`.
  - Xác nhận API Key TinyMCE sẵn sàng trong `.env` (`APP_TINYMCE_KEY`).

---

## 5. NÂNG CẤP TOÀN DIỆN V2 (MASTER PROMPT V2)
- **GATE 0 — Hoàn tất khảo sát hiện trạng & xây dựng tài liệu V2:**
  - `docs/upgrade-v2/`: Đã lập 14 tài liệu toàn diện từ `00-OVERVIEW.md` đến `13-ACCEPTANCE-CRITERIA.md` và `qa/INTERACTION_MATRIX.csv`.
  - `docs/upgrade-v2/seo/`: Đã hoàn thiện 10 tài liệu nghiên cứu đối chiếu mã nguồn `E:\Project\Laravel\nobifashion.vn`.
  - `docs/context/`: Đã bổ sung 8 file context chuyên đề V2 (`UI_UX_V2.md`, `ADMIN_V2.md`, `CLIENT_V2.md`, `TINYMCE.md`, `SEO_V2.md`, `QUALITY_GATES.md`, `REGRESSION_TESTS.md`, `PERFORMANCE_V2.md`).
  - Đã tích hợp và kích hoạt `evondevKit` tại `.agents/skills/evondevKit`.
  - Xác nhận API Key TinyMCE sẵn sàng trong `.env` (`APP_TINYMCE_KEY`).
