@extends('clients.layouts.app')

@section('title', 'Chính Sách Thanh Toán Tiền Mặt & Quy Trình Mua Xe | VinFast Hải Phòng')
@section('meta_description', 'Quy định chi tiết về phương thức thanh toán tiền mặt trực tiếp tại showroom, quy trình 4 bước đặt cọc và nhận xe minh bạch tại VinFast Hải Phòng.')
@section('canonical', url('/chinh-sach-thanh-toan'))

@push('schema')
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
            'name' => 'Chính Sách Thanh Toán',
            'item' => url('/chinh-sach-thanh-toan'),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>

{{-- WebPage Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => 'Chính Sách Thanh Toán Tiền Mặt & Quy Trình Mua Xe | VinFast Hải Phòng',
    'description' => 'Quy định chi tiết về phương thức thanh toán tiền mặt trực tiếp tại showroom, quy trình 4 bước đặt cọc và nhận xe minh bạch tại VinFast Hải Phòng.',
    'url' => url('/chinh-sach-thanh-toan'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@section('content')
{{-- 1. HERO BANNER THANH TOÁN --}}
<section class="vf-policy-hero" style="position: relative; background: #0b1329; color: #ffffff; padding: 50px 0 60px 0; overflow: hidden;">
    <div style="position: absolute; inset: 0; opacity: 0.25; background-image: url('{{ asset('storage/clients/assets/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp') }}'); background-size: cover; background-position: center;"></div>
    <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(11,19,41,0.88) 0%, rgba(15,23,42,0.96) 100%);"></div>

    <div class="vinfast-autohaiphong_layout_container" style="position: relative; z-index: 2;">
        <nav style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 14px;">
            <a href="{{ route('client.home') }}" style="color: #94a3b8; text-decoration: none;">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            <a href="{{ route('client.pages.policies') }}" style="color: #94a3b8; text-decoration: none;">Chính sách</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: #60a5fa; font-weight: 600;">Chính sách thanh toán</span>
        </nav>

        <div style="max-width: 820px;">
            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: rgba(16,185,129,0.2); border: 1px solid rgba(52,211,153,0.3); border-radius: 9999px; font-size: 0.8rem; font-weight: 700; color: #6ee7b7; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px;">
                AN TOÀN • MINH BẠCH • CHÍNH HÃNG
            </span>
            <h1 style="font-size: clamp(1.85rem, 3.2vw, 2.5rem); font-weight: 900; line-height: 1.25; margin-bottom: 14px; color: #ffffff;">
                CHÍNH SÁCH THANH TOÁN
            </h1>
            <p style="font-size: 1rem; line-height: 1.7; color: #cbd5e1; margin-bottom: 24px;">
                Áp dụng cho mọi khách hàng đặt cọc và mua ô tô điện VinFast tại Hải Phòng. Cam kết hình thức thanh toán tiền mặt 100% tại quầy thu ngân Showroom Lê Hồng Phong, bảo mật thông tin và xuất phiếu thu, hóa đơn GTGT đầy đủ dấu đỏ.
            </p>

            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="#quy-trinh-thanh-toan" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 10px 22px; font-size: 0.9rem; text-decoration: none;">
                    Xem Quy Trình 4 Bước Nhận Xe &darr;
                </a>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['site_phone'] ?? '0988302882') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="border-color: rgba(255,255,255,0.4); padding: 10px 20px; font-size: 0.9rem; text-decoration: none;">
                    Hotline Bán Hàng: {{ $settings['site_phone'] ?? '0988 302 882' }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- 2. TABS NAVIGATION --}}
@include('clients.components.policy-tabs', ['activeTab' => 'thanh-toan'])

