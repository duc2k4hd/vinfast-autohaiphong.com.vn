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
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'VinFast Hải Phòng' }}" required 
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Fanpage Facebook</label>
                <input type="url" name="site_facebook" value="{{ $settings['site_facebook'] ?? 'https://www.facebook.com/VinFastHaiPhong' }}" required 
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Địa Chỉ Showroom 3S</label>
            <input type="text" name="site_address" value="{{ $settings['site_address'] ?? 'Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng' }}" required 
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
                <input type="text" name="seo_title" value="{{ $settings['seo_title'] ?? 'VinFast Hải Phòng | Khám phá xe, nhận tư vấn' }}" required
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem;">
                <span style="font-size: 0.75rem; color: var(--admin-muted);">Khuyến nghị: 50 – 65 ký tự.</span>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Mô Tả SEO Trang Chủ (Meta Description)</label>
                <textarea name="seo_description" rows="3" required 
                          style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem; line-height: 1.5;">{{ $settings['seo_description'] ?? 'Tìm hiểu các dòng xe điện VinFast, thông số, giá tham khảo và dịch vụ bán hàng, hậu mãi tại VinFast Hải Phòng.' }}</textarea>
                <span style="font-size: 0.75rem; color: var(--admin-muted);">Khuyến nghị: 120 – 160 ký tự.</span>
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Từ Khóa SEO (Keywords)</label>
                <input type="text" name="seo_keywords" value="{{ $settings['seo_keywords'] ?? 'vinfast hải phòng, ô tô điện vinfast hải phòng, showroom vinfast hải phòng, vf 3, vf 5, vf 6, vf 7, vf 8, vf 9, giá xe vinfast' }}" 
                       style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem;">
                <span style="font-size: 0.75rem; color: var(--admin-muted);">Các từ khóa cách nhau bởi dấu phẩy.</span>
            </div>
        </div>

        {{-- Cấu hình trang Pin & Trạm Sạc --}}
        <div style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 20px; margin-bottom: 24px;">
            <div style="font-weight: 700; color: var(--admin-heading); margin-bottom: 6px; font-size: 1rem;">
                CẤU HÌNH HÌNH ẢNH & NỘI DUNG TRANG PIN & TRẠM SẠC (/pin-va-tram-sac):
            </div>
            <p style="font-size: 0.82rem; color: var(--admin-muted); margin: 0 0 16px 0;">
                Tùy chỉnh các hình ảnh minh họa to đẹp, rõ nét và thông tin chính trên trang Pin & Trạm sạc VinFast Hải Phòng.
            </p>

            {{-- 1. Banner Hero --}}
            <div style="margin-bottom: 18px; border-bottom: 1px dashed var(--admin-border); padding-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Ảnh Banner Chính (Hero)</label>
                <input type="hidden" id="charging_hero_banner" name="charging_hero_banner" value="{{ $settings['charging_hero_banner'] ?? '' }}">
                <img id="charging-hero-preview" src="{{ !empty($settings['charging_hero_banner']) ? asset('storage/'.ltrim($settings['charging_hero_banner'], '/')) : asset('storage/clients/assets/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp') }}" alt="Xem trước banner trạm sạc" style="max-width: 100%; max-height: 200px; display: block; margin-bottom: 10px; border-radius: 6px; border: 1px solid var(--admin-border);">
                <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="chooseImageForField('charging_hero_banner', 'charging-hero-preview', 'Chọn ảnh banner trạm sạc')">Chọn ảnh từ thư viện</button>
                <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="clearImageForField('charging_hero_banner', 'charging-hero-preview')">Đặt lại mặc định</button>
            </div>

            {{-- Tiêu đề & Mô tả Hero --}}
            <div style="display: grid; grid-template-columns: 1fr; gap: 14px; margin-bottom: 18px; border-bottom: 1px dashed var(--admin-border); padding-bottom: 16px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Tiêu Đề Đầu Trang (H1)</label>
                    <input type="text" name="charging_hero_title" value="{{ $settings['charging_hero_title'] ?? 'HẠ TẦNG TRẠM SẠC VINFAST HẢI PHÒNG' }}" 
                           style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.88rem;">Mô Tả Giới Thiệu Đầu Trang</label>
                    <textarea name="charging_hero_desc" rows="2" 
                              style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.9rem; line-height: 1.5;">{{ $settings['charging_hero_desc'] ?? 'Hệ thống trạm sạc V-GREEN phủ rộng khắp 14 quận, huyện và các tuyến cao tốc trọng điểm tại Hải Phòng. Tốc độ sạc nhanh vượt trội, công nghệ thông minh và an toàn tối đa cho mọi chuyến hành trình của bạn.' }}</textarea>
                </div>
            </div>

            {{-- 2. Ảnh 4 trạm sạc tiêu biểu --}}
            <div style="margin-bottom: 18px; border-bottom: 1px dashed var(--admin-border); padding-bottom: 16px;">
                <div style="font-weight: 600; color: var(--admin-heading); margin-bottom: 10px; font-size: 0.9rem;">Hình ảnh 4 điểm sạc tiêu biểu tại Hải Phòng:</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">Showroom VinFast Hải Phòng (Lê Hồng Phong)</label>
                        <input type="hidden" id="charging_img_station_minhdao" name="charging_img_station_minhdao" value="{{ $settings['charging_img_station_minhdao'] ?? '' }}">
                        <img id="station-minhdao-preview" src="{{ !empty($settings['charging_img_station_minhdao']) ? asset('storage/'.ltrim($settings['charging_img_station_minhdao'], '/')) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid var(--admin-border);">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="chooseImageForField('charging_img_station_minhdao', 'station-minhdao-preview')">Chọn ảnh</button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="clearImageForField('charging_img_station_minhdao', 'station-minhdao-preview')">Xóa</button>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">Vincom Plaza Imperia (Hồng Bàng)</label>
                        <input type="hidden" id="charging_img_station_imperia" name="charging_img_station_imperia" value="{{ $settings['charging_img_station_imperia'] ?? '' }}">
                        <img id="station-imperia-preview" src="{{ !empty($settings['charging_img_station_imperia']) ? asset('storage/'.ltrim($settings['charging_img_station_imperia'], '/')) : asset('storage/clients/assets/images/posts/huong-dan-su-dung-tram-sac.webp') }}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid var(--admin-border);">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="chooseImageForField('charging_img_station_imperia', 'station-imperia-preview')">Chọn ảnh</button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="clearImageForField('charging_img_station_imperia', 'station-imperia-preview')">Xóa</button>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">Vincom Plaza Lê Thánh Tông (Ngô Quyền)</label>
                        <input type="hidden" id="charging_img_station_lethanh" name="charging_img_station_lethanh" value="{{ $settings['charging_img_station_lethanh'] ?? '' }}">
                        <img id="station-lethanh-preview" src="{{ !empty($settings['charging_img_station_lethanh']) ? asset('storage/'.ltrim($settings['charging_img_station_lethanh'], '/')) : asset('storage/clients/assets/images/products/hinh-anh-vinfast-vf3-eco-text-logo-banner-desktop-450a97ec-5b90-44ed-b9e3-1bed5dcf3875.webp') }}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid var(--admin-border);">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="chooseImageForField('charging_img_station_lethanh', 'station-lethanh-preview')">Chọn ảnh</button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="clearImageForField('charging_img_station_lethanh', 'station-lethanh-preview')">Xóa</button>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">Trạm Dừng Nghỉ Cao Tốc HN - HP (Km 77)</label>
                        <input type="hidden" id="charging_img_station_highway" name="charging_img_station_highway" value="{{ $settings['charging_img_station_highway'] ?? '' }}">
                        <img id="station-highway-preview" src="{{ !empty($settings['charging_img_station_highway']) ? asset('storage/'.ltrim($settings['charging_img_station_highway'], '/')) : asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-anh-bia-chay-cao-toc-desktop-b639c231-5020-4fc1-96ea-4d94244d115f.webp') }}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid var(--admin-border);">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="chooseImageForField('charging_img_station_highway', 'station-highway-preview')">Chọn ảnh</button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="clearImageForField('charging_img_station_highway', 'station-highway-preview')">Xóa</button>
                    </div>
                </div>
            </div>

            {{-- 3. Ảnh minh họa AC vs DC và Pin --}}
            <div>
                <div style="font-weight: 600; color: var(--admin-heading); margin-bottom: 10px; font-size: 0.9rem;">Hình ảnh minh họa sạc AC, DC & Công nghệ pin:</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">Sạc Chậm / Tại Nhà (AC)</label>
                        <input type="hidden" id="charging_img_ac" name="charging_img_ac" value="{{ $settings['charging_img_ac'] ?? '' }}">
                        <img id="ac-preview" src="{{ !empty($settings['charging_img_ac']) ? asset('storage/'.ltrim($settings['charging_img_ac'], '/')) : asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-chay-duong-co-cay-thanh-pho-desktop-30ef62a1-4be2-4208-85ce-2de1d6ab3f7b.webp') }}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid var(--admin-border);">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="chooseImageForField('charging_img_ac', 'ac-preview')">Chọn ảnh</button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="clearImageForField('charging_img_ac', 'ac-preview')">Xóa</button>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">Sạc Siêu Nhanh (DC)</label>
                        <input type="hidden" id="charging_img_dc" name="charging_img_dc" value="{{ $settings['charging_img_dc'] ?? '' }}">
                        <img id="dc-preview" src="{{ !empty($settings['charging_img_dc']) ? asset('storage/'.ltrim($settings['charging_img_dc'], '/')) : asset('storage/clients/assets/images/posts/huong-dan-su-dung-tram-sac.webp') }}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid var(--admin-border);">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="chooseImageForField('charging_img_dc', 'dc-preview')">Chọn ảnh</button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="clearImageForField('charging_img_dc', 'dc-preview')">Xóa</button>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">Bảo Hành Pin & Khung Gầm</label>
                        <input type="hidden" id="charging_img_battery" name="charging_img_battery" value="{{ $settings['charging_img_battery'] ?? '' }}">
                        <img id="battery-preview" src="{{ !empty($settings['charging_img_battery']) ? asset('storage/'.ltrim($settings['charging_img_battery'], '/')) : asset('storage/clients/assets/images/products/o-to-vinfast-1794679825-tkZx.webp') }}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px; margin-bottom: 6px; border: 1px solid var(--admin-border);">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="chooseImageForField('charging_img_battery', 'battery-preview')">Chọn ảnh</button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="padding: 4px 10px; font-size: 0.78rem;" onclick="clearImageForField('charging_img_battery', 'battery-preview')">Xóa</button>
                    </div>
                </div>
            </div>
        </div>

        <div style="border-top: 1px solid var(--admin-border); padding: 20px 0;">
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Ảnh giới thiệu trang ô tô VinFast</label>
            <input type="hidden" id="catalog_intro_image" name="catalog_intro_image" value="{{ $settings['catalog_intro_image'] ?? '' }}">
            <img id="catalog-intro-preview" src="{{ !empty($settings['catalog_intro_image']) ? asset('storage/'.ltrim($settings['catalog_intro_image'], '/')) : '' }}" alt="Xem trước ảnh giới thiệu" style="max-width: 100%; max-height: 220px; display: {{ !empty($settings['catalog_intro_image']) ? 'block' : 'none' }}; margin-bottom: 10px;">
            <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="chooseCatalogIntroImage()">Chọn ảnh từ thư viện</button>
            <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="clearCatalogIntroImage()">Xóa ảnh</button>
            <p style="font-size: 0.8rem; color: var(--admin-muted);">Ảnh hiển thị bên dưới phần giới thiệu trên trang Ô tô VinFast.</p>
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
function chooseImageForField(inputId, previewId, title) {
    window.openMediaManager({
        mode: 'single',
        confirmText: title || 'Chọn ảnh từ thư viện',
        onSelect: function(media) {
            if (!media || !media.path || media.is_video) {
                alert('Vui lòng chọn một hình ảnh hợp lệ.');
                return;
            }
            document.getElementById(inputId).value = media.path;
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = media.url;
                preview.style.display = 'block';
            }
            formIsDirty = true;
        }
    });
}

function clearImageForField(inputId, previewId) {
    document.getElementById(inputId).value = '';
    const preview = document.getElementById(previewId);
    if (preview) {
        preview.style.display = 'none';
    }
    formIsDirty = true;
}

function chooseCatalogIntroImage() {
    chooseImageForField('catalog_intro_image', 'catalog-intro-preview', 'Chọn ảnh giới thiệu');
}

function clearCatalogIntroImage() {
    clearImageForField('catalog_intro_image', 'catalog-intro-preview');
}
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
