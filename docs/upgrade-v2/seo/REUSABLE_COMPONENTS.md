# CÁC THÀNH PHẦN SEO TÁI SỬ DỤNG (REUSABLE COMPONENTS)

Từ việc nghiên cứu mã nguồn thực tế tại `E:\Project\Laravel\nobifashion.vn`, các thành phần chất lượng cao sau đây được chọn để kế thừa và tích hợp vào VinFast Hải Phòng:

1. **`App\Services\Shared\SeoService`:**
   - Thuật toán sinh slug duy nhất với cơ chế chống trùng lặp `generateUniqueSlug()`.
   - Thuật toán rút gọn trích đoạn sạch HTML và loại bỏ khoảng trắng thừa `generateExcerpt()`.
   - Thuật toán phân tích nội dung bài viết: Đếm số từ, ước tính thời gian đọc bài `estimateReadingTime()`, mật độ từ khóa `calculateKeywordDensity()`.
   - Thang chấm điểm SEO chuẩn mực cho bài viết và xe: Kiểm tra độ dài Meta Title (40–65 ký tự), Meta Description (80–165 ký tự), ảnh thumbnail, thẻ H1/H2.

2. **Endpoint Phân Tích SEO Phía Admin (`Admin\SeoController`):**
   - Tuyến đường `POST /admin/seo/analyze` trả về dữ liệu phân tích JSON cho trình soạn thảo TinyMCE.

3. **Bộ Thẻ Meta Mở Rộng Cho Social Media & Bảo Mật:**
   - Bổ sung `og:image:width`, `og:image:height`, `og:image:alt`.
   - Thêm các header bảo mật hữu ích cho SEO: `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`.