{{-- 3. NỘI DUNG CHÍNH SÁCH THANH TOÁN --}}
<div class="vinfast-autohaiphong_policy_section" style="padding: 50px 0 70px 0; background: #ffffff;">
    <div class="vinfast-autohaiphong_layout_container" style="max-width: 960px;">
        
        {{-- Hộp thông báo an toàn quan trọng --}}
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-left: 5px solid var(--client-color-primary); padding: 20px 24px; border-radius: 8px; margin-bottom: 36px; line-height: 1.7; color: #1e3a8a;">
            <div style="font-weight: 800; font-size: 1.05rem; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                <span>🛡️</span>
                <span>LƯU Ý AN TOÀN QUAN TRỌNG KHI GIAO DỊCH:</span>
            </div>
            <p style="margin: 0; font-size: 0.95rem;">
                Website VinFast Hải Phòng triển khai <strong>phương thức thanh toán tiền mặt duy nhất</strong> tại phòng Kế toán - Thu ngân của Showroom. Hệ thống trực tuyến chỉ tiếp nhận thông tin giữ chỗ và đặt cọc online miễn phí, <strong>tuyệt đối không yêu cầu nhập thông tin thẻ ngân hàng</strong> hoặc chuyển khoản qua bất kỳ tài khoản cá nhân nào.
            </p>
        </div>

        {{-- Phần 1: Phương thức nộp tiền mặt trực tiếp --}}
        <h2 style="font-size: 1.65rem; font-weight: 800; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 14px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px;">
            1. Phương Thức Thanh Toán Tiền Mặt Trực Tiếp
        </h2>
        <div style="line-height: 1.8; color: #334155; font-size: 0.95rem; margin-bottom: 36px;">
            <p>
                Quý khách hàng sau khi xác nhận đơn đặt cọc trực tuyến trên website sẽ được chuyên viên tư vấn gọi điện xác nhận và gửi giấy hẹn. Khách hàng thực hiện nộp tiền mặt trực tiếp tại địa chỉ showroom chính thức:
            </p>
            <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-left: 4px solid #10b981; padding: 18px 22px; border-radius: 6px; margin: 16px 0;">
                <div style="font-weight: 800; font-size: 1.05rem; color: var(--client-color-heading); margin-bottom: 4px;">
                    📍 Showroom VinFast Hải Phòng
                </div>
                <div style="color: #475569; font-size: 0.95rem;">
                    Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng.
                </div>
                <div style="font-size: 0.85rem; color: var(--client-color-muted); margin-top: 6px;">
                    ⏰ Giờ làm việc phòng Thu ngân: Thứ 2 – Thứ 7 (7h30 – 18h00), Chủ nhật (7h00 – 18h00).
                </div>
            </div>
        </div>

        {{-- Phần 2: Quy trình 4 bước nhận xe (Timeline trực quan) --}}
        <h2 id="quy-trinh-thanh-toan" style="font-size: 1.65rem; font-weight: 800; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 14px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px;">
            2. Quy Trình Thanh Toán Tiền Mặt Khi Mua Xe
        </h2>

        <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin: 28px 0 40px 0;">
            {{-- Bước 1 --}}
            <div style="display: flex; gap: 20px; background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 10px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); align-items: flex-start;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; flex-shrink: 0;">
                    1
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 6px;">
                        Bước 1 - Đăng Ký Giữ Xe Online Miễn Phí
                    </h3>
                    <p style="font-size: 0.92rem; color: #475569; line-height: 1.6; margin: 0;">
                        Khách hàng điền thông tin và gửi đơn đặt cọc trên website (hệ thống tự động cấp mã đơn hàng dạng <code>VFHP-YYYYMMDD-XXXX</code>). Hoàn toàn không mất phí và không phải nhập thẻ thanh toán.
                    </p>
                </div>
            </div>

            {{-- Bước 2 --}}
            <div style="display: flex; gap: 20px; background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 10px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); align-items: flex-start;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; flex-shrink: 0;">
                    2
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 6px;">
                        Bước 2 - Xác Nhận Lịch Hẹn & Chuẩn Bị Hồ Sơ
                    </h3>
                    <p style="font-size: 0.92rem; color: #475569; line-height: 1.6; margin: 0;">
                        Chuyên viên bán hàng gọi điện xác nhận màu xe, phiên bản, giá bán niêm yết, chính sách ưu đãi pin và gửi Giấy hẹn khách hàng đến showroom tại Lê Hồng Phong.
                    </p>
                </div>
            </div>

            {{-- Bước 3 --}}
            <div style="display: flex; gap: 20px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); align-items: flex-start;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #16a34a; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; flex-shrink: 0;">
                    3
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #166534; margin-bottom: 6px;">
                        Bước 3 - Nộp Tiền Mặt & Nhận Chứng Từ Tại Showroom
                    </h3>
                    <p style="font-size: 0.92rem; color: #1e3a8a; line-height: 1.6; margin: 0;">
                        Khách hàng nộp tiền mặt tại phòng Kế toán - Thu ngân của Showroom VinFast Hải Phòng, ký hợp đồng mua bán và nhận Phiếu thu/Hóa đơn GTGT hợp lệ có đóng dấu đỏ của đại lý. Tiền được kiểm đếm minh bạch qua máy đếm tiền tự động.
                    </p>
                </div>
            </div>

            {{-- Bước 4 --}}
            <div style="display: flex; gap: 20px; background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 10px; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); align-items: flex-start;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; flex-shrink: 0;">
                    4
                </div>
                <div>
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 6px;">
                        Bước 4 - Nghiệm Thu Kỹ Thuật (PDI) & Bàn Giao Xe
                    </h3>
                    <p style="font-size: 0.92rem; color: #475569; line-height: 1.6; margin: 0;">
                        Tiến hành nghiệm thu xe và bàn giao hồ sơ xe, chìa khóa theo quy trình chuẩn của VinFast Việt Nam. Hỗ trợ đăng ký bấm biển số Hải Phòng và đăng kiểm hoàn chỉnh.
                    </p>
                </div>
            </div>
        </div>

        {{-- Phần 3: Bảng ước tính tiền cọc các dòng xe --}}
        <h2 style="font-size: 1.65rem; font-weight: 800; color: var(--client-color-heading); margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px;">
            3. Bảng Mức Tiền Đặt Cọc Tiêu Chuẩn Các Dòng Xe
        </h2>
        <div style="overflow-x: auto; border: 1px solid var(--client-color-border); border-radius: 10px; margin-bottom: 36px;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="background: #0f172a; color: #ffffff;">
                        <th style="padding: 14px 18px; font-weight: 700;">Dòng Xe</th>
                        <th style="padding: 14px 18px; font-weight: 700;">Phân Khúc</th>
                        <th style="padding: 14px 18px; font-weight: 700;">Mức Đặt Cọc Tiền Mặt</th>
                        <th style="padding: 14px 18px; font-weight: 700; color: #34d399;">Lệ Phí Trước Bạ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--client-color-border);">
                        <td style="padding: 14px 18px; font-weight: 700;">VinFast VF 3</td>
                        <td style="padding: 14px 18px; color: #475569;">Mini SUV Đô Thị</td>
                        <td style="padding: 14px 18px; font-weight: 700; color: #1e3a8a;">15.000.000 VNĐ</td>
                        <td style="padding: 14px 18px; color: #059669; font-weight: 700;">0 VNĐ (Miễn 100%)</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--client-color-border); background: #f8fafc;">
                        <td style="padding: 14px 18px; font-weight: 700;">VinFast VF 5 Plus</td>
                        <td style="padding: 14px 18px; color: #475569;">A-SUV Đa Dụng</td>
                        <td style="padding: 14px 18px; font-weight: 700; color: #1e3a8a;">20.000.000 VNĐ</td>
                        <td style="padding: 14px 18px; color: #059669; font-weight: 700;">0 VNĐ (Miễn 100%)</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--client-color-border);">
                        <td style="padding: 14px 18px; font-weight: 700;">VinFast VF 6</td>
                        <td style="padding: 14px 18px; color: #475569;">B-SUV Hiện Đại</td>
                        <td style="padding: 14px 18px; font-weight: 700; color: #1e3a8a;">30.000.000 VNĐ</td>
                        <td style="padding: 14px 18px; color: #059669; font-weight: 700;">0 VNĐ (Miễn 100%)</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--client-color-border); background: #f8fafc;">
                        <td style="padding: 14px 18px; font-weight: 700;">VinFast VF 7</td>
                        <td style="padding: 14px 18px; color: #475569;">C-SUV Thể Thao</td>
                        <td style="padding: 14px 18px; font-weight: 700; color: #1e3a8a;">40.000.000 VNĐ</td>
                        <td style="padding: 14px 18px; color: #059669; font-weight: 700;">0 VNĐ (Miễn 100%)</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--client-color-border);">
                        <td style="padding: 14px 18px; font-weight: 700;">VinFast VF 8</td>
                        <td style="padding: 14px 18px; color: #475569;">D-SUV Công Nghệ</td>
                        <td style="padding: 14px 18px; font-weight: 700; color: #1e3a8a;">50.000.000 VNĐ</td>
                        <td style="padding: 14px 18px; color: #059669; font-weight: 700;">0 VNĐ (Miễn 100%)</td>
                    </tr>
                    <tr style="background: #f8fafc;">
                        <td style="padding: 14px 18px; font-weight: 700;">VinFast VF 9</td>
                        <td style="padding: 14px 18px; color: #475569;">E-SUV Full Size VIP</td>
                        <td style="padding: 14px 18px; font-weight: 700; color: #1e3a8a;">50.000.000 VNĐ</td>
                        <td style="padding: 14px 18px; color: #059669; font-weight: 700;">0 VNĐ (Miễn 100%)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Phần 4: Cam kết tính minh bạch & an toàn --}}
        <h2 style="font-size: 1.65rem; font-weight: 800; color: var(--client-color-heading); margin-top: 36px; margin-bottom: 14px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px;">
            4. Cam Kết Tính Minh Bạch & An Toàn
        </h2>
        <div style="line-height: 1.8; color: #334155; font-size: 0.95rem; margin-bottom: 40px;">
            <p>
                Tất cả các khoản tiền mặt thanh toán đều được kiểm đếm bằng máy đếm tiền chuyên dụng trước sự chứng kiến của khách hàng, xuất phiếu thu hợp pháp ngay tại thời điểm giao nhận tiền. Mọi thắc mắc về chứng từ thanh toán, vui lòng liên hệ Hotline CSKH Kinh doanh: <strong>0915 286 503</strong> hoặc hotline Bán hàng <strong>{{ $settings['site_phone'] ?? '0988 302 882' }}</strong>.
            </p>
        </div>

        {{-- Nút Call to Action --}}
        <div style="background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 36px; text-align: center;">
            <h3 style="font-size: 1.35rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
                Bạn Đã Chọn Được Mẫu Xe Ưng Ý?
            </h3>
            <p style="color: var(--client-color-muted); font-size: 0.95rem; margin-bottom: 24px;">
                Đăng ký giữ chỗ online ngay hôm nay để nhận báo giá lăn bánh kèm bộ quà tặng đại lý chính hãng.
            </p>
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('client.catalog.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 12px 28px; text-decoration: none; font-size: 0.95rem;">
                    Khám Phá Các Dòng Xe VinFast &rarr;
                </a>
                <a href="{{ route('client.contact.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="padding: 12px 24px; text-decoration: none; font-size: 0.95rem;">
                    Đặt Lịch Hẹn Đến Showroom
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
