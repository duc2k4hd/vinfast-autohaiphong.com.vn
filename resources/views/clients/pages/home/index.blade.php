@extends('clients.layouts.app')

@section('title', 'VinFast Hải Phòng - Đại lý ủy quyền của VinFast Việt Nam | Bảng Giá & Khuyến Mãi')
@section('meta_description', 'Đại lý VinFast Hải Phòng phân phối chính hãng các dòng xe ô tô điện: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9... Giá tốt nhất, hỗ trợ trả góp 80%, lái thử tận nơi.')
@section('canonical', route('client.home'))

@section('content')
{{-- 1. Hero Banner --}}
<section class="vinfast-autohaiphong_home_hero">
    <div class="vinfast-autohaiphong_layout_container">
        <div class="vinfast-autohaiphong_home_hero_content">
            <span style="background-color: var(--client-color-primary); color: #ffffff; padding: 4px 12px; border-radius: 4px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 16px; display: inline-block;">
                Ưu Đãi Đặc Quyền Tháng Này
            </span>
            <h1 class="vinfast-autohaiphong_home_hero_title">
                TIÊN PHONG KỶ NGUYÊN DI CHUYỂN XANH CÙNG VINFAST
            </h1>
            <p class="vinfast-autohaiphong_home_hero_desc">
                Trải nghiệm những mẫu ô tô điện đẳng cấp hàng đầu thế giới với công nghệ thông minh, chi phí vận hành siêu tiết kiệm và chính sách bảo hành lên đến 10 năm tại Hải Phòng.
            </p>
            <div class="vinfast-autohaiphong_home_hero_actions">
                <button type="button" onclick="openQuoteModal(null, 'Tất cả các dòng xe')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_accent" style="padding: 14px 28px; font-size: 0.95rem;">
                    Nhận Báo Giá Lăn Bánh
                </button>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0988302882') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="border-color: #ffffff; color: #ffffff; padding: 14px 28px; font-size: 0.95rem;">
                    Hotline: {{ $siteSettings['site_phone'] ?? '0988 302 882' }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- 2. Section Bảng Giá & Danh Mục Các Dòng Xe Ô Tô VinFast --}}
