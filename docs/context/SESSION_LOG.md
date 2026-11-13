# Nhật Ký Các Phiên Làm Việc (Session Log) — VinFast Hải Phòng

## Phiên làm việc: 2026-11-13 10:55

### 1. Đã hoàn thành:
- **Cập nhật quy tắc Git tuyệt đối vào Context:**
  - AI tuyệt đối không chạy bất kỳ lệnh `git` nào (không add, commit, push hay status).
  - AI chỉ soạn thảo câu lệnh và nội dung commit mẫu bằng tiếng Việt có dấu để người dùng tự thực thi.
- **Cập nhật toàn diện thông tin liên hệ chuẩn xác VinFast Minh Đạo:**
  - Bán hàng: `0988 302 882`
  - Dịch vụ – phụ tùng: `0915 286 506`
  - CSKH Kinh doanh: `0915 286 503`
  - CSKH Dịch vụ: `0843 714 333`
  - Giờ làm việc: Thứ 2 – Thứ 7: Dịch vụ 7h50–17h00, Kinh doanh 7h30–18h00 | Chủ nhật: Kinh doanh 7h00–18h00, Dịch vụ nghỉ.
  - Facebook: `https://www.facebook.com/VinFastMinhDao`
- **Đồng bộ Cơ sở dữ liệu & Giao diện:**
  - Cập nhật seeder [InitialSettingsSeeder.php](file:///e:/Project/Laravel/vinfast-autohaiphong.com.vn/database/seeders/InitialSettingsSeeder.php) và chạy nạp vào DB thật.
  - Xóa cache settings.
  - Cập nhật Header, Footer (khối thông tin liên hệ 4 bộ phận, giờ làm việc, link fanpage) và Floating Action buttons.
  - Cập nhật Feature Test [tests/Feature/HomeTest.php](file:///e:/Project/Laravel/vinfast-autohaiphong.com.vn/tests/Feature/HomeTest.php) -> **100% PASS**.

### 2. Công việc tiếp theo:
- Xây dựng trang danh mục sản phẩm `/o-to-vinfast/`.
- Xây dựng trang chi tiết từng dòng xe `/xe/{slug}/`.
- Xây dựng giỏ hàng và màn hình thanh toán tiền mặt duy nhất (`/gio-hang/`, `/thanh-toan/`).
- Xây dựng hệ thống quản trị Admin (`/admin/dashboard`, `/admin/products`).
