{{-- Topbar --}}
<div class="vinfast-autohaiphong_header_topbar">
    <div class="vinfast-autohaiphong_layout_container vinfast-autohaiphong_header_topbar_inner">
        <div class="vinfast-autohaiphong_header_topbar_contact">
            <span>📍 {{ $siteSettings['site_address'] ?? 'Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng, Hải Phòng' }}</span>
            <span>🕒 {{ $siteSettings['site_hours'] ?? 'T2–T7: Dịch vụ 7h50–17h00, KD 7h30–18h00 | CN: KD 7h00–18h00' }}</span>
        </div>
        <div class="vinfast-autohaiphong_header_topbar_links">
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0988302882') }}" class="vinfast-autohaiphong_header_topbar_link">
                <span>📞 Bán hàng: <strong>{{ $siteSettings['site_phone'] ?? '0988 302 882' }}</strong></span>
            </a>
            <span class="vinfast-autohaiphong_header_topbar_divider">|</span>
            <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone_service'] ?? '0915286506') }}" class="vinfast-autohaiphong_header_topbar_link">
                <span>🔧 Dịch vụ: <strong>{{ $siteSettings['site_phone_service'] ?? '0915 286 506' }}</strong></span>
            </a>
            <span class="vinfast-autohaiphong_header_topbar_divider">|</span>
            <a href="{{ $siteSettings['site_facebook'] ?? 'https://www.facebook.com/VinFastMinhDao' }}" target="_blank" rel="noopener noreferrer" class="vinfast-autohaiphong_header_topbar_link" title="Fanpage Facebook chính thức">
                <span>Facebook</span>
            </a>
        </div>
    </div>
</div>

{{-- Header Chính - Chuẩn 100% Ảnh 2: Tinh Tế, Thanh Mảnh, Không Cồng Kềnh --}}
<header class="vinfast-autohaiphong_header_main">
    <div class="vinfast-autohaiphong_layout_container vinfast-autohaiphong_header_inner">
        {{-- Logo Ảnh Chính Thức --}}
        <a href="{{ route('client.home') }}" class="vinfast-autohaiphong_header_logo_link" aria-label="VinFast Hải Phòng">
            <img src="{{ asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                 alt="{{ $siteSettings['site_name'] ?? 'VinFast Hải Phòng' }}" 
                 class="vinfast-autohaiphong_header_logo_img"
                 width="155"
                 height="36">
        </a>

        {{-- Desktop Navigation (Chuẩn Mẫu Ảnh 2) --}}
        <nav class="vinfast-autohaiphong_header_nav" data-vf-mobile-menu>
            <ul class="vinfast-autohaiphong_header_nav_list">
                {{-- 1. VinFast Hải Phòng (Chữ Xanh Thương Hiệu) --}}
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ route('client.home') }}" class="vinfast-autohaiphong_header_nav_link vinfast-autohaiphong_header_nav_link_brand {{ request()->routeIs('client.home') ? 'active' : '' }}">
                        VinFast Hải Phòng
                    </a>
                </li>

                {{-- 2. Ô Tô VinFast ˅ (Dropdown Xe) --}}
                <li class="vinfast-autohaiphong_header_nav_item vinfast-autohaiphong_header_nav_item_has_sub">
                    <a href="{{ url('/o-to-vinfast') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('o-to-vinfast*') || request()->is('xe*') ? 'active' : '' }}">
                        Ô Tô VinFast <span class="vinfast-autohaiphong_header_nav_arrow">˅</span>
                    </a>
                    <div class="vinfast-autohaiphong_header_dropdown">
                        <div class="vinfast-autohaiphong_header_dropdown_title">DANH MỤC XE VINFAST</div>
                        <div class="vinfast-autohaiphong_header_dropdown_grid">
                            <a href="{{ url('/xe/vinfast-vf-3') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 3</a>
                            <a href="{{ url('/xe/vinfast-vf-5') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 5 Plus</a>
                            <a href="{{ url('/xe/vinfast-vf-6') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 6</a>
                            <a href="{{ url('/xe/vinfast-vf-7') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 7</a>
                            <a href="{{ url('/xe/vinfast-vf-8') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 8</a>
                            <a href="{{ url('/xe/vinfast-vf-9') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 9</a>
                            <a href="{{ url('/xe/vinfast-vf8-all-new') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF 8 All New</a>
                            <a href="{{ url('/xe/vinfast-vf-wild') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast VF Wild</a>
                            <a href="{{ url('/xe/vinfast-minio-green') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast Minio Green</a>
                            <a href="{{ url('/xe/vinfast-ec-van') }}" class="vinfast-autohaiphong_header_dropdown_item">VinFast EC Van</a>
                            <a href="{{ url('/o-to-vinfast') }}" class="vinfast-autohaiphong_header_dropdown_item vinfast-autohaiphong_header_dropdown_item_all">
                                Xem tất cả 15 mẫu xe &rarr;
                            </a>
                        </div>
                    </div>
                </li>

                {{-- 3. Pin & Trạm Sạc --}}
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/pin-va-tram-sac') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('pin-va-tram-sac*') ? 'active' : '' }}">
                        Pin & Trạm Sạc
                    </a>
                </li>

                {{-- 4. Tin Tức --}}
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/chuyen-muc/tin-tuc') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('chuyen-muc/tin-tuc*') ? 'active' : '' }}">
                        Tin Tức
                    </a>
                </li>

                {{-- 5. Liên Hệ --}}
                <li class="vinfast-autohaiphong_header_nav_item">
                    <a href="{{ url('/lien-he') }}" class="vinfast-autohaiphong_header_nav_link {{ request()->is('lien-he*') ? 'active' : '' }}">
                        Liên Hệ
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Mobile Hamburger Button --}}
        <button type="button" 
                class="vinfast-autohaiphong_header_mobile_btn" 
                data-vf-mobile-toggle 
                aria-label="Mở menu" 
                aria-expanded="false">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>
</header>
