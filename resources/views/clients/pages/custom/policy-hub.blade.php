@extends('clients.layouts.app')

@section('title', 'Chính sách và quyền lợi khách hàng | VinFast Hải Phòng')
@section('meta_description', 'Tra cứu thông tin bảo hành, thanh toán, pin và trạm sạc, cùng các chính sách khách hàng tại VinFast Hải Phòng. Xem điều kiện cụ thể theo từng xe.')
@section('canonical', url('/chinh-sach'))

@push('schema')
{{-- FAQPage Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
        [
            '@type' => 'Question',
            'name' => 'Thời gian bảo hành xe ô tô điện VinFast là bao lâu?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'VinFast áp dụng thời hạn bảo hành chính hãng lên tới 10 năm hoặc 200.000 km đối với các dòng xe VF 7, VF 8, VF 9; và 7 năm hoặc 160.000 km đối với VF 3, VF 5 Plus, VF 6. Pin cao áp được bảo hành 7-10 năm không giới hạn km.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Hình thức thanh toán khi mua xe tại VinFast Hải Phòng như thế nào?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Website triển khai hình thức đặt cọc online miễn phí và thanh toán tiền mặt 100% trực tiếp tại phòng Kế toán - Thu ngân của Showroom VinFast Hải Phòng (Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Hải Phòng) để đảm bảo an toàn tuyệt đối.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Pin xe điện VinFast chai bao nhiêu thì được đổi mới?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Đối với cả pin thuê và xe mua pin, VinFast cam kết đổi pin mới hoặc sửa chữa miễn phí khi dung lượng pin khả dụng (SoH) tụt xuống dưới 70%.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Dịch vụ cứu hộ 24/7 của VinFast tại Hải Phòng có mất phí không?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Trong suốt thời gian bảo hành, khách hàng được miễn phí cứu hộ 24/7 và dịch vụ sạc lưu động Mobile Charging tại Hải Phòng.'
            ]
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@'.'context' => 'https://schema.org',
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
            'name' => 'Trung Tâm Chính Sách',
            'item' => url('/chinh-sach'),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@section('content')
{{-- 1. HERO BANNER --}}
<section class="vf-policy-hero" style="position: relative; background: #0b1329; color: #ffffff; padding: 60px 0 70px 0; overflow: hidden;">
    <div style="position: absolute; inset: 0; opacity: 0.28; background-image: url('{{ asset('storage/clients/assets/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp') }}'); background-size: cover; background-position: center;"></div>
    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(11,19,41,0.85) 0%, rgba(15,23,42,0.96) 100%);"></div>

    <div class="vinfast-autohaiphong_layout_container" style="position: relative; z-index: 2;">
        <nav style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 14px;">
            <a href="{{ route('client.home') }}" style="color: #94a3b8; text-decoration: none;">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: #60a5fa; font-weight: 600;">Chính sách & Quyền lợi</span>
        </nav>

        <div style="max-width: 820px;">
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: rgba(37,99,235,0.25); border: 1px solid rgba(96,165,250,0.3); border-radius: 9999px; font-size: 0.8rem; font-weight: 700; color: #93c5fd; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px;">
                VINFAST HẢI PHÒNG • HẬU MÃI TẬN TÂM
            </span>
            <h1 style="font-size: clamp(2rem, 3.5vw, 2.75rem); font-weight: 900; line-height: 1.25; margin-bottom: 16px; color: #ffffff;">
                TRUNG TÂM CHÍNH SÁCH & QUYỀN LỢI KHÁCH HÀNG
            </h1>
            <p style="font-size: 1.05rem; line-height: 1.7; color: #cbd5e1; margin-bottom: 28px;">
                Cam kết minh bạch toàn diện: Bảo hành xe điện dài nhất thị trường lên tới 10 năm, cứu hộ 24/7 hoàn toàn miễn phí, quy trình thanh toán tiền mặt an toàn tại quầy thu ngân Showroom Lê Hồng Phong.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px;">
                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; padding: 14px 16px;">
                    <div style="font-size: 1.35rem; font-weight: 900; color: #60a5fa;">10 Năm</div>
                    <div style="font-size: 0.82rem; color: #cbd5e1; margin-top: 2px;">Hoặc 200.000 km bảo hành xe</div>
                </div>
                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; padding: 14px 16px;">
                    <div style="font-size: 1.35rem; font-weight: 900; color: #34d399;">Không Giới Hạn</div>
                    <div style="font-size: 0.82rem; color: #cbd5e1; margin-top: 2px;">Số km bảo hành pin cao áp</div>
                </div>
                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; padding: 14px 16px;">
                    <div style="font-size: 1.35rem; font-weight: 900; color: #fbbf24;">100% Tiền Mặt</div>
                    <div style="font-size: 0.82rem; color: #cbd5e1; margin-top: 2px;">Nộp trực tiếp tại Showroom</div>
                </div>
                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; padding: 14px 16px;">
                    <div style="font-size: 1.35rem; font-weight: 900; color: #f472b6;">24/7 Miễn Phí</div>
                    <div style="font-size: 0.82rem; color: #cbd5e1; margin-top: 2px;">Cứu hộ khẩn cấp tại Hải Phòng</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 2. TABS NAVIGATION --}}
