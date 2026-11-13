@extends('clients.layouts.app')

@section('title', 'Trải Nghiệm Khách Hàng | VinFast Hải Phòng')
@section('meta_description', 'Lắng nghe những chia sẻ, đánh giá thực tế từ khách hàng đã tin tưởng sở hữu và vận hành xe ô tô điện VinFast tại Hải Phòng.')
@section('canonical', url('/trai-nghiem-khach-hang'))

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
                    "Gia đình tôi chọn chiếc VinFast VF 6 sau khi đã lái thử nhiều dòng xe cùng phân khúc. Xe đầm chắc, cách âm rất tốt và đặc biệt là chi phí tiền điện tiết kiệm hơn rất nhiều so với tiền xăng trước đây. Dịch vụ tại VinFast Minh Đạo Số 1 Bạch Đằng rất tận tâm và chu đáo."
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
                    "VinFast VF 8 phiên bản Plus chạy cao tốc Hải Phòng - Hà Nội êm ái tuyệt vời, tính năng trợ lái ADAS cấp độ 2 giúp tôi lái xe đường dài rất nhàn nhã và an tâm. Đội ngũ kỹ thuật viên xưởng dịch vụ Minh Đạo làm việc rất chuyên nghiệp."
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
                Đăng ký lái thử miễn phí tận nhà hoặc tại Showroom VinFast Minh Đạo ngay hôm nay.
            </p>
            <button type="button" onclick="openQuoteModal(null, 'Đăng ký lái thử xe VinFast')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 12px 28px;">
                Đăng Ký Lái Thử Miễn Phí
            </button>
        </div>
    </div>
</div>
@endsection

