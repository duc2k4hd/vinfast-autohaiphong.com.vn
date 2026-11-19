@extends('clients.layouts.app')

@section('title', 'Trải nghiệm xe VinFast tại Hải Phòng | Tư vấn')
@section('meta_description', 'Tìm hiểu dịch vụ tư vấn và đăng ký lái thử xe VinFast tại Hải Phòng. Liên hệ showroom để được cập nhật thông tin và hỗ trợ trực tiếp.')
@section('canonical', url('/trai-nghiem-khach-hang'))

@push('schema')
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
            'name' => 'Trải Nghiệm Khách Hàng',
            'item' => url('/trai-nghiem-khach-hang'),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@section('content')
<div class="vinfast-autohaiphong_custom_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 36px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            TRẢI NGHIỆM KHÁCH HÀNG
        </h1>
        <p style="color: var(--client-color-muted); font-size: 1rem;">
            Những câu chuyện người thật việc thật từ cộng đồng chủ xe VinFast tại thành phố Hải Phòng.
        </p>
    </div>
</div>

<div class="vinfast-autohaiphong_custom_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px; margin-bottom: 40px;">
            
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="color: #f59e0b; margin-bottom: 12px; font-size: 1.1rem;">★★★★★</div>
                <p style="font-size: 0.95rem; color: #334155; line-height: 1.7; margin-bottom: 20px;">
                    "Gia đình tôi chọn chiếc VinFast VF 6 sau khi đã lái thử nhiều dòng xe cùng phân khúc. Xe đầm chắc, cách âm rất tốt và đặc biệt là chi phí tiền điện tiết kiệm hơn rất nhiều so với tiền xăng trước đây. Dịch vụ tại VinFast Hải Phòng rất tận tâm và chu đáo."
                </p>
                <div style="border-top: 1px solid var(--client-color-border); padding-top: 14px;">
                    <div style="font-weight: 700; color: var(--client-color-heading);">Anh Trần Hoàng Nam</div>
                    <div style="font-size: 0.8rem; color: var(--client-color-muted);">Chủ xe VinFast VF 6 Plus — Quận Lê Chân, Hải Phòng</div>
                </div>
            </div>

            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="color: #f59e0b; margin-bottom: 12px; font-size: 1.1rem;">★★★★★</div>
                <p style="font-size: 0.95rem; color: #334155; line-height: 1.7; margin-bottom: 20px;">
                    "Chiếc VF 3 thực sự là cứu tinh cho việc đi làm hàng ngày trong nội đô của tôi. Dễ đỗ, gầm cao lội nước thoải mái và sạc pin cực kỳ tiện lợi ở Vincom Imperia gần nhà. Mua xe thanh toán tiền mặt trực tiếp tại showroom rất rõ ràng, hợp đồng minh bạch."
                </p>
                <div style="border-top: 1px solid var(--client-color-border); padding-top: 14px;">
                    <div style="font-weight: 700; color: var(--client-color-heading);">Chị Nguyễn Thùy Linh</div>
                    <div style="font-size: 0.8rem; color: var(--client-color-muted);">Chủ xe VinFast VF 3 — Quận Hồng Bàng, Hải Phòng</div>
                </div>
            </div>

            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="color: #f59e0b; margin-bottom: 12px; font-size: 1.1rem;">★★★★★</div>
                <p style="font-size: 0.95rem; color: #334155; line-height: 1.7; margin-bottom: 20px;">
                    "VinFast VF 8 phiên bản Plus chạy cao tốc Hải Phòng - Hà Nội êm ái tuyệt vời, tính năng trợ lái ADAS cấp độ 2 giúp tôi lái xe đường dài rất nhàn nhã và an tâm. Đội ngũ kỹ thuật viên xưởng dịch vụ VinFast Hải Phòng làm việc rất chuyên nghiệp."
                </p>
                <div style="border-top: 1px solid var(--client-color-border); padding-top: 14px;">
                    <div style="font-weight: 700; color: var(--client-color-heading);">Bác Lê Văn Minh</div>
                    <div style="font-size: 0.8rem; color: var(--client-color-muted);">Chủ xe VinFast VF 8 — Quận Ngô Quyền, Hải Phòng</div>
                </div>
            </div>

        </div>

        {{-- Khối đăng ký lái thử --}}
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 36px; text-align: center;">
            <h3 style="font-size: 1.35rem; font-weight: 800; color: #1e3a8a; margin-bottom: 8px;">
                Bạn Muốn Trực Tiếp Cầm Lái & Cảm Nhận?
            </h3>
            <p style="color: #1e40af; margin-bottom: 20px; font-size: 0.95rem;">
                Đăng ký lái thử miễn phí tận nhà hoặc tại Showroom VinFast Hải Phòng ngay hôm nay.
            </p>
            <button type="button" onclick="openQuoteModal(null, 'Đăng ký lái thử xe VinFast')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 12px 28px;">
                Đăng Ký Lái Thử Miễn Phí
            </button>
        </div>
    </div>
</div>
@endsection
