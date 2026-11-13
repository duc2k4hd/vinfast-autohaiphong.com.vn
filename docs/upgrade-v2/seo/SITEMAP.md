# ĐẶC TẢ SITEMAP XML & HTML (SITEMAP V2)

## 1. Sitemap XML Động (`/sitemap.xml`)
- Tự động truy vấn database tạo file XML hợp lệ với header `Content-Type: application/xml`.
- Bao gồm các URL:
  - Trang chủ (`/`) - `changefreq: daily`, `priority: 1.0`
  - Danh mục xe (`/o-to-vinfast`) - `priority: 0.9`
  - 15 dòng xe (`/xe/{slug}`) - `priority: 0.8`
  - Tin tức (`/chuyen-muc/tin-tuc`) - `priority: 0.8`
  - Các bài viết (`/chuyen-muc/tin-tuc/{slug}`) - `priority: 0.7`
  - Trang liên hệ, hạ tầng pin & trạm sạc, chính sách - `priority: 0.6`

## 2. Kế Hoạch Bổ Sung HTML Sitemap (`/so-do-trang-web`)
- Học hỏi từ `nobifashion.vn`, bổ sung trang HTML Sitemap phân cấp trực quan cho người dùng dễ dàng tìm kiếm xe và bài viết theo danh mục.

