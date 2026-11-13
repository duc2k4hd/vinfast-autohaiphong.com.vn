<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản Trị Hệ Thống') | VinFast Hải Phòng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #1464f4;
            --admin-bg: #f8fafc;
            --admin-surface: #ffffff;
            --admin-border: #e2e8f0;
            --admin-heading: #0f172a;
            --admin-text: #334155;
            --admin-muted: #64748b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Open Sans', sans-serif; background-color: var(--admin-bg); color: var(--admin-text); font-size: 14px; }
        a { text-decoration: none; color: inherit; }
        
        .vinfast-autohaiphong_admin_layout { display: flex; min-height: 100vh; }
        .vinfast-autohaiphong_admin_sidebar { width: 250px; background-color: #ffffff; border-right: 1px solid var(--admin-border); flex-shrink: 0; display: flex; flex-direction: column; }
        .vinfast-autohaiphong_admin_sidebar_brand { padding: 20px 24px; border-bottom: 1px solid var(--admin-border); font-size: 1.1rem; font-weight: 800; color: var(--admin-primary); }
        .vinfast-autohaiphong_admin_sidebar_menu { list-style: none; padding: 16px 12px; flex: 1; }
        .vinfast-autohaiphong_admin_sidebar_link { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 6px; font-weight: 600; color: var(--admin-text); margin-bottom: 4px; transition: all 0.15s ease; }
        .vinfast-autohaiphong_admin_sidebar_link:hover, .vinfast-autohaiphong_admin_sidebar_link.active { background-color: #eff6ff; color: var(--admin-primary); }
        
        .vinfast-autohaiphong_admin_main { flex: 1; display: flex; flex-direction: column; overflow-x: hidden; }
        .vinfast-autohaiphong_admin_topbar { height: 60px; background: #ffffff; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; }
        .vinfast-autohaiphong_admin_content { padding: 28px; flex: 1; }
        
        .vinfast-autohaiphong_admin_card { background: #ffffff; border: 1px solid var(--admin-border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 24px; }
        .vinfast-autohaiphong_admin_card_title { font-size: 1.15rem; font-weight: 700; color: var(--admin-heading); margin-bottom: 16px; border-bottom: 1px solid var(--admin-border); padding-bottom: 10px; }
        
        .vinfast-autohaiphong_admin_table { width: 100%; border-collapse: collapse; text-align: left; }
        .vinfast-autohaiphong_admin_table th { background: #f8fafc; padding: 12px 16px; font-weight: 600; font-size: 0.8rem; color: var(--admin-muted); border-bottom: 1px solid var(--admin-border); text-transform: uppercase; }
        .vinfast-autohaiphong_admin_table td { padding: 14px 16px; border-bottom: 1px solid var(--admin-border); font-size: 0.9rem; vertical-align: middle; }
        
        .vinfast-autohaiphong_admin_badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; }
        .vinfast-autohaiphong_admin_badge_success { background: #dcfce7; color: #166534; }
        .vinfast-autohaiphong_admin_badge_warning { background: #fef3c7; color: #92400e; }
        .vinfast-autohaiphong_admin_badge_danger { background: #fee2e2; color: #991b1b; }
        
        .vinfast-autohaiphong_admin_btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 5px; font-weight: 600; font-size: 0.85rem; cursor: pointer; border: 1px solid transparent; }
        .vinfast-autohaiphong_admin_btn_primary { background-color: var(--admin-primary); color: #ffffff; }
        .vinfast-autohaiphong_admin_btn_primary:hover { background-color: #0b50c8; }
        .vinfast-autohaiphong_admin_btn_outline { background-color: transparent; border-color: var(--admin-border); color: var(--admin-text); }
        .vinfast-autohaiphong_admin_btn_outline:hover { background-color: #f1f5f9; }
    </style>
</head>
<body>
    <div class="vinfast-autohaiphong_admin_layout">
        {{-- Sidebar --}}
        <aside class="vinfast-autohaiphong_admin_sidebar">
            <div class="vinfast-autohaiphong_admin_sidebar_brand">
                VINFAST HẢI PHÒNG
                <div style="font-size: 0.75rem; color: var(--admin-muted); font-weight: normal; margin-top: 2px;">Quản Trị Hệ Thống 3S</div>
            </div>
            <ul class="vinfast-autohaiphong_admin_sidebar_menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        📊 Tổng Quan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                        🚗 Quản Lý Dòng Xe
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        💵 Đơn Đặt Cọc Tiền Mặt
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.leads.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.leads*') ? 'active' : '' }}">
                        📋 Yêu Cầu Báo Giá
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="vinfast-autohaiphong_admin_sidebar_link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        ⚙️ Cài Đặt Hệ Thống
                    </a>
                </li>
                <li style="margin-top: 24px; border-top: 1px solid var(--admin-border); padding-top: 12px;">
                    <a href="{{ route('client.home') }}" target="_blank" class="vinfast-autohaiphong_admin_sidebar_link">
                        🌐 Xem Website Ngoài
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Main Area --}}
        <div class="vinfast-autohaiphong_admin_main">
            {{-- Topbar --}}
            <header class="vinfast-autohaiphong_admin_topbar">
                <div style="font-weight: 700; color: var(--admin-heading);">
                    @yield('header_title', 'Bảng Điều Khiển')
                </div>
                <div style="display: flex; align-items: center; gap: 16px;">
                    <span style="font-weight: 600; color: var(--admin-text);">
                        👤 {{ auth()->user()->name ?? 'Quản Trị Viên' }}
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
</body>
</html>

