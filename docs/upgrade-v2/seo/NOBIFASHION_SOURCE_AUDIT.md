# KHẢO SÁT MÃ NGUỒN SEO NOBIFASHION.VN (NOBIFASHION SOURCE AUDIT)

## 1. Thông Tin Khảo Sát
- **Đường dẫn local:** `E:\Project\Laravel\nobifashion.vn`
- **Tình trạng truy cập:** Đã xác minh tồn tại thực tế trên máy tính (PowerShell `Test-Path` trả về `True`).
- **Framework:** Laravel (PHP 8.2+, MySQL).

## 2. Các Thành Phần SEO Đã Tìm Thấy & Phân Tích
### 2.1. Lớp Dịch Vụ SEO (`app/Services/SeoService.php`)
- **Tạo Slug tự động:** `generateSlug(string $title, ?int $ignoreId)` xử lý trùng lặp slug bằng cách thêm hậu tố số tăng dần (`-2`, `-3`), fallback chuỗi ngẫu nhiên khi title trống.
- **Tạo Excerpt:** `generateExcerpt(string $content, int $limit = 160)` làm sạch toàn bộ thẻ HTML bằng `strip_tags()` và dọn dẹp khoảng trắng thừa bằng `Str::squish()`.
- **Đánh giá điểm SEO (SEO Score):**
  - Thang điểm 100, trừ điểm nếu thiếu Meta Title (-10đ), Meta Description không nằm trong khoảng 80–170 ký tự (-10đ), thiếu ảnh đại diện (-10đ), thiếu tag liên quan (-5đ), thiếu tóm tắt (-5đ).
- **Phân tích nội dung (Content Analysis):**
  - Đếm tổng số từ (`str_word_count`).
  - Ước tính thời gian đọc bài (`ceil(word_count / 250)` phút).
  - Tính toán mật độ từ khóa chính (`keyword_density` tính bằng tỷ lệ % xuất hiện từ khóa trên tổng số từ).

### 2.2. Bộ Điều Khiển Phân Tích SEO Trong Admin (`app/Http/Controllers/Admins/SeoController.php`)
- Cung cấp endpoint API `POST /admin/seo/analyze` nhận dữ liệu bài viết (title, content, excerpt, meta_title, meta_description, focus_keyword).
- Trả về JSON chứa điểm SEO, danh sách cảnh báo (warnings), số từ, thời gian đọc và mật độ từ khóa để giao diện admin hiển thị phản hồi trực tiếp cho người viết bài.

### 2.3. Cấu Trúc Sitemap & Thẻ Meta
- Có cả XML sitemap và HTML sitemap trực quan (`resources/views/clients/sitemap/index.blade.php`).
- Thẻ meta khai báo đầy đủ `max-snippet:-1, max-image-preview:large, max-video-preview:-1`, Open Graph có chỉ định rõ kích thước ảnh `1200x630px` và thẻ bảo mật `Strict-Transport-Security`, `X-Content-Type-Options: nosniff`.

