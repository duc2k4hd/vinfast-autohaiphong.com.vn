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
        {{-- SECTION 1: HERO BANNER SLIDER --}}
        <section class="vinfast-autohaiphong_product_hero" id="dau-trang" aria-label="VinFast {{ $car->name }}" data-vf-product-gallery>
            <div class="vinfast-autohaiphong_product_hero-slider" data-hero-slider>
                @foreach($gallerySlides as $index => $slide)
                    <div class="vinfast-autohaiphong_product_hero-slide {{ $index === 0 ? 'vinfast-autohaiphong_product_hero-slide-active' : '' }}"
                         data-vf-gallery-slide="{{ $index }}"
                         aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                        <img src="{{ $slide['src'] }}" 
                             alt="{{ $slide['alt'] }}"
                             @if($index === 0) fetchpriority="high" @else loading="lazy" @endif />
                    </div>
                @endforeach

                @if($gallerySlides->count() > 1)
                    <button class="vinfast-autohaiphong_product_hero-arrow vinfast-autohaiphong_product_hero-prev is-previous"
                            type="button"
                            data-action="hero-prev"
                            data-vf-gallery-previous
                            aria-label="Ảnh trước">
                        ‹
                    </button>
                    <button class="vinfast-autohaiphong_product_hero-arrow vinfast-autohaiphong_product_hero-next is-next"
                            type="button"
                            data-action="hero-next"
                            data-vf-gallery-next
                            aria-label="Ảnh tiếp">
                        ›
                    </button>
                    <div class="vinfast-autohaiphong_product_hero-pagination" aria-label="Chọn banner">
                        @foreach($gallerySlides as $index => $slide)
                            <button type="button"
                                    class="vinfast-autohaiphong_product_hero-dot {{ $index === 0 ? 'vinfast-autohaiphong_product_is-active is-active' : '' }}"
                                    data-hero-dot="{{ $index }}"
                                    data-vf-gallery-thumbnail="{{ $index }}"
                                    aria-label="Banner {{ $index + 1 }}"></button>
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
                        <span class="vinfast-autohaiphong_product_intro-watermark">{{ $shortModelName }}</span>
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

                        {{-- 2. Spec Highlights (3 khối thanh mảnh phân cách bởi nét mờ như ảnh mẫu) --}}
                        <div class="vinfast-autohaiphong_product_spec-highlights">
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

        {{-- SECTION 3: BỘ SƯU TẬP MÀU SẮC (COLOR STUDIO) --}}
        <section class="vinfast-autohaiphong_product_colors vinfast-autohaiphong_product_section" id="vf3-mau-xe">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_section-head" data-reveal>
                    <h2>Tự do sáng tạo, tỏa sáng chất riêng</h2>
                    <p>Lựa chọn màu sắc phù hợp với phong cách và cá tính của bạn</p>
                </div>
                <div class="vinfast-autohaiphong_product_color-stage" data-reveal>
                    <img class="vinfast-autohaiphong_product_color-car"
                         data-color-car
                         src="{{ asset('storage/clients/assets/images/theme-v1/product-white.webp') }}"
                         alt="Mô phỏng {{ $car->name }} theo màu được chọn"
                         loading="lazy" />
                    <div class="vinfast-autohaiphong_product_color-bottom">
                        <div class="vinfast-autohaiphong_product_color-switcher" role="group" aria-label="Chọn màu xe">
                            <button type="button" data-action="color-prev" class="vinfast-autohaiphong_product_color-arrow" aria-label="Màu trước">‹</button>
                            <div class="vinfast-autohaiphong_product_swatches" data-swatches></div>
                            <button type="button" data-action="color-next" class="vinfast-autohaiphong_product_color-arrow" aria-label="Màu tiếp">›</button>
                        </div>
                        <p class="vinfast-autohaiphong_product_color-name" data-color-name>Infinity Blanc</p>
                    </div>
                </div>
                <p class="vinfast-autohaiphong_product_color-notice">
                    Hình phối màu mang tính minh họa. Màu sơn thực tế có thể khác do màn hình và điều kiện ánh sáng.
                </p>
            </div>
        </section>

        {{-- SECTION 4: SO SÁNH CHI PHÍ VẬN HÀNH (EV VS ICE) --}}
        <section class="vinfast-autohaiphong_product_compare vinfast-autohaiphong_product_section" id="vf3-so-sanh">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_section-head" data-reveal>
                    <h2>So sánh giữa xe VinFast {{ $car->name }} và xe động cơ đốt trong</h2>
                    <p>Khám phá lợi ích vượt trội về kinh tế và môi trường của xe điện trong sử dụng hằng ngày</p>
                </div>
                <div class="vinfast-autohaiphong_product_compare-grid" data-reveal>
                    <div class="vinfast-autohaiphong_product_compare-form">
                        <h3>Ước tính chi phí di chuyển hằng năm</h3>
                        <p class="vinfast-autohaiphong_product_muted">
                            Nhập giả định để tự so sánh chi phí năng lượng (không bao gồm phí mua xe và bảo dưỡng).
                        </p>
                        <label class="vinfast-autohaiphong_product_field">
                            <span>Quãng đường mỗi năm</span>
                            <input type="range" min="3000" max="35000" step="1000" value="12000" data-calc="distance" />
                            <output data-calc-label="distance">12.000 km</output>
                        </label>
                        <label class="vinfast-autohaiphong_product_field">
                            <span>Giá điện giả định (VNĐ/kWh)</span>
                            <input type="number" min="0" step="500" value="3000" data-calc="electricity" />
                        </label>
                        <label class="vinfast-autohaiphong_product_field">
                            <span>Giá xăng giả định (VNĐ/lít)</span>
                            <input type="number" min="0" step="500" value="24000" data-calc="petrol" />
                        </label>
                        <div class="vinfast-autohaiphong_product_compare-results">
                            <div>
                                <span>Xe điện · 12 kWh/100km (giả định)</span>
                                <strong data-calc-result="electric">4.320.000 ₫</strong>
                            </div>
                            <div>
                                <span>Xe xăng · 6 lít/100km (giả định)</span>
                                <strong data-calc-result="petrol">17.280.000 ₫</strong>
                            </div>
                        </div>
                        <p class="vinfast-autohaiphong_product_saving">
                            Chênh lệch chi phí giả định: <strong data-calc-result="saving">12.960.000 ₫/năm</strong>
                        </p>
                    </div>

                    <div class="vinfast-autohaiphong_product_compare-story">
                        <div class="vinfast-autohaiphong_product_compare-story-top">
                            <span class="vinfast-autohaiphong_product_leaf">❧</span>
                            <h3>Lựa chọn di chuyển xanh</h3>
                            <p>Không phát thải trực tiếp từ ống xả, vận hành êm ái và linh hoạt trên mọi cung đường.</p>
                        </div>
                        <img src="{{ $mainCarImage }}" alt="{{ $car->name }}" loading="lazy" />
                        <p>Ví dụ minh họa dùng thông số tiêu thụ do người dùng giả định, giúp hình dung khả năng tiết kiệm chi phí.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 5: SHOWCASE IMAGE BANNER --}}
        <section class="vinfast-autohaiphong_product_image-banner vinfast-autohaiphong_product_showcase" aria-label="VinFast {{ $car->name }}">
            <img src="{{ asset('storage/clients/assets/images/theme-v1/style-yellow.webp') }}"
                 alt="{{ $car->name }} - Ngoại thất và kiến trúc nổi bật"
                 loading="lazy" />
            <span aria-hidden="true">{{ $shortModelName }}</span>
        </section>

        {{-- SECTION 6: DESIGN HIGHLIGHTS & GALLERY --}}
        <section class="vinfast-autohaiphong_product_design vinfast-autohaiphong_product_section" id="vf3-thiet-ke">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_design-head" data-reveal>
                    <div>
                        <h2>Định hình phong cách di chuyển đô thị</h2>
                        <p>Ngôn ngữ thiết kế khác biệt giúp xe luôn thu hút ánh nhìn ở bất cứ nơi đâu.</p>
                    </div>
                    <div>
                        <h3>Tìm hiểu về {{ $car->name }}</h3>
                        <div class="vinfast-autohaiphong_product_design-tabs" role="tablist" aria-label="Thông tin nổi bật">
                            <button class="vinfast-autohaiphong_product_is-active" type="button" role="tab" aria-selected="true" data-design-tab="0">
                                Bán kính quay
                            </button>
                            <button type="button" role="tab" aria-selected="false" data-design-tab="1">
                                Chiều dài cơ sở
                            </button>
                            <button type="button" role="tab" aria-selected="false" data-design-tab="2">
                                La-zăng
                            </button>
                        </div>
                        <p class="vinfast-autohaiphong_product_design-description" data-design-description>
                            Dễ dàng quay đầu xe trong không gian đô thị với bán kính quay tối thiểu khoảng 4,5m.
                        </p>
                        <button type="button" class="vinfast-autohaiphong_product_text-cta" onclick="openQuoteModal({{ $car->id }}, '{{ $car->name }}')">
                            Đăng ký tư vấn ngay <span aria-hidden="true">→</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="vinfast-autohaiphong_product_design-gallery" data-reveal>
                <button type="button" class="vinfast-autohaiphong_product_gallery-arrow vinfast-autohaiphong_product_gallery-left" data-action="gallery-prev" aria-label="Ảnh trước">‹</button>
                <div class="vinfast-autohaiphong_product_design-track" data-design-track>
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/city-red.webp') }}" alt="{{ $car->name }} - Khung cảnh đô thị" loading="lazy" />
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/cyber-yellow.webp') }}" alt="{{ $car->name }} - Phong cách hiện đại" loading="lazy" />
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/nature-yellow.webp') }}" alt="{{ $car->name }} - Khám phá thiên nhiên" loading="lazy" />
                </div>
                <button type="button" class="vinfast-autohaiphong_product_gallery-arrow vinfast-autohaiphong_product_gallery-right" data-action="gallery-next" aria-label="Ảnh sau">›</button>
            </div>
        </section>

        {{-- SECTION 7: NGOẠI THẤT MOSAIC GRID (LIGHTBOX TRIGGERS) --}}
        <section class="vinfast-autohaiphong_product_mosaic" id="vf3-ngoai-that" aria-label="Hình ảnh ngoại thất {{ $car->name }}">
            <div class="vinfast-autohaiphong_product_mosaic-main vinfast-autohaiphong_product_lightbox-trigger" tabindex="0" role="button" aria-label="Xem ảnh ngoại thất lớn" data-lightbox="0">
                <img src="{{ asset('storage/clients/assets/images/theme-v1/cyber-yellow.webp') }}" alt="{{ $car->name }} - Góc nhìn tổng quan" loading="lazy" />
            </div>
            <div class="vinfast-autohaiphong_product_mosaic-row">
                <div class="vinfast-autohaiphong_product_lightbox-trigger" tabindex="0" role="button" aria-label="Xem chi tiết đầu xe" data-lightbox="1">
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/front-detail.webp') }}" alt="{{ $car->name }} - Chi tiết mặt ca-lăng và đèn pha" loading="lazy" />
                </div>
                <div class="vinfast-autohaiphong_product_lightbox-trigger" tabindex="0" role="button" aria-label="Xem xe hòa cùng thiên nhiên" data-lightbox="2">
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/nature-yellow.webp') }}" alt="{{ $car->name }} - Trên cung đường ven biển" loading="lazy" />
                </div>
            </div>
            <div class="vinfast-autohaiphong_product_mosaic-thumbs">
                <button type="button" data-lightbox="3">
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/red-thumb.webp') }}" alt="{{ $car->name }} sắc đỏ" loading="lazy" />
                    <span>Phong cách cá tính</span>
                </button>
                <button type="button" data-lightbox="4">
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/yellow-thumb.webp') }}" alt="{{ $car->name }} sắc vàng" loading="lazy" />
                    <span>Thiết kế linh hoạt</span>
                </button>
                <button type="button" data-lightbox="5">
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/wheel-thumb.webp') }}" alt="Chi tiết la-zăng {{ $car->name }}" loading="lazy" />
                    <span>Ấn tượng trong từng chi tiết</span>
                </button>
            </div>
        </section>

        {{-- SECTION 8: NỘI THẤT XE --}}
        <section class="vinfast-autohaiphong_product_interior vinfast-autohaiphong_product_section" id="vf3-noi-that">
            <div class="vinfast-autohaiphong_product_container">
                <div class="vinfast-autohaiphong_product_section-head" data-reveal>
                    <h2>Luôn đủ chỗ cho mọi người</h2>
                    <p>Không gian được tối ưu để mỗi hành trình đều thoải mái cho bạn và những người đồng hành.</p>
                </div>
                <div class="vinfast-autohaiphong_product_interior-image vinfast-autohaiphong_product_lightbox-trigger" role="button" tabindex="0" data-lightbox="6" aria-label="Xem chi tiết nội thất">
                    <img src="{{ asset('storage/clients/assets/images/theme-v1/interior.webp') }}" alt="Không gian nội thất xe {{ $car->name }}, ghế ngồi và màn hình giải trí" loading="lazy" />
                    <span class="vinfast-autohaiphong_product_interior-label">Nội thất <span>↗</span></span>
                </div>
            </div>
        </section>

        {{-- SECTION 9: BẢNG THÔNG SỐ KỸ THUẬT (TECHNICAL SPECIFICATIONS) --}}
        <section class="vinfast-autohaiphong_product_technical" id="vf3-thong-so">
            <div class="vinfast-autohaiphong_product_container">
                <h2 data-reveal style="color: #ffffff; margin-bottom: 24px;">
                    BẢNG THÔNG SỐ KỸ THUẬT XE {{ Str::upper($car->name) }}
                </h2>

                <div class="vinfast-autohaiphong_product_technical-grid">
                    <div class="vinfast-autohaiphong_product_technical-tabs" role="tablist" aria-label="Nhóm thông số">
                        @if($specGroups->isNotEmpty())
                            @foreach($specGroups as $gName => $gSpecs)
                                @php $gSlug = Str::slug($gName); @endphp
                                <button class="{{ $loop->first ? 'vinfast-autohaiphong_product_is-active' : '' }}"
                                        type="button"
                                        role="tab"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                        data-spec-tab="{{ $gSlug }}">
                                    {{ $gName }} <span>›</span>
                                </button>
                            @endforeach
                        @else
                            <button class="vinfast-autohaiphong_product_is-active" type="button" role="tab" aria-selected="true" data-spec-tab="general">
                                Thông số tổng quan <span>›</span>
                            </button>
                        @endif
                    </div>

                    <div class="vinfast-autohaiphong_product_technical-panel" role="tabpanel">
                        <h3 data-spec-title style="color: #ffffff;">
                            {{ $specGroups->isNotEmpty() ? $specGroups->keys()->first() : 'Thông số kỹ thuật' }}
                        </h3>
                        <div data-spec-content>
                            @if($specGroups->isNotEmpty())
                                @foreach($specGroups->first() as $sp)
                                    <div class="vinfast-autohaiphong_product_spec-row">
                                        <span>{{ $sp->label }}</span>
                                        <span>{{ trim($sp->value . ' ' . ($sp->unit ?? '')) }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="vinfast-autohaiphong_product_spec-row">
                                    <span>Tên dòng xe</span>
                                    <span>{{ $car->name }}</span>
                                </div>
                                <div class="vinfast-autohaiphong_product_spec-row">
                                    <span>Mã định danh (SKU)</span>
                                    <span>{{ $car->sku ?? 'VF-MODEL' }}</span>
                                </div>
                                <div class="vinfast-autohaiphong_product_spec-row">
                                    <span>Phân khúc</span>
                                    <span>{{ $car->category_name ?? 'Ô tô điện thông minh' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="vinfast-autohaiphong_product_technical-note">
                    <p>
                        (*) Thông số và chính sách bán hàng có thể thay đổi theo thông báo chính thức của VinFast Việt Nam tại từng thời điểm. Quý khách vui lòng liên hệ trực tiếp Showroom VinFast Minh Đạo Hải Phòng để nhận thông tin cập nhật mới nhất.
                    </p>
                    <div>
                        <a href="#vf3-so-sanh" class="vinfast-autohaiphong_product_btn vinfast-autohaiphong_product_btn-light">
                            So sánh chi phí xe
                        </a>
                        <button type="button" class="vinfast-autohaiphong_product_btn vinfast-autohaiphong_product_btn-primary" onclick="openQuoteModal({{ $car->id }}, '{{ $car->name }}')">
                            Yêu cầu tư vấn kỹ thuật
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 10: BOTTOM HERO CTA --}}
        <section class="vinfast-autohaiphong_product_bottom-hero" aria-label="Khám phá VinFast {{ $car->name }}">
            <img src="{{ asset('storage/clients/assets/images/theme-v1/footer-car.webp') }}" alt="{{ $car->name }} trên cung đường" loading="lazy" />
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
