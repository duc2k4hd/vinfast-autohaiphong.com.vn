@extends('clients.layouts.app')

@section('title', 'Liên Hệ Đại Lý VinFast Minh Đạo Hải Phòng | Hotline & Địa Chỉ')
@section('meta_description', 'Liên hệ Showroom VinFast Minh Đạo Hải Phòng: Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng. Hotline Bán hàng: 0988 302 882, Dịch vụ: 0915 286 506.')
@section('canonical', url('/lien-he'))

@push('schema')
{{-- ContactPage & LocalBusiness Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ContactPage',
    'name' => 'Liên Hệ VinFast Minh Đạo Hải Phòng',
    'description' => 'Trang thông tin liên hệ, hotline bán hàng, hotline dịch vụ và địa chỉ showroom chính thức VinFast tại Hải Phòng.',
    'url' => url('/lien-he'),
    'mainEntity' => [
        '@type' => 'AutoDealer',
        'name' => 'VinFast Minh Đạo Hải Phòng',
        'telephone' => '0988 302 882',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Số 1 Bạch Đằng, Phường Thượng Lý',
            'addressLocality' => 'Quận Hồng Bàng',
            'addressRegion' => 'Hải Phòng',
            'addressCountry' => 'VN'
        ],
        'openingHours' => [
            'Mo-Sa 07:30-18:00',
            'Su 07:00-18:00'
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<div class="vinfast-autohaiphong_contact_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 32px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            LIÊN HỆ VINFAST HẢI PHÒNG
        </h1>
        <p style="color: var(--client-color-muted); font-size: 0.95rem;">
            Đại lý ủy quyền 3S chính thức của VinFast tại thành phố Hải Phòng. Sẵn sàng phục vụ và tư vấn 24/7.
        </p>
    </div>
</div>

<div class="vinfast-autohaiphong_contact_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: grid; grid-template-columns: 1.1fr 1.3fr; gap: 40px; align-items: start;">
            
            {{-- Cột Trái: Thông tin liên hệ trực tiếp & Giờ mở cửa --}}
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 20px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 6px; display: inline-block;">
                    THÔNG TIN SHOWROOM 3S
                </h2>

                <div style="margin-bottom: 20px; line-height: 1.6;">
                    <strong style="color: var(--client-color-heading); display: block; margin-bottom: 4px;">📍 Địa chỉ trụ sở:</strong>
                    <span style="color: #475569;">{{ $siteSettings['site_address'] ?? 'Số 1 Bạch Đằng, Phường Thượng Lý, Quận Hồng Bàng, TP. Hải Phòng' }}</span>
                </div>

                {{-- Khối 4 số Hotline chuyên trách chuẩn xác --}}
                <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 6px; padding: 18px; margin-bottom: 24px;">
                    <div style="font-weight: 700; color: var(--client-color-heading); margin-bottom: 12px; font-size: 0.95rem;">
                        ĐƯỜNG DÂY NÓNG HỖ TRỢ:
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                        <li>
                            📞 <strong>Bán hàng:</strong> 
                            <a href="tel:0988302882" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0988 302 882</a>
                        </li>
                        <li>
                            🔧 <strong>Dịch vụ – Phụ tùng:</strong> 
                            <a href="tel:0915286506" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0915 286 506</a>
                        </li>
                        <li>
                            💼 <strong>CSKH Kinh doanh:</strong> 
                            <a href="tel:0915286503" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0915 286 503</a>
                        </li>
                        <li>
                            🛠️ <strong>CSKH Dịch vụ:</strong> 
                            <a href="tel:0843714333" style="color: var(--client-color-primary); font-weight: 700; text-decoration: none;">0843 714 333</a>
                        </li>
                    </ul>
                </div>

                {{-- Giờ làm việc chi tiết --}}
                <div style="margin-bottom: 20px; line-height: 1.6;">
                    <strong style="color: var(--client-color-heading); display: block; margin-bottom: 6px;">🕒 Giờ làm việc:</strong>
                    <div style="font-size: 0.9rem; color: #334155;">
                        <p style="margin-bottom: 4px;"><strong>Thứ 2 – Thứ 7:</strong></p>
                        <p style="margin-left: 12px; margin-bottom: 4px;">• Dịch vụ: 7h50 – 17h00</p>
                        <p style="margin-left: 12px; margin-bottom: 8px;">• Kinh doanh: 7h30 – 18h00</p>
                        <p style="margin-bottom: 4px;"><strong>Chủ nhật:</strong></p>
                        <p style="margin-left: 12px; margin-bottom: 4px;">• Dịch vụ & Phụ tùng: Nghỉ</p>
                        <p style="margin-left: 12px; margin-bottom: 0;">• Kinh doanh: 7h00 – 18h00</p>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--client-color-border); padding-top: 16px;">
                    <a href="{{ $siteSettings['site_facebook'] ?? 'https://www.facebook.com/VinFastMinhDao' }}" target="_blank" rel="noopener noreferrer" 
                       class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="width: 100%; text-decoration: none; text-align: center;">
                        Theo dõi Fanpage Facebook Chính Thức &rarr;
                    </a>
                </div>
            </div>

            {{-- Cột Phải: Form gửi tin nhắn liên hệ --}}
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 20px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 6px; display: inline-block;">
                    GỬI LỜI NHẮN CHO CHÚNG TÔI
                </h2>

                @if(session('success'))
                    <div style="background-color: #dcfce7; border: 1px solid #bbf7d0; color: #15803d; padding: 14px 18px; border-radius: 6px; margin-bottom: 20px; font-size: 0.95rem;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background-color: #fee2e2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('client.contact.store') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                            Họ và tên của bạn <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               placeholder="Nguyễn Văn A" 
                               style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
                    </div>

                    <div style="grid-template-columns: 1fr 1fr; display: grid; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                                Số điện thoại <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required 
                                   placeholder="0988 302 882" 
                                   style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                                Email của bạn
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   placeholder="email@example.com" 
                                   style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                            Chủ đề cần tư vấn
                        </label>
                        <input type="text" name="subject" value="{{ old('subject') }}" 
                               placeholder="Ví dụ: Tư vấn giá lăn bánh VF 3, chính sách bảo dưỡng..." 
                               style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                            Nội dung chi tiết <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea name="message" rows="4" required 
                                  placeholder="Vui lòng để lại lời nhắn cụ thể..." 
                                  style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="width: 100%; padding: 13px; font-size: 1rem;">
                        Gửi Yêu Cầu Liên Hệ &rarr;
                    </button>
                </form>
            </div>
        </div>

        {{-- Khối Bản Đồ Vị Trí Showroom 3S VinFast Hải Phòng --}}
        <div style="margin-top: 40px; background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 4px;">
                        VỊ TRÍ SHOWROOM VINFAST MINH ĐẠO HẢI PHÒNG
                    </h3>
                    <p style="font-size: 0.88rem; color: var(--client-color-muted); margin: 0;">
                        Địa chỉ: Số 1 Bạch Đằng, Phường Thượng Lý, Quận Hồng Bàng, Thành phố Hải Phòng (Cách cầu Bính 300m)
                    </p>
                </div>
                <a href="https://maps.google.com/?q=VinFast+Minh+Đạo+Số+1+Bạch+Đằng+Hải+Phòng" target="_blank" rel="noopener noreferrer" 
                   class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="font-size: 0.85rem; padding: 8px 16px; text-decoration: none;">
                    📍 Mở Google Maps Chỉ Đường &nearr;
                </a>
            </div>

            <div style="border-radius: 6px; overflow: hidden; height: 360px; background: #e2e8f0; position: relative;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.39414272847!2d106.67139!3d20.8654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7af39b6b7a8b%3A0x6b7a8b39b6b7a8b!2zU-G7kSAxIELhuqFjaCDEkOG6sW5nLCBUaMaw4bujbmcgTMO9LCBI4buTbmcgQsOgbmcsIEjhuqNpIFBow7JuZw!5e0!3m2!1svi!2svn!4v1700000000000!5m2!1svi!2svn" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Bản đồ chỉ dẫn Showroom VinFast Minh Đạo Hải Phòng"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

