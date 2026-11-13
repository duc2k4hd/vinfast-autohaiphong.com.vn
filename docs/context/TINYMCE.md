# CONTEXT TINYMCE — TÍCH HỢP TRÌNH SOẠN THẢO CHUYÊN NGHIỆP

## 1. Cấu Hình & Tích Hợp
- API Key được cấu hình trong `.env`: `APP_TINYMCE_KEY=...`
- Khai báo an toàn trong `config/services.php`:
  ```php
  'tinymce' => [
      'key' => env('APP_TINYMCE_KEY'),
  ],
  ```
- Gọi trong view Blade Admin qua `config('services.tinymce.key')`, tuyệt đối không gọi `env()` trực tiếp trong Blade.
- Tích hợp với Thư viện Media nội bộ qua Media Picker popup hoặc `images_upload_handler`.
- Bộ lọc làm sạch mã nguồn HTML (paste cleanup) tự động loại bỏ class lạ, thẻ script, style rác khi người dùng copy từ Word/Web vào.
- Chỉ nạp script TinyMCE trong trang Admin chỉnh sửa bài viết và xe; tuyệt đối không tải trên Client.

