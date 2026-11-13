# PROJECT_CONTEXT — VinFast Hải Phòng

## Tổng quan
Website VinFast Hải Phòng được xây dựng bằng Laravel 13, tái tạo từ https://vinfast-haiphong.com/

## Trạng thái hiện tại
- Giai đoạn: 1 — Foundation
- Khởi tạo: 2026-11-13

## Công nghệ
- Backend: Laravel 13.42.0
- PHP: 8.4.4
- Database: MySQL 8.0+
- Template: Blade
- Build: Vite
- Font: Open Sans

## Kiến trúc
- Client: app/Http/Controllers/Client/, resources/views/clients/
- Admin: app/Http/Controllers/Admin/, resources/views/admin/
- Shared: app/Services/Shared/, app/Models/

## Routes
- web.php: Client routes
- admin.php: Admin routes (middleware: web, auth:admin)
- api.php: API routes

## Database
- Chưa thiết kế

## Tình trạng hoàn thành
### Giai đoạn 0 — Audit
- [ ] URL inventory
- [ ] Page matrix
- [ ] Design tokens

### Giai đoạn 1 — Foundation
- [x] Git init
- [x] Cấu trúc thư mục
- [ ] Base layouts
- [ ] Open Sans
- [ ] Context system

## Quyết định quan trọng
- Thanh toán: Chỉ tiền mặt (cash only)
- Font: Open Sans duy nhất
- SSR: Blade (không dùng SPA)
- Giá tiền: BIGINT UNSIGNED VND

## Git Rules
- KHÔNG tự push
- Commit bằng tiếng Việt có dấu
- Format: feat(module): mô tả

## Next Actions
1. Hoàn thành audit website nguồn
2. Thiết kế database
3. Cài Open Sans
4. Tạo base layout Client
