# KIỂM ĐỊNH UI/UX TOÀN DIỆN (UI/UX AUDIT V2) — ÁP DỤNG EVONDEVKIT

## 1. Đánh Giá Đối Chiếu Với evondevKit & Nguyên Tắc Chống "AI Feel"
Theo tài liệu chính thức của skill `evondevKit` tại `.agents/skills/evondevKit/skills/ui-ux/SKILL.md`:
- **Định hướng thiết kế thống nhất:**
  *Enterprise-grade, minimal, neutral, light, restrained, professional.*
- **Danh sách thói quen AI cần loại bỏ triệt để:**
  1. Tuyệt đối không dùng 6 card gradient tím/xanh/cam lòe loẹt trên Dashboard.
  2. Tuyệt đối không dùng emoji thay cho icon SVG đơn sắc chuyên nghiệp.
  3. Bo góc chuẩn mực (`4px`, `6px`, `8px`), không bo tròn quá lớn (`24px - 32px`) gây cảm giác đồ chơi.
  4. Đổ bóng (shadow) phẳng, tinh tế (`0 1px 2px rgba(0,0,0,0.05)`), không dùng bóng phát sáng (neon glow) hay glassmorphism không có mục đích.
  5. Khoảng cách (spacing) nhất quán dựa trên thang đo 4px / 8px / 12px / 16px / 24px / 32px.
  6. Typography cân xứng: Dùng font `Open Sans` với font weight 400 (Regular), 500 (Medium), 600 (Semibold), 700 (Bold).

## 2. Kiểm Định Chi Tiết Phía Client
- **Màu Sắc & Bố Cục:**
  - Nền trang chủ đạo: Trắng `#FFFFFF` và xám cực nhẹ `#F8FAFC`.
  - Màu thương hiệu: Xanh `#1464F4` được tiết chế chỉ sử dụng cho nút hành động chính (Primary CTA), liên kết thương hiệu, trạng thái active.
  - Khung giới hạn nội dung: Cố định chuẩn `max-width: 1200px` trên toàn bộ các section.
- **Header & Menu (Ảnh 2):**
  - Chiều cao 76px trên Desktop, 60px trên Mobile.
  - Menu thanh mảnh, cỡ chữ 14px–15px, khoảng cách giữa các mục thoáng đãng, loại bỏ các nút thô to làm mất cân đối.
- **Trang Danh Mục & Thẻ Xe (Product Cards):**
  - Chiều cao card xe được đồng bộ hóa, không bị giật hay so le khi tên xe dài.
  - Ảnh xe tỷ lệ 16:9 sắc nét, có fallback tự động khi ảnh bị thiếu hoặc đường dẫn lỗi.
  - Nút bấm gồm: "Báo Giá Lăn Bánh" (Primary `#1464F4`) và "Chi Tiết" (Neutral viền xám).
- **Trang Chi Tiết Dòng Xe:**
  - Khối Thông số kỹ thuật Key-Value nằm ở **vị trí đầu tiên**, giúp người mua tra cứu nhanh công suất, pin, số chỗ, tầm hoạt động.
  - Phân cấp nội dung rõ ràng: Tên xe -> Giá từ -> Gallery ảnh -> Bảng Specs -> Mô tả chi tiết HTML -> Dòng xe liên quan.

## 3. Kiểm Định Chi Tiết Phía Admin
- **Triết Lý Thiết Kế:**
  - Lấy cảm hứng từ Stripe Dashboard và Shopify Admin: Màu nền nhẹ `#F8FAFC`, bề mặt card trắng `#FFFFFF`, viền mảnh `#E2E8F0`, chữ xám than `#0F172A`, chữ phụ `#64748B`.
- **Thanh Điều Hướng (Sidebar):**
  - Nhóm chức năng logic: Tổng quan (Dashboard), Bán hàng (Đơn cọc, Báo giá), Sản phẩm (Dòng xe, Biến thể), Truyền thông (Bài viết, Media), Hệ thống (Cài đặt).
  - Không nhồi nhét icon màu sắc, dùng icon SVG đơn sắc tinh tế.
- **Bảng Dữ Liệu (Data Tables):**
  - Header bảng nền xám nhẹ, chữ in hoa nhỏ (12px, font-weight 600, màu `#64748B`).
  - Hàng dữ liệu có padding rộng rãi, hover đổi màu nhẹ `#F1F5F9`.
  - Cột số (giá tiền, số điện thoại) căn phải hoặc có định dạng rõ ràng (`1.200.000 VNĐ`).
  - Phân trang server-side rõ ràng: Hiển thị "Hiển thị 1 - 10 trên tổng số 15 bản ghi".
- **Biểu Mẫu (Forms):**
  - Nhãn (Labels) đặt phía trên input rõ ràng, font-size 13px–14px, font-weight 600.
  - Thông báo lỗi validation hiển thị ngay dưới từng ô nhập liệu bằng chữ đỏ `#DC2626` kích thước 12px.

