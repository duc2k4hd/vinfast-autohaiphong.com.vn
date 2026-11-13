# CONTEXT KIỂM THỬ HỒI QUY (REGRESSION TESTS V2)

## 1. Bộ Kiểm Thử Baseline Hiện Có
28 bài kiểm thử đạt 100% PASS (119 assertions):
- `AdminPanelTest`: Đăng nhập, Dashboard, Danh sách xe, Specs Key-Value, Quản lý đơn cọc tiền mặt, Quản lý Leads, Cài đặt.
- `AdminPostAndMediaTest`: Quản lý bài viết tin tức và Thư viện Media tập trung.
- `CartAndCheckoutTest`: Giỏ hàng, Đặt cọc tiền mặt duy nhất, sinh mã đơn `VFHP-YYYYMMDD-XXXX`.
- `CatalogAndProductTest`: Danh mục xe, phân trang `/o-to-vinfast/page/2`, chi tiết xe, Specs Key-Value ở vị trí đầu tiên.
- `ClientContentPagesTest`: Pin & trạm sạc, Trải nghiệm khách hàng, Tin tức, Liên hệ, Chính sách.
- `HomeTest`: Trang chủ, Lưới sản phẩm, Form đăng ký báo giá.
- `SitemapAndSeoTest`: Sitemap XML, Robots.txt, JSON-LD Schema `AutoDealer` & `Car`, Thẻ meta social.

## 2. Kế Hoạch Mở Rộng
- Mở rộng thêm bài test kiểm tra tích hợp TinyMCE & Media Picker trong Admin.
- Bài test kiểm tra phân tích SEO `SeoService` kế thừa từ Nobi Fashion.
- Bài test kiểm tra chuyển đổi biến thể xe (Variants) và hiển thị giá tương ứng.

