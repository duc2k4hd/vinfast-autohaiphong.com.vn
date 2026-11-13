# Phân Tích Đáp Ứng Đa Màn Hình (Reference Responsive Matrix) — vinfast-haiphong.com

## 1. Hệ Thống Điểm Ngắt (Responsive Breakpoints)
| Breakpoint | Chiều Rộng Màn Hình | Thiết Bị Mục Tiêu | Quy Tắc Bố Cục |
| :--- | :--- | :--- | :--- |
| **xs** | `< 430px` (360px, 390px, 430px) | iPhone, Galaxy S, Điện thoại phổ biến | Bố cục 1 cột toàn màn hình, menu hamburger |
| **sm** | `640px` | Điện thoại ngang, phablet | Bố cục 1–2 cột thích ứng |
| **md** | `768px` | iPad Mini, Tablet dọc | Lưới 2 cột cho card xe, thanh lọc rút gọn |
| **lg** | `1024px` | iPad Pro, Tablet ngang, Laptop nhỏ | Lưới 3 cột, menu chính hiển thị đầy đủ |
| **xl** | `1200px` | Desktop tiêu chuẩn | Container cố định `max-width: 1200px` |
| **2xl** | `1440px - 1920px` | Màn hình máy tính lớn, Full HD | Canh giữa toàn bộ nội dung, padding 2 bên cân đối |

---

## 2. Ma Trận Thích Ứng Chi Tiết Theo Từng Thành Phần

### 2.1. Thanh Header & Navigation
- **Desktop (>= 1024px):**
  - Chiều cao header 76px cố định, hiển thị logo bên trái, thanh menu ngang thanh mảnh ở giữa (mẫu ảnh 2).
  - Topbar hiển thị đầy đủ địa chỉ, giờ mở cửa và 4 số hotline.
- **Mobile & Tablet (< 1024px):**
  - Chiều cao header co gọn còn 60px.
  - Topbar ẩn các thông tin dài, chỉ giữ lại số hotline bán hàng và dịch vụ bấm gọi trực tiếp.
  - Menu chuyển đổi sang nút Hamburger 3 gạch, khi mở trượt ra panel điều hướng mượt mà phủ kín màn hình.

### 2.2. Lưới Trưng Bày Xe (Product Cards Grid)
- **Desktop (>= 1024px):** Lưới 3 cột đồng đều (`grid-template-columns: repeat(3, 1fr)`), khoảng cách 24px, container giới hạn tối đa 1200px.
- **Tablet (768px – 1023px):** Lưới 2 cột (`grid-template-columns: repeat(2, 1fr)`), khoảng cách 18px.
- **Mobile (< 768px):** Lưới 1 cột (`grid-template-columns: 1fr`), card xe hiển thị full chiều ngang màn hình với padding viền 16px.

### 2.3. Trang Chi Tiết Dòng Xe (`/xe/{slug}`)
- **Desktop (>= 1024px):**
  - Chia 2 cột: Cột trái là Gallery ảnh lớn + thumbnails phụ (tỷ lệ 1.15fr); Cột phải là Khối thông tin giá niêm yết, chọn phiên bản và nút cọc / báo giá (1fr).
  - Khối thông số kỹ thuật Key-Value nằm ở vị trí đầu tiên ngay dưới dạng bảng ngang 2 cột.
- **Mobile (< 1024px):**
  - Tự động chuyển thành 1 cột dọc: Gallery ảnh hiển thị ở trên cùng, khối giá và nút bấm trượt xuống dưới.
  - Bảng thông số kỹ thuật Key-Value co giãn linh hoạt, cho phép xem rõ từng cặp thông số mà không bị tràn màn hình ngang.

### 2.4. Khối Nút Nổi Gọi Điện & Zalo (Floating Widget)
- **Desktop:** Kích thước nút 50px x 50px, cách góc phải 24px, hiệu ứng sóng rung nhẹ nhàng.
- **Mobile:** Kích thước nút 44px x 44px (chuẩn kích thước chạm ngón tay tối thiểu của Apple Human Interface Guidelines và Google Material Design), cách đáy 70px để không che khuất thanh điều hướng hệ thống.

---

## 3. Checklist Kiểm Tra Đáp Ứng Giao Diện Đã Xác Minh
- [x] Độ rộng 360px (Samsung Galaxy nhỏ): Không tràn ngang, cỡ chữ dễ đọc.
- [x] Độ rộng 390px (iPhone 12/13/14/15/16 tiêu chuẩn): Đẹp, cân đối.
- [x] Độ rộng 430px (iPhone Pro Max): Tối ưu tối đa không gian hiển thị.
- [x] Độ rộng 768px (iPad dọc): Lưới 2 cột card xe hiển thị hài hòa.
- [x] Độ rộng 1024px (iPad Pro / Laptop nhỏ): Chuyển sang giao diện Desktop mượt mà.
- [x] Độ rộng 1200px (Desktop chuẩn): Bố cục container `max-width: 1200px` sắc nét.
- [x] Độ rộng 1440px - 1920px (Màn hình lớn Full HD): Canh giữa hoàn hảo, nền trắng sáng sang trọng.