@include('clients.components.policy-tabs', ['activeTab' => $activeTab])

{{-- 3. 4 TRỤ CỘT CHÍNH SÁCH CHÍNH --}}
<section style="padding: 50px 0; background: #ffffff;">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="text-align: center; max-width: 680px; margin: 0 auto 40px auto;">
            <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-color-primary); text-transform: uppercase; letter-spacing: 1px;">
                QUYỀN LỢI ĐẶC QUYỀN
            </span>
            <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-top: 6px; margin-bottom: 10px;">
                4 Trụ Cột Chính Sách Khách Hàng VinFast
            </h2>
            <p style="font-size: 0.95rem; color: var(--client-color-muted); line-height: 1.6;">
                Mọi chính sách tại VinFast Hải Phòng đều được thiết kế nhằm mang lại sự yên tâm tuyệt đối và bảo vệ tối đa lợi ích của chủ sở hữu xe điện.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
            {{-- Trụ cột 1 --}}
            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 28px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease;">
                <div>
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 18px;">
                        🛡️
                    </div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 10px;">
                        Chính Sách Bảo Hành & Bảo Dưỡng
                    </h3>
                    <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin-bottom: 16px;">
                        Thời hạn bảo hành xe từ 7 đến 10 năm, pin cao áp không giới hạn số km. Cam kết đổi pin mới khi dung lượng SoH < 70%.
                    </p>
                    <ul style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 0.85rem; color: #334155; line-height: 1.8;">
                        <li>✓ 7 năm: VF 3, VF 5 Plus, VF 6</li>
                        <li>✓ 10 năm: VF 7, VF 8, VF 9</li>
                        <li>✓ Cứu hộ 24/7 & Mobile Service</li>
                    </ul>
                </div>
                <a href="{{ route('client.pages.warranty_policy') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="text-align: center; text-decoration: none; padding: 9px 16px; font-size: 0.88rem;">
                    Xem Chi Tiết Bảo Hành &rarr;
                </a>
            </div>

            {{-- Trụ cột 2 --}}
            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 28px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease;">
                <div>
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 18px;">
                        💵
                    </div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 10px;">
                        Thanh Toán Tiền Mặt & Nhận Xe
                    </h3>
                    <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin-bottom: 16px;">
                        Khóa cố định phương thức nộp tiền mặt trực tiếp tại Showroom Lê Hồng Phong. Hệ thống cấp phiếu thu và hợp đồng dấu đỏ minh bạch.
                    </p>
                    <ul style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 0.85rem; color: #334155; line-height: 1.8;">
                        <li>✓ Đặt cọc online không trừ thẻ</li>
                        <li>✓ Miễn 100% lệ phí trước bạ (0 đồng)</li>
                        <li>✓ Hỗ trợ vay trả góp 80% giá trị xe</li>
                    </ul>
                </div>
                <a href="{{ route('client.pages.payment_policy') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="text-align: center; text-decoration: none; padding: 9px 16px; font-size: 0.88rem;">
                    Xem Quy Trình Thanh Toán &rarr;
                </a>
            </div>

            {{-- Trụ cột 3 --}}
            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 28px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease;">
                <div>
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 18px;">
                        🔋
                    </div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 10px;">
                        Chính Sách Pin & Trạm Sạc V-GREEN
                    </h3>
                    <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin-bottom: 16px;">
                        Hạ tầng trạm sạc phủ rộng 14 quận/huyện Hải Phòng. Chính sách thuê pin linh hoạt giúp giảm giá lăn bánh ban đầu xuống mức thấp nhất.
                    </p>
                    <ul style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 0.85rem; color: #334155; line-height: 1.8;">
                        <li>✓ Đổi pin khi dung lượng < 70%</li>
                        <li>✓ Sạc siêu nhanh 10% - 70% chỉ từ 24 phút</li>
                        <li>✓ Trạm sạc 24/7 toàn thành phố</li>
                    </ul>
                </div>
                <a href="{{ route('client.pages.charging_stations') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="text-align: center; text-decoration: none; padding: 9px 16px; font-size: 0.88rem;">
                    Bản Đồ & Chi Phí Trạm Sạc &rarr;
                </a>
            </div>

            {{-- Trụ cột 4 --}}
            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 28px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s ease;">
                <div>
                    <div style="width: 48px; height: 48px; border-radius: 10px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 18px;">
                        🔒
                    </div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 10px;">
                        Bảo Mật Dữ Liệu & Pháp Lý
                    </h3>
                    <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin-bottom: 16px;">
                        Tuân thủ tuyệt đối Nghị định 13/2023/NĐ-CP về bảo vệ dữ liệu cá nhân. Không chia sẻ thông tin khách hàng cho bên thứ ba vì mục đích thương mại.
                    </p>
                    <ul style="list-style: none; padding: 0; margin: 0 0 20px 0; font-size: 0.85rem; color: #334155; line-height: 1.8;">
                        <li>✓ Mã hóa thông tin liên hệ 100%</li>
                        <li>✓ Quyền yêu cầu xóa thông tin bất kỳ lúc nào</li>
                        <li>✓ Hợp đồng mua bán chuẩn pháp luật</li>
                    </ul>
                </div>
                <a href="{{ route('client.pages.privacy_policy') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="text-align: center; text-decoration: none; padding: 9px 16px; font-size: 0.88rem;">
                    Xem Chính Sách Bảo Mật &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

