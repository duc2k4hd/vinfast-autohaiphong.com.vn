# KIỂM ĐỊNH LUỒNG LÀM VIỆC ADMIN (ADMIN WORKFLOW AUDIT V2)

## 1. Mục Tiêu Cốt Lõi Của Giao Diện Admin
Giao diện Admin phải đạt tiêu chuẩn: **Nhân viên không có kiến thức kỹ thuật hoặc lập trình cũng có thể quản trị xe, giá, hình ảnh, bài viết, đơn hàng và báo giá một cách nhanh chóng, chính xác và không sợ thao tác nhầm.**

## 2. Kiểm Định Chi Tiết Từng Luồng Nghiệp Vụ
### 2.1. Luồng Quản Lý Sản Phẩm Xe & Thông Số Key-Value (`/admin/products`)
- **Hiện trạng:**
  - Danh sách xe hiển thị ảnh, tên xe, giá niêm yết, giá khuyến mãi.
  - Form chỉnh sửa có thể thêm/bớt thông số Key-Value bằng nút "+ Thêm Dòng Thông Số" và xóa từng dòng.
- **Điểm cần nâng cấp V2:**
  - Thay thế ô nhập mô tả chi tiết `<textarea>` bằng trình soạn thảo **TinyMCE** chuyên nghiệp.
  - Tích hợp nút "Chọn ảnh từ Thư viện" (Media Picker) để thay đổi ảnh đại diện xe thay vì nhập URL hay chỉ dùng ảnh mặc định.
  - Bổ sung tab/khối quản lý Biến thể (Variants) cho xe: Thêm phiên bản (Base, Plus), chính sách pin (Thuê pin / Mua đứt pin).
  - Cảnh báo khi người dùng sửa dữ liệu mà chưa bấm Lưu (Unsaved changes warning).

### 2.2. Luồng Quản Lý Đơn Cọc Tiền Mặt (`/admin/orders`)
- **Hiện trạng:**
  - Danh sách đơn hàng với mã `VFHP-YYYYMMDD-XXXX`, tên khách, số điện thoại, tổng tiền, phương thức `cash`.
  - Có nút "Xác nhận đã nhận tiền mặt" gọi `PATCH /admin/orders/{id}/confirm-cash`.
- **Điểm cần nâng cấp V2:**
  - Bổ sung bộ lọc trạng thái đơn: Chờ nộp tiền mặt tại Showroom, Đã thu tiền mặt, Hoàn tất bàn giao xe, Đã hủy.
  - Tích hợp ô nhập "Ghi chú nội bộ" khi nhân viên showroom thu tiền mặt (ví dụ: Số phiếu thu, tên nhân viên thu ngân).
  - Tách bạch trạng thái thanh toán (`payment_status: paid / pending`) và trạng thái đơn (`status: pending / processing / completed / cancelled`).

### 2.3. Luồng Quản Lý Khách Hàng Báo Giá (`/admin/leads`)
- **Hiện trạng:**
  - Danh sách hiển thị tên, điện thoại, dòng xe quan tâm, ghi chú, trạng thái `new`.
  - Có thể đổi trạng thái sang `contacted`, `converted`, `cancelled`.
- **Điểm cần nâng cấp V2:**
  - Nút chuyển trạng thái nhanh dạng dropdown hoặc badge chọn trực tiếp không cần reload trang phức tạp.
  - Nút gọi nhanh điện thoại `tel:...` cho nhân viên trực tổng đài click là kết nối ngay.
  - Lọc theo dòng xe mà khách hàng quan tâm (VF 3, VF 5, VF 8...).

### 2.4. Luồng Biên Tập Tin Tức & Bài Viết (`/admin/posts`)
- **Hiện trạng:**
  - CRUD bài viết tin tức cơ bản.
- **Điểm cần nâng cấp V2 (Ưu Tiên P0):**
  - Tích hợp **TinyMCE** với API Key từ `APP_TINYMCE_KEY` qua `config('services.tinymce.key')`.
  - Tích hợp Media Manager để chèn ảnh nội bộ vào giữa bài viết.
  - Làm sạch mã HTML (paste cleanup) khi copy bài từ báo chí hoặc Word vào không bị dính style rác.
  - Tích hợp widget đánh giá SEO thời gian thực (độ dài tiêu đề, mật độ từ khóa, thời gian đọc).

### 2.5. Luồng Quản Lý Thư Viện Media Tập Trung (`/admin/media`)
- **Hiện trạng:**
  - Upload file và xem danh sách ảnh.
- **Điểm cần nâng cấp V2:**
  - Chức năng Copy nhanh URL ảnh để sử dụng.
  - Hiển thị kích thước tệp (KB/MB) và số lần ảnh đang được sử dụng (usages check) để ngăn chặn việc vô tình xóa mất ảnh đang hiển thị ngoài trang chủ hoặc trang sản phẩm.

