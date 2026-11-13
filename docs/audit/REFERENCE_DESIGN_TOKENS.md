# REFERENCE DESIGN TOKENS — vinfast-haiphong.com
> Phương pháp: Khảo sát qua search_web + thông tin nhận diện thương hiệu VinFast  
> Ngày: 2026-11-13  
> **Cảnh báo:** Các giá trị hex cụ thể cho website đại lý chưa được xác minh trực tiếp từ CSS — đây là thông tin tổng hợp từ nhận diện thương hiệu VinFast chính thức và mô tả quan sát.

---

## 1. Màu sắc (Colors)

### Màu thương hiệu VinFast chính thức (Global Brand Guidelines)

| Tên | HEX | RGB | Mô tả |
|-----|-----|-----|-------|
| **Future Blue (Primary)** | `#1464F4` | rgb(20, 100, 244) | Màu xanh chủ đạo thương hiệu — dùng cho accent, nút, link |
| **Steel Blue** | `#92A0B2` | rgb(146, 160, 178) | Màu phụ — viền, icon |
| **Light Ice / Silver** | `#D9E1E2` | rgb(217, 225, 226) | Màu nền nhẹ, border |

### Màu website đại lý (quan sát từ mô tả)

| Tên | Giá trị (ước tính) | Dùng cho |
|-----|-------------------|---------|
| **Màu nền chính** | `#FFFFFF` (trắng) | Background toàn trang |
| **Màu nền phụ** | `#F5F5F5` hoặc `#F8F8F8` (xám sáng) | Background section xen kẽ |
| **Màu header/nav** | Tối (đen hoặc xanh đậm) | Thanh điều hướng |
| **Màu footer** | Tối (đen hoặc xanh đậm) | Footer background |
| **Màu text chính** | `#000000` hoặc `#1A1A1A` | Nội dung bài viết, thông số |
| **Màu text phụ** | `#666666` hoặc `#777777` | Chú thích, metadata |
| **Màu CTA button** | Đỏ/Cam hoặc Xanh lá sáng | Nút "Đăng ký lái thử", "Báo giá" |
| **Màu link hover** | `#1464F4` (Future Blue) | Hover state trên menu |

> [!NOTE]
> Màu CTA của website đại lý thường lệch khỏi màu chính thức VinFast — có thể là đỏ (#E30613 hoặc tương tự) hoặc xanh lá (#00B14F). Cần xác minh bằng DevTools thực tế.

---

## 2. Font chữ (Typography)

| Vị trí | Font family | Ghi chú |
|--------|------------|---------|
| **Font chính** | Sans-serif (Roboto, Open Sans, hoặc Inter) | Phổ biến trên WordPress theme ô tô |
| **Tiêu đề (H1–H3)** | Font không chân (Sans-serif), weight 700 | Bold, uppercase thường dùng |
| **Nội dung (Body)** | Font không chân, weight 400 | Cỡ ~15–16px |
| **CTA Button** | Sans-serif, weight 600–700 | Uppercase hoặc Title Case |
| **Số liệu / Giá** | Sans-serif, weight 700, cỡ lớn | Nổi bật |

> [!NOTE]
> Chưa xác minh được tên font cụ thể từ source code. Cần kiểm tra `<link>` Google Fonts hoặc `@font-face` trong CSS thực tế.

---

## 3. Spacing & Layout (ước tính)

| Token | Giá trị | Dùng cho |
|-------|---------|---------|
| Container width | ~1200px hoặc 1280px | Max-width desktop |
| Section padding | 60px–80px top/bottom | Khoảng cách section |
| Card gap | 20px–30px | Khoảng cách card sản phẩm |
| Border radius | 4px–8px | Card, button, input |

---

## 4. Logo & Branding

| Mục | Thông tin |
|-----|-----------|
| Logo | Logo VinFast chính thức (hình tròn với chữ VinFast) + tên đại lý |
| Tên đại lý | VinFast Minh Đạo Hải Phòng (theo search result) |
| Favicon | Dự kiến dùng logo VinFast |

---

## 5. Màu sơn xe (Vehicle Colors — quan sát được)

| Mã sơn | Tên màu | Mô tả |
|--------|---------|-------|
| C4E | Urban Mint | Xanh bạc hà pastel |
| GNB | Deep Ocean | Xanh rêu đậm |
| *(nhiều màu khác)* | — | Đen, Trắng, Bạc, Đỏ, Cam... |

---

*Tất cả giá trị trên đây là ước tính/suy luận từ thông tin thương hiệu. Phải xác minh bằng browser DevTools hoặc CSS trực tiếp.*
