# KIỂM ĐỊNH AN TOÀN VÀ BẢO MẬT (SECURITY AUDIT V2)

## 1. Các Cơ Chế Bảo Vệ Hiện Hữu
- **CSRF Protection:** Mọi form (Leads, Cart, Checkout, Admin forms) đều có token `@csrf`.
- **Idempotency Key:** Form đặt cọc tiền mặt sử dụng UUID `idempotency_key` trong session, ngăn chặn việc người dùng double click hoặc refresh tạo nhiều đơn cọc trùng lặp.
- **SQL Injection:** 100% truy vấn dùng Eloquent ORM và Query Builder với PDO parameter binding.
- **XSS Prevention:** Tránh in thẻ HTML không kiểm soát. Ký tự `@context` trong Blade JSON-LD đã được mã hóa an toàn qua `json_encode()`.

## 2. Kế Hoạch Nâng Cấp Bảo Mật V2
1. **Làm Sạch Nội Dung HTML Khi Dán (Paste Sanitizer):**
   - Khi người dùng dán nội dung từ Word hoặc các trang web bên ngoài vào TinyMCE, backend cần có bộ lọc lọc bỏ các thẻ độc hại như `<script>`, `<iframe>`, `onload`, `onerror`, `javascript:` trước khi lưu vào database.
2. **Bảo Mật API Key TinyMCE:**
   - Không hardcode API key vào mã nguồn Blade.
   - Cấu hình qua `config('services.tinymce.key')` lấy từ `.env`.
3. **Phân Quyền Admin & Rate Limiting:**
   - Bảo vệ route `/admin/login` bằng Rate Limiter (tối đa 5 lần thử/phút) chống brute-force mật khẩu.

