# ĐẶC TẢ DỮ LIỆU CẤU TRÚC (STRUCTURED DATA JSON-LD V2)

## 1. Schema Đại Lý Ô Tô (AutoDealer Schema)
Áp dụng trên Trang chủ và Trang liên hệ:
- `@context`: `https://schema.org`
- `@type`: `AutoDealer`
- `name`: `VinFast Hải Phòng - Showroom VinFast Minh Đạo`
- `address`: Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng, Hải Phòng
- `telephone`: `0988 302 882`
- `paymentAccepted`: `Cash` (Tiền mặt duy nhất)
- `openingHours`: Giờ làm việc chi tiết T2-T7 & Chủ nhật

## 2. Schema Xe Ô Tô (Car Schema)
Áp dụng trên từng trang chi tiết xe (`/xe/{slug}`):
- `@type`: `Car`
- `name`: Tên mẫu xe
- `brand`: VinFast
- `offers`: Giá niêm yết/khuyến mãi bằng tiền VND

## 3. Schema Bài Báo (Article Schema)
Áp dụng trên từng bài viết tin tức:
- `@type`: `Article`
- `headline`: Tiêu đề bài viết
- `publisher`: VinFast Hải Phòng

