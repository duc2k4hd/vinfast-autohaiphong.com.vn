@extends('clients.layouts.app')

@section('title', 'Hạ Tầng Pin & Trạm Sạc Xe Điện VinFast Tại Hải Phòng')
@section('meta_description', 'Khám phá mạng lưới trạm sạc xe ô tô điện VinFast V-GREEN tại Hải Phòng, bảng giá sạc pin và chính sách bảo hành pin xe điện 10 năm.')
@section('canonical', url('/pin-va-tram-sac'))

@section('content')
<div class="vinfast-autohaiphong_custom_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 36px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            PIN & HẠ TẦNG TRẠM SẠC VINFAST HẢI PHÒNG
        </h1>
        <p style="color: var(--client-color-muted); font-size: 1rem;">
            Hệ thống trạm sạc phủ khắp 14 quận huyện thành phố Hải Phòng, nạp nhanh, thông minh và an toàn vượt trội.
        </p>
    </div>
</div>

<div class="vinfast-autohaiphong_custom_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        
        {{-- Khối 3 cam kết trạm sạc --}}
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 48px;">
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #eff6ff; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; color: var(--client-color-primary);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 8px;">Công Nghệ Sạc Siêu Nhanh</h3>
                <p style="font-size: 0.9rem; color: #475569; line-height: 1.6;">
                    Công suất trụ sạc DC từ 30kW, 60kW, 150kW đến siêu sạc 250kW, giúp nạp từ 10% lên 70% chỉ trong khoảng 20 – 30 phút.
                </p>
            </div>

            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #eff6ff; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; color: var(--client-color-primary);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 8px;">Phủ Sóng Rộng Khắp Hải Phòng</h3>
                <p style="font-size: 0.9rem; color: #475569; line-height: 1.6;">
                    Có mặt tại các trung tâm thương mại Vincom, tòa nhà Vinhomes Imperia, Marina, trạm dừng nghỉ cao tốc và cây xăng liên kết.
                </p>
            </div>

            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #eff6ff; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; color: var(--client-color-primary);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 8px;">Chính Sách Pin Đỉnh Cao</h3>
                <p style="font-size: 0.9rem; color: #475569; line-height: 1.6;">
                    VinFast cam kết bảo hành pin lên đến 10 năm không giới hạn quãng đường di chuyển cho bản mua đứt pin hoặc đổi mới khi dung lượng dưới 70%.
                </p>
            </div>
        </div>

        {{-- Chi tiết danh sách điểm sạc tiêu biểu tại Hải Phòng --}}
        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); margin-bottom: 40px;">
            <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 20px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px; display: inline-block;">
                CÁC ĐIỂM SẠC VINFAST TIÊU BIỂU TẠI HẢI PHÒNG
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                <div style="border: 1px solid var(--client-color-border); border-radius: 6px; padding: 16px;">
                    <div style="font-weight: 700; color: var(--client-color-heading); margin-bottom: 4px;">Showroom VinFast Minh Đạo</div>
                    <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 6px;">Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng</div>
                    <span style="font-size: 0.75rem; background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-weight: 600;">Sạc siêu nhanh 250kW + DC 60kW</span>
                </div>

                <div style="border: 1px solid var(--client-color-border); border-radius: 6px; padding: 16px;">
                    <div style="font-weight: 700; color: var(--client-color-heading); margin-bottom: 4px;">Vincom Plaza Imperia Hải Phòng</div>
                    <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 6px;">Khu đô thị Vinhomes Imperia, Hồng Bàng</div>
                    <span style="font-size: 0.75rem; background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-weight: 600;">Trụ sạc DC 60kW & AC 11kW</span>
                </div>

                <div style="border: 1px solid var(--client-color-border); border-radius: 6px; padding: 16px;">
                    <div style="font-weight: 700; color: var(--client-color-heading); margin-bottom: 4px;">Vincom Plaza Lê Thánh Tông</div>
                    <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 6px;">Số 4 Lê Thánh Tông, Máy Tơ, Ngô Quyền</div>
                    <span style="font-size: 0.75rem; background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-weight: 600;">Hầm B1, Trụ sạc nhanh DC</span>
                </div>

                <div style="border: 1px solid var(--client-color-border); border-radius: 6px; padding: 16px;">
                    <div style="font-weight: 700; color: var(--client-color-heading); margin-bottom: 4px;">Trạm Dừng Nghỉ Cao Tốc HN - HP</div>
                    <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 6px;">Km 77, Cao tốc Hà Nội - Hải Phòng</div>
                    <span style="font-size: 0.75rem; background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-weight: 600;">Trụ sạc công suất cao 150kW/250kW</span>
                </div>
            </div>
        </div>

        {{-- CTA Tư vấn --}}
        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 32px; text-align: center;">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 8px;">
                Cần Hỗ Trợ Kỹ Thuật Pin & Trạm Sạc Tại Hải Phòng?
            </h3>
            <p style="color: #64748b; margin-bottom: 20px;">
                Đội ngũ kỹ thuật viên VinFast Minh Đạo luôn túc trực 24/7 để hỗ trợ Quý khách giải quyết mọi vấn đề về trạm sạc và cứu hộ pin.
            </p>
            <a href="tel:0915286506" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 12px 28px; text-decoration: none;">
                Hotline Dịch Vụ: 0915 286 506
            </a>
        </div>
    </div>
</div>
@endsection

