# Báo Cáo Kiểm Tra Dữ Liệu Nguồn (Reference Data Audit) — vinfast-haiphong.com

## 1. Dữ Liệu Sản Phẩm Xe Thu Thập Được
| Tên Xe | Slug Nguồn | Mức Giá Tham Khảo (VND) | Số Lượng Ảnh Sitemap | Trạng Thái Kiểm Tra |
| :--- | :--- | :--- | :--- | :--- |
| VinFast VF 2 | `vinfast-vf-2` | ~ 188.000.000 | 18 ảnh | Khớp sitemap |
| VinFast VF 3 | `vinfast-vf-3` | ~ 285.000.000 | 30 ảnh | Khớp sitemap |
| VinFast VF 5 Plus | `vinfast-vf-5` | ~ 496.000.000 | 27 ảnh | Khớp sitemap |
| VinFast VF 6 | `vinfast-vf-6` | ~ 646.000.000 | 24 ảnh | Khớp sitemap |
| VinFast VF 7 | `vinfast-vf-7` | ~ 740.000.000 | 32 ảnh | Khớp sitemap |
| VinFast VF 8 | `vinfast-vf-8` | ~ 850.000.000 | 55 ảnh | Khớp sitemap |
| VinFast VF 8 All New | `vinfast-vf8-all-new` | ~ 899.000.000 | 30 ảnh | Khớp sitemap |
| VinFast VF 9 | `vinfast-vf-9` | ~ 1.348.000.000 | 19 ảnh | Khớp sitemap |
| VinFast VF Wild | `vinfast-vf-wild` | ~ 860.000.000 | 4 ảnh | Khớp sitemap (Bản concept/đặt trước) |
| VinFast VF MPV 7 | `vinfast-vf-mpv-7` | ~ 750.000.000 | 11 ảnh | Khớp sitemap |
| VinFast EC Van | `vinfast-ec-van` | ~ 268.000.000 | 5 ảnh | Khớp sitemap |
| VinFast Limo Green | `vinfast-limo-green` | ~ 699.000.000 | 12 ảnh | Khớp sitemap |
| VinFast Nerio Green | `vinfast-nerio-green` | ~ 628.000.000 | 9 ảnh | Khớp sitemap |
| VinFast Herio Green | `vinfast-herio-green` | ~ 450.000.000 | 8 ảnh | Khớp sitemap |
| VinFast Minio Green | `vinfast-minio-green` | ~ 188.000.000 | 11 ảnh | Khớp sitemap |

---

## 2. Quy Tắc Giá & Đặt Hàng
- Đơn vị lưu trữ cơ sở dữ liệu: `BIGINT UNSIGNED` (VNĐ tuyệt đối, không lưu số thực float).
- Mức giá trên mang tính chất niêm yết tham khảo, hệ thống hỗ trợ trạng thái `price_on_request` (Báo giá lăn bánh).
- Quy trình thanh toán: **DUY NHẤT TIỀN MẶT (CASH ONLY)** theo đúng yêu cầu nghiệp vụ cố định mục 5.6. Không tích hợp cổng trực tuyến tự động.
