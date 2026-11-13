{{-- Topbar --}}
<div class="vinfast-autohaiphong_header_topbar">
    <div class="vinfast-autohaiphong_layout_container vinfast-autohaiphong_header_topbar_inner">
        <div class="vinfast-autohaiphong_header_topbar_contact">
            <span>📍 {{ $siteSettings['site_address'] ?? 'Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng, Hải Phòng' }}</span>
            <span>🕒 {{ $siteSettings['site_hours'] ?? 'T2–T7: Dịch vụ 7h50–17h00, KD 7h30–18h00 | CN: KD 7h00–18h00' }}</span>
        </div>
        <div style="display: flex; align-items: center; gap: 14px;">
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0988302882') }}" class="vinfast-autohaiphong_header_topbar_link">
                <span>📞 Bán hàng: <strong>{{ $siteSettings['site_phone'] ?? '0988 302 882' }}</strong></span>
            </a>
            <span style="opacity: 0.3;">|</span>
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone_service'] ?? '0915286506') }}" class="vinfast-autohaiphong_header_topbar_link">
                <span>🔧 Dịch vụ: <strong>{{ $siteSettings['site_phone_service'] ?? '0915 286 506' }}</strong></span>
            </a>
            <span style="opacity: 0.3;">|</span>
            <a href="{{ $siteSettings['site_facebook'] ?? 'https://www.facebook.com/VinFastMinhDao' }}" target="_blank" rel="noopener noreferrer" class="vinfast-autohaiphong_header_topbar_link" title="Fanpage Facebook chính thức">
                <span>Facebook</span>
            </a>
        </div>
    </div>
</div>

{{-- Header Chính --}}
<header class="vinfast-autohaiphong_header_main">
    <div class="vinfast-autohaiphong_layout_container vinfast-autohaiphong_header_inner">
        {{-- Logo --}}
        <a href="{{ route('client.home') }}" class="vinfast-autohaiphong_header_logo">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
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
            <button type="button" onclick="openQuoteModal(null, 'Tất cả các dòng xe')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
                Báo Giá Lăn Bánh
            </button>
        </div>
    </div>
</header>
