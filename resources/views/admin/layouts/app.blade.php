<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quản Trị Hệ Thống') | VinFast Hải Phòng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #1464f4;
            --admin-primary-hover: #0d52ce;
            --admin-bg: #f8fafc;
            --admin-surface: #ffffff;
            --admin-border: #e2e8f0;
            --admin-heading: #0f172a;
            --admin-text: #334155;
            --admin-muted: #64748b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Open Sans', sans-serif; background-color: var(--admin-bg); color: var(--admin-text); font-size: 14px; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }
        
        .vinfast-autohaiphong_admin_layout { display: flex; min-height: 100vh; }
        .vinfast-autohaiphong_admin_sidebar { width: 250px; background-color: #ffffff; border-right: 1px solid var(--admin-border); flex-shrink: 0; display: flex; flex-direction: column; }
        .vinfast-autohaiphong_admin_sidebar_brand { padding: 20px 24px; border-bottom: 1px solid var(--admin-border); font-size: 1.05rem; font-weight: 800; color: var(--admin-primary); letter-spacing: 0.5px; }
        .vinfast-autohaiphong_admin_sidebar_menu { list-style: none; padding: 16px 12px; flex: 1; }
        .vinfast-autohaiphong_admin_sidebar_heading { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--admin-muted); padding: 14px 14px 6px 14px; }
        .vinfast-autohaiphong_admin_sidebar_link { display: flex; align-items: center; gap: 10px; padding: 9px 14px; border-radius: 6px; font-weight: 600; color: var(--admin-text); margin-bottom: 2px; transition: all 0.15s ease; font-size: 0.88rem; }
        .vinfast-autohaiphong_admin_sidebar_link:hover, .vinfast-autohaiphong_admin_sidebar_link.active { background-color: #eff6ff; color: var(--admin-primary); }
        .vinfast-autohaiphong_admin_sidebar_link svg { width: 18px; height: 18px; flex-shrink: 0; stroke-width: 2; }
        
        .vinfast-autohaiphong_admin_main { flex: 1; display: flex; flex-direction: column; overflow-x: hidden; }
        .vinfast-autohaiphong_admin_topbar { height: 60px; background: #ffffff; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; }
        .vinfast-autohaiphong_admin_content { padding: 28px; flex: 1; }
        
        .vinfast-autohaiphong_admin_card { background: #ffffff; border: 1px solid var(--admin-border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 2px rgba(0,0,0,0.03); margin-bottom: 24px; }
        .vinfast-autohaiphong_admin_card_title { font-size: 1.1rem; font-weight: 700; color: var(--admin-heading); margin-bottom: 16px; border-bottom: 1px solid var(--admin-border); padding-bottom: 10px; }
        
        .vinfast-autohaiphong_admin_product_thumb { width: 96px; aspect-ratio: 16 / 9; height: auto; object-fit: contain; border: 1px solid var(--admin-border); border-radius: 4px; background: #fff; display: block; }
        .vinfast-autohaiphong_admin_product_preview { width: min(100%, 320px); aspect-ratio: 16 / 9; height: auto; border-radius: 6px; border: 1px solid var(--admin-border); overflow: hidden; background: #f8fafc; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .vinfast-autohaiphong_admin_product_preview_image { width: 100%; height: 100%; object-fit: contain; }
        .vinfast-autohaiphong_admin_table { width: 100%; border-collapse: collapse; text-align: left; }
        .vinfast-autohaiphong_admin_table th { background: #f8fafc; padding: 12px 16px; font-weight: 600; font-size: 0.78rem; color: var(--admin-muted); border-bottom: 1px solid var(--admin-border); text-transform: uppercase; letter-spacing: 0.5px; }
        .vinfast-autohaiphong_admin_table td { padding: 14px 16px; border-bottom: 1px solid var(--admin-border); font-size: 0.88rem; vertical-align: middle; }
        
        .vinfast-autohaiphong_admin_badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; }
        .vinfast-autohaiphong_admin_badge_success { background: #dcfce7; color: #166534; }
        .vinfast-autohaiphong_admin_badge_warning { background: #fef3c7; color: #92400e; }
        .vinfast-autohaiphong_admin_badge_danger { background: #fee2e2; color: #991b1b; }
        
        .vinfast-autohaiphong_admin_btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 5px; font-weight: 600; font-size: 0.85rem; cursor: pointer; border: 1px solid transparent; transition: all 0.15s ease; }
        .vinfast-autohaiphong_admin_btn_primary { background-color: var(--admin-primary); color: #ffffff; }
        .vinfast-autohaiphong_admin_btn_primary:hover { background-color: var(--admin-primary-hover); }
        .vinfast-autohaiphong_admin_btn_outline { background-color: transparent; border-color: var(--admin-border); color: var(--admin-text); }
        .vinfast-autohaiphong_admin_btn_outline:hover { background-color: #f1f5f9; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="vinfast-autohaiphong_admin_layout">
        {{-- Sidebar --}}
        <aside class="vinfast-autohaiphong_admin_sidebar">
            <div class="vinfast-autohaiphong_admin_sidebar_brand">
                VINFAST HẢI PHÒNG
                <div style="font-size: 0.75rem; color: var(--admin-muted); font-weight: normal; margin-top: 2px;">Hệ Thống Quản Trị Doanh Nghiệp</div>
            </div>
            <ul class="vinfast-autohaiphong_admin_sidebar_menu">
                <li class="vinfast-autohaiphong_admin_sidebar_heading">TỔNG QUAN</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        Bảng Điều Khiển
                    </a>
                </li>

                <li class="vinfast-autohaiphong_admin_sidebar_heading">BÁN HÀNG</li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        Đơn Đặt Cọc Tiền Mặt
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.leads.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.leads*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        Yêu Cầu Báo Giá
                    </a>
                </li>

                <li class="vinfast-autohaiphong_admin_sidebar_heading">SẢN PHẨM & NỘI DUNG</li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 17h14M5 17a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2M5 17l-2 3h18l-2-3"></path><circle cx="7.5" cy="12.5" r="1.5"></circle><circle cx="16.5" cy="12.5" r="1.5"></circle></svg>
                        Quản Lý Dòng Xe
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.posts.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        Quản Lý Tin Tức
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.media.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.media*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        Thư Viện Media
                    </a>
                </li>

                <li class="vinfast-autohaiphong_admin_sidebar_heading">HỆ THỐNG</li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        Cài Đặt Hệ Thống
                    </a>
                </li>
                <li style="margin-top: 18px; border-top: 1px solid var(--admin-border); padding-top: 10px;">
                    <a href="{{ route('client.home') }}" target="_blank" class="vinfast-autohaiphong_admin_sidebar_link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        Xem Website Ngoài
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Main Area --}}
        <div class="vinfast-autohaiphong_admin_main">
            {{-- Topbar --}}
            <header class="vinfast-autohaiphong_admin_topbar">
                <div>
                    @if(View::hasSection('breadcrumb'))
                        <div style="font-size: 0.76rem; color: var(--admin-muted); margin-bottom: 2px;">
                            @yield('breadcrumb')
                        </div>
                    @endif
                    <div style="font-weight: 700; color: var(--admin-heading); font-size: 1.05rem;">
                        @yield('header_title', 'Bảng Điều Khiển')
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <span style="font-weight: 600; color: var(--admin-text); display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        {{ auth()->user()->name ?? 'Quản Trị Viên' }}
                    </span>
                    <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 6px 12px; font-size: 0.8rem;">
                            Đăng Xuất
                        </button>
                    </form>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="vinfast-autohaiphong_admin_content">
                @if(session('success'))
                    <div style="background-color: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">
                        ✓ {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="background-color: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 600;">
                        ✕ {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
    @include('admin.components.confirm-dialog')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const trackedForms = document.querySelectorAll('form.form-track-changes');
        trackedForms.forEach(function (form) {
            let isDirty = false;
            let isSubmitting = false;

            form.addEventListener('input', () => isDirty = true);
            form.addEventListener('change', () => isDirty = true);
            form.addEventListener('submit', () => isSubmitting = true);

            window.addEventListener('beforeunload', function (e) {
                if (isDirty && !isSubmitting) {
                    e.preventDefault();
                    e.returnValue = 'Bạn có các thay đổi chưa được lưu. Bạn có chắc chắn muốn rời đi?';
                    return e.returnValue;
                }
            });
        });
    });
    </script>
    @stack('scripts')
</body>
</html>

