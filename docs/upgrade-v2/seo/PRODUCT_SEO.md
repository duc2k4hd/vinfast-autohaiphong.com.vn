# TỐI ƯU HÓA SEO CHO DÒNG XE Ô TÔ (PRODUCT SEO V2)

## 1. Yêu Cầu Cho Từng Mẫu Xe (`/xe/{slug}`)
- **Thẻ H1 duy nhất:** Tên chính thức của dòng xe (ví dụ: `VINFAST VF 3`, `VINFAST VF 8`).
- **Thẻ Meta Title:** Chứa tên xe, bảng giá lăn bánh và tên đại lý VinFast Hải Phòng (dưới 65 ký tự).
- **Thẻ Meta Description:** Tóm tắt ngắn gọn phân khúc xe, công suất, tầm hoạt động mỗi lần sạc, giá niêm yết và ưu đãi tiền mặt (khoảng 140–160 ký tự).
- **Ảnh Đại Diện (OG Image):** Ảnh xe góc 3/4 chính diện, rõ nét, có thuộc tính `alt` mô tả chính xác.
- **Bảng Thông Số Kỹ Thuật:** Định dạng HTML dạng bảng Key-Value sạch sẽ đặt ngay đầu trang, giúp Google trích xuất Featured Snippet tốt nhất.
- **Structured Data JSON-LD:**
  ```json
  {
    "@context": "https://schema.org/",
    "@type": "Car",
    "name": "VinFast VF 3",
    "brand": {
      "@type": "Brand",
      "name": "VinFast"
    },
    "offers": {
      "@type": "Offer",
      "priceCurrency": "VND",
      "price": 285000000,
      "availability": "https://schema.org/InStock"
    }
  }
  ```

