# Giao diện Sản phẩm VinFast VF 3 (Pure HTML/CSS/JS)

Bộ mã nguồn giao diện trang sản phẩm **VinFast VF 3** (`https://vinfastauto.com/vn_vi/dat-coc-xe-dien-vf3`) được xây dựng bằng **HTML5, CSS3 và Vanilla JavaScript thuần 100%**, không phụ thuộc thư viện ngoài.

## Đặc điểm kỹ thuật
- **Tiền tố Class (Namespace Prefix):** Toàn bộ 100% class trong HTML, CSS và JS đều được gắn tiền tố `vinfast-autohaiphong_product_` nhằm chống xung đột CSS tuyệt đối khi tích hợp vào hệ thống CMS/WordPress/Drupal hiện có.
- **Đầy đủ toàn bộ phần tử & tính năng tương tác:**
  1. **Header & Mega Menu V2:** Menu Ô tô (Xe cá nhân, Xe dịch vụ, Động cơ xăng), Xe máy điện (Cao cấp, Trung cấp, Phổ thông), Dịch vụ hậu mãi, Pin & trạm sạc và Drawer Menu phải.
  2. **Secondary Sticky Navbar & Scrollspy:** Tự động hiển thị khi cuộn qua Hero banner, đồng bộ trạng thái mục đang xem và hỗ trợ chọn nhanh trên Mobile.
  3. **Hero Banner & Footer Hero:** Tương thích ảnh Desktop/Mobile (`<picture>`).
  4. **Tổng quan sản phẩm (Xe nhỏ - Giá trị lớn):** Chuyển đổi mượt mà giữa 2 phiên bản `VF 3 Eco` (285.000.000 VNĐ) và `VF 3 Plus` (296.000.000 VNĐ).
  5. **Tùy chọn màu sắc (Color Customizer):** Chuyển đổi 7 màu ngoại thất (`Infinity Blanc`, `Zenith Grey`, `Solar Ruby`, `Summer Yellow`, `Sky Blue`, `Rose Pink`, `Urban Mint`) kèm nút điều hướng trái/phải và hiệu ứng preload mượt mà.
  6. **Công cụ So sánh chi phí nhiên liệu (Fuel Cost Comparison):** Tính toán trực tiếp chi phí nhiên liệu/tháng của VF 3, số tiền tiết kiệm theo tháng, năm và tới 10/02/2029 giữa VF 3 và xe Xăng/Dầu.
  7. **Hiệu ứng mở rộng ảnh khi cuộn (Scroll-Expand Image Introduce):** Sử dụng `IntersectionObserver` mở rộng khung ảnh toàn màn hình và chuyển đổi ảnh có logo khi cuộn tới.
  8. **Slider Diện mạo & Form Đăng ký tư vấn Inline:** Carousel hỗ trợ nút bấm, chấm phân trang (pagination bullets), vuốt cảm ứng (touch swipe) trên di động và kiểm tra hợp lệ form trực tiếp.
  9. **Video Giới thiệu Autoplay:** Tự động phát/tạm dừng khi cuộn vào/ra vùng nhìn thấy.
  10. **Thẻ Ngoại thất (Multi-Image Cards) & Nội thất (Interior Gallery):** Bố cục chuẩn xác, hiệu ứng phóng nhẹ khi di chuột.
  11. **Thông số kỹ thuật (Dark Mode Accordion/Tabs):** Chuyển đổi giữa 3 nhóm `Kích thước`, `Pin & Sạc`, `Công nghệ trang bị` cùng liên kết tải Brochure.
  12. **Hệ sinh thái toàn diện, Footer & Popup Đăng ký tư vấn (`<dialog>`):** Đầy đủ kiểm tra định dạng số điện thoại Việt Nam, bộ đếm ký tự (0/300) và nút Sticky trên di động.

## Cấu trúc thư mục
```
vinfast-vf3-product/
├── index.html       # File giao diện HTML chính
├── css/
│   └── style.css    # Toàn bộ style và responsive (Mobile / Tablet / Desktop)
├── js/
│   └── main.js      # Toàn bộ logic tương tác Vanilla JS
└── README.md        # Hướng dẫn sử dụng
```
