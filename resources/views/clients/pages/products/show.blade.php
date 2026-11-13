@extends('clients.layouts.app')

@section('title', $car->name . ' - Bảng Giá Lăn Bánh & Thông Số Kỹ Thuật | VinFast Hải Phòng')
@section('meta_description', 'Xem thông số kỹ thuật xe ' . $car->name . ': Bảng giá niêm yết, thông số chi tiết key-value, pin, quãng đường và hỗ trợ mua xe thanh toán tiền mặt tại VinFast Minh Đạo Hải Phòng.')
@section('canonical', url('/xe/' . $car->slug))

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

<div class="vinfast-autohaiphong_product_section" style="padding: 36px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        {{-- Khối thông tin xe chính (Gallery & Giá) --}}
        <div style="display: grid; grid-template-columns: 1.15fr 1fr; gap: 40px; margin-bottom: 40px; align-items: start;">
            {{-- Cột Trái: Gallery Ảnh --}}
            <div>
                {{-- Ảnh lớn --}}
                <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden; position: relative; padding-top: 60%; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                    <img id="vf-main-car-img" 
                         src="{{ $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
                         alt="{{ $car->thumbnail_alt ?? $car->name }}" 
                         style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                </div>

                {{-- Thumbnails phụ --}}
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                    <div onclick="document.getElementById('vf-main-car-img').src=this.querySelector('img').src" 
                         style="cursor: pointer; border: 2px solid var(--client-color-primary); border-radius: 6px; overflow: hidden; padding-top: 60%; position: relative;">
                        <img src="{{ $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
                             alt="{{ $car->name }}" 
                             style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>

            {{-- Cột Phải: Thông tin giá & Mua hàng --}}
            <div>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-color-primary); text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $car->category_name ?? 'Ô tô điện' }}
                </span>
                <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin: 6px 0 12px 0; line-height: 1.2;">
                    {{ $car->name }}
                </h1>

                {{-- Hộp giá niêm yết --}}
                <div style="background: #ffffff; padding: 18px 20px; border-radius: 6px; border: 1px solid var(--client-color-border); margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                    <div style="font-size: 0.85rem; color: var(--client-color-muted); margin-bottom: 4px;">Giá niêm yết chính hãng:</div>
                    @if($car->price_on_request || (!$car->sale_price && !$car->regular_price))
                        <div style="font-size: 1.65rem; font-weight: 800; color: var(--client-color-primary);">Liên hệ nhận giá ưu đãi</div>
                    @else
                        <div style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-primary);">
                            {{ number_format($car->sale_price ?: $car->regular_price, 0, ',', '.') }} VNĐ
                        </div>
                    @endif
                    <div style="font-size: 0.825rem; color: var(--client-color-muted); margin-top: 6px;">
                        * Giá đã bao gồm VAT. Ưu đãi miễn 100% lệ phí trước bạ theo chính sách Nhà nước.
                    </div>
                </div>

                {{-- Mô tả ngắn --}}
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--client-color-text); margin-bottom: 24px;">
                    {{ $car->short_description ?? 'Mẫu xe ô tô điện thông minh hàng đầu của VinFast với động cơ mạnh mẽ, trang bị công nghệ an toàn hiện đại và nội thất tiện nghi vượt trội.' }}
                </p>

                {{-- Danh sách phiên bản (nếu có) --}}
                @if($variants->isNotEmpty())
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px; color: var(--client-color-heading);">
                            Chọn Phiên Bản:
                        </label>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            @foreach($variants as $idx => $variant)
                                <button type="button" 
                                        class="vinfast-autohaiphong_btn {{ $idx === 0 ? 'vinfast-autohaiphong_btn_primary' : 'vinfast-autohaiphong_btn_neutral' }}" 
                                        style="font-size: 0.85rem; padding: 8px 14px;">
                                    {{ $variant->name }} - {{ number_format($variant->sale_price ?: $variant->regular_price, 0, ',', '.') }} đ
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Cam kết showroom 3S Hải Phòng --}}
                <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 6px; padding: 14px 18px; margin-bottom: 24px; font-size: 0.85rem; line-height: 1.6;">
                    <div style="font-weight: 700; color: var(--client-color-heading); margin-bottom: 6px;">ĐẶC QUYỀN KHI MUA XE TẠI ĐẠI LÝ HẢI PHÒNG:</div>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li>✓ Bảo hành chính hãng lên đến 7 – 10 năm hoặc 200.000 km.</li>
                        <li>✓ Hỗ trợ vay trả góp ngân hàng tới 80% giá trị xe, thủ tục duyệt nhanh.</li>
                        <li>✓ Sẵn xe, đủ màu, hỗ trợ giao xe tận nhà theo yêu cầu.</li>
                        <li>✓ <strong>Phương thức thanh toán:</strong> Duy nhất tiền mặt trực tiếp tại Showroom VinFast Minh Đạo Hải Phòng.</li>
                    </ul>
                </div>

                {{-- Nút hành động --}}
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('client.checkout.direct', ['product_id' => $car->id]) }}" 
                       class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" 
                       style="flex: 1.2; padding: 13px 20px; font-size: 0.95rem; text-decoration: none;">
                        Đặt Cọc Xe (Tiền Mặt)
                    </a>
                    <button type="button" 
                            onclick="openQuoteModal({{ $car->id }}, '{{ addslashes($car->name) }}')" 
                            class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_secondary" 
                            style="flex: 1; padding: 13px 18px; font-size: 0.95rem;">
                        Nhận Báo Giá
                    </button>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0988302882') }}" 
                       class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" 
                       style="padding: 13px 18px; font-size: 0.95rem; text-decoration: none;">
                        📞 {{ $siteSettings['site_phone'] ?? '0988 302 882' }}
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
                                <img src="{{ $rel->thumbnail_path ? asset('storage/' . $rel->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
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
@endsection
