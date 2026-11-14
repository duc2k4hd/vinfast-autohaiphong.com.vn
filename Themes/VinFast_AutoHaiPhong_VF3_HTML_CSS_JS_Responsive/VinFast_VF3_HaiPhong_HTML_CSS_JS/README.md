# VINFAST VF 3 — GIAO DIỆN SẢN PHẨM HẢI PHÒNG

Bản dựng HTML, CSS, JavaScript **thuần**, tham chiếu bố cục trong ảnh chụp người dùng cung cấp và nội dung công khai của trang [VF 3](https://vinfastauto.com/vn_vi/dat-coc-xe-dien-vf3). Đây là **bản triển khai độc lập**, không phải bản xuất mã nguồn chính thức của VinFast.

## Khởi động trên Windows 11

1. Giải nén thư mục `VinFast_VF3_HaiPhong_HTML_CSS_JS`.
2. Nhấp đúp `index.html` để xem trực tiếp, hoặc mở PowerShell tại thư mục này, chạy:

   ```powershell
   py -m http.server 8080
   ```
3. Truy cập `http://localhost:8080`.

Để kiểm tra tính năng trên localhost, nên dùng cách số 2.

## Cấu trúc thư mục

```text
VinFast_VF3_HaiPhong_HTML_CSS_JS/
├── index.html                 # Toàn bộ 11 section và các dialog
├── assets/
│   ├── css/
│   │   ├── style.css          # Bố cục/animation thành phần
│   │   └── responsive.css     # Responsive cho điện thoại, tablet, desktop
│   ├── js/
│   │   ├── config.js          # Giá, phiên bản, màu xe, thông số, link đặt cọc
│   │   └── main.js            # Xử lý menu, gallery, màu, tab, form, calculator
│   └── images/
│       ├── *.webp             # Ảnh fallback từ screenshot do người dùng cung cấp
│       ├── favicon.svg
│       └── REMOTE_ASSETS.md
├── previews/                  # Ảnh chụp QA tại nhiều kích thước viewport
├── QA_REPORT.json             # Kết quả kiểm thử tự động
└── README.md
```

## Tương tác hoạt động

- Menu responsive; đóng khi chọn mục hoặc nhấn Escape.
- Hero 2 slide, điều khiển trái/phải, chấm tròn, tự chuyển theo thời gian.
- Chọn phiên bản Eco/Plus và cập nhật giá giao diện.
- 7 lựa chọn màu, có tên và trạng thái active (màu là **mô phỏng bằng CSS filter**, không phải ảnh thật theo từng mã màu).
- Bảng giả định chi phí: tùy chỉnh km/năm, giá điện/kWh, giá xăng/lít và kết quả cập nhật tức thì. Hệ số sử dụng giả định của bản demo: xe điện 12 kWh/100km, xe xăng 6 lít/100km. Không phải thông số tiêu thụ chính thức của VF 3.
- Tab đặc điểm thiết kế, gallery slider, lightbox ngoại thất và nội thất (phím trái/phải, Escape), tab kỹ thuật.
- Popup form tư vấn có kiểm tra dữ liệu đầu vào và trạng thái rõ ràng. **Không gửi hoặc lưu số điện thoại** vì chưa kết nối backend.
- Các nút đặt cọc mở trang đặt cọc chính thức, không thu tiền trên bản demo.
- Phím tắt hỗ trợ, hiệu ứng xuất hiện khi cuộn, chế độ giảm chuyển động theo cài đặt hệ điều hành.

## Cấu hình

Sửa `assets/js/config.js` để cập nhật `trims`, `colors`, `specGroups`, `designHighlights`, `depositUrl`. Các CTA đặt cọc trong `index.html` cũng có URL chính thức; nếu đổi link đặt cọc thì cập nhật cả HTML.

Toàn bộ CSS class trong HTML đều dùng tiền tố **`vinfast-autohaiphong_product_`**. ID chỉ dùng cho các anchor section và quan hệ truy cập của dialog.

## Tài nguyên ảnh và giới hạn tái tạo

Ảnh fallback đóng gói trong `assets/images` là **các vùng ảnh cắt từ screenshot 264 × 2047 px người dùng đã tải lên**. Một số ảnh lớn có hỗ trợ URL từ nguồn công khai (`data-remote-image`); nếu truy cập web và ảnh có thể tải, JavaScript sẽ thay ảnh fallback bằng ảnh có độ phân giải cao hơn. Trình duyệt offline sẽ giữ ảnh screenshot chất lượng thấp.

Vì không tải được nguyên bộ HTML/CSS/JS và các file đồ họa của website chính thức từ môi trường dựng, **không thể xác nhận trùng khớp 100% từng pixel, animation hay toàn bộ chức năng backend**. Ảnh từ nguồn khác chỉ dùng để minh họa, không khẳng định là ảnh trên trang mẫu. Cần có quyền sử dụng hình ảnh, logo, thương hiệu trước khi xuất bản thương mại.

## Tích hợp Laravel thực tế

- Chuyển các section sang Blade partial, giữ prefix CSS.
- Thay form demo bằng POST tới API Laravel + CSRF, rate limiting, reCAPTCHA nếu cần, thông báo chính sách xử lý dữ liệu cá nhân.
- Thay hình phối màu CSS filter bằng ảnh đã được phê duyệt cho từng màu/phiên bản.
- Gắn dữ liệu phiên bản/giá theo bảng `products`, `variants` và `settings`, không hardcode trong production.
- Chỉ sử dụng API đặt cọc/thanh toán của nền tảng được ủy quyền, không giả danh thanh toán VinFast.
- Thiết lập tên miền và các trang chính sách cho website thực tế.

## Kiểm thử

`QA_REPORT.json`: đã chạy Chromium trên 5 độ rộng **320, 390, 768, 1024, 1440 px** bằng bản dựng HTML/CSS/JS tương đương được nội tuyến trong môi trường test. Không phát hiện JavaScript error hoặc overflow theo phép đo `documentElement.scrollWidth - window.innerWidth`. Đã bấm thử đổi phiên bản, màu, thông số, chi phí, dialog và lightbox. Đây không phải kiểm thử 100% mọi trình duyệt.