{{-- 4. CÔNG CỤ TRA CỨU BẢO HÀNH THEO DÒNG XE (INTERACTIVE WARRANTY CHECKER) --}}
<section id="tra-cuu-bao-hanh" style="padding: 60px 0; background: #f8fafc; border-top: 1px solid var(--client-color-border); border-bottom: 1px solid var(--client-color-border);">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; flex-wrap: wrap; gap: 16px;">
            <div>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-color-primary); text-transform: uppercase; letter-spacing: 1px;">
                    CÔNG CỤ TRA CỨU TRỰC QUAN
                </span>
                <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-top: 4px;">
                    Tra Cứu Hạn Bảo Hành Từng Dòng Xe VinFast
                </h2>
                <p style="font-size: 0.95rem; color: var(--client-color-muted); margin: 0;">
                    Chọn mẫu xe để xem thời hạn bảo hành xe, bảo hành pin, chu kỳ và chi phí bảo dưỡng định kỳ.
                </p>
            </div>
            <a href="{{ route('client.pages.warranty_policy') }}" style="font-size: 0.9rem; font-weight: 600; color: var(--client-color-primary); text-decoration: none;">
                Xem toàn bộ chính sách bảo hành ↗
            </a>
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
                            Xem Chi Tiết Mẫu Xe &rarr;
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

