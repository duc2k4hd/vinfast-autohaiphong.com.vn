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
{{-- Breadcrumb --}}
<div class="vinfast-autohaiphong_product_breadcrumb_wrapper" style="background-color: var(--client-color-surface); border-bottom: 1px solid var(--client-color-border); padding: 12px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <nav style="font-size: 0.85rem; color: var(--client-color-muted);">
            <a href="{{ route('client.home') }}" style="color: var(--client-color-text);">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            <a href="{{ url('/o-to-vinfast') }}" style="color: var(--client-color-text);">Ô Tô VinFast</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: var(--client-color-primary); font-weight: 600;">{{ $car->name }}</span>
        </nav>
    </div>
</div>

<div class="vinfast-autohaiphong_product_section">
    <div class="vinfast-autohaiphong_layout_container">
        {{-- Khối thông tin xe chính (Gallery & Giá) --}}
        <div class="vinfast-autohaiphong_product_hero">
            <div class="vinfast-autohaiphong_product_gallery">
                {{-- Gallery ảnh 16:9 với thumbnail điều hướng --}}
                @php
                    $gallerySlides = $galleryImages->map(fn ($image) => [
                        'src' => asset('storage/' . $image->path),
                        'alt' => $image->alt_text ?: $car->name,
                    ])->values();
                @endphp
                <div class="vinfast-autohaiphong_product_gallery_viewer" data-vf-product-gallery data-slide-count="{{ $gallerySlides->count() }}">
                    <div class="vinfast-autohaiphong_product_main_image" aria-live="polite">
                        @if($gallerySlides->isNotEmpty())
                            @foreach($gallerySlides as $index => $slide)
                                <img src="{{ $slide['src'] }}"
                                     alt="{{ $slide['alt'] }}"
                                     class="vinfast-autohaiphong_product_main_image_asset {{ $index === 0 ? 'is-active' : '' }}"
                                     data-vf-gallery-slide="{{ $index }}"
                                     @if($index > 0) loading="lazy" @endif>
                            @endforeach
                        @else
                            <img src="{{ asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}"
                                 alt="{{ $car->name }}"
                                 class="vinfast-autohaiphong_product_main_image_asset is-active">
                        @endif
                        @if($gallerySlides->count() > 1)
                            <button type="button" class="vinfast-autohaiphong_product_gallery_arrow is-previous" data-vf-gallery-previous aria-label="Ảnh trước">‹</button>
                            <button type="button" class="vinfast-autohaiphong_product_gallery_arrow is-next" data-vf-gallery-next aria-label="Ảnh tiếp theo">›</button>
                            <span class="vinfast-autohaiphong_product_gallery_counter" data-vf-gallery-counter aria-live="polite">1 / {{ $gallerySlides->count() }}</span>
                        @endif
                    </div>
                    @if($gallerySlides->count() > 1)
                        <div class="vinfast-autohaiphong_product_thumbnails" role="tablist" aria-label="Ảnh sản phẩm">
                            @foreach($gallerySlides as $index => $slide)
                                <button type="button"
                                        class="vinfast-autohaiphong_product_thumbnail {{ $index === 0 ? 'is-active' : '' }}"
                                        data-vf-gallery-thumbnail="{{ $index }}"
                                        role="tab"
                                        aria-label="Xem ảnh {{ $index + 1 }}: {{ $slide['alt'] }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    <img src="{{ $slide['src'] }}" alt="" loading="lazy" class="vinfast-autohaiphong_product_thumbnail_asset">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Cột Phải: Thông tin giá & Mua hàng --}}
            <div class="vinfast-autohaiphong_product_information">
                <span class="vinfast-autohaiphong_product_category">
                    {{ $car->category_name ?? 'Ô tô điện' }}
                </span>
                <h1 class="vinfast-autohaiphong_product_title">
                    {{ $car->name }}
                </h1>

                {{-- Hộp giá niêm yết --}}
                <div class="vinfast-autohaiphong_product_price_panel">
                    <div class="vinfast-autohaiphong_product_price_heading">
                        <span class="vinfast-autohaiphong_product_price_caption">Giá niêm yết chính hãng:</span>
                        <span id="vf-selected-variant-label" class="vinfast-autohaiphong_product_variant_label"></span>
                    </div>
                    @if($car->price_on_request || (!$car->sale_price && !$car->regular_price))
                        <div id="vf-car-price-display" class="vinfast-autohaiphong_product_price">Liên hệ nhận giá ưu đãi</div>
                    @else
                        <div id="vf-car-price-display" class="vinfast-autohaiphong_product_price">
                            {{ number_format($car->sale_price ?: $car->regular_price, 0, ',', '.') }} VNĐ
                        </div>
                    @endif
                    <div class="vinfast-autohaiphong_product_price_note">
                        * Giá đã bao gồm VAT. Ưu đãi miễn 100% lệ phí trước bạ theo chính sách Nhà nước.
                    </div>
                </div>

                {{-- Mô tả ngắn --}}
                <p class="vinfast-autohaiphong_product_short_description">
                    {{ $car->short_description ?? 'Mẫu xe ô tô điện thông minh hàng đầu của VinFast với động cơ mạnh mẽ, trang bị công nghệ an toàn hiện đại và nội thất tiện nghi vượt trội.' }}
                </p>

                {{-- Danh sách phiên bản tương tác động --}}
                @if($variants->isNotEmpty())
                    <div class="vinfast-autohaiphong_product_variants">
                        <label class="vinfast-autohaiphong_product_variants_label">
                            Chọn Phiên Bản & Mức Giá:
                        </label>
                        <div id="vf-variant-buttons-container" class="vinfast-autohaiphong_product_variant_buttons">
                            @foreach($variants as $idx => $variant)
                                @php
                                    $vPrice = $variant->sale_price ?: $variant->regular_price;
                                @endphp
                                <button type="button"
                                        class="vinfast-autohaiphong_btn vf-variant-btn vinfast-autohaiphong_product_variant_button {{ $idx === 0 ? 'vinfast-autohaiphong_btn_primary' : 'vinfast-autohaiphong_btn_outline' }}"
                                        data-price="{{ $vPrice }}"
                                        data-name="{{ $variant->name }}"
                                        data-sku="{{ $variant->sku }}"
                                        onclick="selectCarVariant(this)">
                                    {{ $variant->name }} - {{ number_format($vPrice, 0, ',', '.') }} đ
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Cam kết showroom 3S Hải Phòng --}}
                <div class="vinfast-autohaiphong_product_benefits">
                    <div class="vinfast-autohaiphong_product_benefits_heading">ĐẶC QUYỀN KHI MUA XE TẠI ĐẠI LÝ HẢI PHÒNG:</div>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li>✓ Bảo hành chính hãng lên đến 7 – 10 năm hoặc 200.000 km.</li>
                        <li>✓ Hỗ trợ vay trả góp ngân hàng tới 80% giá trị xe, thủ tục duyệt nhanh.</li>
                        <li>✓ Sẵn xe, đủ màu, hỗ trợ giao xe tận nhà theo yêu cầu.</li>
                        <li>✓ <strong>Phương thức thanh toán:</strong> Duy nhất tiền mặt trực tiếp tại Showroom VinFast Minh Đạo Hải Phòng.</li>
                    </ul>
                </div>

                {{-- Nút hành động --}}
                <div class="vinfast-autohaiphong_product_actions">
                    <a href="{{ route('client.checkout.direct', ['product_id' => $car->id]) }}" 
                       class="vinfast-autohaiphong_product_action vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
                        Đặt Cọc Xe (Tiền Mặt)
                    </a>
                    <button type="button" 
                            onclick="openQuoteModal({{ $car->id }}, '{{ addslashes($car->name) }}')" 
                            class="vinfast-autohaiphong_product_action vinfast-autohaiphong_btn vinfast-autohaiphong_btn_secondary">
                        Nhận Báo Giá
                    </button>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0988302882') }}" 
                       class="vinfast-autohaiphong_product_action vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline">
                        {{ $siteSettings['site_phone'] ?? '0988 302 882' }}
                    </a>
                </div>
            </div>
        </div>

        {{-- 
            YÊU CẦU QUAN TRỌNG: 
            Ở PHẦN CONTENT SẢN PHẨM THÌ THÔNG SỐ SẼ Ở ĐẦU TIÊN VÀ MỚI ĐẾN MÔ TẢ CHI TIẾT.
            THÔNG SỐ LÀ CÁC KEY VÀ VALUE ĐỂ TRÍCH XUẤT CỰC NHANH CỰC MƯỢT.
        --}}

        {{-- 1. THÔNG SỐ KỸ THUẬT (Ở VỊ TRÍ ĐẦU TIÊN) --}}
        <div class="vinfast-autohaiphong_product_specs_box">
            <h2 class="vinfast-autohaiphong_product_specs_heading">
                BẢNG THÔNG SỐ KỸ THUẬT XE {{ mb_strtoupper($car->name, 'UTF-8') }}
            </h2>

            @if($specifications->isNotEmpty())
                <div class="vinfast-autohaiphong_product_specs_grid">
                    @foreach($specifications as $spec)
                        <div class="vinfast-autohaiphong_product_specs_row">
                            <span class="vinfast-autohaiphong_product_specs_key">{{ $spec->label }}</span>
                            <span class="vinfast-autohaiphong_product_specs_value">
                                {{ $spec->value }}{{ $spec->unit ? ' ' . $spec->unit : '' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="vinfast-autohaiphong_product_specs_grid">
                    <div class="vinfast-autohaiphong_product_specs_row">
                        <span class="vinfast-autohaiphong_product_specs_key">Dòng xe</span>
                        <span class="vinfast-autohaiphong_product_specs_value">Ô tô điện thông minh</span>
                    </div>
                    <div class="vinfast-autohaiphong_product_specs_row">
                        <span class="vinfast-autohaiphong_product_specs_key">Động cơ</span>
                        <span class="vinfast-autohaiphong_product_specs_value">100% Thuần Điện</span>
                    </div>
                    <div class="vinfast-autohaiphong_product_specs_row">
                        <span class="vinfast-autohaiphong_product_specs_key">Bảo hành chính hãng</span>
                        <span class="vinfast-autohaiphong_product_specs_value">7 – 10 năm</span>
                    </div>
                    <div class="vinfast-autohaiphong_product_specs_row">
                        <span class="vinfast-autohaiphong_product_specs_key">Hình thức thanh toán</span>
                        <span class="vinfast-autohaiphong_product_specs_value">Tiền mặt tại showroom</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- 2. MÔ TẢ CHI TIẾT SẢN PHẨM (NẰM PHÍA DƯỚI THÔNG SỐ KỸ THUẬT) --}}
        <div class="vinfast-autohaiphong_product_detail_box">
            <h2 style="font-size: 1.3rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 16px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px; display: inline-block;">
                GIỚI THIỆU CHI TIẾT {{ mb_strtoupper($car->name, 'UTF-8') }}
            </h2>

            <div class="vinfast-autohaiphong_product_detail_content">
                @if(!empty($car->description_html))
                    {!! $car->description_html !!}
                @else
                    <p>
                        <strong>{{ $car->name }}</strong> là mẫu xe điện được nghiên cứu và phát triển bởi VinFast – thương hiệu ô tô quốc gia Việt Nam. Xe sở hữu phong cách thiết kế hiện đại, ngôn ngữ tạo hình năng động, tối ưu hóa khí động học giúp xe vận hành thanh thoát và tiết kiệm năng lượng tối đa.
                    </p>
                    <h3 style="font-size: 1.15rem; color: var(--client-color-heading); margin-top: 20px;">1. Thiết Kế Sang Trọng & Không Gian Rộng Rãi</h3>
                    <p>
                        Khoang cabin của xe được bố trí khoa học, vật liệu hoàn thiện cao cấp mang lại cảm giác dễ chịu cho mọi hành khách trên các hành trình dài. Màn hình điều khiển trung tâm tích hợp toàn bộ các tính năng giải trí, định vị dẫn đường và điều khiển các tiện ích trên xe chỉ bằng những thao tác chạm nhẹ hoặc ra lệnh giọng nói tiếng Việt mượt mà.
                    </p>
                    <h3 style="font-size: 1.15rem; color: var(--client-color-heading); margin-top: 20px;">2. Công Nghệ An Toàn & Hệ Thống Trợ Lái ADAS</h3>
                    <p>
                        Xe được trang bị các tính năng an toàn tiêu chuẩn quốc tế như hệ thống chống bó cứng phanh (ABS), phân phối lực phanh điện tử (EBD), cân bằng điện tử (ESC), hỗ trợ khởi hành ngang dốc (HSA), cùng gói trợ lái nâng cao ADAS với cảnh báo lệch làn, phanh khẩn cấp tự động và camera sắc nét.
                    </p>
                    <h3 style="font-size: 1.15rem; color: var(--client-color-heading); margin-top: 20px;">3. Hạ Tầng Trạm Sạc & Ưu Đãi Tại VinFast Hải Phòng</h3>
                    <p>
                        Quý khách hàng mua xe tại Showroom VinFast Minh Đạo Hải Phòng (Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng) hoàn toàn yên tâm về mạng lưới trạm sạc phủ kín các tuyến phố, trung tâm thương mại và quốc lộ trên toàn địa bàn Hải Phòng cũng như toàn quốc. Đặc biệt, đại lý hỗ trợ chính sách thanh toán tiền mặt trực tiếp, giao xe nhanh và hướng dẫn sử dụng tận tình.
                    </p>
                @endif
            </div>
        </div>

        {{-- 3. CÁC DÒNG XE LIÊN QUAN --}}
        @if($relatedCars->isNotEmpty())
            <div>
                <h2 style="font-size: 1.3rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 24px; text-align: center;">
                    CÁC DÒNG XE VINFAST KHÁC BẠN CÓ THỂ QUAN TÂM
                </h2>
                <div class="vinfast-autohaiphong_home_grid">
                    @foreach($relatedCars as $rel)
                        <div class="vinfast-autohaiphong_home_car_card">
                            <div class="vinfast-autohaiphong_home_car_thumb">
                                <img src="{{ $rel->thumbnail_path ? asset('storage/' . $rel->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                                     alt="{{ $rel->name }}" 
                                     loading="lazy" 
                                     width="600" 
                                     height="338">
                            </div>
                            <div class="vinfast-autohaiphong_home_car_body">
                                <h3 class="vinfast-autohaiphong_home_car_name" style="font-size: 1.15rem;">
                                    <a href="{{ url('/xe/' . $rel->slug) }}">{{ $rel->name }}</a>
                                </h3>
                                <div class="vinfast-autohaiphong_home_car_price_box">
                                    <span class="vinfast-autohaiphong_home_car_price_label">Giá từ:</span>
                                    <span class="vinfast-autohaiphong_home_car_price" style="font-size: 1.15rem;">
                                        {{ number_format($rel->sale_price ?: $rel->regular_price, 0, ',', '.') }} VNĐ
                                    </span>
                                </div>
                                <div class="vinfast-autohaiphong_home_car_actions">
                                    <a href="{{ url('/xe/' . $rel->slug) }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="width: 100%; text-decoration: none;">
                                        Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function selectCarVariant(btn) {
    if (!btn) return;
    const price = btn.getAttribute('data-price');
    const name = btn.getAttribute('data-name');
    const display = document.getElementById('vf-car-price-display');
    const variantLabel = document.getElementById('vf-selected-variant-label');

    if (price && display) {
        const formatted = new Intl.NumberFormat('vi-VN').format(price);
        display.textContent = formatted + ' VNĐ';
    }

    if (variantLabel && name) {
        variantLabel.textContent = name;
        variantLabel.style.display = 'inline-block';
    }

    document.querySelectorAll('.vf-variant-btn').forEach(function(el) {
        el.classList.remove('vinfast-autohaiphong_btn_primary');
        el.classList.add('vinfast-autohaiphong_btn_outline');
    });

    btn.classList.remove('vinfast-autohaiphong_btn_outline');
    btn.classList.add('vinfast-autohaiphong_btn_primary');
}
</script>
@endsection