<section class="vinfast-autohaiphong_home_section">
    <div class="vinfast-autohaiphong_layout_container">
        <div class="vinfast-autohaiphong_home_section_header">
            <span class="vinfast-autohaiphong_home_section_tag">Dòng Xe Ô Tô Điện</span>
            <h2 class="vinfast-autohaiphong_home_section_title">DANH MỤC XE VINFAST CHÍNH HÃNG</h2>
            <p class="vinfast-autohaiphong_home_section_desc">
                Bảng giá niêm yết và thông số các dòng xe ô tô điện VinFast mới nhất tại đại lý ủy quyền Hải Phòng.
            </p>
        </div>

        <div class="vinfast-autohaiphong_home_grid">
            @forelse($cars as $car)
                <div class="vinfast-autohaiphong_home_car_card">
                    {{-- Thumbnail --}}
                    <div class="vinfast-autohaiphong_home_car_thumb">
                        <img src="{{ $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
                             alt="{{ $car->thumbnail_alt ?? $car->name }}" 
                             loading="lazy" 
                             width="600" 
                             height="338">
                    </div>

                    {{-- Body --}}
                    <div class="vinfast-autohaiphong_home_car_body">
                        <h3 class="vinfast-autohaiphong_home_car_name">
                            <a href="{{ url('/xe/' . $car->slug) }}">{{ $car->name }}</a>
                        </h3>

                        {{-- Giá --}}
                        <div class="vinfast-autohaiphong_home_car_price_box">
                            <span class="vinfast-autohaiphong_home_car_price_label">Giá từ: </span>
                            @if($car->price_on_request || (!$car->sale_price && !$car->regular_price))
                                <span class="vinfast-autohaiphong_home_car_price" style="font-size: 1.15rem; color: var(--client-color-primary);">Liên hệ báo giá</span>
                            @else
                                <span class="vinfast-autohaiphong_home_car_price">
                                    {{ number_format($car->sale_price ?: $car->regular_price, 0, ',', '.') }} VNĐ
                                </span>
                            @endif
                        </div>

                        {{-- Thông số tóm tắt --}}
                        <div class="vinfast-autohaiphong_home_car_specs">
                            <div>⚡ 100% Thuần Điện</div>
                            <div>🛡️ Bảo hành 7-10 năm</div>
                            <div>🔋 Thuê / Mua Pin</div>
                            <div>🚀 Trả góp tới 80%</div>
                        </div>

                        {{-- Actions --}}
                        <div class="vinfast-autohaiphong_home_car_actions">
                            <button type="button" onclick="openQuoteModal({{ $car->id }}, '{{ addslashes($car->name) }}')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_accent">
                                Báo Giá Lăn Bánh
                            </button>
                            <a href="{{ url('/xe/' . $car->slug) }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Fallback danh sách 6 mẫu xe phổ biến nếu database chưa nạp dữ liệu đầy đủ --}}
                @php
                    $fallbackCars = [
                        ['name' => 'VinFast VF 3', 'slug' => 'vinfast-vf-3', 'price' => '285.000.000', 'img' => 'https://vinfast-haiphong.com/wp-content/uploads/2025/03/VinFast-VF3-mau-xanh-quan-doi-600x400-1.webp'],
                        ['name' => 'VinFast VF 5 Plus', 'slug' => 'vinfast-vf-5', 'price' => '496.000.000', 'img' => 'https://vinfast-haiphong.com/wp-content/uploads/2025/03/VinFast-VF5-mau-vang-3.webp'],
                        ['name' => 'VinFast VF 6', 'slug' => 'vinfast-vf-6', 'price' => '646.000.000', 'img' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/03/vf6-1.webp'],
                        ['name' => 'VinFast VF 7', 'slug' => 'vinfast-vf-7', 'price' => '740.000.000', 'img' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/03/vf7-1.webp'],
                        ['name' => 'VinFast VF 8 All New', 'slug' => 'vinfast-vf8-all-new', 'price' => '899.000.000', 'img' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/05/vf8-all-new-300x180.png'],
                        ['name' => 'VinFast VF 9', 'slug' => 'vinfast-vf-9', 'price' => '1.348.000.000', 'img' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/03/vf9-1.webp'],
                    ];
                @endphp
                @foreach($fallbackCars as $item)
                    <div class="vinfast-autohaiphong_home_car_card">
                        <div class="vinfast-autohaiphong_home_car_thumb">
                            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" loading="lazy" width="600" height="338">
                        </div>
                        <div class="vinfast-autohaiphong_home_car_body">
                            <h3 class="vinfast-autohaiphong_home_car_name">
                                <a href="{{ url('/xe/' . $item['slug']) }}">{{ $item['name'] }}</a>
                            </h3>
                            <div class="vinfast-autohaiphong_home_car_price_box">
                                <span class="vinfast-autohaiphong_home_car_price_label">Giá từ: </span>
                                <span class="vinfast-autohaiphong_home_car_price">{{ $item['price'] }} VNĐ</span>
                            </div>
                            <div class="vinfast-autohaiphong_home_car_specs">
                                <div>⚡ 100% Thuần Điện</div>
                                <div>🛡️ Bảo hành 7-10 năm</div>
                                <div>🔋 Thuê / Mua Pin</div>
                                <div>🚀 Trả góp tới 80%</div>
                            </div>
                            <div class="vinfast-autohaiphong_home_car_actions">
                                <button type="button" onclick="openQuoteModal(null, '{{ $item['name'] }}')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_accent">
                                    Báo Giá Lăn Bánh
                                </button>
                                <a href="{{ url('/xe/' . $item['slug']) }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- 3. Section Dịch Vụ Pin & Trạm Sạc Toàn Quốc --}}
<section class="vinfast-autohaiphong_home_section vinfast-autohaiphong_home_section_surface">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <span class="vinfast-autohaiphong_home_section_tag">Hạ Tầng Xanh Đột Phá</span>
                <h2 class="vinfast-autohaiphong_home_section_title" style="text-align: left;">MẠNG LƯỚI TRẠM SẠC PHỦ KHẮP 63 TỈNH THÀNH</h2>
                <p style="margin-bottom: 20px; color: var(--client-color-muted); line-height: 1.7;">
                    VinFast quy hoạch hệ thống trạm sạc xe điện với hơn 150.000 cổng sạc trên toàn quốc, phân bố tại các trạm dừng chân cao tốc, trung tâm thương mại, khu chung cư và tòa nhà văn phòng, giúp khách hàng hoàn toàn yên tâm trên mọi hành trình dài.
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 28px;">
                    <div style="background: #ffffff; padding: 16px; border-radius: 8px; border: 1px solid var(--client-color-border);">
                        <strong style="color: var(--client-color-primary); font-size: 1.4rem; display: block;">150.000+</strong>
                        <span style="font-size: 0.85rem; color: var(--client-color-muted);">Cổng sạc toàn quốc</span>
                    </div>
                    <div style="background: #ffffff; padding: 16px; border-radius: 8px; border: 1px solid var(--client-color-border);">
                        <strong style="color: var(--client-color-success); font-size: 1.4rem; display: block;">10-25 phút</strong>
                        <span style="font-size: 0.85rem; color: var(--client-color-muted);">Sạc nhanh 10% - 70%</span>
                    </div>
                </div>
                <a href="{{ url('/pin-va-tram-sac') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
                    Tìm Hiểu Về Pin & Trạm Sạc
                </a>
            </div>
            <div>
                <img src="https://vinfast-haiphong.com/wp-content/uploads/2025/03/hd-ps-b.jpg" alt="Trạm sạc VinFast Hải Phòng" style="border-radius: 12px; box-shadow: var(--client-shadow-lg);" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- 4. Section Tin Tức Mới Nhất --}}
<section class="vinfast-autohaiphong_home_section">
    <div class="vinfast-autohaiphong_layout_container">
        <div class="vinfast-autohaiphong_home_section_header">
            <span class="vinfast-autohaiphong_home_section_tag">Tin Tức & Sự Kiện</span>
            <h2 class="vinfast-autohaiphong_home_section_title">TIN TỨC VINFAST HẢI PHÒNG</h2>
            <p class="vinfast-autohaiphong_home_section_desc">
                Cập nhật các chương trình ưu đãi, sự kiện lái thử và chính sách phát triển mới nhất.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            @forelse($latestPosts as $post)
                <article style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="position: relative; padding-top: 56.25%; background: #f1f5f9;">
                        <img src="{{ $post->featured_image_path ? asset('storage/' . $post->featured_image_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/10/banner-vf-wild.webp' }}" 
                             alt="{{ $post->featured_image_alt ?? $post->title }}" 
                             style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" 
                             loading="lazy">
                    </div>
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <span style="font-size: 0.8rem; color: var(--client-color-muted); margin-bottom: 8px;">
                            📅 {{ $post->published_at ? date('d/m/Y', strtotime($post->published_at)) : date('d/m/Y') }}
                        </span>
                        <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 10px; line-height: 1.4;">
                            <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p style="font-size: 0.9rem; color: var(--client-color-muted); margin-bottom: 16px; line-height: 1.5;">
                            {{ Str::limit($post->excerpt ?? '', 100) }}
                        </p>
                        <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}" style="margin-top: auto; color: var(--client-color-primary); font-weight: 600; font-size: 0.9rem;">
                            Đọc bài viết →
                        </a>
                    </div>
                </article>
            @empty
                {{-- Fallback 3 bài viết mẫu từ nguồn --}}
                <article style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="position: relative; padding-top: 56.25%; background: #f1f5f9;">
                        <img src="https://vinfast-haiphong.com/wp-content/uploads/2026/10/banner-vf-wild.webp" alt="VinFast ra mắt VF 8 thế hệ mới" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                    </div>
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <span style="font-size: 0.8rem; color: var(--client-color-muted); margin-bottom: 8px;">📅 2026-11-10</span>
                        <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 10px; line-height: 1.4;">
                            <a href="{{ url('/chuyen-muc/tin-tuc') }}">VinFast ra mắt VF 8 thế hệ mới: Nâng cấp trải nghiệm toàn diện cho người dùng</a>
                        </h3>
                        <p style="font-size: 0.9rem; color: var(--client-color-muted); margin-bottom: 16px; line-height: 1.5;">
                            VinFast chính thức giới thiệu mẫu SUV điện VF 8 All New với loạt cải tiến vượt trội về thiết kế và công nghệ thông minh.
                        </p>
                        <a href="{{ url('/chuyen-muc/tin-tuc') }}" style="margin-top: auto; color: var(--client-color-primary); font-weight: 600; font-size: 0.9rem;">
                            Đọc bài viết →
                        </a>
                    </div>
                </article>
            @endforelse
        </div>
    </div>
</section>
@endsection

