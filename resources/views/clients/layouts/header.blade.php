{{-- Topbar --}}
<div class="vinfast-autohaiphong_header_topbar">
    <div class="vinfast-autohaiphong_layout_container vinfast-autohaiphong_header_topbar_inner">
        <div class="vinfast-autohaiphong_header_topbar_contact">
            <span>📍 {{ $siteSettings['site_address'] ?? 'Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng' }}</span>
            <span>🕒 {{ $siteSettings['site_hours'] ?? '08:00 - 18:00 (Thứ 2 - Chủ Nhật)' }}</span>
        </div>
        <div>
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0966597282') }}" class="vinfast-autohaiphong_header_topbar_link">
                <span>📞 Hotline: <strong>{{ $siteSettings['site_phone'] ?? '0966.597.282' }}</strong></span>
            </a>
        </div>
    </div>
</div>

{{-- Header Chính --}}
<header class="vinfast-autohaiphong_header_main">
    <div class="vinfast-autohaiphong_layout_container vinfast-autohaiphong_header_inner">
        {{-- Logo --}}
        <a href="{{ route('client.home') }}" class="vinfast-autohaiphong_header_logo">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L2 22h4l6-13 6 13h4L12 2z"/>
            </svg>
            <span>VINFAST HẢI PHÒNG</span>
            <span class="vinfast-autohaiphong_header_logo_badge">3S</span>
        </a>

        {{-- Desktop Navigation --}}
        <nav class="vinfast-autohaiphong_header_nav">
            <ul class="vinfast-autohaiphong_header_nav_list">
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ route('client.home') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->routeIs('client.home') ? 'active' : '' }}">
                        Trang chủ
                    </a>
                </li>
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/o-to-vinfast') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('o-to-vinfast*') ? 'active' : '' }}">
                        Ô Tô VinFast ▾
                    </a>
                    <div class="vinfast-autohaiphong_header_dropdown">
                        <a href="{{ url('/xe/vinfast-vf-3') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 3</a>
                        <a href="{{ url('/xe/vinfast-vf-5') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 5 Plus</a>
                        <a href="{{ url('/xe/vinfast-vf-6') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 6</a>
                        <a href="{{ url('/xe/vinfast-vf-7') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 7</a>
                        <a href="{{ url('/xe/vinfast-vf-8') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 8</a>
                        <a href="{{ url('/xe/vinfast-vf-9') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 9</a>
                        <a href="{{ url('/xe/vinfast-vf-wild') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF Wild</a>
                        <a href="{{ url('/xe/vinfast-minio-green') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast Minio Green</a>
                        <a href="{{ url('/xe/vinfast-ec-van') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast EC Van</a>
                    </div>
                </li>
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/pin-va-tram-sac') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('pin-va-tram-sac*') ? 'active' : '' }}">
                        Pin & Trạm Sạc
                    </a>
                </li>
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/trai-nghiem-khach-hang') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('trai-nghiem-khach-hang*') ? 'active' : '' }}">
                        Trải Nghiệm Khách Hàng
                    </a>
                </li>
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/chuyen-muc/tin-tuc') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('chuyen-muc/tin-tuc*') ? 'active' : '' }}">
                        Tin Tức
                    </a>
                </li>
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/lien-he') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('lien-he*') ? 'active' : '' }}">
                        Liên Hệ
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Header Actions --}}
        <div>
            <button type="button" onclick="openQuoteModal(null, 'Tất cả các dòng xe')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_accent">
                Báo Giá Lăn Bánh
            </button>
        </div>
    </div>
</header>
