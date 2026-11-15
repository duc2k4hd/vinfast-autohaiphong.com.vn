@extends('clients.layouts.app')

@section('title', 'Chính Sách Bảo Hành Ô Tô Điện VinFast Chính Hãng | VinFast Hải Phòng')
@section('meta_description', 'Chính sách bảo hành xe ô tô điện VinFast chính hãng từ 7 đến 10 năm hoặc 200.000 km. Bảo hành pin cao áp không giới hạn km, cứu hộ 24/7 miễn phí tại Hải Phòng.')
@section('canonical', url('/chinh-sach-bao-hanh'))

@push('schema')
{{-- FAQPage Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
        [
            '@type' => 'Question',
            'name' => 'Thời gian bảo hành xe ô tô điện VinFast là bao lâu?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'VinFast bảo hành chính hãng 10 năm hoặc 200.000 km đối với các dòng xe VF 7, VF 8, VF 9; và 7 năm hoặc 160.000 km đối với VF 3, VF 5 Plus, VF 6. Pin cao áp được bảo hành 7-10 năm không giới hạn km.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Khi nào xe điện VinFast được thay thế pin mới miễn phí?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Khách hàng mua đứt pin hoặc thuê pin sẽ được sửa chữa hoặc thay thế pin mới miễn phí khi dung lượng pin khả dụng (SoH) tụt xuống dưới mức 70% trong thời hạn bảo hành.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Địa chỉ xưởng dịch vụ 3S VinFast tại Hải Phòng ở đâu?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Xưởng dịch vụ 3S VinFast Hải Phòng tọa lạc tại Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng. Hotline kỹ thuật - dịch vụ: 0915 286 506.'
            ]
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Trang chủ',
            'item' => route('client.home'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Chính Sách',
            'item' => url('/chinh-sach'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => 'Chính Sách Bảo Hành',
            'item' => url('/chinh-sach-bao-hanh'),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@section('content')
{{-- 1. HERO BANNER BẢO HÀNH --}}
<section class="vf-policy-hero" style="position: relative; background: #0b1329; color: #ffffff; padding: 50px 0 60px 0; overflow: hidden;">
    <div style="position: absolute; inset: 0; opacity: 0.25; background-image: url('{{ asset('storage/clients/assets/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp') }}'); background-size: cover; background-position: center;"></div>
    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(11,19,41,0.88) 0%, rgba(15,23,42,0.96) 100%);"></div>

    <div class="vinfast-autohaiphong_layout_container" style="position: relative; z-index: 2;">
        <nav style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 14px;">
            <a href="{{ route('client.home') }}" style="color: #94a3b8; text-decoration: none;">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            <a href="{{ route('client.pages.policies') }}" style="color: #94a3b8; text-decoration: none;">Chính sách</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: #60a5fa; font-weight: 600;">Bảo hành & Bảo dưỡng</span>
        </nav>

        <div style="max-width: 820px;">
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: rgba(37,99,235,0.25); border: 1px solid rgba(96,165,250,0.3); border-radius: 9999px; font-size: 0.8rem; font-weight: 700; color: #93c5fd; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px;">
                CAM KẾT HẬU MÃI SỐ 1 THỊ TRƯỜNG
            </span>
            <h1 style="font-size: clamp(1.85rem, 3.2vw, 2.5rem); font-weight: 900; line-height: 1.25; margin-bottom: 14px; color: #ffffff;">
                CHÍNH SÁCH BẢO HÀNH CHÍNH HÃNG
            </h1>
            <p style="font-size: 1rem; line-height: 1.7; color: #cbd5e1; margin-bottom: 24px;">
                Áp dụng cho mọi khách hàng sở hữu xe ô tô điện VinFast tại Hải Phòng. Thời hạn bảo hành vượt trội lên tới 10 năm hoặc 200.000 km, cam kết pin không giới hạn số km và cứu hộ 24/7 hoàn toàn miễn phí.
            </p>

            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="#tra-cuu-xe" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 10px 22px; font-size: 0.9rem; text-decoration: none;">
                    Tra Cứu Bảo Hành Theo Dòng Xe &darr;
                </a>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['site_phone_service'] ?? '0915286506') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="border-color: rgba(255,255,255,0.4); padding: 10px 20px; font-size: 0.9rem; text-decoration: none;">
                    Hotline Dịch Vụ: {{ $settings['site_phone_service'] ?? '0915 286 506' }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- 2. TABS NAVIGATION --}}
@include('clients.components.policy-tabs', ['activeTab' => 'bao-hanh'])

{{-- 3. 4 ĐIỂM TỰA VÀNG BẢO HÀNH --}}
<section style="padding: 50px 0; background: #ffffff;">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 10px; padding: 24px;">
                <div style="font-size: 2rem; margin-bottom: 12px;">🏆</div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #1e3a8a; margin-bottom: 6px;">7 – 10 Năm</div>
                <div style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem; margin-bottom: 8px;">Thời Hạn Dài Nhất Thị Trường</div>
                <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin: 0;">
                    Gấp 2 đến 3 lần thời hạn bảo hành thông thường của các dòng xe động cơ xăng truyền thống.
                </p>
            </div>

            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 10px; padding: 24px;">
                <div style="font-size: 2rem; margin-bottom: 12px;">🔋</div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #059669; margin-bottom: 6px;">Không Giới Hạn KM</div>
                <div style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem; margin-bottom: 8px;">Bảo Hành Pin Cao Áp</div>
                <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin: 0;">
                    Chính sách bảo hành pin 7-10 năm không hạn chế số km vận hành. Đổi mới miễn phí khi SoH < 70%.
                </p>
            </div>

            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 10px; padding: 24px;">
                <div style="font-size: 2rem; margin-bottom: 12px;">🚨</div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #2563eb; margin-bottom: 6px;">24/7 Miễn Phí</div>
                <div style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem; margin-bottom: 8px;">Cứu Hộ Khẩn Cấp Toàn Quốc</div>
                <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin: 0;">
                    Hỗ trợ kéo xe về xưởng dịch vụ chính hãng 3S và cứu hộ sạc pin cơ động trên toàn địa bàn Hải Phòng.
                </p>
            </div>

            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 10px; padding: 24px;">
                <div style="font-size: 2rem; margin-bottom: 12px;">🚐</div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #d97706; margin-bottom: 6px;">Mobile Service</div>
                <div style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem; margin-bottom: 8px;">Bảo Dưỡng Lưu Động Tận Nơi</div>
                <p style="font-size: 0.85rem; color: #475569; line-height: 1.6; margin: 0;">
                    Đội ngũ kỹ thuật viên 3S đến tận nhà hoặc cơ quan tại Hải Phòng để kiểm tra và bảo dưỡng xe.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 4. CÔNG CỤ TRA CỨU BẢO HÀNH THEO TỪNG MẪU XE (INTERACTIVE) --}}
