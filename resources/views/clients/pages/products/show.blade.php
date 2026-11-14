@extends('clients.layouts.app')

@section('title', $car->name . ' - Bảng Giá Lăn Bánh & Thông Số Kỹ Thuật | VinFast Hải Phòng')
@section('meta_description', 'Xem thông số kỹ thuật xe ' . $car->name . ': Bảng giá niêm yết, thông số chi tiết key-value, pin, quãng đường và hỗ trợ mua xe thanh toán tiền mặt tại VinFast Minh Đạo Hải Phòng.')
@section('canonical', url('/xe/' . $car->slug))

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org/',
    '@type' => 'Car',
    'name' => $car->name,
    'image' => $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
    'description' => $car->short_description,
    'brand' => [
        '@type' => 'Brand',
        'name' => 'VinFast',
    ],
    'offers' => [
        '@type' => 'Offer',
        'url' => url('/xe/' . $car->slug),
        'priceCurrency' => 'VND',
        'price' => (float) ($car->sale_price ?: $car->regular_price ?: 0),
        'availability' => 'https://schema.org/InStock',
        'priceValidUntil' => '2026-12-31',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
@php
    $shortModelName = trim(Str::upper(Str::replace(['VinFast ', 'vinfast '], '', $car->name)));
    $modelCode = trim(Str::upper(preg_replace('/[^a-zA-Z0-9]/', '', str_replace(['VinFast', 'vinfast'], '', $car->name)))) ?: 'VF3';
    $mainCarImage = $car->thumbnail_path 
        ? asset('storage/' . $car->thumbnail_path) 
        : asset('storage/clients/assets/images/theme-v1/product.webp');

    $gallerySlides = $galleryImages->map(function ($img) use ($car) {
        return [
            'src' => asset('storage/' . $img->path),
            'alt' => $img->alt_text ?: $car->name,
        ];
    })->values();

    if ($gallerySlides->isEmpty()) {
        $gallerySlides = collect([
            ['src' => asset('storage/clients/assets/images/theme-v1/hero.webp'), 'alt' => $car->name . ' - Ngoại thất'],
            ['src' => asset('storage/clients/assets/images/theme-v1/nature-yellow.webp'), 'alt' => $car->name . ' - Vận hành'],
        ]);
    }

    $specGroups = $specifications->groupBy(function ($spec) {
        return $spec->group_name ?: 'Thông số chung';
    });

    // Trích xuất 3 thông số nổi bật (Quãng đường, Sạc nhanh, Bảo hành)
    $rangeSpec = $specifications->first(function ($s) {
        return Str::contains(Str::lower($s->label), ['quãng đường', 'tầm hoạt động', 'nedc', 'wltp']);
    })?->value ?? '215 km/1 lần sạc (NEDC)';

    $chargeSpec = $specifications->first(function ($s) {
        return Str::contains(Str::lower($s->label), ['sạc nhanh', 'thời gian sạc', 'sạc']);
    })?->value ?? '36 phút (10% - 70%)';

    $warrantySpec = '7 - 10 năm hoặc 160.000 - 200.000 km';

    // Cấu trúc dữ liệu client JSON
    $jsonTrims = [];
    foreach ($variants as $v) {
        $jsonTrims[$v->id] = [
            'name' => $v->name,
            'price' => (int) ($v->sale_price ?: $v->regular_price ?: 0),
            'sku' => $v->sku,
        ];
    }

    $jsonSpecGroups = [];
    foreach ($specGroups as $gName => $gSpecs) {
        $slugKey = Str::slug($gName);
        $jsonSpecGroups[$slugKey] = [
            'title' => $gName,
            'rows' => $gSpecs->map(fn ($sp) => [$sp->label, trim($sp->value . ' ' . ($sp->unit ?? ''))])->values()->all(),
        ];
    }
@endphp

{{-- Dữ liệu JavaScript cho Theme V1 --}}
<script>
window.VINFAST_PRODUCT_DATA = {
    model: @json($car->name),
    basePrice: {{ (int) ($car->sale_price ?: $car->regular_price ?: 0) }},
    trims: @json($jsonTrims),
    specGroups: @json($jsonSpecGroups),
    colors: [
        { name: 'Sky Blue', value: '#8de0e7', filter: 'hue-rotate(102deg) saturate(1.0)' },
        { name: 'Rose Pink', value: '#efafce', filter: 'hue-rotate(242deg) saturate(.55) brightness(1.09)' },
        { name: 'Urban Mint', value: '#829b87', filter: 'hue-rotate(58deg) saturate(.62) brightness(.83)' },
        { name: 'Infinity Blanc', value: '#e3e3e3', filter: 'grayscale(1) brightness(1.62) contrast(.86)' },
        { name: 'Zenith Grey', value: '#8f9293', filter: 'grayscale(1) brightness(.93)' },
        { name: 'Solar Ruby', value: '#be2030', filter: 'hue-rotate(300deg) saturate(2.2) brightness(.92)' },
        { name: 'Summer Yellow', value: '#ffd21f', filter: 'none' }
    ],
    designHighlights: [
        'Dễ dàng quay đầu xe trong không gian đô thị với bán kính quay tối thiểu khoảng 4,5m.',
        'Chiều dài cơ sở tối ưu giúp khoang cabin rộng rãi, tự tin di chuyển trong nội đô và đường trường.',
        'La-zăng thể thao tạo nên diện mạo trẻ trung, cá tính và đậm chất công nghệ thế hệ mới.'
    ]
};
</script>

{{-- Breadcrumb Navigation --}}
<div class="vinfast-autohaiphong_product_breadcrumb_wrapper" style="background-color: var(--vf-bg); border-bottom: 1px solid var(--vf-border); padding: 12px 0;">
    <div class="vinfast-autohaiphong_product_container">
        <nav style="font-size: 0.85rem; color: var(--vf-muted); display: flex; align-items: center; gap: 8px;">
            <a href="{{ route('client.home') }}" style="color: var(--vf-text);">Trang chủ</a>
            <span>/</span>
            <a href="{{ url('/o-to-vinfast') }}" style="color: var(--vf-text);">Ô Tô VinFast</a>
            <span>/</span>
            <span style="color: var(--vf-blue); font-weight: 600;">{{ $car->name }}</span>
        </nav>
    </div>
</div>

{{-- Container Giao Diện Theme V1 --}}
<div class="vinfast-autohaiphong_product_app" data-car-id="{{ $car->id }}" data-car-name="{{ $car->name }}">
    <main>
        {{-- SECTION 1: HERO BANNER SLIDER (TỶ LỆ CHUẨN 19:6) --}}
        @php
            $heroBanners = (!empty($banners) && $banners->isNotEmpty()) ? $banners : collect([
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/hero.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' - Đột phá phong cách đô thị',
                    'title' => 'VINFAST ' . Str::upper($car->name),
                    'subtitle' => 'Mẫu xe điện thông minh, định hình phong cách di chuyển đô thị tương lai',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/nature-yellow.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' - Tự do khám phá',
                    'title' => 'TỰ DO TỎA SÁNG CHẤT RIÊNG',
                    'subtitle' => 'Khởi đầu mỗi hành trình với sự linh hoạt, bền bỉ và tiết kiệm vượt trội',
                ],
            ]);
        @endphp

        <section class="vinfast-autohaiphong_product_hero" id="dau-trang" aria-label="VinFast {{ $car->name }}">
            <div class="vinfast-autohaiphong_product_hero-slider" data-hero-slider>
                @foreach($heroBanners as $bIndex => $banner)
                    <div class="vinfast-autohaiphong_product_hero-slide {{ $bIndex === 0 ? 'vinfast-autohaiphong_product_hero-slide-active' : '' }}"
                         data-hero-slide="{{ $bIndex }}"
                         aria-hidden="{{ $bIndex === 0 ? 'false' : 'true' }}">
                        <img src="{{ $banner->image_url }}"
                             alt="{{ $banner->alt_text }}"
                             {{ $bIndex === 0 ? 'fetchpriority=high' : 'loading=lazy' }} />

                        {{-- Tiêu đề và mô tả ngắn hiển thị ở khoảng trên ở giữa banner --}}
                        @if(!empty($banner->title) || !empty($banner->subtitle))
                            <div class="vinfast-autohaiphong_product_hero-caption">
                                @if(!empty($banner->title))
                                    <h2 class="vinfast-autohaiphong_product_hero-title">{{ $banner->title }}</h2>
                                @endif
                                @if(!empty($banner->subtitle))
                                    <p class="vinfast-autohaiphong_product_hero-subtitle">{{ $banner->subtitle }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach

                @if($heroBanners->count() > 1)
                    <button class="vinfast-autohaiphong_product_hero-arrow vinfast-autohaiphong_product_hero-prev"
                            type="button"
                            data-action="hero-prev"
                            aria-label="Ảnh banner trước">
                        ‹
                    </button>
                    <button class="vinfast-autohaiphong_product_hero-arrow vinfast-autohaiphong_product_hero-next"
                            type="button"
                            data-action="hero-next"
                            aria-label="Ảnh banner tiếp">
                        ›
                    </button>
                    <div class="vinfast-autohaiphong_product_hero-pagination" aria-label="Chọn banner">
                        @foreach($heroBanners as $bIndex => $banner)
                            <button type="button"
                                    class="vinfast-autohaiphong_product_hero-dot {{ $bIndex === 0 ? 'vinfast-autohaiphong_product_is-active' : '' }}"
                                    data-hero-dot="{{ $bIndex }}"
                                    aria-label="Banner {{ $bIndex + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- SECTION 2: INTRO & VARIANTS & HIGHLIGHTS --}}
        <section class="vinfast-autohaiphong_product_intro vinfast-autohaiphong_product_section" id="vf3-gioi-thieu">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_intro-grid">
                    {{-- Cột Trái: Visual và Watermark Tỷ Lệ 4/3 Chuẩn --}}
                    @php
                        $firstVariant = $variants->first();
                        $initialCarImage = ($firstVariant && !empty($firstVariant->thumbnail_path))
                            ? asset('storage/' . $firstVariant->thumbnail_path)
                            : $mainCarImage;
                    @endphp
                    <div class="vinfast-autohaiphong_product_intro-visual" data-reveal>
                        <img class="vinfast-autohaiphong_product_intro-car"
                             src="{{ $initialCarImage }}"
                             alt="{{ $car->name }}"
                             loading="eager" />
                    </div>

                    {{-- Cột Phải: Trims, Specs Highlights, Price & Deposit Chuẩn Ảnh Mẫu --}}
                    <div class="vinfast-autohaiphong_product_intro-info" data-reveal>
                        <h1 class="sr-only">{{ $car->name }}</h1>

                        {{-- 1. Trim Picker (Chỉ hiển thị khi sản phẩm có các phiên bản / biến thể) --}}
                        @if($variants->isNotEmpty())
                            <span class="sr-only">Chọn Phiên Bản</span>
                            <div class="vinfast-autohaiphong_product_trim-picker-wrapper">
                                <div class="vinfast-autohaiphong_product_trim-picker" role="group" aria-label="Phiên bản xe">
                                    <span class="vinfast-autohaiphong_product_trim-indicator" aria-hidden="true"></span>
                                    @foreach($variants as $idx => $variant)
                                        @php
                                            $variantImg = !empty($variant->thumbnail_path)
                                                ? asset('storage/' . $variant->thumbnail_path)
                                                : $mainCarImage;
                                            $variantPrice = $variant->sale_price ?: $variant->regular_price;
                                        @endphp
                                        <button type="button"
                                                data-trim="{{ $variant->id }}"
                                                data-price-val="{{ $variantPrice ?: ($car->sale_price ?: $car->regular_price) }}"
                                                data-price-formatted="{{ number_format($variantPrice ?: ($car->sale_price ?: $car->regular_price), 0, ',', '.') }} VNĐ"
                                                data-name="{{ $variant->name }}"
                                                data-image="{{ $variantImg }}"
                                                class="vinfast-autohaiphong_product_trim {{ $idx === 0 ? 'vinfast-autohaiphong_product_is-active' : '' }}"
                                                aria-pressed="{{ $idx === 0 ? 'true' : 'false' }}">
                                            {{ $variant->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <span id="vf-selected-variant-label" class="sr-only">{{ $firstVariant->name }}</span>
                        @else
                            <span class="sr-only">Chọn Phiên Bản</span>
                            <span id="vf-selected-variant-label" class="sr-only">Tiêu Chuẩn</span>
                        @endif

                        {{-- 2. Spec Highlights (Các khối thông số nổi bật quản lý linh hoạt trong Admin) --}}
                        <div class="vinfast-autohaiphong_product_spec-highlights">
                            @if(isset($specHighlights) && $specHighlights->isNotEmpty())
                                @foreach($specHighlights as $sh)
                                    <div class="vinfast-autohaiphong_product_spec-item">
                                        <div>
                                            @if(is_numeric($sh->value) || strlen($sh->value) <= 6)
                                                <span class="vinfast-autohaiphong_product_spec-number">{{ $sh->value }}</span>
                                            @else
                                                <span class="vinfast-autohaiphong_product_spec-title">{{ $sh->value }}</span>
                                            @endif
                                            @if(!empty($sh->unit))
                                                <span class="vinfast-autohaiphong_product_spec-unit">{{ $sh->unit }}</span>
                                            @endif
                                        </div>
                                        @if(!empty($sh->subtitle))
                                            <p class="vinfast-autohaiphong_product_spec-sub">{{ $sh->subtitle }}</p>
                                        @endif
                                        <p class="vinfast-autohaiphong_product_spec-label">{{ $sh->label }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="vinfast-autohaiphong_product_spec-item">
                                    <div>
                                        <span class="vinfast-autohaiphong_product_spec-number">215</span>
                                        <span class="vinfast-autohaiphong_product_spec-unit">km/1 lần sạc (NEDC)</span>
                                    </div>
                                    <p class="vinfast-autohaiphong_product_spec-label">Quãng đường di chuyển</p>
                                </div>

                                <div class="vinfast-autohaiphong_product_spec-item">
                                    <div>
                                        <span class="vinfast-autohaiphong_product_spec-number">36</span>
                                        <span class="vinfast-autohaiphong_product_spec-unit">phút</span>
                                    </div>
                                    <p class="vinfast-autohaiphong_product_spec-label">Sạc nhanh từ 10% - 70%</p>
                                </div>

                                <div class="vinfast-autohaiphong_product_spec-item">
                                    <div>
                                        <span class="vinfast-autohaiphong_product_spec-title">7 năm hoặc 160.000km</span>
                                    </div>
                                    <p class="vinfast-autohaiphong_product_spec-sub">(Tùy điều kiện nào đến trước)</p>
                                    <p class="vinfast-autohaiphong_product_spec-label">Bảo hành</p>
                                </div>
                            @endif
                        </div>

                        {{-- 3. Bottom Row: Giá Bán & Nút Đặt Cọc Ngay --}}
                        <div class="vinfast-autohaiphong_product_intro-actions">
                            <div class="vinfast-autohaiphong_product_price-tag">
                                <span class="vinfast-autohaiphong_product_price-dot"></span>
                                @php
                                    $initialDisplayPrice = ($firstVariant && ($firstVariant->sale_price ?: $firstVariant->regular_price))
                                        ? ($firstVariant->sale_price ?: $firstVariant->regular_price)
                                        : ($car->sale_price ?: $car->regular_price);
                                @endphp
                                <span class="vinfast-autohaiphong_product_price-text">Giá bán từ: <strong data-price id="vf-car-price-display">{{ number_format($initialDisplayPrice, 0, ',', '.') }} VNĐ</strong></span>
                            </div>

                            <form action="{{ route('client.cart.add') }}" method="POST" style="margin: 0; display: inline-flex; flex-shrink: 0;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $car->id }}">
                                <input type="hidden" name="variant_id" id="vf-cart-variant-id" value="{{ $variants->first()?->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="vinfast-autohaiphong_product_btn-deposit">
                                    Đặt cọc ngay
                                </button>
                            </form>

                            <button type="button" class="sr-only" onclick="openQuoteModal({{ $car->id }}, '{{ $car->name }}')">
                                YÊU CẦU BÁO GIÁ LĂN BÁNH
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 3: BỘ SƯU TẬP MÀU SẮC (COLOR STUDIO) CHUẨN THEO ẢNH MẪU --}}
        @php
            $colorStudioList = (!empty($colors) && $colors->isNotEmpty()) ? $colors->map(function($c) use ($mainCarImage) {
                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'code' => $c->color_code,
                    'image' => !empty($c->image_path) ? asset('storage/' . $c->image_path) : $mainCarImage,
                ];
            }) : collect([
                ['name' => 'Solar Ruby', 'code' => '#d83a3a', 'image' => asset('storage/clients/assets/images/products/hinh-anh-vinfast-vf3-plus-1794626563.webp')],
                ['name' => 'Electric Yellow', 'code' => '#f2d852', 'image' => $mainCarImage],
                ['name' => 'Desert Sage', 'code' => '#82917d', 'image' => asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-1794624468.webp')],
            ]);
            $initialColor = $colorStudioList->first();
        @endphp
        <section class="vinfast-autohaiphong_product_colors vinfast-autohaiphong_product_section" id="vf3-mau-xe">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_section-head" data-reveal>
                    <h2>Tự do sáng tạo, tỏa sáng chất riêng</h2>
                    <p>Lựa chọn màu sắc phù hợp với phong cách và cá tính của bạn</p>
                </div>
                <div class="vinfast-autohaiphong_product_color-stage" data-reveal>
                    {{-- Chữ mờ VF3 Watermark in nghiêng to bản chuẩn 100% như ảnh mẫu --}}
                    <div class="vinfast-autohaiphong_product_color-watermark" aria-hidden="true">
                        <span>{{ $modelCode }}</span>
                    </div>

                    {{-- Khung hiển thị xe góc ngang side-view to lớn hoành tráng --}}
                    <div class="vinfast-autohaiphong_product_color-car-wrapper" data-color-car-wrapper>
                        <img class="vinfast-autohaiphong_product_color-car"
                             data-color-car
                             src="{{ $initialColor['image'] }}"
                             alt="Mô phỏng màu {{ $initialColor['name'] }}"
                             loading="eager" />
                    </div>

                    {{-- Dải chuyển màu sắc swatches giống hệt ảnh mẫu --}}
                    <div class="vinfast-autohaiphong_product_color-bottom">
                        <div class="vinfast-autohaiphong_product_color-switcher" role="group" aria-label="Chọn màu xe">
                            <button type="button" data-action="color-prev" class="vinfast-autohaiphong_product_color-arrow" aria-label="Màu trước">‹</button>
                            <div class="vinfast-autohaiphong_product_swatches" data-swatches>
                                @foreach($colorStudioList as $cIdx => $cItem)
                                    <button type="button"
                                            class="vinfast-autohaiphong_product_color-dot {{ $cIdx === 0 ? 'vinfast-autohaiphong_product_is-active' : '' }}"
                                            data-color="{{ $cIdx }}"
                                            data-name="{{ $cItem['name'] }}"
                                            data-image="{{ $cItem['image'] }}"
                                            data-code="{{ $cItem['code'] }}"
                                            aria-label="Màu {{ $cItem['name'] }}"
                                            aria-pressed="{{ $cIdx === 0 ? 'true' : 'false' }}">
                                        <span class="vinfast-autohaiphong_product_color-circle" style="background-color: {{ $cItem['code'] }};"></span>
                                        <span class="vinfast-autohaiphong_product_color-label">{{ $cItem['name'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                            <button type="button" data-action="color-next" class="vinfast-autohaiphong_product_color-arrow" aria-label="Màu tiếp">›</button>
                        </div>
                    </div>
                </div>
                <p class="vinfast-autohaiphong_product_color-notice">
                    Hình phối màu mang tính minh họa. Màu sơn thực tế có thể khác do màn hình và điều kiện ánh sáng.
                </p>
            </div>
        </section>

        {{-- SECTION 7: BÀI VIẾT GIỚI THIỆU CHI TIẾT SẢN PHẨM (PRODUCT CONTENT ARTICLE) --}}
        <section class="vinfast-autohaiphong_product_article vinfast-autohaiphong_product_section" id="vf3-bai-viet" aria-label="Giới thiệu chi tiết {{ $car->name }}">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_article-card" data-reveal>
                    <div class="vinfast-autohaiphong_product_content">
                        @if(!empty($car->description_html))
                            {!! $car->description_html !!}
                        @else
                            <h2>Thiết kế đột phá — Định hình phong cách đô thị</h2>
                            <p>
                                VinFast {{ $car->name }} mang trong mình triết lý thiết kế tối giản nhưng giàu cá tính, được sáng tạo nhằm tối ưu hóa trải nghiệm di chuyển linh hoạt trong các đô thị năng động. Với những đường nét hình khối vuông vức khỏe khoắn, khoảng sáng gầm vượt trội và bộ la-zăng thể thao, mẫu xe tự tin thu hút mọi ánh nhìn ngay từ lần đầu chạm mắt.
                            </p>

                            <figure>
                                <img src="{{ asset('storage/clients/assets/images/theme-v1/style-yellow.webp') }}" alt="Thiết kế ngoại thất ấn tượng của VinFast {{ $car->name }}" loading="lazy" />
                                <figcaption>Ngoại thất nổi bật với những đường nét góc cạnh, phong cách thời thượng và đa dạng gam màu cá tính</figcaption>
                            </figure>

                            <p>
                                Không chỉ mang tính thẩm mỹ cao, từng chi tiết trên xe đều được tính toán kỹ lưỡng về mặt khí động học và sự thực dụng. Mặt trước nổi bật với logo chữ V mạ crôm vươn rộng liền mạch cùng cụm đèn chiếu sáng sắc sảo, tạo dấu ấn nhận diện thương hiệu VinFast đặc trưng và sang trọng.
                            </p>

                            <blockquote>
                                "Sở hữu VinFast {{ $car->name }} không chỉ là sở hữu một phương tiện di chuyển, mà là khẳng định phong cách sống xanh, văn minh và đón đầu kỷ nguyên giao thông tương lai."
                            </blockquote>

                            <h2>Không gian nội thất tinh gọn, tiện nghi vượt trội</h2>
                            <p>
                                Bước vào khoang lái của VinFast {{ $car->name }}, người dùng sẽ lập tức cảm nhận được sự thoáng đãng và ngăn nắp. Triết lý thiết kế công thái học (Ergonomics) được ứng dụng thông minh giúp tối đa hóa không gian để chân và khoảng trần xe, mang đến sự dễ chịu cho cả người lái lẫn hành khách trên mọi cung đường.
                            </p>

                            <figure>
                                <img src="{{ asset('storage/clients/assets/images/theme-v1/interior.webp') }}" alt="Khoang lái công thái học và màn hình điều khiển thông minh xe VinFast {{ $car->name }}" loading="lazy" />
                                <figcaption>Khoang lái hiện đại với màn hình cảm ứng trung tâm sắc nét, tích hợp điều khiển thông minh và kết nối đa phương tiện</figcaption>
                            </figure>

                            <p>
                                Các trang bị tiện ích trên xe được chăm chút để đáp ứng hoàn hảo nhu cầu sinh hoạt thường nhật:
                            </p>
                            <ul>
                                <li>Màn hình giải trí cảm ứng sắc nét, giao diện tiếng Việt thân thiện, hỗ trợ kết nối thông minh không dây.</li>
                                <li>Vô lăng thiết kế vát đáy thể thao D-cut tích hợp các phím điều khiển chức năng tiện lợi.</li>
                                <li>Ghế ngồi bọc da êm ái, phối màu trẻ trung, hàng ghế sau có thể gập linh hoạt mở rộng khoang hành lý lên tới hàng trăm lít.</li>
                                <li>Hệ thống điều hòa làm mát nhanh và sâu, giữ không khí trong xe luôn trong lành, dễ chịu.</li>
                            </ul>

                            <h2>Khả năng vận hành bền bỉ & An toàn vượt chuẩn</h2>
                            <p>
                                Được trang bị khối động cơ điện thế hệ mới kết hợp cùng hệ thống pin lithium tiên tiến, xe mang lại khả năng tăng tốc tức thì, mượt mà và hoàn toàn không có độ trễ chân ga. Vận hành êm ái tuyệt đối, không tiếng ồn động cơ và không mùi xăng dầu, biến mỗi chuyến đi thành khoảng thời gian thư thái trọn vẹn.
                            </p>

                            <figure>
                                <img src="{{ asset('storage/clients/assets/images/theme-v1/nature-yellow.webp') }}" alt="VinFast {{ $car->name }} di chuyển linh hoạt trên mọi cung đường" loading="lazy" />
                                <figcaption>Linh hoạt chinh phục các cung đường đô thị đông đúc lẫn những chuyến dã ngoại ngoại thành đầy hứng khởi</figcaption>
                            </figure>

                            <p>
                                VinFast luôn đặt tiêu chuẩn an toàn của khách hàng lên hàng đầu. Xe được trang bị khung gầm cứng vững cùng hệ thống an toàn chủ động và thụ động toàn diện:
                            </p>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Hạng mục an toàn</th>
                                        <th>Trang bị tiêu chuẩn</th>
                                        <th>Lợi ích thực tế</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Hệ thống phanh</td>
                                        <td>Phanh đĩa trước + ABS / EBD</td>
                                        <td>Rút ngắn quãng đường phanh, chống bó cứng an toàn khi phanh gấp</td>
                                    </tr>
                                    <tr>
                                        <td>Cân bằng & Lực kéo</td>
                                        <td>Hệ thống kiểm soát lực kéo (TCS)</td>
                                        <td>Chống trơn trượt hiệu quả trên đường mưa ướt, ôm cua vững vàng</td>
                                    </tr>
                                    <tr>
                                        <td>Hỗ trợ đỗ xe</td>
                                        <td>Cảm biến lùi & Camera quan sát</td>
                                        <td>Tự tin xoay xở và lùi đỗ vào những điểm đỗ chật hẹp</td>
                                    </tr>
                                    <tr>
                                        <td>Bảo vệ pin & Khoang lái</td>
                                        <td>Tiêu chuẩn chống nước IP67</td>
                                        <td>An tâm di chuyển qua các tuyến phố ngập nước trong mùa mưa</td>
                                    </tr>
                                </tbody>
                            </table>

                            <p>
                                Với chi phí vận hành siêu tiết kiệm chỉ bằng 1/3 xe xăng cùng chính sách hậu mãi và bảo hành chính hãng lên tới 7 năm hoặc 160.000 km, VinFast {{ $car->name }} là sự lựa chọn kinh tế, bền bỉ và đáng tin cậy hàng đầu cho mọi cá nhân và gia đình.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 5: SHOWCASE IMAGE BANNER (SLIDER 19:6 NGHỆ THUẬT, KHÔNG CHỨA TEXT) --}}
        @php
            $showcaseBanners = (!empty($banners) && $banners->isNotEmpty()) ? $banners : collect([
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/style-yellow.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' - Ngoại thất và kiến trúc nổi bật',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/nature-yellow.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' - Khám phá tự do phong cách',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/hero.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' - Đột phá phong cách đô thị',
                ],
            ]);
        @endphp

        <section class="vinfast-autohaiphong_product_image-banner vinfast-autohaiphong_product_showcase" aria-label="Bộ ảnh VinFast {{ $car->name }}">
            <div class="vinfast-autohaiphong_product_showcase-slider" data-showcase-slider>
                @foreach($showcaseBanners as $sIndex => $sBanner)
                    <div class="vinfast-autohaiphong_product_showcase-slide {{ $sIndex === 0 ? 'vinfast-autohaiphong_product_showcase-slide-active' : '' }}"
                         data-showcase-slide="{{ $sIndex }}"
                         aria-hidden="{{ $sIndex === 0 ? 'false' : 'true' }}">
                        <img src="{{ $sBanner->image_url }}"
                             alt="{{ $sBanner->alt_text ?: ($car->name . ' - Hình ảnh chi tiết ' . ($sIndex + 1)) }}"
                             loading="lazy" />
                    </div>
                @endforeach
            </div>

            @if($showcaseBanners->count() > 1)
                {{-- Nút điều hướng mũi tên mảnh mai hai bên --}}
                <button type="button" 
                        class="vinfast-autohaiphong_product_showcase-arrow vinfast-autohaiphong_product_showcase-prev" 
                        data-action="showcase-prev" 
                        aria-label="Ảnh trước">‹</button>
                <button type="button" 
                        class="vinfast-autohaiphong_product_showcase-arrow vinfast-autohaiphong_product_showcase-next" 
                        data-action="showcase-next" 
                        aria-label="Ảnh tiếp theo">›</button>

                {{-- Chấm pagination chuyển ảnh thanh lịch --}}
                <div class="vinfast-autohaiphong_product_showcase-pagination" data-showcase-pagination>
                    @foreach($showcaseBanners as $sIndex => $sBanner)
                        <button type="button" 
                                class="vinfast-autohaiphong_product_showcase-dot {{ $sIndex === 0 ? 'vinfast-autohaiphong_product_is-active' : '' }}" 
                                data-showcase-dot="{{ $sIndex }}" 
                                aria-label="Chuyển đến ảnh banner {{ $sIndex + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- SECTION 9: BẢNG THÔNG SỐ KỸ THUẬT (TECHNICAL DATA SHEET) --}}
        <section class="vinfast-autohaiphong_product_technical" id="vf3-thong-so">
            <div class="vinfast-autohaiphong_product_container">
                {{-- HEADER PHONG CÁCH KỸ THUẬT Ô TÔ CHUYÊN NGHIỆP --}}
                <div class="vinfast-autohaiphong_product_technical-header" data-reveal>
                    <span class="vinfast-autohaiphong_product_technical-code">SPECIFICATION SHEET &bull; {{ Str::upper($car->sku ?? 'VF-3') }}</span>
                    <h2>BẢNG THÔNG SỐ KỸ THUẬT XE {{ Str::upper($car->name) }}</h2>
                    <p class="vinfast-autohaiphong_product_technical-subtitle">
                        Số liệu kỹ thuật tiêu chuẩn được kiểm định và công bố bởi VinFast Việt Nam
                    </p>
                </div>

                {{-- THANH CÔNG CỤ KỸ THUẬT (SEARCH, VIEW MODES, COPY & PRINT) --}}
                <div class="vinfast-autohaiphong_product_technical-toolbar" data-reveal>
                    <div class="vinfast-autohaiphong_product_technical-search">
                        <svg class="vinfast-autohaiphong_product_search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text"
                               data-spec-search
                               placeholder="Tìm nhanh thông số (pin, công suất, kích thước, túi khí, camera...)"
                               aria-label="Tìm nhanh thông số kỹ thuật">
                        <button type="button" data-spec-search-clear class="vinfast-autohaiphong_product_search-clear" style="display: none;" title="Xóa tìm kiếm">✕</button>
                    </div>

                    <div class="vinfast-autohaiphong_product_technical-actions">
                        <div class="vinfast-autohaiphong_product_view-modes" role="group" aria-label="Chế độ hiển thị">
                            <button type="button" data-spec-mode="tabs" class="vinfast-autohaiphong_product_mode-btn vinfast-autohaiphong_product_is-active">
                                Phân nhóm
                            </button>
                            <button type="button" data-spec-mode="all" class="vinfast-autohaiphong_product_mode-btn">
                                Toàn bộ thông số ({{ $specifications->count() }})
                            </button>
                        </div>

                        <button type="button" data-spec-action="copy" class="vinfast-autohaiphong_product_tool-btn" title="Sao chép bảng thông số">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            <span data-spec-copy-text>Sao chép</span>
                        </button>

                        <button type="button" data-spec-action="print" class="vinfast-autohaiphong_product_tool-btn" title="In bảng thông số">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                            <span>In bảng</span>
                        </button>
                    </div>
                </div>

                {{-- STATUS BAR CHO LIVE SEARCH --}}
                <div data-spec-search-status class="vinfast-autohaiphong_product_spec-search-status" style="display: none;"></div>

                {{-- VIEW 1: CHẾ ĐỘ PHÂN NHÓM (TABBED VIEW) --}}
                <div data-spec-view-tabs class="vinfast-autohaiphong_product_technical-grid" data-reveal>
                    <div class="vinfast-autohaiphong_product_technical-tabs" role="tablist" aria-label="Nhóm thông số">
                        @if($specGroups->isNotEmpty())
                            @foreach($specGroups as $gName => $gSpecs)
                                @php $gSlug = Str::slug($gName); @endphp
                                <button class="{{ $loop->first ? 'vinfast-autohaiphong_product_is-active' : '' }}"
                                        type="button"
                                        role="tab"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                        data-spec-tab="{{ $gSlug }}">
                                    <span class="vinfast-autohaiphong_product_spec-tab-num">{{ sprintf('%02d', $loop->iteration) }}</span>
                                    <span class="vinfast-autohaiphong_product_spec-tab-title">{{ $gName }}</span>
                                    <span class="vinfast-autohaiphong_product_spec-tab-count">{{ $gSpecs->count() }}</span>
                                </button>
                            @endforeach
                        @else
                            <button class="vinfast-autohaiphong_product_is-active" type="button" role="tab" aria-selected="true" data-spec-tab="general">
                                <span class="vinfast-autohaiphong_product_spec-tab-num">01</span>
                                <span class="vinfast-autohaiphong_product_spec-tab-title">Thông số tổng quan</span>
                                <span class="vinfast-autohaiphong_product_spec-tab-count">3</span>
                            </button>
                        @endif
                    </div>

                    <div class="vinfast-autohaiphong_product_technical-panel" role="tabpanel">
                        <div class="vinfast-autohaiphong_product_technical-panel-head">
                            <div>
                                <span class="vinfast-autohaiphong_product_panel-caption">DANH MỤC THÔNG SỐ KỸ THUẬT</span>
                                <h3 data-spec-title>{{ $specGroups->isNotEmpty() ? $specGroups->keys()->first() : 'Thông số kỹ thuật' }}</h3>
                            </div>
                            <span class="vinfast-autohaiphong_product_spec-panel-stamp">{{ Str::upper($car->name) }}</span>
                        </div>

                        <div class="vinfast-autohaiphong_product_table-wrap">
                            <table class="vinfast-autohaiphong_product_spec-table" aria-label="Bảng thông số chi tiết">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 55%;">HẠNG MỤC / NỘI DUNG</th>
                                        <th scope="col" style="width: 45%; text-align: right;">THÔNG SỐ TIÊU CHUẨN</th>
                                    </tr>
                                </thead>
                                <tbody data-spec-content>
                                    @if($specGroups->isNotEmpty())
                                        @foreach($specGroups->first() as $sp)
                                            <tr style="--row-idx: {{ $loop->index }};">
                                                <td class="vinfast-autohaiphong_product_cell-label">{{ $sp->label }}</td>
                                                <td class="vinfast-autohaiphong_product_cell-value">{{ trim($sp->value . ' ' . ($sp->unit ?? '')) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr style="--row-idx: 0;">
                                            <td class="vinfast-autohaiphong_product_cell-label">Tên dòng xe</td>
                                            <td class="vinfast-autohaiphong_product_cell-value">{{ $car->name }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- VIEW 2: CHẾ ĐỘ XEM TOÀN BỘ (FULL SPECIFICATION SHEET) --}}
                <div data-spec-view-all class="vinfast-autohaiphong_product_spec-all-view" style="display: none;">
                    @if($specGroups->isNotEmpty())
                        @foreach($specGroups as $gName => $gSpecs)
                            <div class="vinfast-autohaiphong_product_spec-group-block" data-reveal>
                                <div class="vinfast-autohaiphong_product_spec-group-head">
                                    <span class="vinfast-autohaiphong_product_spec-group-num">{{ sprintf('%02d', $loop->iteration) }}</span>
                                    <h4>{{ Str::upper($gName) }}</h4>
                                    <span class="vinfast-autohaiphong_product_spec-group-count">{{ $gSpecs->count() }} mục</span>
                                </div>
                                <div class="vinfast-autohaiphong_product_table-wrap">
                                    <table class="vinfast-autohaiphong_product_spec-table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 55%;">HẠNG MỤC / NỘI DUNG</th>
                                                <th scope="col" style="width: 45%; text-align: right;">THÔNG SỐ TIÊU CHUẨN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gSpecs as $sp)
                                                <tr style="--row-idx: {{ $loop->index }};">
                                                    <td class="vinfast-autohaiphong_product_cell-label">{{ $sp->label }}</td>
                                                    <td class="vinfast-autohaiphong_product_cell-value">{{ trim($sp->value . ' ' . ($sp->unit ?? '')) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- VIEW 3: CHẾ ĐỘ KẾT QUẢ TÌM KIẾM (LIVE SEARCH RESULTS) --}}
                <div data-spec-view-search class="vinfast-autohaiphong_product_spec-search-view" style="display: none;">
                    <div class="vinfast-autohaiphong_product_table-wrap">
                        <table class="vinfast-autohaiphong_product_spec-table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 28%;">PHÂN NHÓM</th>
                                    <th scope="col" style="width: 42%;">HẠNG MỤC / NỘI DUNG</th>
                                    <th scope="col" style="width: 30%; text-align: right;">THÔNG SỐ TIÊU CHUẨN</th>
                                </tr>
                            </thead>
                            <tbody data-spec-search-results>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- GHI CHÚ PHÁP LÝ & CTA KỸ THUẬT --}}
                <div class="vinfast-autohaiphong_product_technical-note" data-reveal>
                    <p>
                        (*) Các thông số kỹ thuật trên được căn cứ theo tài liệu công bố chính thức của VinFast Việt Nam. Các trang bị, tính năng có thể được nâng cấp hoặc thay đổi mà không cần thông báo trước tùy theo phiên bản phần mềm (FOTA/SOTA) hoặc lô sản xuất. Quý khách vui lòng liên hệ VinFast Minh Đạo Hải Phòng để nhận bảng cấu hình chính xác nhất tại thời điểm giao dịch.
                    </p>
                    <div class="vinfast-autohaiphong_product_technical-cta">
                        <a href="#vf3-so-sanh" class="vinfast-autohaiphong_product_btn-sharp">
                            Bảng so sánh chi phí vận hành
                        </a>
                        <button type="button" class="vinfast-autohaiphong_product_btn-sharp vinfast-autohaiphong_product_btn-sharp-primary" onclick="openQuoteModal({{ $car->id }}, '{{ $car->name }}')">
                            Yêu cầu tư vấn kỹ thuật chi tiết
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 8: NỘI THẤT XE (BENTO / MOSAIC GALLERY HÌNH CHỮ NHẬT DÀI) --}}
        @php
            $interiorList = (!empty($interiors) && $interiors->isNotEmpty()) ? $interiors : collect([
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/interior.webp'),
                    'alt_text' => 'Khoang lái công thái học & Màn hình 10 inch',
                    'caption' => 'Khoang lái công thái học & Màn hình 10 inch',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/front-detail.webp'),
                    'alt_text' => 'Chi tiết táp-lô & Vô lăng thể thao D-cut',
                    'caption' => 'Chi tiết táp-lô & Vô lăng thể thao D-cut',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/wheel-thumb.webp'),
                    'alt_text' => 'Cụm điều khiển thông minh & Cần gạt số',
                    'caption' => 'Cụm điều khiển thông minh & Cần gạt số',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/red-thumb.webp'),
                    'alt_text' => 'Hàng ghế sau gập linh hoạt 285L',
                    'caption' => 'Hàng ghế sau gập linh hoạt 285L',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/yellow-thumb.webp'),
                    'alt_text' => 'Tối ưu không gian 4 chỗ ngồi rộng rãi',
                    'caption' => 'Tối ưu không gian 4 chỗ ngồi rộng rãi',
                ],
            ]);
        @endphp

        <section class="vinfast-autohaiphong_product_interior vinfast-autohaiphong_product_section" id="vf3-noi-that">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_section-head" data-reveal>
                    <h2>Không gian nội thất xe {{ $car->name }}</h2>
                    <p>Thiết kế công thái học tối ưu hoá từng centimet, mang lại trải nghiệm tiện nghi, trẻ trung và hiện đại</p>
                </div>

                {{-- Khối Nội Thất Xếp Tầng Xếp Lớp (Tiered Gallery) - Ảnh to bản, dài sâu, tuyệt đối không đè nhau --}}
                <div class="vinfast-autohaiphong_product_interior-gallery" data-reveal>
                    @php
                        $interiorItems = $interiorList->values();
                        $total = $interiorItems->count();
                        $cIdx = 0;
                    @endphp

                    @while($cIdx < $total)
                        @php
                            $rem = $total - $cIdx;
                        @endphp

                        @if($rem === 1)
                            {{-- Tầng 1 ảnh to đại cảnh trải rộng --}}
                            <div class="vinfast-autohaiphong_product_interior-tier vinfast-autohaiphong_product_interior-tier-full">
                                @php $item = $interiorItems[$cIdx]; @endphp
                                <div class="vinfast-autohaiphong_product_interior-card vinfast-autohaiphong_product_lightbox-trigger"
                                     role="button" tabindex="0" data-lightbox="{{ $cIdx }}"
                                     aria-label="Xem chi tiết: {{ $item->caption ?: 'Nội thất xe' }}">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->alt_text ?: ($item->caption ?: 'Ảnh nội thất ' . ($cIdx + 1)) }}" loading="lazy" />
                                    @if(!empty($item->caption))
                                        <div class="vinfast-autohaiphong_product_interior-caption">
                                            <span>{{ $item->caption }}</span>
                                            <span class="vinfast-autohaiphong_product_interior-zoom-icon">↗</span>
                                        </div>
                                    @endif
                                </div>
                                @php $cIdx += 1; @endphp
                            </div>
                        @elseif($rem === 2)
                            {{-- Tầng 2 ảnh to song song ngang nhau --}}
                            <div class="vinfast-autohaiphong_product_interior-tier vinfast-autohaiphong_product_interior-tier-pair">
                                @for($k = 0; $k < 2; $k++)
                                    @php $item = $interiorItems[$cIdx]; @endphp
                                    <div class="vinfast-autohaiphong_product_interior-card vinfast-autohaiphong_product_lightbox-trigger"
                                         role="button" tabindex="0" data-lightbox="{{ $cIdx }}"
                                         aria-label="Xem chi tiết: {{ $item->caption ?: 'Nội thất xe' }}">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->alt_text ?: ($item->caption ?: 'Ảnh nội thất ' . ($cIdx + 1)) }}" loading="lazy" />
                                        @if(!empty($item->caption))
                                            <div class="vinfast-autohaiphong_product_interior-caption">
                                                <span>{{ $item->caption }}</span>
                                                <span class="vinfast-autohaiphong_product_interior-zoom-icon">↗</span>
                                            </div>
                                        @endif
                                    </div>
                                    @php $cIdx += 1; @endphp
                                @endfor
                            </div>
                        @elseif($rem === 3 || $rem >= 5)
                            {{-- Tầng Cụm 3 ảnh: 1 ảnh lớn (Hero) + 2 ảnh xếp chồng bên cạnh (Đảo bên so le theo lượt) --}}
                            @php
                                $isReversed = (floor($cIdx / 5) % 2 === 1);
                            @endphp
                            <div class="vinfast-autohaiphong_product_interior-tier vinfast-autohaiphong_product_interior-tier-combo {{ $isReversed ? 'vinfast-autohaiphong_product_interior-tier-reversed' : '' }}">
                                <div class="vinfast-autohaiphong_product_interior-combo-hero">
                                    @php $item = $interiorItems[$cIdx]; @endphp
                                    <div class="vinfast-autohaiphong_product_interior-card vinfast-autohaiphong_product_lightbox-trigger"
                                         role="button" tabindex="0" data-lightbox="{{ $cIdx }}"
                                         aria-label="Xem chi tiết: {{ $item->caption ?: 'Nội thất xe' }}">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->alt_text ?: ($item->caption ?: 'Ảnh nội thất ' . ($cIdx + 1)) }}" loading="lazy" />
                                        @if(!empty($item->caption))
                                            <div class="vinfast-autohaiphong_product_interior-caption">
                                                <span>{{ $item->caption }}</span>
                                                <span class="vinfast-autohaiphong_product_interior-zoom-icon">↗</span>
                                            </div>
                                        @endif
                                    </div>
                                    @php $cIdx += 1; @endphp
                                </div>
                                <div class="vinfast-autohaiphong_product_interior-combo-stack">
                                    @for($k = 0; $k < 2; $k++)
                                        @php $item = $interiorItems[$cIdx]; @endphp
                                        <div class="vinfast-autohaiphong_product_interior-card vinfast-autohaiphong_product_lightbox-trigger"
                                             role="button" tabindex="0" data-lightbox="{{ $cIdx }}"
                                             aria-label="Xem chi tiết: {{ $item->caption ?: 'Nội thất xe' }}">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->alt_text ?: ($item->caption ?: 'Ảnh nội thất ' . ($cIdx + 1)) }}" loading="lazy" />
                                            @if(!empty($item->caption))
                                                <div class="vinfast-autohaiphong_product_interior-caption">
                                                    <span>{{ $item->caption }}</span>
                                                    <span class="vinfast-autohaiphong_product_interior-zoom-icon">↗</span>
                                                </div>
                                            @endif
                                        </div>
                                        @php $cIdx += 1; @endphp
                                    @endfor
                                </div>
                            </div>
                        @elseif($rem === 4)
                            {{-- 4 ảnh còn lại: chia thành 2 cặp ảnh to song song --}}
                            <div class="vinfast-autohaiphong_product_interior-tier vinfast-autohaiphong_product_interior-tier-pair">
                                @for($k = 0; $k < 2; $k++)
                                    @php $item = $interiorItems[$cIdx]; @endphp
                                    <div class="vinfast-autohaiphong_product_interior-card vinfast-autohaiphong_product_lightbox-trigger"
                                         role="button" tabindex="0" data-lightbox="{{ $cIdx }}"
                                         aria-label="Xem chi tiết: {{ $item->caption ?: 'Nội thất xe' }}">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->alt_text ?: ($item->caption ?: 'Ảnh nội thất ' . ($cIdx + 1)) }}" loading="lazy" />
                                        @if(!empty($item->caption))
                                            <div class="vinfast-autohaiphong_product_interior-caption">
                                                <span>{{ $item->caption }}</span>
                                                <span class="vinfast-autohaiphong_product_interior-zoom-icon">↗</span>
                                            </div>
                                        @endif
                                    </div>
                                    @php $cIdx += 1; @endphp
                                @endfor
                            </div>
                        @endif
                    @endwhile
                </div>
            </div>
        </section>

        {{-- SECTION 4: SO SÁNH CHI PHÍ VẬN HÀNH (EV VS ICE) --}}
        <section class="vinfast-autohaiphong_product_compare vinfast-autohaiphong_product_section" 
                 id="vf3-so-sanh"
                 data-calc-ev-rate="{{ $comparison['ev_consumption'] }}"
                 data-calc-ice-rate="{{ $comparison['ice_consumption'] }}">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_section-head" data-reveal>
                    <h2>So sánh kinh tế giữa VinFast <strong>"{{ $car->name }}"</strong> và xe xăng cùng phân khúc</h2>
                    <p>Định mức tiêu hao thực tế theo phân khúc {{ $comparison['segment_name'] }} giúp ước tính chính xác hiệu quả tiết kiệm chi phí</p>
                </div>
                <div class="vinfast-autohaiphong_product_compare-grid" data-reveal>
                    <div class="vinfast-autohaiphong_product_compare-form">
                        <h3>Ước tính chi phí năng lượng di chuyển hằng năm</h3>
                        <p class="vinfast-autohaiphong_product_muted">
                            Dựa trên định mức tiêu chuẩn của VinFast <strong>"{{ $car->name }}"</strong> và dòng xe động cơ đốt trong tương đương (chưa bao gồm chi phí bảo dưỡng và khấu hao).
                        </p>
                        <label class="vinfast-autohaiphong_product_field">
                            <span>Quãng đường di chuyển mỗi năm</span>
                            <input type="range" min="3000" max="35000" step="1000" value="{{ $comparison['default_distance'] }}" data-calc="distance" />
                            <output data-calc-label="distance">{{ number_format($comparison['default_distance'], 0, ',', '.') }} km</output>
                        </label>
                        <label class="vinfast-autohaiphong_product_field">
                            <span>Giá điện sinh hoạt / trụ sạc (VNĐ/kWh)</span>
                            <input type="number" min="0" step="100" value="{{ $comparison['default_electricity_price'] }}" data-calc="electricity" />
                        </label>
                        <label class="vinfast-autohaiphong_product_field">
                            <span>Giá xăng RON 95 tham chiếu (VNĐ/lít)</span>
                            <input type="number" min="0" step="100" value="{{ $comparison['default_petrol_price'] }}" data-calc="petrol" />
                        </label>
                        <div class="vinfast-autohaiphong_product_compare-results">
                            <div>
                                <span>VinFast {{ $car->name }} · {{ $comparison['ev_consumption'] }} kWh/100km</span>
                                <strong data-calc-result="electric">{{ number_format($comparison['initial_ev_cost'], 0, ',', '.') }} ₫</strong>
                            </div>
                            <div>
                                <span>{{ $comparison['ice_label'] }} · {{ $comparison['ice_consumption'] }} lít/100km</span>
                                <strong data-calc-result="petrol">{{ number_format($comparison['initial_ice_cost'], 0, ',', '.') }} ₫</strong>
                            </div>
                        </div>
                        <p class="vinfast-autohaiphong_product_saving">
                            <span>Tiết kiệm chi phí năng lượng mỗi năm:</span>
                            <strong data-calc-result="saving">{{ number_format($comparison['initial_saving'], 0, ',', '.') }} ₫/năm</strong>
                        </p>
                    </div>

                    <div class="vinfast-autohaiphong_product_compare-story">
                        <div class="vinfast-autohaiphong_product_compare-story-top">
                            <span class="vinfast-autohaiphong_product_leaf">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                                </svg>
                            </span>
                            <h3>Lựa chọn di chuyển xanh · {{ $comparison['segment_name'] }}</h3>
                            <p>Không phát thải khí nhà kính từ ống xả, chi phí nhiên liệu chỉ bằng khoảng 1/3 đến 1/4 so với xe xăng cùng phân khúc, vận hành êm ái vượt bậc.</p>
                        </div>
                        <img src="{{ $mainCarImage }}" alt="{{ $car->name }}" loading="lazy" />
                        <p>Thông số so sánh thực tế theo phân khúc {{ $comparison['segment_name'] }}, minh chứng lợi thế tài chính lâu dài của xe điện VinFast.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 10: BOTTOM HERO CTA (SLIDER 19:6 NGHỆ THUẬT, GIỮ NGUYÊN BOTTOM-OVERLAY) --}}
        @php
            $bottomBanners = (!empty($banners) && $banners->isNotEmpty()) ? $banners : collect([
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/footer-car.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' trên mọi cung đường',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/hero.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' - Khám phá phong cách mới',
                ],
                (object)[
                    'image_url' => asset('storage/clients/assets/images/theme-v1/nature-yellow.webp'),
                    'alt_text' => 'VinFast ' . $car->name . ' - Bền bỉ và tiết kiệm',
                ],
            ]);
        @endphp

        <section class="vinfast-autohaiphong_product_bottom-hero" aria-label="Khám phá VinFast {{ $car->name }}">
            <div class="vinfast-autohaiphong_product_bottom-slider" data-bottom-slider>
                @foreach($bottomBanners as $bIndex => $bBanner)
                    <div class="vinfast-autohaiphong_product_bottom-slide {{ $bIndex === 0 ? 'vinfast-autohaiphong_product_bottom-slide-active' : '' }}"
                         data-bottom-slide="{{ $bIndex }}"
                         aria-hidden="{{ $bIndex === 0 ? 'false' : 'true' }}">
                        <img src="{{ $bBanner->image_url }}" 
                             alt="{{ $bBanner->alt_text ?: ($car->name . ' - Banner ' . ($bIndex + 1)) }}" 
                             loading="lazy" />
                    </div>
                @endforeach
            </div>

            @if($bottomBanners->count() > 1)
                {{-- Nút điều hướng hai bên mỏng nhẹ --}}
                <button type="button" 
                        class="vinfast-autohaiphong_product_bottom-arrow vinfast-autohaiphong_product_bottom-prev" 
                        data-action="bottom-prev" 
                        aria-label="Ảnh trước">‹</button>
                <button type="button" 
                        class="vinfast-autohaiphong_product_bottom-arrow vinfast-autohaiphong_product_bottom-next" 
                        data-action="bottom-next" 
                        aria-label="Ảnh tiếp theo">›</button>

                {{-- Pagination dots thanh lịch ở đáy --}}
                <div class="vinfast-autohaiphong_product_bottom-pagination" data-bottom-pagination>
                    @foreach($bottomBanners as $bIndex => $bBanner)
                        <button type="button" 
                                class="vinfast-autohaiphong_product_bottom-dot {{ $bIndex === 0 ? 'vinfast-autohaiphong_product_is-active' : '' }}" 
                                data-bottom-dot="{{ $bIndex }}" 
                                aria-label="Chuyển sang ảnh {{ $bIndex + 1 }}"></button>
                    @endforeach
                </div>
            @endif

            <div class="vinfast-autohaiphong_product_bottom-overlay">
                <h2>{{ $shortModelName }}</h2>
                <p>Nhỏ gọn. Cá tính. Sẵn sàng cùng bạn trên mọi hành trình.</p>
                <div>
                    <form action="{{ route('client.cart.add') }}" method="POST" style="display: inline-block;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $car->id }}">
                        <input type="hidden" name="variant_id" value="{{ $variants->first()?->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="vinfast-autohaiphong_product_btn vinfast-autohaiphong_product_btn-primary">
                            Đặt cọc ngay ↗
                        </button>
                    </form>
                    <button class="vinfast-autohaiphong_product_btn vinfast-autohaiphong_product_btn-white" type="button" onclick="openQuoteModal({{ $car->id }}, 'Đăng ký lái thử {{ $car->name }}')">
                        Đăng ký lái thử
                    </button>
                </div>
            </div>
        </section>

        {{-- SECTION 11: CÁC DÒNG XE CÙNG PHÂN KHÚC (RELATED CARS) --}}
        @if($relatedCars->isNotEmpty())
            <section class="vinfast-autohaiphong_product_section" style="background-color: var(--vf-bg); border-top: 1px solid var(--vf-border); padding: 60px 0;">
                <div class="vinfast-autohaiphong_product_container">
                    <div class="vinfast-autohaiphong_product_section-head" style="margin-bottom: 36px;">
                        <h2>Các Dòng Xe VinFast Khác</h2>
                        <p>Khám phá thêm các dòng ô tô điện thông minh phù hợp cho gia đình và công việc</p>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                        @foreach($relatedCars as $rel)
                            <div style="background: #ffffff; border: 1px solid var(--vf-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s;">
                                <a href="{{ route('client.products.show', $rel->slug) }}" style="display: block; aspect-ratio: 16/9; overflow: hidden; background: #f8fafc;">
                                    @if($rel->thumbnail_path)
                                        <img src="{{ asset('storage/' . $rel->thumbnail_path) }}" alt="{{ $rel->thumbnail_alt ?: $rel->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--vf-muted); font-weight: 600;">VinFast</div>
                                    @endif
                                </a>
                                <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 6px; color: var(--vf-text);">
                                            <a href="{{ route('client.products.show', $rel->slug) }}">{{ $rel->name }}</a>
                                        </h3>
                                        <div style="font-size: 0.95rem; font-weight: 700; color: var(--vf-blue); margin-bottom: 12px;">
                                            {{ $rel->price_on_request ? 'Liên hệ báo giá' : number_format($rel->sale_price ?: $rel->regular_price, 0, ',', '.') . ' VNĐ' }}
                                        </div>
                                    </div>
                                    <a href="{{ route('client.products.show', $rel->slug) }}" class="vinfast-autohaiphong_product_btn vinfast-autohaiphong_product_btn-outline" style="width: 100%;">
                                        Xem Chi Tiết Xe →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- THƯ VIỆN ẢNH SẢN PHẨM (INTERACTIVE PRODUCT GALLERY CHO GALLERY IMAGES) --}}
        @if($galleryImages->isNotEmpty())
            <div class="sr-only" data-vf-product-gallery aria-hidden="true" style="display: none;">
                @foreach($galleryImages as $gIdx => $gImg)
                    <div data-vf-gallery-slide class="{{ $gIdx === 0 ? 'is-active' : '' }}">
                        <img src="{{ asset('storage/' . $gImg->path) }}" alt="{{ $gImg->alt_text ?: $car->name }}">
                    </div>
                    <button type="button" data-vf-gallery-thumbnail="{{ $gIdx }}" class="{{ $gIdx === 0 ? 'is-active' : '' }}">
                        <img src="{{ asset('storage/' . $gImg->path) }}" alt="{{ $gImg->alt_text ?: $car->name }}">
                    </button>
                @endforeach
                <button type="button" data-vf-gallery-previous>‹</button>
                <button type="button" data-vf-gallery-next>›</button>
                <span data-vf-gallery-counter>1 / {{ $galleryImages->count() }}</span>
            </div>
        @endif
    </main>

    {{-- FLOATING ACTION BUTTONS --}}
    <div class="vinfast-autohaiphong_product_floating">
        <button type="button" onclick="openQuoteModal({{ $car->id }}, '{{ $car->name }}')" class="vinfast-autohaiphong_product_float-button" aria-label="Mở tư vấn báo giá">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </button>
        <button type="button" data-action="top" class="vinfast-autohaiphong_product_float-top" aria-label="Lên đầu trang">
            ↑
        </button>
    </div>

    {{-- LIGHTBOX MODAL DIALOG --}}
    <div class="vinfast-autohaiphong_product_lightbox" role="presentation" data-lightbox-modal hidden>
        <div class="vinfast-autohaiphong_product_lightbox-shade" data-action="close-lightbox"></div>
        <div class="vinfast-autohaiphong_product_lightbox-content" role="dialog" aria-modal="true" aria-label="Thư viện ảnh {{ $car->name }}">
            <button type="button" class="vinfast-autohaiphong_product_lightbox-close" data-action="close-lightbox" aria-label="Đóng ảnh">×</button>
            <button type="button" class="vinfast-autohaiphong_product_lightbox-nav" data-action="lightbox-prev" aria-label="Ảnh trước">‹</button>
            <img data-lightbox-image alt="Hình ảnh {{ $car->name }}" />
            <button type="button" class="vinfast-autohaiphong_product_lightbox-nav" data-action="lightbox-next" aria-label="Ảnh tiếp">›</button>
            <div class="vinfast-autohaiphong_product_lightbox-count" data-lightbox-count>1 / 7</div>
        </div>
    </div>
</div>
@endsection
