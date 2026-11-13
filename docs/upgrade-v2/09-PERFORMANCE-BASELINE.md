# ĐO LƯỜNG HIỆU NĂNG CƠ BẢN (PERFORMANCE BASELINE V2)

## 1. Phương Châm Tối Ưu Hóa
**"Tốc độ phải phụ thuộc 100% vào code nhanh. Cache chỉ để tránh tải lại database nhiều lần, không dùng cache để che giấu code chậm hay truy vấn kém hiệu quả."**

## 2. Kết Quả Đo Lường Hiện Tại (Baseline Metrics)
- **Thời gian chạy Test Suite:** 1.4s – 1.6s cho toàn bộ 28 tests.
- **Thời gian build Vite Assets:** 173ms – 220ms cho toàn bộ CSS/JS (Client & Admin).
- **Kích thước Bundle:**
  - `app.css` (Client): ~14.12 kB (gzip: ~2.89 kB)
  - `app.js` (Client): ~1.02 kB (gzip: ~0.43 kB)
  - Fonts Open Sans: Tải cục bộ woff/woff2 trung bình 16kB - 18kB/tệp.
- **Truy Vấn Cơ Sở Dữ Liệu:**
  - Trang chủ: 3 queries (Settings, 15 xe có thumbnail, 3 bài viết mới nhất).
  - Chi tiết xe: 3 queries (Chi tiết xe & media, specs Key-Value, 3 xe liên quan).
  - Không có tình trạng N+1 queries; các truy vấn đều dùng `leftJoin` hoặc `whereIn` tối ưu.

## 3. Các Điểm Tối Ưu Nâng Cao Cho V2
1. **Tránh tải TinyMCE trên Client:**
   - TinyMCE và các script admin chỉ được load duy nhất trên các trang `/admin/products/{id}/edit` và `/admin/posts/{id}/edit`. Tuyệt đối không để rò rỉ sang giao diện người dùng Client.
2. **Ưu Tiên Tải Ảnh Hero LCP:**
   - Slide banner đầu tiên không dùng lazy loading để tối ưu hóa chỉ số Largest Contentful Paint (LCP) của Google.
   - Các slide sau và danh sách xe ở dưới mới áp dụng `loading="lazy"`.