<section id="tra-cuu-xe" style="padding: 60px 0; background: #f8fafc; border-top: 1px solid var(--client-color-border); border-bottom: 1px solid var(--client-color-border);">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="text-align: center; max-width: 680px; margin: 0 auto 32px auto;">
            <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-color-primary); text-transform: uppercase; letter-spacing: 1px;">
                CÔNG CỤ TRA CỨU
            </span>
            <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-top: 4px; margin-bottom: 10px;">
                Tra Cứu Chi Tiết Hạn Bảo Hành Cho Từng Mẫu Xe
            </h2>
            <p style="font-size: 0.95rem; color: var(--client-color-muted); line-height: 1.6;">
                Bấm chọn dòng xe bạn đang quan tâm để xem thời hạn bảo hành xe, pin cao áp và ước tính chi phí bảo dưỡng.
            </p>
        </div>

        {{-- Thanh chọn xe --}}
        <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 12px; margin-bottom: 24px; scrollbar-width: none;" role="tablist">
            @foreach($vehicles as $idx => $v)
                <button type="button" 
                        class="vf-warranty-tab-btn {{ $idx === 0 ? 'active' : '' }}" 
                        onclick="switchWarrantyVehicle('{{ $v['id'] }}', this)"
                        style="display: flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; border: 1px solid {{ $idx === 0 ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ $idx === 0 ? '#eff6ff' : '#ffffff' }}; color: {{ $idx === 0 ? 'var(--client-color-primary)' : '#334155' }}; font-weight: 700; font-size: 0.92rem; cursor: pointer; white-space: nowrap; transition: all 0.2s ease;">
                    <img src="{{ $v['image'] }}" alt="{{ $v['name'] }}" style="width: 32px; height: 20px; object-fit: contain;">
                    <span>{{ $v['name'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- Khối thông tin chi tiết xe được chọn --}}
        @foreach($vehicles as $idx => $v)
            <div id="warranty-card-{{ $v['id'] }}" 
                 class="vf-warranty-card-panel" 
                 style="display: {{ $idx === 0 ? 'grid' : 'none' }}; grid-template-columns: 1fr 1.35fr; gap: 36px; background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 36px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03); align-items: center;">
                
                {{-- Cột ảnh xe --}}
                <div style="text-align: center;">
                    <div style="background: #f1f5f9; border-radius: 12px; padding: 24px; display: flex; align-items: center; justify-content: center; min-height: 240px; margin-bottom: 14px;">
                        <img src="{{ $v['image'] }}" alt="{{ $v['name'] }}" style="max-width: 100%; max-height: 200px; object-fit: contain; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.08));">
                    </div>
                    <div style="font-size: 0.85rem; color: var(--client-color-muted);">
                        Phân khúc: <strong style="color: var(--client-color-heading);">{{ $v['segment'] }}</strong> • Quãng đường: <strong style="color: var(--client-color-primary);">{{ $v['range'] }}</strong>
                    </div>
                </div>

                {{-- Cột thông số & cam kết --}}
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
                        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--client-color-heading); margin: 0;">
                            {{ $v['name'] }}
                        </h3>
                        <span style="background: #ecfdf5; color: #059669; padding: 4px 12px; border-radius: 9999px; font-size: 0.8rem; font-weight: 700;">
                            Chính Hãng VinFast
                        </span>
                    </div>

                    {{-- Bảng thông số bảo hành --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                        <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 12px 14px;">
                            <div style="font-size: 0.78rem; color: var(--client-color-muted); text-transform: uppercase;">Bảo hành thân xe & thiết bị</div>
                            <div style="font-size: 1.05rem; font-weight: 800; color: #1e3a8a; margin-top: 4px;">{{ $v['warranty_car'] }}</div>
                        </div>

                        <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 12px 14px;">
                            <div style="font-size: 0.78rem; color: var(--client-color-muted); text-transform: uppercase;">Bảo hành pin cao áp</div>
                            <div style="font-size: 1.05rem; font-weight: 800; color: #059669; margin-top: 4px;">{{ $v['warranty_battery'] }}</div>
                        </div>

                        <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 12px 14px;">
                            <div style="font-size: 0.78rem; color: var(--client-color-muted); text-transform: uppercase;">Chu kỳ bảo dưỡng định kỳ</div>
                            <div style="font-size: 0.95rem; font-weight: 700; color: #334155; margin-top: 4px;">{{ $v['service_interval'] }}</div>
                        </div>

                        <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 12px 14px;">
                            <div style="font-size: 0.78rem; color: var(--client-color-muted); text-transform: uppercase;">Chi phí bảo dưỡng ước tính</div>
                            <div style="font-size: 0.95rem; font-weight: 700; color: var(--client-color-primary); margin-top: 4px;">{{ $v['est_maintenance'] }}</div>
                        </div>
                    </div>

                    {{-- Điểm nhấn quyền lợi --}}
                    <div style="margin-bottom: 24px;">
                        <div style="font-weight: 700; font-size: 0.88rem; color: var(--client-color-heading); margin-bottom: 8px;">Đặc quyền bảo hành & hỗ trợ:</div>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.85rem; color: #475569; line-height: 1.7;">
                            @foreach($v['highlights'] as $hl)
                                <li style="display: flex; align-items: flex-start; gap: 8px; margin-bottom: 4px;">
                                    <span style="color: #2563eb; font-weight: bold;">✓</span>
                                    <span>{{ $hl }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Nút hành động --}}
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="{{ url('/xe/' . ($v['id'] === 'vf3' ? 'vinfast-vf-3' : ($v['id'] === 'vf5' ? 'vinfast-vf-5' : ($v['id'] === 'vf6' ? 'vinfast-vf-6' : ($v['id'] === 'vf7' ? 'vinfast-vf-7' : ($v['id'] === 'vf8' ? 'vinfast-vf-8' : 'vinfast-vf-9')))))) }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 10px 20px; font-size: 0.9rem; text-decoration: none;">
                            Xem Bảng Giá & Thông Số {{ $v['name'] }} &rarr;
                        </a>
                        <button type="button" onclick="openQuoteModal(null, 'Tư vấn bảo hành xe ' + '{{ $v['name'] }}')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="padding: 10px 18px; font-size: 0.9rem;">
                            Đăng Ký Tư Vấn & Lái Thử
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- 5. CHI TIẾT BẢO HÀNH TỪNG HỆ THỐNG LINH KIỆN --}}
<section style="padding: 60px 0; background: #ffffff;">
    <div class="vinfast-autohaiphong_layout_container" style="max-width: 960px;">
        <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 24px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 10px;">
            1. Phạm Vi & Chi Tiết Các Hạng Mục Bảo Hành
        </h2>

        <div style="line-height: 1.8; color: #334155; font-size: 0.95rem; margin-bottom: 36px;">
            <p>
                Chính sách bảo hành có hiệu lực tính từ ngày bàn giao xe chính thức được ghi nhận trên Hệ thống Quản lý Bán hàng của VinFast hoặc ngày xuất Hóa đơn Giá trị Gia tăng (tùy điều kiện nào đến trước).
            </p>

            <div style="background: #eff6ff; border-left: 4px solid var(--client-color-primary); padding: 16px 20px; border-radius: 4px; margin: 20px 0; color: #1e40af;">
                <strong>Cam kết chuyển giao quyền bảo hành:</strong> Chính sách bảo hành áp dụng theo xe, không phụ thuộc vào việc đổi chủ sở hữu. Khi chuyển nhượng hoặc bán lại xe, chủ sở hữu kế tiếp tại Hải Phòng vẫn được thừa hưởng 100% thời gian bảo hành và quyền lợi còn lại.
            </div>

            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 28px; margin-bottom: 12px;">
                Phân Loại Thời Hạn Bảo Hành Chi Tiết:
            </h3>

            <div style="display: grid; grid-template-columns: 1fr; gap: 14px; margin-bottom: 24px;">
                <div style="border: 1px solid var(--client-color-border); border-radius: 8px; padding: 18px 20px; background: #ffffff;">
                    <div style="font-weight: 700; color: #1e3a8a; font-size: 1.05rem; margin-bottom: 6px;">
                        🔹 Xe ô tô điện phân khúc phổ thông (VF 3, VF 5 Plus, VF 6):
                    </div>
                    <div>Thời hạn bảo hành tiêu chuẩn là <strong>7 năm hoặc 160.000 km</strong> (tùy điều kiện nào đến trước). Pin cao áp bảo hành <strong>8 năm không giới hạn số km</strong>.</div>
                </div>

                <div style="border: 1px solid var(--client-color-border); border-radius: 8px; padding: 18px 20px; background: #ffffff;">
                    <div style="font-weight: 700; color: #1e3a8a; font-size: 1.05rem; margin-bottom: 6px;">
                        🔹 Xe ô tô điện phân khúc cao cấp (VF 7, VF 8, VF 9):
                    </div>
                    <div>Thời hạn bảo hành tiêu chuẩn là <strong>10 năm hoặc 200.000 km</strong> (tùy điều kiện nào đến trước). Pin cao áp bảo hành <strong>10 năm không giới hạn số km</strong>.</div>
                </div>

                <div style="border: 1px solid var(--client-color-border); border-radius: 8px; padding: 18px 20px; background: #ffffff;">
                    <div style="font-weight: 700; color: #1e3a8a; font-size: 1.05rem; margin-bottom: 6px;">
                        🔹 Phụ tùng chính hãng thay thế có tính phí:
                    </div>
                    <div>Bảo hành <strong>2 năm hoặc 40.000 km</strong> (tùy điều kiện nào đến trước) khi mua và lắp đặt tại Xưởng dịch vụ 3S VinFast Hải Phòng.</div>
                </div>

                <div style="border: 1px solid var(--client-color-border); border-radius: 8px; padding: 18px 20px; background: #ffffff;">
                    <div style="font-weight: 700; color: #1e3a8a; font-size: 1.05rem; margin-bottom: 6px;">
                        🔹 Bình ắc quy phụ 12V:
                    </div>
                    <div>Bảo hành <strong>1 năm không giới hạn số km</strong> lăn bánh.</div>
                </div>
            </div>
        </div>

        {{-- 2. DỊCH VỤ CỨU HỘ & XƯỞNG DỊCH VỤ --}}
        <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 24px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 10px;">
            2. Dịch Vụ Cứu Hộ 24/7 & Xưởng Dịch Vụ 3S Tại Hải Phòng
        </h2>

        <div style="line-height: 1.8; color: #334155; font-size: 0.95rem; margin-bottom: 36px;">
            <p>
                Khách hàng sở hữu ô tô điện VinFast gặp sự cố trên mọi tuyến đường tại khu vực Hải Phòng (bao gồm đường nội đô, cao tốc Hà Nội - Hải Phòng, Quốc lộ 5, Quốc lộ 10, đảo Cát Hải...) sẽ được hỗ trợ cứu hộ khẩn cấp 24/7.
            </p>

            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 28px; margin: 24px 0;">
                <div style="font-size: 1.15rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 14px;">
                    THÔNG TIN XƯỞNG DỊCH VỤ 3S VINFAST HẢI PHÒNG:
                </div>
                <div style="margin-bottom: 12px;">
                    📍 <strong>Địa chỉ:</strong> Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng.
                </div>
                <div style="margin-bottom: 12px;">
                    🔧 <strong>Năng lực kỹ thuật:</strong> Đầy đủ phòng sơn sấy chuẩn quốc tế, máy chẩn đoán lỗi chuyên dụng VinFast, kho phụ tùng chính hãng 100% xuất xứ từ Tổ hợp Nhà máy VinFast Hải Phòng (Cát Hải).
                </div>
                <div style="margin-bottom: 12px;">
                    📞 <strong>Hotline Dịch vụ – Phụ tùng:</strong> <a href="tel:0915286506" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0915 286 506</a>
                </div>
                <div>
                    🛠️ <strong>CSKH Dịch vụ:</strong> <a href="tel:0843714333" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0843 714 333</a> | <strong>Tổng đài VinFast cứu hộ:</strong> <a href="tel:1900232389" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">1900 23 23 89</a>
                </div>
            </div>
        </div>

        {{-- 3. CÁC TRƯỜNG HỢP KHÔNG THUỘC PHẠM VI BẢO HÀNH --}}
        <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 24px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 10px;">
            3. Các Trường Hợp Không Thuộc Phạm Vi Bảo Hành
        </h2>

        <div style="line-height: 1.8; color: #334155; font-size: 0.95rem; margin-bottom: 40px;">
            <ul style="padding-left: 20px; margin: 0;">
                <li style="margin-bottom: 8px;">Hao mòn tự nhiên theo thời gian của các chi tiết tiêu hao như: má phanh, gạt mưa, chụp bụi, các bóng đèn chiếu sáng ngoài thời gian bảo hành riêng.</li>
                <li style="margin-bottom: 8px;">Xe bị can thiệp, sửa chữa, thay đổi kết cấu phần mềm điều khiển ECU hoặc đấu nối thêm phụ kiện điện trái quy định ngoài hệ thống xưởng ủy quyền chính thức.</li>
                <li style="margin-bottom: 8px;">Hư hỏng do sử dụng sai mục đích, chở quá tải trọng thiết kế, hoặc cố tình cho xe ngập nước quá mức cho phép trong cẩm nang hướng dẫn sử dụng.</li>
                <li style="margin-bottom: 8px;">Hư hại do các yếu tố bất khả kháng bên ngoài: tai nạn giao thông, thiên tai hỏa hoạn, động đất, tác động của hóa chất độc hại hoặc đá văng trên đường.</li>
            </ul>
        </div>

        {{-- KHỐI CTA HỖ TRỢ --}}
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 36px; text-align: center;">
            <h3 style="font-size: 1.4rem; font-weight: 800; color: #1e3a8a; margin-bottom: 8px;">
                Cần Hỗ Trợ Kỹ Thuật Hoặc Đặt Lịch Bảo Dưỡng?
            </h3>
            <p style="color: #1e40af; font-size: 0.95rem; margin-bottom: 20px;">
                Đội ngũ kỹ thuật viên VinFast Hải Phòng sẵn sàng tiếp nhận xe và tư vấn quy trình bảo hành chu đáo nhất.
            </p>
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="tel:0915286506" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 12px 28px; text-decoration: none; font-size: 0.95rem;">
                    Gọi Hotline Dịch Vụ: 0915 286 506
                </a>
                <a href="{{ route('client.contact.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="padding: 12px 24px; text-decoration: none; font-size: 0.95rem;">
                    Chỉ Đường Đến Showroom Lê Hồng Phong
                </a>
            </div>
        </div>
    </div>
</section>

{{-- JS SWITCH XE TRONG BẢNG BẢO HÀNH --}}
<script>
function switchWarrantyVehicle(id, btn) {
    document.querySelectorAll('.vf-warranty-tab-btn').forEach(function(el) {
        el.style.borderColor = 'var(--client-color-border)';
        el.style.backgroundColor = '#ffffff';
        el.style.color = '#334155';
    });
    btn.style.borderColor = 'var(--client-color-primary)';
    btn.style.backgroundColor = '#eff6ff';
    btn.style.color = 'var(--client-color-primary)';

    document.querySelectorAll('.vf-warranty-card-panel').forEach(function(el) {
        el.style.display = 'none';
    });
    const target = document.getElementById('warranty-card-' + id);
    if (target) {
        target.style.display = 'grid';
    }
}
</script>
@endsection
