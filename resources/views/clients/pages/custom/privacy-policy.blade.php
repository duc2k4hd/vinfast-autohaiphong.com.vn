@extends('clients.layouts.app')

@section('title', 'Chính Sách Bảo Mật Thông Tin | VinFast Hải Phòng')
@section('meta_description', 'Cam kết bảo mật thông tin cá nhân khách hàng theo tiêu chuẩn pháp luật Việt Nam tại Đại lý VinFast Minh Đạo Hải Phòng.')
@section('canonical', url('/chinh-sach-bao-mat'))

@section('content')
<div class="vinfast-autohaiphong_policy_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 36px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            CHÍNH SÁCH BẢO MẬT THÔNG TIN
        </h1>
        <p style="color: var(--client-color-muted); font-size: 0.95rem;">
            Bảo vệ tuyệt đối thông tin khách hàng và tuân thủ các quy định pháp luật về bảo mật dữ liệu.
        </p>
    </div>
</div>

<div class="vinfast-autohaiphong_policy_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container" style="max-width: 900px;">
        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); line-height: 1.8; color: #334155;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 12px;">
                1. Mục Đích Thu Thập Thông Tin
            </h2>
            <p>
                VinFast Hải Phòng chỉ thu thập thông tin cơ bản (Họ tên, Số điện thoại, Email, Nội dung nhu cầu xe) khi Quý khách gửi form báo giá, đặt cọc xe hoặc liên hệ tư vấn nhằm mục đích:
            </p>
            <ul style="padding-left: 20px; margin-bottom: 20px;">
                <li>Hỗ trợ tư vấn chi tiết thông số kỹ thuật, bảng giá lăn bánh và chương trình khuyến mãi.</li>
                <li>Liên hệ xác nhận lịch lái thử và thủ tục thanh toán tiền mặt tại showroom.</li>
                <li>Thực hiện các quyền lợi bảo hành, bảo dưỡng định kỳ và dịch vụ hậu mãi.</li>
            </ul>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 12px;">
                2. Cam Kết Bảo Vệ Dữ Liệu
            </h2>
            <p>
                Chúng tôi tuyệt đối không bán, chia sẻ hoặc chuyển giao thông tin cá nhân của Quý khách cho bất kỳ bên thứ ba nào vì mục đích thương mại khi chưa có sự đồng ý rõ ràng của Quý khách. Mọi dữ liệu lưu trữ đều được bảo vệ bằng các biện pháp kỹ thuật số và phân quyền quản trị nghiêm ngặt.
            </p>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 12px;">
                3. Quyền Của Khách Hàng
            </h2>
            <p>
                Quý khách có quyền yêu cầu tra cứu, điều chỉnh hoặc hủy bỏ thông tin cá nhân của mình trong cơ sở dữ liệu bất kỳ lúc nào bằng cách gọi tới Hotline CSKH: <strong>0915 286 503</strong> hoặc đến trực tiếp Showroom Số 1 Bạch Đằng, Thượng Lý, Hồng Bàng, Hải Phòng.
            </p>
        </div>
    </div>
</div>
@endsection