{{-- 5. SO SÁNH BẢO DƯỠNG XE ĐIỆN VS XE XĂNG --}}
<section style="padding: 60px 0; background: #ffffff;">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="text-align: center; max-width: 700px; margin: 0 auto 36px auto;">
            <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-color-primary); text-transform: uppercase; letter-spacing: 1px;">
                TỐI ƯU CHI PHÍ VẬN HÀNH
            </span>
            <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-top: 4px; margin-bottom: 10px;">
                So Sánh Chu Kỳ Bảo Dưỡng: Ô Tô Điện VinFast vs Xe Xăng
            </h2>
            <p style="font-size: 0.95rem; color: var(--client-color-muted); line-height: 1.6;">
                Không có động cơ đốt trong phức tạp, ô tô điện VinFast loại bỏ hoàn toàn các hạng mục tốn kém nhất của xe xăng truyền thống.
            </p>
        </div>

        <div style="overflow-x: auto; border: 1px solid var(--client-color-border); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="background: #0f172a; color: #ffffff;">
                        <th style="padding: 16px 20px; font-weight: 700;">Hạng Mục Bảo Dưỡng</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #60a5fa;">Ô Tô Điện VinFast (Chuẩn 3S)</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #cbd5e1;">Xe Xăng Cùng Phân Khúc</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #34d399;">Lợi Ích Cho Khách Hàng</th>
                    </tr>
                </thead>
                <tbody style="divide-y: 1px solid var(--client-color-border);">
                    <tr style="border-bottom: 1px solid var(--client-color-border); background: #ffffff;">
                        <td style="padding: 16px 20px; font-weight: 600; color: var(--client-color-heading);">Dầu động cơ & Lọc dầu</td>
                        <td style="padding: 16px 20px; color: #059669; font-weight: 700;">KHÔNG CÓ (0 đồng)</td>
                        <td style="padding: 16px 20px; color: #ef4444;">Phải thay mỗi 5.000 – 10.000 km</td>
                        <td style="padding: 16px 20px; color: #059669;">Tiết kiệm hàng triệu đồng mỗi năm</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--client-color-border); background: #f8fafc;">
                        <td style="padding: 16px 20px; font-weight: 600; color: var(--client-color-heading);">Bugi, Dây curoa, Lọc xăng</td>
                        <td style="padding: 16px 20px; color: #059669; font-weight: 700;">KHÔNG CÓ (0 đồng)</td>
                        <td style="padding: 16px 20px; color: #ef4444;">Thay thế định kỳ theo số km</td>
                        <td style="padding: 16px 20px; color: #059669;">Không lo hỏng vặt hay chết máy giữa đường</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--client-color-border); background: #ffffff;">
                        <td style="padding: 16px 20px; font-weight: 600; color: var(--client-color-heading);">Chu kỳ bảo dưỡng định kỳ</td>
                        <td style="padding: 16px 20px; font-weight: 700; color: #1e3a8a;">12.000 km hoặc 1 năm</td>
                        <td style="padding: 16px 20px; color: #64748b;">5.000 km hoặc 6 tháng</td>
                        <td style="padding: 16px 20px; color: #059669;">Thời gian vào xưởng giảm 50%</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--client-color-border); background: #f8fafc;">
                        <td style="padding: 16px 20px; font-weight: 600; color: var(--client-color-heading);">Má phanh & Đĩa phanh</td>
                        <td style="padding: 16px 20px; color: #059669;">Rất ít hao mòn (nhờ phanh tái sinh)</td>
                        <td style="padding: 16px 20px; color: #64748b;">Mòn nhanh do ma sát liên tục</td>
                        <td style="padding: 16px 20px; color: #059669;">Tuổi thọ má phanh gấp 2-3 lần</td>
                    </tr>
                    <tr style="background: #eff6ff;">
                        <td style="padding: 16px 20px; font-weight: 700; color: #1e3a8a;">Tổng chi phí bảo dưỡng 5 năm</td>
                        <td style="padding: 16px 20px; font-weight: 800; color: #2563eb; font-size: 1.05rem;">Chỉ từ 4 – 8 triệu VNĐ</td>
                        <td style="padding: 16px 20px; font-weight: 800; color: #ef4444; font-size: 1.05rem;">Khoảng 25 – 45 triệu VNĐ</td>
                        <td style="padding: 16px 20px; font-weight: 800; color: #059669;">Tiết kiệm tới 75% chi phí</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- 6. FAQ & HOTLINE HỖ TRỢ --}}
