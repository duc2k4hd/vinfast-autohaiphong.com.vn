@extends('admin.layouts.app')

@section('title', 'Cấu Hình Cài Đặt Website')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <span>Cài đặt hệ thống</span>
@endsection
@section('header_title', 'CẤU HÌNH THÔNG TIN ĐẠI LÝ VINFAST HẢI PHÒNG')

@section('content')
<div class="vinfast-autohaiphong_admin_card" style="max-width: 900px;">
    <div class="vinfast-autohaiphong_admin_card_title">
        CẤU HÌNH THÔNG TIN LIÊN HỆ & HOẠT ĐỘNG
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Tên Đại Lý</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'VinFast Hải Phòng — Đại Lý Minh Đạo' }}" required 
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Fanpage Facebook</label>
                <input type="url" name="site_facebook" value="{{ $settings['site_facebook'] ?? 'https://www.facebook.com/VinFastMinhDao' }}" required 
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Địa Chỉ Showroom 3S</label>
            <input type="text" name="site_address" value="{{ $settings['site_address'] ?? 'Số 1 Bạch Đằng, Phường Thượng Lý, Quận Hồng Bàng, TP. Hải Phòng' }}" required 
                   style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
        </div>

        {{-- 4 Số Hotline chuyên trách --}}
        <div style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <div style="font-weight: 700; color: var(--admin-heading); margin-bottom: 14px;">HỆ THỐNG ĐƯỜNG DÂY NÓNG CHUYÊN TRÁCH:</div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Hotline Bán Hàng</label>
                    <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '0988 302 882' }}" required 
                           style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Dịch Vụ – Phụ Tùng</label>
                    <input type="text" name="site_phone_service" value="{{ $settings['site_phone_service'] ?? '0915 286 506' }}" required 
                           style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">CSKH Kinh Doanh</label>
                    <input type="text" name="site_phone_cskh_kd" value="{{ $settings['site_phone_cskh_kd'] ?? '0915 286 503' }}" 
                           style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">CSKH Dịch Vụ</label>
                    <input type="text" name="site_phone_cskh_dv" value="{{ $settings['site_phone_cskh_dv'] ?? '0843 714 333' }}" 
                           style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                </div>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Giờ Làm Việc Của Đại Lý</label>
            <input type="text" name="site_hours" value="{{ $settings['site_hours'] ?? 'T2–T7: Dịch vụ 7h50–17h00, KD 7h30–18h00 | CN: KD 7h00–18h00' }}" required 
                   style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
        </div>

        {{-- Khối Cấu Hình SEO & Tìm Kiếm Toàn Trang --}}
        <div style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 20px; margin-bottom: 24px;">
            <div style="font-weight: 700; color: var(--admin-heading); margin-bottom: 6px;">CẤU HÌNH SEO TRANG CHỦ & TÌM KIẾM GOOGLE:</div>
            <p style="font-size: 0.82rem; color: var(--admin-muted); margin: 0 0 16px 0;">
                Thông tin này sẽ hiển thị trên kết quả tìm kiếm Google, Zalo và Facebook khi chia sẻ liên kết trang chủ.
            </p>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Tiêu Đề SEO Trang Chủ (Meta Title)</label>
                <input type="text" name="seo_title" value="{{ $settings['seo_title'] ?? 'VinFast Hải Phòng - Đại lý ủy quyền của VinFast Việt Nam' }}" required 
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem;">
                <span style="font-size: 0.75rem; color: var(--admin-muted);">Khuyến nghị: 50 – 65 ký tự.</span>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Mô Tả SEO Trang Chủ (Meta Description)</label>
                <textarea name="seo_description" rows="3" required 
                          style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem; line-height: 1.5;">{{ $settings['seo_description'] ?? 'VinFast Hải Phòng chuyên phân phối ô tô điện VinFast chính hãng: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9... Giá tốt nhất, hỗ trợ trả góp 80%.' }}</textarea>
                <span style="font-size: 0.75rem; color: var(--admin-muted);">Khuyến nghị: 120 – 160 ký tự.</span>
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Từ Khóa SEO (Keywords)</label>
                <input type="text" name="seo_keywords" value="{{ $settings['seo_keywords'] ?? 'vinfast hải phòng, vinfast minh đạo, vf 3, vf 5, vf 6, vf 7, vf 8, vf 9, giá xe vinfast' }}" 
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem;">
                <span style="font-size: 0.75rem; color: var(--admin-muted);">Các từ khóa cách nhau bởi dấu phẩy.</span>
            </div>
        </div>

        <div style="border-top: 1px solid var(--admin-border); padding-top: 20px;">
            <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 12px 28px; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Lưu Thay Đổi & Xóa Cache Hệ Thống
            </button>
        </div>
    </form>
</div>

<script>
let formIsDirty = false;
const settingsForm = document.querySelector('form[action*="admin/settings"]');
if (settingsForm) {
    settingsForm.addEventListener('input', () => { formIsDirty = true; });
    settingsForm.addEventListener('change', () => { formIsDirty = true; });
    settingsForm.addEventListener('submit', () => { formIsDirty = false; });
}
window.addEventListener('beforeunload', (e) => {
    if (formIsDirty) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>
@endsection

