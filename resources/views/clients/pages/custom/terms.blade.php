@extends('clients.layouts.app')

@section('title', 'Điều Khoản Sử Dụng | VinFast Hải Phòng')
@section('meta_description', 'Các điều khoản sử dụng và quy định truy cập website VinFast Hải Phòng.')
@section('canonical', url('/dieu-khoan-su-dung'))

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
            'name' => 'Điều Khoản Sử Dụng Website',
            'item' => url('/dieu-khoan-su-dung'),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>

{{-- WebPage Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    'name' => 'Điều Khoản Sử Dụng Website | VinFast Hải Phòng',
    'description' => 'Các điều khoản sử dụng và quy định truy cập website VinFast Hải Phòng.',
    'url' => url('/dieu-khoan-su-dung'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@section('content')
<div class="vinfast-autohaiphong_policy_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 36px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            ĐIỀU KHOẢN SỬ DỤNG WEBSITE
        </h1>
        <p style="color: var(--client-color-muted); font-size: 0.95rem;">
            Quy định chung khi truy cập, tham khảo thông số và đăng ký thông tin tại vinfast-autohaiphong.com.vn.
        </p>
    </div>
</div>

<div class="vinfast-autohaiphong_policy_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container" style="max-width: 900px;">
        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); line-height: 1.8; color: #334155;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 12px;">
                1. Quyền Sở Hữu Trí Tuệ
            </h2>
            <p>
                Toàn bộ nội dung, logo, hình ảnh sản phẩm và thông số kỹ thuật được hiển thị trên website thuộc bản quyền của VinFast Việt Nam và VinFast Hải Phòng. Nghiêm cấm sao chép, tái bản hoặc sử dụng cho mục đích thương mại trái phép khi chưa được sự đồng ý bằng văn bản.
            </p>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 12px;">
                2. Thông Tin Sản Phẩm & Giá Bán
            </h2>
            <p>
                Giá xe, thông số kỹ thuật và các chương trình ưu đãi được cập nhật liên tục theo chính sách của VinFast tại từng thời điểm. Khách hàng vui lòng liên hệ trực tiếp hotline hoặc đến showroom để nhận báo giá chính xác nhất.
            </p>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-top: 24px; margin-bottom: 12px;">
                3. Điều Chỉnh Điều Khoản
            </h2>
            <p>
                VinFast Hải Phòng có quyền cập nhật, bổ sung các điều khoản này theo quy định của pháp luật mà không cần thông báo trước. Việc tiếp tục sử dụng website đồng nghĩa với việc Quý khách chấp thuận các điều khoản sửa đổi.
            </p>
        </div>
    </div>
</div>
@endsection

