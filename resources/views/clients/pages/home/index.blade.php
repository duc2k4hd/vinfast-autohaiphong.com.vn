@extends('clients.layouts.app')

@section('title', 'VinFast Hải Phòng - Đại lý ủy quyền của VinFast Việt Nam | Bảng Giá & Khuyến Mãi')
@section('meta_description', 'Đại lý VinFast Hải Phòng phân phối chính hãng các dòng xe ô tô điện: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9... Giá tốt nhất, hỗ trợ trả góp 80%, lái thử tận nơi.')
@section('canonical', route('client.home'))

@section('content')
{{-- 1. Hero Banner - Banners Ảnh Thật --}}
<section class="vinfast-autohaiphong_home_hero">
    <div style="position: relative; width: 100%; overflow: hidden;">
        <div id="vf-banner-slider" style="display: flex; transition: transform 0.5s ease; width: 100%;">
            {{-- Slide 1 --}}
            <div style="min-width: 100%; position: relative;">
                <a href="{{ url('/xe/vinfast-vf-wild') }}">
                    <img src="{{ asset('storage/clients/assets/images/banners/banner-vf-wild-94utr45.webp') }}" 
                         alt="VinFast VF Wild" 
                         class="vinfast-autohaiphong_home_hero_img"
                         width="1920" 
                         height="520">
                </a>
            </div>
            {{-- Slide 2 --}}
            <div style="min-width: 100%; position: relative;">
                <a href="{{ url('/o-to-vinfast') }}">
                    <img src="{{ asset('storage/clients/assets/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp') }}" 
                         alt="Vì Tương Lai Xanh" 
                         class="vinfast-autohaiphong_home_hero_img"
                         width="1920" 
                         height="520">
                </a>
            </div>
            {{-- Slide 3 --}}
            <div style="min-width: 100%; position: relative;">
                <a href="{{ url('/lien-he') }}">
                    <img src="{{ asset('storage/clients/assets/images/banners/vinfast-banner-54gf5.png') }}" 
                         alt="VinFast Hải Phòng Showroom" 
                         class="vinfast-autohaiphong_home_hero_img"
                         width="1920" 
                         height="520">
                </a>
            </div>
        </div>

        {{-- Nút Chuyển Slide Tinh Tế --}}
        <button type="button" 
                onclick="prevSlide()" 
                style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.7); border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #333;" 
                aria-label="Slide trước">
            ‹
        </button>
        <button type="button" 
                onclick="nextSlide()" 
                style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.7); border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #333;" 
                aria-label="Slide tiếp">
            ›
        </button>
    </div>
</section>

{{-- 2. Box Trưng Bày Sản Phẩm (Max-width 1200px) --}}
<section class="vinfast-autohaiphong_home_section">
    <div class="vinfast-autohaiphong_layout_container">
        <div class="vinfast-autohaiphong_home_section_header">
            <span class="vinfast-autohaiphong_home_section_tag">Sản Phẩm Chính Hãng</span>
            <h2 class="vinfast-autohaiphong_home_section_title">CÁC DÒNG XE Ô TÔ VINFAST</h2>
            <p class="vinfast-autohaiphong_home_section_desc">
                Bảng giá niêm yết các dòng xe ô tô điện VinFast phân phối chính hãng tại khu vực Hải Phòng.
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

                        {{-- Giá bán --}}
                        <div class="vinfast-autohaiphong_home_car_price_box">
                            <span class="vinfast-autohaiphong_home_car_price_label">Giá từ:</span>
                            @if($car->price_on_request || (!$car->sale_price && !$car->regular_price))
                                <span class="vinfast-autohaiphong_home_car_price" style="font-size: 1.1rem;">Liên hệ báo giá</span>
                            @else
                                <span class="vinfast-autohaiphong_home_car_price">
                                    {{ number_format($car->sale_price ?: $car->regular_price, 0, ',', '.') }} VNĐ
                                </span>
                            @endif
                        </div>

                        {{-- Thông số ngắn gọn --}}
                        <div class="vinfast-autohaiphong_home_car_specs">
                            <div>⚡ 100% Thuần Điện</div>
                            <div>🛡️ Bảo hành 7–10 năm</div>
                            <div>🔋 Linh hoạt Pin</div>
                            <div>🚀 Trả góp tới 80%</div>
                        </div>

                        {{-- Actions --}}
                        <div class="vinfast-autohaiphong_home_car_actions">
                            <button type="button" onclick="openQuoteModal({{ $car->id }}, '{{ addslashes($car->name) }}')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
                                Báo Giá Lăn Bánh
                            </button>
                            <a href="{{ url('/xe/' . $car->slug) }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_neutral">
                                Chi Tiết
                            </a>
                        </div>
                    </div>
                </div>
            @empty
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
                                <span class="vinfast-autohaiphong_home_car_price_label">Giá từ:</span>
                                <span class="vinfast-autohaiphong_home_car_price">{{ $item['price'] }} VNĐ</span>
                            </div>
                            <div class="vinfast-autohaiphong_home_car_specs">
                                <div>⚡ 100% Thuần Điện</div>
                                <div>🛡️ Bảo hành 7–10 năm</div>
                                <div>🔋 Linh hoạt Pin</div>
                                <div>🚀 Trả góp tới 80%</div>
                            </div>
                            <div class="vinfast-autohaiphong_home_car_actions">
                                <button type="button" onclick="openQuoteModal(null, '{{ $item['name'] }}')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
                                    Báo Giá Lăn Bánh
                                </button>
                                <a href="{{ url('/xe/' . $item['slug']) }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_neutral">
                                    Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- 3. Section Pin & Trạm Sạc (Nền Sáng Nhẹ #f8fafc) --}}
<section class="vinfast-autohaiphong_home_section vinfast-autohaiphong_home_section_surface">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; align-items: center;">
            <div>
                <span class="vinfast-autohaiphong_home_section_tag">Hạ Tầng Xanh Tiên Phong</span>
                <h2 class="vinfast-autohaiphong_home_section_title" style="text-align: left;">HỆ THỐNG TRẠM SẠC TRÊN TOÀN QUỐC</h2>
                <p style="margin-bottom: 20px; color: var(--client-color-muted); line-height: 1.6; font-size: 0.95rem;">
                    Quy hoạch hơn 150.000 cổng sạc trên khắp 63 tỉnh thành, kết nối các tuyến cao tốc, trung tâm thương mại và khu dân cư, đảm bảo việc sạc pin xe điện trở nên tiện lợi và an tâm mọi lúc mọi nơi.
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 24px;">
                    <div style="background: #ffffff; padding: 14px 16px; border-radius: 6px; border: 1px solid var(--client-color-border);">
                        <strong style="color: var(--client-color-primary); font-size: 1.35rem; display: block;">150.000+</strong>
                        <span style="font-size: 0.825rem; color: var(--client-color-muted);">Cổng sạc toàn quốc</span>
                    </div>
                    <div style="background: #ffffff; padding: 14px 16px; border-radius: 6px; border: 1px solid var(--client-color-border);">
                        <strong style="color: var(--client-color-primary); font-size: 1.35rem; display: block;">10–25 phút</strong>
                        <span style="font-size: 0.825rem; color: var(--client-color-muted);">Sạc nhanh 10% – 70%</span>
                    </div>
                </div>
                <a href="{{ url('/pin-va-tram-sac') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
                    Tìm Hiểu Về Pin & Trạm Sạc
                </a>
            </div>
            <div>
                <img src="https://vinfast-haiphong.com/wp-content/uploads/2025/03/hd-ps-b.jpg" alt="Trạm sạc VinFast Hải Phòng" style="border-radius: 8px; border: 1px solid var(--client-color-border); width: 100%;" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- 4. Section Tin Tức Mới Nhất --}}
