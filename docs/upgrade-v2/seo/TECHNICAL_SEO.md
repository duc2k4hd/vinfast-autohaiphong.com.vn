# ĐẶC TẢ KỸ THUẬT SEO (TECHNICAL SEO V2)

## 1. Khả Năng Thu Thập & Lập Chỉ Mục (Crawlability & Indexability)
- **Robots.txt:**
  - `User-agent: *`
  - `Disallow: /admin/` (Chặn lập chỉ mục hệ thống quản trị)
  - `Disallow: /dat-hang-thanh-cong/` (Bảo mật thông tin đơn hàng cá nhân)
  - `Sitemap: https://vinfast-autohaiphong.com.vn/sitemap.xml`
- **Canonical URLs:**
  - Sử dụng URL tuyệt đối trên 100% trang indexable.
  - Phân trang có URL canonical độc lập (ví dụ `/o-to-vinfast/page/2`), không trỏ tất cả về trang 1.
- **Xử Lý Mã Trạng Thái HTTP:**
  - Trang hợp lệ trả về `200 OK`.
  - Trang không tồn tại (xe hoặc bài viết sai slug) trả về `404 Not Found`.

## 2. Thẻ Meta & Hiển Thị Mạng Xã Hội
- **Meta Robots:** Mặc định `index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1`.
- **Open Graph (Facebook, Zalo):**
  - `og:locale`: `vi_VN`
  - `og:type`: `website` / `article` / `product`
  - `og:image:width`: `1200`
  - `og:image:height`: `630`
- **Twitter Cards:**
  - `twitter:card`: `summary_large_image`

