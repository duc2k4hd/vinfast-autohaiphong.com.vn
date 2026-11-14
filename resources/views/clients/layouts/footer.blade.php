<footer class="vinfast-autohaiphong_footer_main">
    <div class="vinfast-autohaiphong_layout_container">
        <div class="vf-footer-intro">
            <div><span class="vf-footer-eyebrow">VINFAST HẢI PHÒNG</span><h2>Đồng hành trên mọi hành trình</h2><p>Khám phá xe điện VinFast và kết nối với đội ngũ tư vấn của chúng tôi.</p></div>
            <a class="vf-footer-intro-link" href="{{ route('client.contact.index') }}">Liên hệ với chúng tôi <span aria-hidden="true">↗</span></a>
        </div>
        <div class="vf-footer-grid">
            <section><h3>{{ $siteSettings['site_name'] ?? 'VinFast Hải Phòng' }}</h3>
                <p>{{ $siteSettings['company_name'] ?? 'VinFast Hải Phòng' }}</p>
                <p><strong>Showroom</strong><br>{{ $siteSettings['site_address'] ?? 'Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng' }}</p>
                <p><strong>Giờ làm việc</strong><br>{{ $siteSettings['site_hours'] ?? 'Thứ 2 – Thứ 7: Dịch vụ 7h50–17h00, kinh doanh 7h30–18h00; Chủ nhật: Dịch vụ nghỉ, kinh doanh 7h00–18h00' }}</p>
            </section>
            <nav aria-label="Khám phá"><h3>Khám phá</h3><ul><li><a href="{{ route('client.catalog.index') }}">Dòng xe VinFast</a></li><li><a href="{{ route('client.posts.index') }}">Tin tức</a></li><li><a href="{{ route('client.contact.index') }}">Liên hệ</a></li><li><a href="{{ route('client.pages.charging_stations') }}">Pin và trạm sạc</a></li><li><a href="{{ route('client.pages.payment_policy') }}">Chính sách thanh toán</a></li><li><a href="{{ route('client.pages.warranty_policy') }}">Bảo hành & bảo dưỡng</a></li><li><a href="{{ route('client.pages.privacy_policy') }}">Chính sách bảo mật</a></li><li><a href="{{ route('client.pages.terms') }}">Điều khoản sử dụng</a></li></ul></nav>
            <section><h3>Liên hệ</h3><p>Bán hàng<br><a class="vf-footer-phone" href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone'] ?? '0988 302 882') }}">{{ $siteSettings['site_phone'] ?? '0988 302 882' }}</a></p><p>Dịch vụ – phụ tùng<br><a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['site_phone_service'] ?? '0915 286 506') }}">{{ $siteSettings['site_phone_service'] ?? '0915 286 506' }}</a></p><p><a href="{{ $siteSettings['site_facebook'] ?? 'https://www.facebook.com/VinFastHaiPhong' }}" target="_blank" rel="noopener noreferrer">Facebook ↗</a></p></section>
            <section class="vf-footer-form"><h3>Nhận tư vấn</h3><p>Để lại thông tin để chúng tôi liên hệ tư vấn cho bạn.</p>
                <form action="{{ route('client.leads.store') }}" method="POST">@csrf
                    <input type="hidden" name="type" value="consultation">
                    <label for="footer-name">Họ và tên</label><input id="footer-name" name="name" type="text" autocomplete="name" required maxlength="255" value="{{ old('name') }}">
                    <label for="footer-phone">Số điện thoại</label><input id="footer-phone" name="phone" type="tel" autocomplete="tel" required pattern="0[35789][0-9]{8}" title="Số điện thoại di động gồm 10 chữ số" value="{{ old('phone') }}">
                    <label class="vf-footer-consent"><input type="checkbox" required> <span>Tôi đồng ý cung cấp thông tin để được liên hệ tư vấn.</span></label>
                    @if ($errors->has('name') || $errors->has('phone'))<p role="alert">{{ $errors->first('name') ?: $errors->first('phone') }}</p>@endif
                    <button type="submit">Gửi yêu cầu <span aria-hidden="true">→</span></button>
                </form>
            </section>
        </div>
        <div class="vf-footer-bottom"><span>© {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'VinFast Hải Phòng' }}</span><span>VinFast Hải Phòng</span></div>
    </div>
</footer>
{{-- Floating Phone & Zalo Button --}}
<nav class="vinfast-autohaiphong_floating_wrapper" aria-label="Liên hệ nhanh">
    <button type="button" class="vinfast-autohaiphong_floating_top" data-back-to-top aria-label="Lên đầu trang" hidden>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
    </button>
    <a href="tel:0988302882" class="vinfast-autohaiphong_floating_btn vinfast-autohaiphong_floating_phone" aria-label="Gọi bán hàng: 0988 302 882">
        <span class="vinfast-autohaiphong_floating_icon" aria-hidden="true"><svg width="23" height="23" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span>
        <span class="vinfast-autohaiphong_floating_copy"><strong>Gọi tư vấn</strong><small>0988 302 882</small></span>
    </a>
    <a href="https://zalo.me/0988302882" target="_blank" rel="noopener noreferrer" class="vinfast-autohaiphong_floating_btn vinfast-autohaiphong_floating_zalo" aria-label="Chat qua Zalo với bán hàng (mở tab mới)">
        <span class="vinfast-autohaiphong_floating_icon vinfast-autohaiphong_floating_zalo_icon" aria-hidden="true">Zalo</span>
        <span class="vinfast-autohaiphong_floating_copy"><strong>Chat Zalo</strong><small>Hỗ trợ nhanh</small></span>
    </a>
</nav>
