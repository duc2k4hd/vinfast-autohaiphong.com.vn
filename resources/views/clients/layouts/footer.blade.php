<footer class="vinfast-autohaiphong_footer_main">
    <div class="vinfast-autohaiphong_layout_container">
        <div class="vinfast-autohaiphong_footer_grid">
            {{-- Cột 1: Thông tin đại lý --}}
            <div>
                <h3 class="vinfast-autohaiphong_footer_title">{{ $siteSettings['site_name'] ?? 'VinFast Hải Phòng' }}</h3>
                <p style="margin-bottom: 12px; font-size: 0.95rem; line-height: 1.6;">
                    {{ $siteSettings['company_name'] ?? 'Đại lý ủy quyền chính thức của VinFast Việt Nam tại Hải Phòng.' }}
                </p>
                <p style="margin-bottom: 8px; font-size: 0.9rem;">
                    📍 <strong>Địa chỉ:</strong> {{ $siteSettings['site_address'] ?? 'Số 1 Bạch Đằng, P. Thượng Lý, Q. Hồng Bàng, TP. Hải Phòng' }}
                </p>
                <p style="margin-bottom: 8px; font-size: 0.9rem;">
                    📞 <strong>Hotline 24/7:</strong> <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0966597282') }}" style="color: #ffffff; font-weight: 700;">{{ $siteSettings['site_phone'] ?? '0966.597.282' }}</a>
                </p>
                <p style="font-size: 0.9rem;">
                    ✉️ <strong>Email:</strong> {{ $siteSettings['site_email'] ?? 'kinhdoanh@vinfast-haiphong.com' }}
                </p>
            </div>

            {{-- Cột 2: Các dòng xe ô tô --}}
            <div>
                <h3 class="vinfast-autohaiphong_footer_title">Dòng Xe Ô Tô</h3>
                <ul class="vinfast-autohaiphong_footer_list">
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/xe/vinfast-vf-3') }}">VinFast VF 3</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/xe/vinfast-vf-5') }}">VinFast VF 5 Plus</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/xe/vinfast-vf-6') }}">VinFast VF 6</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/xe/vinfast-vf-7') }}">VinFast VF 7</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/xe/vinfast-vf-8') }}">VinFast VF 8</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/xe/vinfast-vf-9') }}">VinFast VF 9</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/xe/vinfast-vf-wild') }}">VinFast VF Wild</a></li>
                </ul>
            </div>

            {{-- Cột 3: Chính sách & Dịch vụ --}}
            <div>
                <h3 class="vinfast-autohaiphong_footer_title">Chính Sách</h3>
                <ul class="vinfast-autohaiphong_footer_list">
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/chinh-sach-thanh-toan') }}">Chính sách thanh toán tiền mặt</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/chinh-sach-bao-hanh') }}">Chính sách bảo hành & bảo dưỡng</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/chinh-sach-bao-mat') }}">Chính sách bảo mật thông tin</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/dieu-khoan-su-dung') }}">Điều khoản sử dụng</a></li>
                    <li class="vinfast-autohaiphong_footer_item"><a href="{{ url('/pin-va-tram-sac') }}">Hệ thống trạm sạc toàn quốc</a></li>
                </ul>
            </div>

            {{-- Cột 4: Đăng ký tư vấn --}}
            <div>
                <h3 class="vinfast-autohaiphong_footer_title">Đăng Ký Tư Vấn</h3>
                <p style="font-size: 0.9rem; margin-bottom: 14px;">Để lại số điện thoại để chuyên viên tư vấn gửi bảng giá lăn bánh và chương trình khuyến mãi mới nhất.</p>
                <form action="{{ route('client.leads.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 8px;">
                    @csrf
                    <input type="hidden" name="type" value="consultation">
                    <input type="text" name="name" required placeholder="Họ và tên của bạn" style="padding: 10px 14px; border-radius: 4px; border: 1px solid #334155; background: #0f172a; color: #ffffff; font-size: 0.9rem;">
                    <input type="tel" name="phone" required placeholder="Số điện thoại liên hệ *" style="padding: 10px 14px; border-radius: 4px; border: 1px solid #334155; background: #0f172a; color: #ffffff; font-size: 0.9rem;">
                    <button type="submit" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="margin-top: 4px;">Gửi Yêu Cầu</button>
                </form>
            </div>
        </div>

        {{-- Footer bản quyền --}}
        <div class="vinfast-autohaiphong_footer_bottom">
            <div>
                © {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'VinFast Hải Phòng' }}. Tất cả các quyền được bảo lưu.
            </div>
            <div>
                Phương thức thanh toán: <strong>Tiền mặt tại Showroom</strong> | Mã số đại lý: <strong>3S-HP01</strong>
            </div>
        </div>
    </div>
</footer>

{{-- Floating Phone & Zalo Button --}}
<div class="vinfast-autohaiphong_floating_wrapper">
    <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0966597282') }}" class="vinfast-autohaiphong_floating_btn vinfast-autohaiphong_floating_phone" title="Gọi hotline ngay" aria-label="Gọi hotline">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
        </svg>
    </a>
    <a href="{{ $siteSettings['site_zalo'] ?? 'https://zalo.me/0966597282' }}" target="_blank" rel="noopener noreferrer" class="vinfast-autohaiphong_floating_btn vinfast-autohaiphong_floating_zalo" title="Chat qua Zalo" aria-label="Chat qua Zalo">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.03 2 11c0 2.87 1.5 5.43 3.84 7.02l-.99 3.55c-.1.37.26.69.6.53l4.08-1.95C10.23 20.67 11.1 20.8 12 20.8c5.52 0 10-4.03 10-9s-4.48-9-10-9z"/>
        </svg>
    </a>
</div>
