@extends('clients.layouts.app')

@section('title', 'Chính Sách Thanh Toán Tiền Mặt | VinFast Hải Phòng')
@section('meta_description', 'Quy định chi tiết về phương thức thanh toán tiền mặt trực tiếp khi mua xe và đặt cọc tại Đại lý VinFast Minh Đạo Hải Phòng.')
@section('canonical', url('/chinh-sach-thanh-toan'))

@section('content')
<div class="vinfast-autohaiphong_policy_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 36px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            CHÍNH SÁCH THANH TOÁN
        </h1>
        <p style="color: var(--client-color-muted); font-size: 0.95rem;">
            Áp dụng cho khách hàng mua xe ô tô điện và phụ tùng chính hãng tại VinFast Hải Phòng.
        </p>
    </div>
</div>

<div class="vinfast-autohaiphong_policy_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container" style="max-width: 900px;">
        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); line-height: 1.8; color: #334155;">
            
            {{-- Hộp thông báo quan trọng --}}
            <div style="background: #eff6ff; border-left: 4px solid var(--client-color-primary); padding: 16px 20px; border-radius: 4px; margin-bottom: 28px; color: #1e40af;">
                <strong>LƯU Ý QUAN TRỌNG:</strong> Website VinFast Hải Phòng triển khai <strong>phương thức thanh toán tiền mặt duy nhất</strong> tại quầy thu ngân của showroom. Hệ thống trực tuyến chỉ tiếp nhận thông tin giữ chỗ và đặt cọc, tuyệt đối không yêu cầu nhập thông tin thẻ tín dụng hay chuyển khoản qua cổng trung gian thứ ba.
            </div>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 12px;">
                1. Phương Thức Thanh Toán Tiền Mặt Trực Tiếp
            </h2>
            <p>
                Quý khách hàng sau khi xác nhận đơn đặt cọc trực tuyến trên website sẽ được chuyên viên tư vấn liên hệ và gửi giấy hẹn. Khách hàng thực hiện thanh toán tiền mặt trực tiếp tại địa chỉ:
            </p>
            <p style="padding-left: 16px; border-left: 2px solid #cbd5e1; font-weight: 600; color: var(--client-color-heading);">
                Showroom VinFast Minh Đạo — Số 1 Bạch Đằng, Phường Thượng Lý, Quận Hồng Bàng, Thành phố Hải Phòng.
            </p>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 12px;">
                2. Quy Trình Thanh Toán Tiền Mặt Khi Mua Xe
            </h2>
            <ol style="padding-left: 20px; margin-bottom: 20px;">
                <li style="margin-bottom: 8px;">
                    <strong>Bước 1 - Đăng ký giữ xe:</strong> Khách hàng điền thông tin và gửi đơn đặt cọc trên website (hệ thống cấp mã đơn hàng dạng <code>VFHP-YYYYMMDD-XXXX</code>).
                </li>
                <li style="margin-bottom: 8px;">
                    <strong>Bước 2 - Xác nhận lịch hẹn:</strong> Chuyên viên bán hàng gọi điện xác nhận màu xe, phiên bản, giá bán niêm yết và thời gian khách hàng đến showroom.
                </li>
                <li style="margin-bottom: 8px;">
                    <strong>Bước 3 - Nộp tiền và nhận chứng từ:</strong> Khách hàng nộp tiền mặt tại phòng Kế toán - Thu ngân của Showroom Minh Đạo, ký hợp đồng mua bán và nhận Phiếu thu/Hóa đơn GTGT hợp lệ có đóng dấu đỏ của đại lý.
                </li>
                <li style="margin-bottom: 8px;">
                    <strong>Bước 4 - Bàn giao xe:</strong> Tiến hành nghiệm thu xe và bàn giao hồ sơ xe, chìa khóa theo quy trình chuẩn của VinFast Việt Nam.
                </li>
            </ol>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 12px;">
                3. Cam Kết Tính Minh Bạch & An Toàn
            </h2>
            <p>
                Tất cả các khoản tiền mặt thanh toán đều được kiểm đếm bằng máy đếm tiền chuyên dụng trước sự chứng kiến của khách hàng, xuất phiếu thu hợp pháp ngay tại thời điểm giao nhận tiền. Mọi thắc mắc về chứng từ thanh toán, vui lòng liên hệ Hotline CSKH Kinh doanh: <strong>0915 286 503</strong>.
            </p>
        </div>
    </div>
</div>
@endsection

