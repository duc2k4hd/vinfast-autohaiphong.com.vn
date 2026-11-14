{{-- Topbar --}}
<div class="vinfast-autohaiphong_header_topbar">
    <div class="vinfast-autohaiphong_layout_container vinfast-autohaiphong_header_topbar_inner">
        <div class="vinfast-autohaiphong_header_topbar_contact">
            <span>📍 {{ $siteSettings['site_address'] ?? 'Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng.' }}</span>
            {{-- <span>🕒 {{ $siteSettings['site_hours'] ?? 'T2–T7: Dịch vụ 7h50–17h00, KD 7h30–18h00 | CN: KD 7h00–18h00' }}</span> --}}
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
                <span style="width: 20px; height: 20px"><svg xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" version="1.1" id="svg9" width="20" height="20" viewBox="0 0 666.66668 666.66717"><script xmlns="" id="eppiocemhmnlbhjplcgkofciiegomcon"/><script xmlns=""/><script xmlns=""/>
                    <defs id="defs13">
                        <clipPath clipPathUnits="userSpaceOnUse" id="clipPath25">
                        <path d="M 0,700 H 700 V 0 H 0 Z" id="path23"/>
                        </clipPath>
                    </defs>
                    <g id="g17" transform="matrix(1.3333333,0,0,-1.3333333,-133.33333,799.99999)">
                        <g id="g19">
                        <g id="g21" clip-path="url(#clipPath25)">
                            <g id="g27" transform="translate(600,350)">
                            <path d="m 0,0 c 0,138.071 -111.929,250 -250,250 -138.071,0 -250,-111.929 -250,-250 0,-117.245 80.715,-215.622 189.606,-242.638 v 166.242 h -51.552 V 0 h 51.552 v 32.919 c 0,85.092 38.508,124.532 122.048,124.532 15.838,0 43.167,-3.105 54.347,-6.211 V 81.986 c -5.901,0.621 -16.149,0.932 -28.882,0.932 -40.993,0 -56.832,-15.528 -56.832,-55.9 V 0 h 81.659 l -14.028,-76.396 h -67.631 V -248.169 C -95.927,-233.218 0,-127.818 0,0" style="fill:#0866ff;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path29"/>
                            </g>
                            <g id="g31" transform="translate(447.9175,273.6036)">
                            <path d="M 0,0 14.029,76.396 H -67.63 v 27.019 c 0,40.372 15.838,55.899 56.831,55.899 12.733,0 22.981,-0.31 28.882,-0.931 v 69.253 c -11.18,3.106 -38.509,6.212 -54.347,6.212 -83.539,0 -122.048,-39.441 -122.048,-124.533 V 76.396 h -51.552 V 0 h 51.552 v -166.242 c 19.343,-4.798 39.568,-7.362 60.394,-7.362 10.254,0 20.358,0.632 30.288,1.831 L -67.63,0 Z" style="fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:none" id="path33"/>
                            </g>
                        </g>
                        </g>
                    </g>
                </svg></span>
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

                {{-- Danh sách xe --}}
                <li class="vinfast-autohaiphong_header_nav_item vinfast-autohaiphong_header_nav_item_has_sub" data-vf-cars-menu>
                    <button type="button" class="vinfast-autohaiphong_header_nav_link vinfast-autohaiphong_header_cars_toggle {{ request()->is('o-to-vinfast*') || request()->is('xe*') ? 'active' : '' }}" data-vf-cars-toggle aria-expanded="false" aria-controls="vf-cars-dropdown">
                        Ô Tô VinFast <svg class="vinfast-autohaiphong_header_nav_arrow" width="14" height="14" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <div id="vf-cars-dropdown" class="vinfast-autohaiphong_header_dropdown" hidden>
                        <div class="vinfast-autohaiphong_header_dropdown_inner">
                            <div class="vinfast-autohaiphong_header_dropdown_heading">
                                <span>Khám phá các dòng xe VinFast</span>
                                <a href="{{ route('client.catalog.index') }}">Xem tất cả xe <span aria-hidden="true">→</span></a>
                            </div>
                            <div class="vinfast-autohaiphong_header_dropdown_grid">
                                @foreach($menuCars as $menuCar)
                                    <a href="{{ route('client.products.show', $menuCar->slug) }}" class="vinfast-autohaiphong_header_dropdown_item">
                                        <span class="vinfast-autohaiphong_header_dropdown_image">
                                            @if($menuCar->thumbnail_path)
                                                <img src="{{ asset('storage/' . $menuCar->thumbnail_path) }}" alt="" loading="lazy" width="220" height="120">
                                            @else
                                                <span class="vinfast-autohaiphong_header_dropdown_placeholder">VinFast</span>
                                            @endif
                                        </span>
                                        <span class="vinfast-autohaiphong_header_dropdown_name">{{ $menuCar->name }}</span>
                                        @if($menuCar->category_name)
                                            <span class="vinfast-autohaiphong_header_dropdown_badge">{{ $menuCar->category_name }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
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

            {{-- Thông tin liên hệ nhanh cho Mobile Menu --}}
            <div class="vinfast-autohaiphong_header_mobile_contact">
                <div class="vinfast-autohaiphong_header_mobile_contact_title">HỖ TRỢ TRỰC TIẾP TẠI HẢI PHÒNG</div>
                <div class="vinfast-autohaiphong_header_mobile_contact_links">
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0988302882') }}" class="vinfast-autohaiphong_header_mobile_contact_link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>Bán hàng: <strong>{{ $siteSettings['site_phone'] ?? '0988 302 882' }}</strong></span>
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone_service'] ?? '0915286506') }}" class="vinfast-autohaiphong_header_mobile_contact_link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        <span>Dịch vụ: <strong>{{ $siteSettings['site_phone_service'] ?? '0915 286 506' }}</strong></span>
                    </a>
                </div>
                <div class="vinfast-autohaiphong_header_mobile_contact_addr">
                    <span>Số 1 Bạch Đằng, P. Thượng Lý, Q. Hồng Bàng, TP. Hải Phòng</span>
                </div>
            </div>
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