<section style="padding: 60px 0; background: #f8fafc; border-top: 1px solid var(--client-color-border);">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 40px; align-items: start;">
            {{-- Cột FAQ --}}
            <div>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--client-color-primary); text-transform: uppercase; letter-spacing: 1px;">
                    GIẢI ĐÁP THẮC MẮC
                </span>
                <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--client-color-heading); margin-top: 4px; margin-bottom: 20px;">
                    Câu Hỏi Thường Gặp Của Khách Hàng
                </h2>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <details style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 16px 20px; cursor: pointer;">
                        <summary style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem;">
                            Thời gian bảo hành xe ô tô điện VinFast tại Hải Phòng là bao lâu?
                        </summary>
                        <div style="margin-top: 10px; font-size: 0.9rem; color: #475569; line-height: 1.6;">
                            VinFast áp dụng thời hạn bảo hành chính hãng tiêu chuẩn cao nhất thị trường: 10 năm hoặc 200.000 km cho VF 7, VF 8, VF 9; và 7 năm hoặc 160.000 km cho VF 3, VF 5 Plus, VF 6. Pin cao áp bảo hành 7-10 năm không giới hạn km.
                        </div>
                    </details>

                    <details style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 16px 20px; cursor: pointer;">
                        <summary style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem;">
                            Tôi có phải thanh toán tiền mặt 100% khi nhận xe không?
                        </summary>
                        <div style="margin-top: 10px; font-size: 0.9rem; color: #475569; line-height: 1.6;">
                            Đúng vậy. Để đảm bảo an toàn và tính pháp lý minh bạch tuyệt đối, website VinFast Hải Phòng chỉ tiếp nhận đặt cọc online không thu phí thẻ. Toàn bộ tiền mua xe được nộp trực tiếp bằng tiền mặt tại phòng Kế toán - Thu ngân Showroom Lê Hồng Phong, có biên lai và hóa đơn VAT có dấu đỏ.
                        </div>
                    </details>

                    <details style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 16px 20px; cursor: pointer;">
                        <summary style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem;">
                            Pin xe điện bị chai bao nhiêu phần trăm thì được đổi mới?
                        </summary>
                        <div style="margin-top: 10px; font-size: 0.9rem; color: #475569; line-height: 1.6;">
                            Theo cam kết chính hãng của VinFast, khi dung lượng pin khả dụng (State of Health - SoH) giảm xuống dưới 70%, khách hàng thuê pin hoặc mua đứt pin sẽ được sửa chữa hoặc thay thế bộ pin mới hoàn toàn miễn phí tại Xưởng dịch vụ 3S.
                        </div>
                    </details>

                    <details style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 16px 20px; cursor: pointer;">
                        <summary style="font-weight: 700; color: var(--client-color-heading); font-size: 0.95rem;">
                            Khi xe gặp sự cố hết pin hoặc chết máy trên đường Hải Phòng, tôi gọi ai?
                        </summary>
                        <div style="margin-top: 10px; font-size: 0.9rem; color: #475569; line-height: 1.6;">
                            Quý khách có thể gọi trực tiếp Hotline Xưởng Dịch Vụ VinFast Hải Phòng: <strong>{{ $settings['site_phone_service'] ?? '0915 286 506' }}</strong> hoặc Tổng đài Cứu hộ VinFast Toàn quốc: <strong>1900 23 23 89</strong> (hỗ trợ 24/7/365).
                        </div>
                    </details>
                </div>
            </div>

            {{-- Cột Hotline & Địa chỉ hỗ trợ --}}
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 32px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                <div style="display: inline-block; padding: 4px 10px; background: #eff6ff; color: #2563eb; font-size: 0.78rem; font-weight: 700; border-radius: 4px; margin-bottom: 12px;">
                    ĐẠI LÝ ỦY QUYỀN 3S
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 16px;">
                    Showroom & Xưởng Dịch Vụ 3S VinFast Hải Phòng
                </h3>
                
                <p style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin-bottom: 20px;">
                    📍 <strong>Địa chỉ:</strong> {{ $settings['site_address'] ?? 'Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng' }}
                </p>

                <div style="border-top: 1px dashed var(--client-color-border); padding-top: 16px; margin-bottom: 20px;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 8px;">Đường dây nóng hỗ trợ 24/7:</div>
                    <ul style="list-style: none; padding: 0; margin: 0; line-height: 2; font-size: 0.9rem;">
                        <li>📞 <strong>Bán hàng:</strong> <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['site_phone'] ?? '0988302882') }}" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">{{ $settings['site_phone'] ?? '0988 302 882' }}</a></li>
                        <li>🔧 <strong>Dịch vụ – Phụ tùng:</strong> <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['site_phone_service'] ?? '0915286506') }}" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">{{ $settings['site_phone_service'] ?? '0915 286 506' }}</a></li>
                        <li>💼 <strong>CSKH Kinh doanh:</strong> <a href="tel:0915286503" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0915 286 503</a></li>
                        <li>🛠️ <strong>CSKH Dịch vụ:</strong> <a href="tel:0843714333" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0843 714 333</a></li>
                    </ul>
                </div>

                <a href="{{ route('client.contact.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="display: block; text-align: center; text-decoration: none; padding: 11px; font-size: 0.95rem;">
                    Đặt Lịch Hẹn Tại Showroom &rarr;
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