<section class="vinfast-autohaiphong_home_section">
    <div class="vinfast-autohaiphong_layout_container">
        <div class="vinfast-autohaiphong_home_section_header">
            <span class="vinfast-autohaiphong_home_section_tag">Tin Tức Đại Lý</span>
            <h2 class="vinfast-autohaiphong_home_section_title">TIN TỨC & SỰ KIỆN</h2>
            <p class="vinfast-autohaiphong_home_section_desc">
                Cập nhật chính sách giá, ưu đãi lãi suất và hoạt động lái thử tại Hải Phòng.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
            @forelse($latestPosts as $post)
                <article style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="position: relative; padding-top: 56.25%; background: #f8fafc; border-bottom: 1px solid var(--client-color-border);">
                        <img src="{{ $post->featured_image_path ? asset('storage/' . $post->featured_image_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/10/banner-vf-wild.webp' }}" 
                             alt="{{ $post->featured_image_alt ?? $post->title }}" 
                             style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" 
                             loading="lazy">
                    </div>
                    <div style="padding: 18px 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <span style="font-size: 0.8rem; color: var(--client-color-muted); margin-bottom: 6px;">
                            {{ $post->published_at ? date('d/m/Y', strtotime($post->published_at)) : date('d/m/Y') }}
                        </span>
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 8px; line-height: 1.4; color: var(--client-color-heading);">
                            <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--client-color-muted); margin-bottom: 14px; line-height: 1.5;">
                            {{ Str::limit($post->excerpt ?? '', 95) }}
                        </p>
                        <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}" style="margin-top: auto; color: var(--client-color-primary); font-weight: 600; font-size: 0.875rem;">
                            Xem chi tiết →
                        </a>
                    </div>
                </article>
            @empty
                <article style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="position: relative; padding-top: 56.25%; background: #f8fafc; border-bottom: 1px solid var(--client-color-border);">
                        <img src="https://vinfast-haiphong.com/wp-content/uploads/2026/10/banner-vf-wild.webp" alt="VinFast ra mắt VF 8 thế hệ mới" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                    </div>
                    <div style="padding: 18px 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <span style="font-size: 0.8rem; color: var(--client-color-muted); margin-bottom: 6px;">2026-11-10</span>
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 8px; line-height: 1.4; color: var(--client-color-heading);">
                            <a href="{{ url('/chuyen-muc/tin-tuc') }}">VinFast ra mắt VF 8 thế hệ mới: Nâng cấp trải nghiệm toàn diện cho người dùng</a>
                        </h3>
                        <p style="font-size: 0.875rem; color: var(--client-color-muted); margin-bottom: 14px; line-height: 1.5;">
                            VinFast chính thức giới thiệu mẫu SUV điện VF 8 All New với loạt cải tiến vượt trội về thiết kế và công nghệ thông minh.
                        </p>
                        <a href="{{ url('/chuyen-muc/tin-tuc') }}" style="margin-top: auto; color: var(--client-color-primary); font-weight: 600; font-size: 0.875rem;">
                            Xem chi tiết →
                        </a>
                    </div>
                </article>
            @endforelse
        </div>
    </div>
</section>

@push('scripts')
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('#vf-banner-slider > div');
    const totalSlides = slides.length;
    const slider = document.getElementById('vf-banner-slider');

    function updateSlider() {
        if (!slider) return;
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateSlider();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateSlider();
    }

    // Auto play 5s
    setInterval(nextSlide, 5000);
</script>
@endpush
@endsection
