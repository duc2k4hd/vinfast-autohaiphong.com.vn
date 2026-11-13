<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị | VinFast Hải Phòng</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #f8fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .vinfast-autohaiphong_admin_login_box { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; width: 100%; max-width: 420px; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .vinfast-autohaiphong_admin_login_title { font-size: 1.5rem; font-weight: 800; color: #0f172a; text-align: center; margin-bottom: 6px; }
        .vinfast-autohaiphong_admin_login_sub { font-size: 0.85rem; color: #64748b; text-align: center; margin-bottom: 28px; }
        .vinfast-autohaiphong_admin_form_group { margin-bottom: 20px; }
        .vinfast-autohaiphong_admin_form_group label { display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 6px; color: #334155; }
        .vinfast-autohaiphong_admin_form_group input { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem; box-sizing: border-box; }
        .vinfast-autohaiphong_admin_btn_login { width: 100%; background: #1464f4; color: #ffffff; border: none; padding: 12px; border-radius: 6px; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: background 0.15s ease; }
        .vinfast-autohaiphong_admin_btn_login:hover { background: #0b50c8; }
    </style>
</head>
<body>
    <div class="vinfast-autohaiphong_admin_login_box">
        <h1 class="vinfast-autohaiphong_admin_login_title">VINFAST HẢI PHÒNG</h1>
        <div class="vinfast-autohaiphong_admin_login_sub">Đăng Nhập Cổng Quản Trị Hệ Thống 3S</div>

        @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 10px 14px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 20px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="vinfast-autohaiphong_admin_form_group">
                <label>Email Quản Trị</label>
                <input type="email" name="email" value="{{ old('email', 'admin@vinfast-autohaiphong.com.vn') }}" required autofocus placeholder="admin@example.com">
            </div>

            <div class="vinfast-autohaiphong_admin_form_group">
                <label>Mật Khẩu</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <label style="display: flex; align-items: center; gap: 6px; font-size: 0.85rem; color: #475569; cursor: pointer;">
                    <input type="checkbox" name="remember" value="1" checked>
                    Ghi nhớ đăng nhập
                </label>
            </div>

            <button type="submit" class="vinfast-autohaiphong_admin_btn_login">
                Đăng Nhập Quản Trị &rarr;
            </button>
        </form>
    </div>
</body>
</html>

