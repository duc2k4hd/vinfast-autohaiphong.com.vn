# Ma Trận Phân Tích Trang (Reference Page Matrix) — vinfast-haiphong.com

## 1. Cấu Trúc Bố Cục Trang Chủ (`/`)
Trang chủ gồm các phần chính từ trên xuống dưới:
1. **Top Bar / Header:**
   - Hotline: `tel:0966597282` (hoặc số cấu hình trong settings).
   - Địa chỉ showroom: Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng, Hải Phòng.
   - Logo VinFast Hải Phòng (bên trái).
   - Menu chính: Trang chủ, Ô Tô VinFast (dropdown 15 mẫu xe), Pin & Trạm Sạc, Trải Nghiệm Khách Hàng, Tin Tức, Liên Hệ.
   - Nút tìm kiếm & nút Báo giá / Hotline CTA.
2. **Hero Banner Slider:**
   - Banner xe VinFast VF Wild, VF 8 All New, VF 3.
   - Tỷ lệ desktop: 1920x800, có ảnh banner riêng cho mobile.
   - Tiêu đề ưu đãi nổi bật & nút "Nhận Báo Giá Ngay".
3. **Section Các Dòng Xe Ô Tô VinFast (Grid 3-4 cột):**
   - Danh sách sản phẩm: VF 2, VF 3, VF 5, VF 6, VF 7, VF 8, VF 9, VF Wild...
   - Mỗi card sản phẩm gồm:
     - Badge khuyến mãi (nếu có).
     - Ảnh xe chính diện/góc 3/4 chất lượng cao.
     - Tên dòng xe (H3).
     - Giá bán: "Giá từ: xxx.xxx.xxx VNĐ" (hoặc "Liên hệ").
     - Nút "Báo giá lăn bánh" (mở modal biểu mẫu).
     - Nút "Xem chi tiết" (link tới `/xe/{slug}/`).
4. **Section Dòng Xe Dịch Vụ Xanh (Minio, Herio, Nerio, Limo Green, EC Van):**
   - Giới thiệu giải pháp xe điện chạy dịch vụ, taxi, vận tải xanh tiết kiệm chi phí nhiên liệu.
5. **Section Chính Sách Pin & Trạm Sạc:**
   - Điểm mạnh về hạ tầng trạm sạc phủ khắp 63 tỉnh thành.
   - Thiết bị sạc di động và gói thuê pin linh hoạt.
6. **Section Tin Tức & Khuyến Mãi Mới Nhất (Grid 3 cột):**
   - 3 bài viết nổi bật gần nhất, ảnh đại diện, tiêu đề, ngày đăng, nút Xem thêm.
7. **Section Cam Kết & Ưu Đãi Đại Lý:**
   - Bảo hành 7-10 năm chính hãng.
   - Hỗ trợ trả góp lên đến 80-85%.
   - Giao xe nhanh, dịch vụ chuẩn 3S.
8. **Footer Toàn Trang:**
   - Cột 1: Thông tin đại lý, địa chỉ, hotline, email, giấy phép.
   - Cột 2: Danh mục các dòng xe điện VinFast.
   - Cột 3: Chính sách (Bảo mật, Thanh toán tiền mặt, Điều khoản, Bảo hành).
   - Cột 4: Bản đồ / Kết nối mạng xã hội / Hotline tư vấn 24/7.
   - Floating Button: Nút gọi điện nhanh & nút Zalo luôn ghim góc dưới màn hình.

---

## 2. Trang Chi Tiết Sản Phẩm (`/xe/{slug}/`)
- **Breadcrumb:** Trang chủ > Ô tô VinFast > Tên xe.
- **Gallery:** 1 ảnh lớn + thanh trượt thumbnails nhiều góc chụp + ảnh theo phiên bản màu sắc.
- **Khối thông tin bán hàng:**
  - Tên xe (H1).
  - Giá niêm yết & giá ưu đãi (VND).
  - Selector chọn phiên bản (Eco, Plus, Standard...).
  - Color Picker (các nút tròn chọn màu xe).
  - Khối thông số tóm tắt: Quãng đường 1 lần sạc, Thời gian sạc nhanh, Công suất tối đa, Số chỗ ngồi.
  - Nút CTA: "Báo giá lăn bánh" (Modal popup) & "Đặt xe ngay (Thanh toán tiền mặt)".
- **Tabs / Khối chi tiết bên dưới:**
  - Giới thiệu tổng quan & Video trải nghiệm.
  - Bảng thông số kỹ thuật chi tiết.
  - Hình ảnh thực tế nội/ngoại thất.
  - Câu hỏi thường gặp (FAQ).
  - Sản phẩm cùng phân khúc liên quan.

---

## 3. Trang Danh Mục Ô Tô (`/o-to-vinfast/`)
- Bộ lọc danh mục (Tất cả, Xe gia đình, Xe dịch vụ).
- Bộ sắp xếp: Mới nhất, Giá tăng dần, Giá giảm dần.
- Lưới sản phẩm responsive: 1 cột (mobile), 2 cột (tablet), 3 hoặc 4 cột (desktop).
- Phân trang chuẩn SEO.
