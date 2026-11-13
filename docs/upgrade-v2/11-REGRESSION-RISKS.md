# BẢNG ĐÁNH GIÁ NGUY CƠ LỖI HỒI QUY (REGRESSION RISKS V2)

| Nguy Cơ Tiềm Ẩn | Phạm Vi Tác Động | Biện Pháp Phòng Ngừa & Kiểm Soát |
| :--- | :--- | :--- |
| **Sửa giao diện Admin làm hỏng CSS Client** | Client UI | Tách biệt tuyệt đối file CSS: `resources/css/clients/app.css` dùng tiền tố `vinfast-autohaiphong_`, còn `resources/css/admin/app.css` dùng tiền tố `vinfast-autohaiphong_admin_`. |
| **Tích hợp TinyMCE làm mất nội dung mô tả cũ** | Dữ liệu Sản phẩm & Bài viết | TinyMCE chỉ đóng vai trò trình biên tập giao diện, giá trị textarea vẫn map đúng trường `description_html` và `content` trong DB. Trước khi update phải giữ lại dữ liệu hiện có. |
| **Sửa cấu hình Database làm mất 15 dòng xe hoặc 117 specs** | Dữ liệu Xe | Nghiêm cấm chạy `migrate:fresh` hoặc `db:wipe`. Chỉ dùng migrations bổ sung và Seeder kiểm tra `firstOrCreate` hoặc cập nhật an toàn. |
| **Thay đổi URL hoặc slug làm hỏng SEO Google** | SEO Rankings | Toàn bộ 15 slug xe (`vinfast-vf-3`, `vinfast-vf-8`...) và các route (`/o-to-vinfast`, `/pin-va-tram-sac`) được khóa cứng cố định. Có bài test `CatalogAndProductTest` và `SitemapAndSeoTest` bảo vệ. |
| **Thay đổi luồng thanh toán ảnh hưởng đặt cọc tiền mặt** | Nghiệp vụ Đơn hàng | Khóa cứng phương thức thanh toán duy nhất là `cash`. Mọi thay đổi ở form checkout bắt buộc phải pass bộ test `CartAndCheckoutTest`. |

