@extends('clients.layouts.app')

@section('title', 'Hạ Tầng Pin & Trạm Sạc VinFast Tại Hải Phòng | Bản Đồ & Bảng Giá Mới Nhất')
@section('meta_description', 'Khám phá mạng lưới trạm sạc xe điện VinFast V-GREEN tại Hải Phòng: Bản đồ các điểm sạc, hình ảnh thực tế, công suất trụ sạc, công cụ ước tính chi phí và chính sách bảo hành pin 8-10 năm.')
@section('canonical', route('client.pages.charging_stations'))

@push('schema')
{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Trang chủ',
            'item' => route('client.home')
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Pin & Trạm Sạc VinFast Hải Phòng',
            'item' => route('client.pages.charging_stations')
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>

{{-- FAQPage Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
        [
            '@type' => 'Question',
            'name' => 'Trạm sạc VinFast tại Hải Phòng có sạc được cho các dòng xe điện khác không?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Hệ thống trạm sạc công cộng V-GREEN được đầu tư phát triển ưu tiên phục vụ hệ sinh thái các dòng ô tô và xe máy điện thương hiệu VinFast trên toàn quốc và tại Hải Phòng.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Sạc xe điện VinFast khi trời mưa bão tại Hải Phòng có an toàn không?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Hoàn toàn an toàn. Súng sạc và cổng nạp xe VinFast đạt chuẩn chống bụi chống nước cao cấp (IP67/IP68), tích hợp mạch cảm biến dòng rò và cơ chế tự ngắt điện an toàn khi tiếp xúc không đảm bảo.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Chính sách bảo hành pin ô tô điện VinFast là bao lâu?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'VinFast bảo hành pin lên đến 10 năm không giới hạn số km cho dòng xe VF 8 và VF 9 (sử dụng cá nhân); 8 năm hoặc 160.000 km cho các dòng VF 3, VF 5, VF 6, VF 7 và VF e34. Cam kết sửa chữa/thay thế miễn phí khi dung lượng pin khả dụng (SOH) giảm dưới 70% trong thời hạn bảo hành.'
            ]
        ],
        [
            '@type' => 'Question',
            'name' => 'Có nên luôn luôn sạc đầy 100% pin xe điện không?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Đối với nhu cầu di chuyển hàng ngày, khuyến nghị duy trì mức pin từ 20% đến 80-90% để tối ưu tuổi thọ cell pin. Bạn chỉ cần sạc đầy 100% trước những hành trình dài.'
            ]
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@push('styles')
<style>
/* ==========================================================================
   CSS CHO TRANG PIN & TRẠM SẠC VINFAST HẢI PHÒNG (VISUAL EDITORIAL THEME)
   ========================================================================== */
.vf-charge-page {
    color: #1e293b;
    background-color: #f8fafc;
    font-family: inherit;
    line-height: 1.6;
}

.vf-charge-container {
    width: 100%;
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px;
}

/* 1. HERO BANNER - CINEMATIC PHOTOGRAPHY */
.vf-charge-hero-cinematic {
    position: relative;
    min-height: 520px;
    display: flex;
    align-items: center;
    color: #ffffff;
    overflow: hidden;
    padding: 80px 0;
}

.vf-charge-hero-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
}

.vf-charge-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(7, 16, 32, 0.95) 0%, rgba(9, 23, 44, 0.85) 50%, rgba(13, 33, 62, 0.5) 100%);
    z-index: 1;
}

.vf-charge-hero-content {
    position: relative;
    z-index: 2;
    max-width: 760px;
}

.vf-charge-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(30, 64, 175, 0.65);
    border: 1px solid rgba(147, 197, 253, 0.4);
    color: #bfdbfe;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: 9999px;
    margin-bottom: 20px;
    backdrop-filter: blur(8px);
}

.vf-charge-hero-content h1 {
    font-size: clamp(2.2rem, 4.2vw, 3.6rem);
    font-weight: 800;
    line-height: 1.15;
    color: #ffffff;
    margin: 0 0 18px 0;
    letter-spacing: -0.025em;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.vf-charge-hero-desc {
    font-size: 1.1rem;
    color: #e2e8f0;
    line-height: 1.7;
    margin: 0 0 32px 0;
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
}

.vf-charge-hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 36px;
}

.vf-charge-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 26px;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s ease;
    cursor: pointer;
    border: 1px solid transparent;
}

.vf-charge-btn-primary {
    background: #1768cf;
    color: #ffffff;
    box-shadow: 0 4px 16px rgba(23, 104, 207, 0.5);
}

.vf-charge-btn-primary:hover {
    background: #0f54b0;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(23, 104, 207, 0.6);
}

.vf-charge-btn-outline {
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.35);
    color: #ffffff;
    backdrop-filter: blur(6px);
}

.vf-charge-btn-outline:hover {
    background: #ffffff;
    color: #0f172a;
    border-color: #ffffff;
    transform: translateY(-2px);
}

.vf-charge-hero-badges {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    padding-top: 24px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.vf-charge-badge-item strong {
    display: block;
    font-size: 1.35rem;
    font-weight: 800;
    color: #60a5fa;
    margin-bottom: 2px;
}

.vf-charge-badge-item span {
    font-size: 0.825rem;
    color: #cbd5e1;
    line-height: 1.4;
}

/* 2. SECTION COMMONS */
.vf-charge-section {
    padding: 70px 0;
}

.vf-charge-section-white {
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}

.vf-charge-sec-header {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 46px auto;
}

.vf-charge-sec-kicker {
    display: inline-block;
    color: #1768cf;
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.vf-charge-sec-title {
    font-size: clamp(1.75rem, 3vw, 2.4rem);
    font-weight: 800;
    color: #0f172a;
    line-height: 1.25;
    margin: 0 0 14px 0;
    letter-spacing: -0.02em;
}

.vf-charge-sec-desc {
    font-size: 1rem;
    color: #64748b;
    margin: 0;
    line-height: 1.7;
}

/* 3. VISUAL STATION SHOWCASE CARDS (RICH IMAGES) */
.vf-visual-station-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
    margin-bottom: 36px;
}

.vf-visual-station-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
}

.vf-visual-station-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 30px rgba(23, 104, 207, 0.12);
    border-color: #93c5fd;
}

.vf-station-photo-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 10;
    background: #0f172a;
    overflow: hidden;
}

.vf-station-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.vf-visual-station-card:hover .vf-station-photo {
    transform: scale(1.05);
}

.vf-station-photo-tag {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(15, 23, 42, 0.85);
    color: #ffffff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    backdrop-filter: blur(4px);
}

.vf-station-info-body {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.vf-station-info-body h3 {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.vf-station-address {
    font-size: 0.84rem;
    color: #64748b;
    line-height: 1.5;
    margin: 0 0 14px 0;
    display: flex;
    gap: 6px;
}

.vf-station-address svg {
    flex-shrink: 0;
    color: #1768cf;
    margin-top: 2px;
}

.vf-station-specs-pill {
    background: #f1f5f9;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #1e3a8a;
    margin: 0;
}

/* Official Map Referral Banner */
.vf-charge-map-banner {
    background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);
    border: 1px solid #bfdbfe;
    border-radius: 16px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
}

.vf-charge-map-content h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1e3a8a;
    margin: 0 0 6px 0;
}

.vf-charge-map-content p {
    font-size: 0.92rem;
    color: #2563eb;
    margin: 0;
    line-height: 1.6;
}

/* 4. CONFIGURATOR CALCULATOR WITH CAR PHOTO */
.vf-calc-visual-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(15, 23, 42, 0.06);
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
}

.vf-calc-main-panel {
    padding: 40px;
}

.vf-car-visual-selector {
    margin-bottom: 28px;
}

.vf-car-visual-selector label {
    display: block;
    font-size: 0.88rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 12px;
}

.vf-car-thumb-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;
}

.vf-car-thumb-btn {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 6px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

.vf-car-thumb-btn img {
    width: 100%;
    max-height: 42px;
    object-fit: contain;
    margin-bottom: 6px;
    transition: transform 0.2s ease;
}

.vf-car-thumb-btn:hover {
    border-color: #93c5fd;
    background: #f0f7ff;
}

.vf-car-thumb-btn:hover img {
    transform: scale(1.08);
}

.vf-car-thumb-btn.active {
    border-color: #1768cf;
    background: #eff6ff;
    box-shadow: 0 4px 12px rgba(23, 104, 207, 0.15);
}

.vf-car-thumb-btn span {
    font-size: 0.75rem;
    font-weight: 800;
    color: #0f172a;
}

.vf-car-thumb-btn small {
    font-size: 0.68rem;
    color: #64748b;
}

.vf-calc-inputs-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}

.vf-calc-field-group {
    display: flex;
    flex-direction: column;
}

.vf-calc-field-group label {
    font-size: 0.825rem;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.vf-calc-field-group input,
.vf-calc-field-group select {
    padding: 11px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.925rem;
    color: #0f172a;
    outline: none;
    transition: all 0.2s ease;
}

.vf-calc-field-group input:focus,
.vf-calc-field-group select:focus {
    border-color: #1768cf;
    box-shadow: 0 0 0 3px rgba(23, 104, 207, 0.15);
}

/* Calculator Summary Side */
.vf-calc-summary-side {
    background: linear-gradient(135deg, #09172a 0%, #0f2b48 100%);
    color: #ffffff;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.vf-calc-active-car-card {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
    padding: 18px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.vf-active-car-photo {
    width: 90px;
    height: 55px;
    object-fit: contain;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}

.vf-calc-active-car-info h4 {
    font-size: 1.1rem;
    font-weight: 800;
    margin: 0 0 4px 0;
    color: #ffffff;
}

.vf-calc-active-car-info p {
    font-size: 0.8rem;
    color: #93c5fd;
    margin: 0;
}

.vf-summary-metrics {
    display: grid;
    gap: 16px;
    margin-bottom: 24px;
}

.vf-metric-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 16px;
}

.vf-metric-card-label {
    font-size: 0.78rem;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}

.vf-metric-card-val {
    font-size: 1.6rem;
    font-weight: 800;
    color: #38bdf8;
    line-height: 1.2;
}

.vf-metric-card-sub {
    font-size: 0.8rem;
    color: #cbd5e1;
    margin-top: 4px;
}

/* 5. VISUAL AC VS DC PHOTO CARDS */
.vf-visual-types-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    margin-bottom: 30px;
}

.vf-visual-type-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
}

.vf-type-photo-wrap {
    width: 100%;
    aspect-ratio: 16 / 9;
    position: relative;
    background: #0f172a;
    overflow: hidden;
}

.vf-type-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vf-type-content-body {
    padding: 30px;
    flex-grow: 1;
}

.vf-type-content-body h3 {
    font-size: 1.3rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 10px 0;
}

.vf-type-content-body p {
    font-size: 0.92rem;
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 20px;
}

.vf-type-features {
    list-style: none;
    padding: 0;
    margin: 0;
    border-top: 1px solid #f1f5f9;
    padding-top: 16px;
}

.vf-type-features li {
    font-size: 0.875rem;
    color: #334155;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.vf-type-features li svg {
    color: #10b981;
    flex-shrink: 0;
}

/* 6. VISUAL STEP BY STEP PHOTO CARDS */
.vf-visual-steps-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.vf-visual-step-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
}

.vf-step-photo-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    background: #0f172a;
    overflow: hidden;
}

.vf-step-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vf-step-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #1768cf;
    color: #ffffff;
    font-weight: 800;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.vf-step-card-body {
    padding: 20px;
}

.vf-step-card-body h3 {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px 0;
}

.vf-step-card-body p {
    font-size: 0.85rem;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}

/* 7. VISUAL BATTERY & WARRANTY SHOWCASE */
.vf-battery-showcase-box {
    background: linear-gradient(135deg, #09172a 0%, #17385c 100%);
    border-radius: 20px;
    overflow: hidden;
    color: #ffffff;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    box-shadow: 0 20px 45px rgba(15, 23, 42, 0.2);
}

.vf-battery-photo-col {
    width: 100%;
    height: 100%;
    min-height: 380px;
    position: relative;
}

.vf-battery-photo-col img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vf-battery-text-col {
    padding: 46px;
}

.vf-battery-text-col h2 {
    font-size: clamp(1.8rem, 3vw, 2.3rem);
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 16px 0;
    line-height: 1.25;
}

.vf-battery-text-col p {
    font-size: 0.95rem;
    color: #cbd5e1;
    line-height: 1.7;
    margin-bottom: 24px;
}

.vf-warranty-badges-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.vf-w-badge-card {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 10px;
    padding: 16px;
}

.vf-w-badge-card strong {
    display: block;
    font-size: 1.15rem;
    font-weight: 800;
    color: #60a5fa;
    margin-bottom: 4px;
}

.vf-w-badge-card span {
    font-size: 0.8rem;
    color: #cbd5e1;
    line-height: 1.4;
}

/* 8. PHOTO GALLERY GRID */
.vf-photo-gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

.vf-gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 4 / 3;
    background: #0f172a;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
}

.vf-gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.vf-gallery-item:hover img {
    transform: scale(1.08);
}

.vf-gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px 14px 10px;
    background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%);
    color: #ffffff;
    font-size: 0.825rem;
    font-weight: 700;
}

/* 9. FAQ ACCORDION */
.vf-faq-list {
    max-width: 860px;
    margin: 0 auto;
}

.vf-faq-item {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 14px;
    overflow: hidden;
}

.vf-faq-item[open] {
    border-color: #93c5fd;
    box-shadow: 0 4px 15px rgba(23, 104, 207, 0.06);
}

.vf-faq-summary {
    padding: 20px 24px;
    font-weight: 800;
    font-size: 1rem;
    color: #0f172a;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    list-style: none;
    user-select: none;
}

.vf-faq-summary::-webkit-details-marker {
    display: none;
}

.vf-faq-summary::after {
    content: '+';
    font-size: 1.4rem;
    color: #1768cf;
    font-weight: 600;
}

.vf-faq-item[open] .vf-faq-summary::after {
    content: '−';
}

.vf-faq-body {
    padding: 0 24px 22px;
    font-size: 0.92rem;
    color: #475569;
    line-height: 1.75;
    border-top: 1px solid #f1f5f9;
    padding-top: 14px;
}

/* 10. CTA BOX */
.vf-charge-cta-box {
    background: linear-gradient(135deg, #09172a 0%, #1e3a8a 100%);
    border-radius: 20px;
    padding: 44px;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    flex-wrap: wrap;
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.18);
}

.vf-charge-cta-content h2 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 8px 0;
}

.vf-charge-cta-content p {
    font-size: 0.98rem;
    color: #cbd5e1;
    margin: 0;
    line-height: 1.6;
}

/* RESPONSIVE BREAKPOINTS */
@media (max-width: 1100px) {
    .vf-visual-station-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .vf-car-thumb-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .vf-visual-steps-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .vf-photo-gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 900px) {
    .vf-calc-visual-box,
    .vf-visual-types-grid,
    .vf-battery-showcase-box {
        grid-template-columns: 1fr;
    }
    .vf-battery-photo-col {
        min-height: 260px;
    }
}

@media (max-width: 640px) {
    .vf-charge-hero-badges {
        grid-template-columns: 1fr;
    }
    .vf-visual-station-grid {
        grid-template-columns: 1fr;
    }
    .vf-calc-inputs-row {
        grid-template-columns: 1fr;
    }
    .vf-car-thumb-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .vf-visual-steps-grid {
        grid-template-columns: 1fr;
    }
    .vf-warranty-badges-row {
        grid-template-columns: 1fr;
    }
    .vf-photo-gallery-grid {
        grid-template-columns: 1fr;
    }
    .vf-calc-main-panel,
    .vf-calc-summary-side,
    .vf-battery-text-col,
    .vf-charge-cta-box {
        padding: 24px;
    }
}
</style>
@endpush

@section('content')
<div class="vf-charge-page">

    {{-- Breadcrumb --}}
    <div style="background-color: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 12px 0;">
        <div class="vf-charge-container">
            <nav style="font-size: 0.85rem; color: #64748b;">
                <a href="{{ route('client.home') }}" style="color: #475569; text-decoration: none;">Trang chủ</a>
                <span style="margin: 0 6px;">/</span>
                <span style="color: #1768cf; font-weight: 600;">Hạ Tầng Pin & Trạm Sạc VinFast</span>
            </nav>
        </div>
    </div>

    {{-- 1. HERO BANNER - CINEMATIC PHOTOGRAPHY --}}
    <section class="vf-charge-hero-cinematic">
        <img class="vf-charge-hero-bg" 
             src="{{ !empty($settings['charging_hero_banner']) ? asset('storage/'.ltrim($settings['charging_hero_banner'], '/')) : asset('storage/clients/assets/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp') }}" 
             alt="Hạ Tầng Trạm Sạc VinFast Hải Phòng" loading="eager">
        <div class="vf-charge-hero-overlay"></div>

        <div class="vf-charge-container">
            <div class="vf-charge-hero-content">
                <span class="vf-charge-eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    VinFast Hải Phòng
                </span>
                <h1>{{ $settings['charging_hero_title'] ?? 'HẠ TẦNG TRẠM SẠC VINFAST HẢI PHÒNG' }}</h1>
                <p class="vf-charge-hero-desc">
                    {{ $settings['charging_hero_desc'] ?? 'Hệ thống trạm sạc V-GREEN phủ rộng khắp 14 quận, huyện và các tuyến cao tốc trọng điểm tại Hải Phòng. Tốc độ sạc nhanh vượt trội, công nghệ thông minh và an toàn tối đa cho mọi chuyến hành trình của bạn.' }}
                </p>
                <div class="vf-charge-hero-actions">
                    <a href="#ban-do-tram-sac" class="vf-charge-btn vf-charge-btn-primary">
                        Xem mạng lưới trạm sạc Hải Phòng
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#uoc-tinh-chi-phi" class="vf-charge-btn vf-charge-btn-outline">
                        Ước tính chi phí sạc
                    </a>
                </div>
                <div class="vf-charge-hero-badges">
                    <div class="vf-charge-badge-item">
                        <strong>14+ Quận / Huyện</strong>
                        <span>Mạng lưới phủ kín nội thành, ngoại thành & cao tốc</span>
                    </div>
                    <div class="vf-charge-badge-item">
                        <strong>Siêu sạc 250 kW</strong>
                        <span>Nạp nhanh DC từ 10% lên 70% chỉ trong 20–30 phút</span>
                    </div>
                    <div class="vf-charge-badge-item">
                        <strong>Bảo hành 8–10 năm</strong>
                        <span>Cam kết pin chính hãng & bảo hành dung lượng SOH > 70%</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. HÌNH ẢNH CÁC ĐIỂM SẠC TIÊU BIỂU TẠI HẢI PHÒNG --}}
    <section class="vf-charge-section" id="ban-do-tram-sac">
        <div class="vf-charge-container">
            <div class="vf-charge-sec-header">
                <span class="vf-charge-sec-kicker">Mạng Lưới Hạ Tầng</span>
                <h2 class="vf-charge-sec-title">Các Điểm Sạc VinFast Tiêu Biểu Tại Hải Phòng</h2>
                <p class="vf-charge-sec-desc">
                    Hệ thống trạm sạc công cộng V-GREEN được đầu tư hiện đại, phân bố tại các showroom chính hãng, trung tâm thương mại Vincom và các trạm dừng nghỉ giao thông huyết mạch tại Hải Phòng.
                </p>
            </div>

            <div class="vf-visual-station-grid">
                {{-- Trạm 1: Showroom VinFast Hải Phòng --}}
                <div class="vf-visual-station-card">
                    <div class="vf-station-photo-wrap">
                        <img class="vf-station-photo" 
                             src="{{ !empty($settings['charging_img_station_minhdao']) ? asset('storage/'.ltrim($settings['charging_img_station_minhdao'], '/')) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                             alt="Showroom VinFast Hải Phòng">
                        <span class="vf-station-photo-tag" style="background: rgba(37, 99, 235, 0.9);">Showroom Chính Hãng</span>
                    </div>
                    <div class="vf-station-info-body">
                        <div>
                            <h3>Showroom VinFast Hải Phòng</h3>
                            <div class="vf-station-address">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng</span>
                            </div>
                        </div>
                        <p class="vf-station-specs-pill">
                            Trụ siêu sạc DC 250kW & DC 60kW, AC 11kW. Phòng chờ tiện nghi 3S.
                        </p>
                    </div>
                </div>

                {{-- Trạm 2: Vincom Imperia --}}
                <div class="vf-visual-station-card">
                    <div class="vf-station-photo-wrap">
                        <img class="vf-station-photo" 
                             src="{{ !empty($settings['charging_img_station_imperia']) ? asset('storage/'.ltrim($settings['charging_img_station_imperia'], '/')) : asset('storage/clients/assets/images/posts/huong-dan-su-dung-tram-sac.webp') }}" 
                             alt="Vincom Plaza Imperia Hải Phòng">
                        <span class="vf-station-photo-tag" style="background: rgba(16, 185, 129, 0.9);">Trung Tâm Thương Mại</span>
                    </div>
                    <div class="vf-station-info-body">
                        <div>
                            <h3>Vincom Plaza Imperia Hải Phòng</h3>
                            <div class="vf-station-address">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>KĐT Vinhomes Imperia, P. Thượng Lý, Q. Hồng Bàng</span>
                            </div>
                        </div>
                        <p class="vf-station-specs-pill">
                            Bãi đỗ xe ngoài trời & tầng hầm. Trụ sạc nhanh DC 60kW & AC 11kW.
                        </p>
                    </div>
                </div>

                {{-- Trạm 3: Vincom Lê Thánh Tông --}}
                <div class="vf-visual-station-card">
                    <div class="vf-station-photo-wrap">
                        <img class="vf-station-photo" 
                             src="{{ !empty($settings['charging_img_station_lethanh']) ? asset('storage/'.ltrim($settings['charging_img_station_lethanh'], '/')) : asset('storage/clients/assets/images/products/hinh-anh-vinfast-vf3-eco-text-logo-banner-desktop-450a97ec-5b90-44ed-b9e3-1bed5dcf3875.webp') }}" 
                             alt="Vincom Plaza Lê Thánh Tông">
                        <span class="vf-station-photo-tag" style="background: rgba(16, 185, 129, 0.9);">Trung Tâm Thành Phố</span>
                    </div>
                    <div class="vf-station-info-body">
                        <div>
                            <h3>Vincom Plaza Lê Thánh Tông</h3>
                            <div class="vf-station-address">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Số 4 Lê Thánh Tông, P. Máy Tơ, Q. Ngô Quyền, TP. Hải Phòng</span>
                            </div>
                        </div>
                        <p class="vf-station-specs-pill">
                            Tầng hầm đỗ xe an toàn, trang bị trụ sạc nhanh DC phục vụ mua sắm & công việc.
                        </p>
                    </div>
                </div>

                {{-- Trạm 4: Cao tốc HN - HP Km 77 --}}
                <div class="vf-visual-station-card">
                    <div class="vf-station-photo-wrap">
                        <img class="vf-station-photo" 
                             src="{{ !empty($settings['charging_img_station_highway']) ? asset('storage/'.ltrim($settings['charging_img_station_highway'], '/')) : asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-anh-bia-chay-cao-toc-desktop-b639c231-5020-4fc1-96ea-4d94244d115f.webp') }}" 
                             alt="Trạm Dừng Nghỉ Cao Tốc Hà Nội - Hải Phòng Km 77">
                        <span class="vf-station-photo-tag" style="background: rgba(217, 119, 6, 0.9);">Cửa Ngõ Cao Tốc</span>
                    </div>
                    <div class="vf-station-info-body">
                        <div>
                            <h3>Trạm Nghỉ Cao Tốc (Km 77)</h3>
                            <div class="vf-station-address">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Km 77, Tuyến Cao tốc Hà Nội - Hải Phòng (cả 2 chiều)</span>
                            </div>
                        </div>
                        <p class="vf-station-specs-pill">
                            Hệ thống trụ siêu sạc công suất lớn 150kW/250kW tiếp năng lượng thần tốc.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Banner Tra Cứu Trực Tiếp --}}
            <div class="vf-charge-map-banner">
                <div class="vf-charge-map-content">
                    <h3>Tra Cứu Bản Đồ & Trụ Sạc Thời Gian Thực</h3>
                    <p>
                        Dữ liệu hệ thống trạm sạc được cập nhật liên tục trên cổng thông tin đối tác hạ tầng <a href="https://vgreen.net/" target="_blank" rel="noopener noreferrer" style="font-weight: 700; color: #1e40af; text-decoration: underline;">https://vgreen.net/</a> và cổng tra cứu chính thức của VinFast.
                    </p>
                </div>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="https://vinfastauto.com/vn/phu-kien-va-dich-vu-khac/he-thong-showroom-va-tram-sac" target="_blank" rel="noopener noreferrer" class="vf-charge-btn vf-charge-btn-primary">
                        Bản đồ trạm sạc VinFast ↗
                    </a>
                    <a href="https://vgreen.net/" target="_blank" rel="noopener noreferrer" class="vf-charge-btn vf-charge-btn-outline" style="color: #1e40af; border-color: #93c5fd; background: #ffffff;">
                        Hạ tầng V-GREEN ↗
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. CÔNG CỤ TƯƠNG TÁC: ƯỚC TÍNH CHI PHÍ VÀ THỜI GIAN SẠC (VỚI HÌNH ẢNH XE) --}}
    <section class="vf-charge-section vf-charge-section-white" id="uoc-tinh-chi-phi">
        <div class="vf-charge-container">
            <div class="vf-charge-sec-header">
                <span class="vf-charge-sec-kicker">Công Cụ Thông Minh</span>
                <h2 class="vf-charge-sec-title">Ước tính chi phí & thời gian sạc xe điện</h2>
                <p class="vf-charge-sec-desc">
                    Chọn nhanh chiếc xe VinFast của bạn để trực quan hóa lượng điện cần nạp, thời gian chờ tương ứng với từng loại trụ và chi phí dự tính.
                </p>
            </div>

            <div class="vf-calc-visual-box">
                {{-- Cột Form cấu hình --}}
                <div class="vf-calc-main-panel">
                    <div class="vf-car-visual-selector">
                        <label>Chọn dòng xe VinFast để xem thông số pin:</label>
                        <div class="vf-car-thumb-grid" id="car-visual-selector">
                            <div class="vf-car-thumb-btn" data-capacity="18.64" data-name="VF 3" data-photo="{{ asset('storage/clients/assets/images/products/vinfast-vf-3.webp') }}">
                                <img src="{{ asset('storage/clients/assets/images/products/vinfast-vf-3.webp') }}" alt="VinFast VF 3">
                                <span>VF 3</span>
                                <small>18.6 kWh</small>
                            </div>
                            <div class="vf-car-thumb-btn active" data-capacity="37.23" data-name="VF 5 Plus" data-photo="{{ asset('storage/clients/assets/images/products/vinfast-vf-5.webp') }}">
                                <img src="{{ asset('storage/clients/assets/images/products/vinfast-vf-5.webp') }}" alt="VinFast VF 5 Plus">
                                <span>VF 5 Plus</span>
                                <small>37.2 kWh</small>
                            </div>
                            <div class="vf-car-thumb-btn" data-capacity="59.6" data-name="VF 6" data-photo="{{ asset('storage/clients/assets/images/products/vinfast-vf-6.webp') }}">
                                <img src="{{ asset('storage/clients/assets/images/products/vinfast-vf-6.webp') }}" alt="VinFast VF 6">
                                <span>VF 6</span>
                                <small>59.6 kWh</small>
                            </div>
                            <div class="vf-car-thumb-btn" data-capacity="75.3" data-name="VF 7" data-photo="{{ asset('storage/clients/assets/images/products/vinfast-vf-7.webp') }}">
                                <img src="{{ asset('storage/clients/assets/images/products/vinfast-vf-7.webp') }}" alt="VinFast VF 7">
                                <span>VF 7</span>
                                <small>75.3 kWh</small>
                            </div>
                            <div class="vf-car-thumb-btn" data-capacity="87.7" data-name="VF 8" data-photo="{{ asset('storage/clients/assets/images/products/vinfast-vf-8.webp') }}">
                                <img src="{{ asset('storage/clients/assets/images/products/vinfast-vf-8.webp') }}" alt="VinFast VF 8">
                                <span>VF 8</span>
                                <small>87.7 kWh</small>
                            </div>
                            <div class="vf-car-thumb-btn" data-capacity="123" data-name="VF 9" data-photo="{{ asset('storage/clients/assets/images/products/vinfast-vf-9.webp') }}">
                                <img src="{{ asset('storage/clients/assets/images/products/vinfast-vf-9.webp') }}" alt="VinFast VF 9">
                                <span>VF 9</span>
                                <small>123 kWh</small>
                            </div>
                        </div>
                    </div>

                    <form id="charge-calculator" onsubmit="return false;">
                        <div class="vf-calc-inputs-row">
                            <div class="vf-calc-field-group">
                                <label for="battery-capacity">Dung lượng pin (kWh)</label>
                                <input type="number" id="battery-capacity" name="battery_capacity" value="37.23" min="5" max="250" step="0.1" required>
                            </div>

                            <div class="vf-calc-field-group">
                                <label for="charger-type">Loại trụ sạc dự kiến</label>
                                <select id="charger-type" name="charger_type">
                                    <option value="7.4">Sạc tại nhà AC 7.4 kW</option>
                                    <option value="11">Sạc chậm công cộng AC 11 kW</option>
                                    <option value="30">Sạc nhanh DC 30 kW</option>
                                    <option value="60" selected>Sạc nhanh DC 60 kW</option>
                                    <option value="150">Siêu sạc DC 150 kW</option>
                                    <option value="250">Siêu sạc DC 250 kW</option>
                                </select>
                            </div>

                            <div class="vf-calc-field-group">
                                <label for="current-charge">Mức pin hiện tại (%)</label>
                                <input type="number" id="current-charge" name="current_charge" value="20" min="0" max="99" required>
                            </div>

                            <div class="vf-calc-field-group">
                                <label for="target-charge">Mức pin mong muốn (%)</label>
                                <input type="number" id="target-charge" name="target_charge" value="80" min="1" max="100" required>
                            </div>

                            <div class="vf-calc-field-group" style="grid-column: 1 / -1;">
                                <label for="energy-price">Đơn giá điện sạc tham khảo (VNĐ / kWh)</label>
                                <input type="number" id="energy-price" name="energy_price" value="3858" min="0" step="1" required>
                                <span style="font-size: 0.76rem; color: #64748b; margin-top: 4px;">Biểu phí tham khảo của V-GREEN (nhập 0 nếu thuộc chương trình ưu đãi miễn phí sạc)</span>
                            </div>
                        </div>

                        <div style="display: flex; gap: 14px; align-items: center;">
                            <button type="button" id="btn-calculate" class="vf-charge-btn vf-charge-btn-primary" style="padding: 12px 28px;">
                                Cập nhật kết quả tính
                            </button>
                            <span id="calc-error" style="color: #dc2626; font-size: 0.85rem; font-weight: 600;" hidden></span>
                        </div>
                    </form>
                </div>

                {{-- Cột Kết quả với ảnh xe --}}
                <div class="vf-calc-summary-side">
                    <div>
                        <div class="vf-calc-active-car-card">
                            <img id="active-car-img" class="vf-active-car-photo" src="{{ asset('storage/clients/assets/images/products/vinfast-vf-5.webp') }}" alt="Xe đang chọn">
                            <div class="vf-calc-active-car-info">
                                <h4 id="active-car-title">VinFast VF 5 Plus</h4>
                                <p id="active-car-range">Nạp từ 20% lên 80%</p>
                            </div>
                        </div>

                        <div class="vf-summary-metrics">
                            <div class="vf-metric-card">
                                <div class="vf-metric-card-label">Điện năng nạp vào pin</div>
                                <div class="vf-metric-card-val" id="result-kwh">22.34 kWh</div>
                                <div class="vf-metric-card-sub">Nạp thêm khoảng 60% pin khả dụng</div>
                            </div>

                            <div class="vf-metric-card">
                                <div class="vf-metric-card-label">Thời gian sạc ước tính</div>
                                <div class="vf-metric-card-val" id="result-time">~ 25 - 30 Phút</div>
                                <div class="vf-metric-card-sub" id="result-charger-name">Trụ sạc nhanh DC 60 kW</div>
                            </div>

                            <div class="vf-metric-card">
                                <div class="vf-metric-card-label">Chi phí nạp điện ước tính</div>
                                <div class="vf-metric-card-val" id="result-cost">86.188 đ</div>
                                <div class="vf-metric-card-sub">Tiết kiệm tới ~65% so với đổ xăng tương đương</div>
                            </div>
                        </div>
                    </div>

                    <div style="font-size: 0.775rem; color: #94a3b8; line-height: 1.5; background: rgba(0, 0, 0, 0.25); padding: 14px; border-radius: 8px; border-left: 3px solid #38bdf8;">
                        Chưa tính hao hụt khi sạc, phí quá giờ/chiếm trụ và chính sách ưu đãi của hãng theo từng thời kỳ. Thuật toán BMS sẽ tự động hạ dòng bảo vệ pin khi pin trên 80%.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. HÌNH ẢNH MINH HỌA SẠC AC VS DC --}}
    <section class="vf-charge-section">
        <div class="vf-charge-container">
            <div class="vf-charge-sec-header">
                <span class="vf-charge-sec-kicker">Công Nghệ & Kịch Bản</span>
                <h2 class="vf-charge-sec-title">Phân Biệt Chuẩn Sạc AC & DC</h2>
                <p class="vf-charge-sec-desc">
                    Lựa chọn phương thức sạc phù hợp giúp bạn tối ưu hóa thời gian, bảo vệ tối đa tuổi thọ cell pin và tiết kiệm chi phí trên mọi hành trình.
                </p>
            </div>

            <div class="vf-visual-types-grid">
                {{-- Sạc AC --}}
                <div class="vf-visual-type-card">
                    <div class="vf-type-photo-wrap">
                        <img class="vf-type-photo" 
                             src="{{ !empty($settings['charging_img_ac']) ? asset('storage/'.ltrim($settings['charging_img_ac'], '/')) : asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-chay-duong-co-cay-thanh-pho-desktop-30ef62a1-4be2-4208-85ce-2de1d6ab3f7b.webp') }}" 
                             alt="Sạc chậm AC tại nhà và cơ quan">
                    </div>
                    <div class="vf-type-content-body">
                        <h3>Sạc Chậm / Tại Nhà (AC 7.4 kW – 11 kW)</h3>
                        <p>
                            Dòng điện xoay chiều được cấp vào xe và chuyển đổi bởi bộ sạc tích hợp (OBC) trong xe. Phương thức sạc lý tưởng cho giấc ngủ đêm tại nhà hoặc đỗ xe tại cơ quan.
                        </p>
                        <ul class="vf-type-features">
                            <li>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <strong>Vị trí:</strong> Bộ sạc treo tường tại nhà, bãi đỗ chung cư, văn phòng làm việc.
                            </li>
                            <li>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <strong>Lợi ích:</strong> Dòng điện êm dịu, bảo vệ độ bền cell pin tối đa, chi phí lắp đặt kinh tế.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Sạc DC --}}
                <div class="vf-visual-type-card">
                    <div class="vf-type-photo-wrap">
                        <img class="vf-type-photo" 
                             src="{{ !empty($settings['charging_img_dc']) ? asset('storage/'.ltrim($settings['charging_img_dc'], '/')) : asset('storage/clients/assets/images/posts/huong-dan-su-dung-tram-sac.webp') }}" 
                             alt="Sạc siêu nhanh DC tại trạm công cộng">
                    </div>
                    <div class="vf-type-content-body">
                        <h3>Sạc Siêu Nhanh (DC 30 kW – 250 kW)</h3>
                        <p>
                            Trụ sạc chuyển đổi dòng điện một chiều công suất lớn nạp thẳng vào khối pin. Nạp từ 10% đến 70% chỉ trong 20–30 phút, đồng hành cùng bạn trên các hành trình xa.
                        </p>
                        <ul class="vf-type-features">
                            <li>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <strong>Vị trí:</strong> Showroom 3S, trạm dừng cao tốc, trung tâm thương mại Vincom.
                            </li>
                            <li>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <strong>Đặc điểm:</strong> BMS thông minh tự điều chỉnh giảm dòng khi pin > 80% để kiểm soát nhiệt độ an toàn.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. HÌNH ẢNH QUY TRÌNH 4 BƯỚC SẠC XE TẠI TRẠM --}}
    <section class="vf-charge-section vf-charge-section-white" id="huong-dan-sac">
        <div class="vf-charge-container">
            <div class="vf-charge-sec-header">
                <span class="vf-charge-sec-kicker">Cẩm Nang Thao Tác</span>
                <h2 class="vf-charge-sec-title">Quy Trình 4 Bước Sạc Xe Tại Trạm Công Cộng</h2>
                <p class="vf-charge-sec-desc">
                    Thao tác tiếp nạp năng lượng cho xe điện VinFast được thiết kế trực quan, dễ dàng và an toàn tuyệt đối ngay cả khi bạn mới sử dụng xe lần đầu.
                </p>
            </div>

            <div class="vf-visual-steps-grid">
                {{-- Bước 1 --}}
                <div class="vf-visual-step-card">
                    <div class="vf-step-photo-wrap">
                        <img class="vf-step-photo" 
                             src="{{ !empty($settings['charging_step1_img']) ? asset('storage/'.ltrim($settings['charging_step1_img'], '/')) : asset('storage/clients/assets/images/products/hinh-anh-vinfast-vf3-ngoai-that-chi-tiet-mau-do-desktop-bc0702f8-4cf6-46bd-90aa-1b88fad9aaee.webp') }}" 
                             alt="Bước 1 Đỗ xe và mở nắp sạc">
                        <span class="vf-step-badge">1</span>
                    </div>
                    <div class="vf-step-card-body">
                        <h3>Đỗ Xe & Mở Cổng Sạc</h3>
                        <p>Tiến vào ô đỗ đúng hướng cổng nạp, về số P, tắt động cơ xe và mở nắp cổng sạc trên xe.</p>
                    </div>
                </div>

                {{-- Bước 2 --}}
                <div class="vf-visual-step-card">
                    <div class="vf-step-photo-wrap">
                        <img class="vf-step-photo" 
                             src="{{ !empty($settings['charging_step2_img']) ? asset('storage/'.ltrim($settings['charging_step2_img'], '/')) : asset('storage/clients/assets/images/posts/huong-dan-su-dung-tram-sac.webp') }}" 
                             alt="Bước 2 Cắm súng sạc">
                        <span class="vf-step-badge">2</span>
                    </div>
                    <div class="vf-step-card-body">
                        <h3>Kết Nối Súng Sạc</h3>
                        <p>Nhấc súng sạc từ trụ, cắm chắc chắn vào cổng sạc trên xe cho tới khi nghe tiếng khóa chốt an toàn.</p>
                    </div>
                </div>

                {{-- Bước 3 --}}
                <div class="vf-visual-step-card">
                    <div class="vf-step-photo-wrap">
                        <img class="vf-step-photo" 
                             src="{{ !empty($settings['charging_step3_img']) ? asset('storage/'.ltrim($settings['charging_step3_img'], '/')) : asset('storage/clients/assets/images/products/noi-that-vinfast-vf3-1794649793-33Uj.webp') }}" 
                             alt="Bước 3 Quét QR kích hoạt">
                        <span class="vf-step-badge">3</span>
                    </div>
                    <div class="vf-step-card-body">
                        <h3>Quét QR Qua App VinFast</h3>
                        <p>Mở ứng dụng VinFast trên điện thoại, quét mã QR trên đầu trụ sạc để bắt đầu phiên tiếp năng lượng.</p>
                    </div>
                </div>

                {{-- Bước 4 --}}
                <div class="vf-visual-step-card">
                    <div class="vf-step-photo-wrap">
                        <img class="vf-step-photo" 
                             src="{{ !empty($settings['charging_step4_img']) ? asset('storage/'.ltrim($settings['charging_step4_img'], '/')) : asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-trai-nghiem-da-ngoai-thien-nhien-desktop-88b3228b-73d5-43a0-9801-404c32307d28.webp') }}" 
                             alt="Bước 4 Hoàn tất và rút súng sạc">
                        <span class="vf-step-badge">4</span>
                    </div>
                    <div class="vf-step-card-body">
                        <h3>Hoàn Tất & Rút Súng Sạc</h3>
                        <p>Bấm dừng sạc trên App hoặc màn hình xe, chờ nhả chốt khóa, rút súng sạc và gài lại vị trí trên trụ.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. HÌNH ẢNH SHOWCASE BẢO HÀNH PIN & KHUNG GẦM --}}
    <section class="vf-charge-section">
        <div class="vf-charge-container">
            <div class="vf-battery-showcase-box">
                <div class="vf-battery-photo-col">
                    <img src="{{ !empty($settings['charging_img_battery']) ? asset('storage/'.ltrim($settings['charging_img_battery'], '/')) : asset('storage/clients/assets/images/products/o-to-vinfast-1794679825-tkZx.webp') }}" 
                         alt="Công nghệ pin xe điện VinFast">
                </div>
                <div class="vf-battery-text-col">
                    <span class="vf-charge-eyebrow" style="background: rgba(56, 189, 248, 0.2); border-color: rgba(56, 189, 248, 0.4); color: #7dd3fc;">Cam Kết Chất Lượng Vượt Trội</span>
                    <h2>Chính Sách Bảo Hành Pin Xe Điện VinFast</h2>
                    <p>
                        VinFast áp dụng thời hạn bảo hành pin dài nhất trên thị trường ô tô Việt Nam, đem lại sự yên tâm tuyệt đối cho chủ sở hữu trong suốt vòng đời sử dụng xe.
                    </p>
                    <div class="vf-warranty-badges-row">
                        <div class="vf-w-badge-card">
                            <strong>10 Năm / Không Giới Hạn Km</strong>
                            <span>Áp dụng cho dòng xe cao cấp VF 8 & VF 9 (sử dụng cá nhân)</span>
                        </div>
                        <div class="vf-w-badge-card">
                            <strong>8 Năm / 160.000 Km</strong>
                            <span>Áp dụng cho các dòng thông minh VF 3, VF 5, VF 6, VF 7</span>
                        </div>
                        <div class="vf-w-badge-card" style="grid-column: 1 / -1;">
                            <strong>Cam Kết Dung Lượng SOH > 70%</strong>
                            <span>Sửa chữa hoặc đổi mới khối pin hoàn toàn miễn phí khi dung lượng pin khả dụng sụt dưới 70% do lỗi nhà sản xuất trong thời hạn bảo hành.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 7. BỘ SƯU TẬP HÌNH ẢNH XE ĐIỆN VINFAST TẠI HẢI PHÒNG --}}
    <section class="vf-charge-section vf-charge-section-white">
        <div class="vf-charge-container">
            <div class="vf-charge-sec-header">
                <span class="vf-charge-sec-kicker">Hình Ảnh Thực Tế</span>
                <h2 class="vf-charge-sec-title">Hệ Sinh Thái Xe Điện & Trạm Sạc Hải Phòng</h2>
                <p class="vf-charge-sec-desc">
                    Những hình ảnh sống động của các dòng ô tô điện VinFast trên các cung đường thành phố cảng và các trạm tiếp năng lượng hiện đại.
                </p>
            </div>

            <div class="vf-photo-gallery-grid">
                <div class="vf-gallery-item">
                    <img src="{{ asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-chay-duong-co-cay-thanh-pho-desktop-30ef62a1-4be2-4208-85ce-2de1d6ab3f7b.webp') }}" alt="VinFast trong đô thị Hải Phòng">
                    <div class="vf-gallery-caption">Di chuyển linh hoạt trong đô thị Hải Phòng</div>
                </div>
                <div class="vf-gallery-item">
                    <img src="{{ asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-trai-nghiem-da-ngoai-thien-nhien-desktop-88b3228b-73d5-43a0-9801-404c32307d28.webp') }}" alt="VinFast dã ngoại thiên nhiên">
                    <div class="vf-gallery-caption">Hành trình xanh dã ngoại ngoại thành Hải Phòng</div>
                </div>
                <div class="vf-gallery-item">
                    <img src="{{ asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-anh-bia-chay-cao-toc-desktop-b639c231-5020-4fc1-96ea-4d94244d115f.webp') }}" alt="VinFast trên cao tốc Hà Nội - Hải Phòng">
                    <div class="vf-gallery-caption">Vận hành êm ái trên cao tốc Hà Nội - Hải Phòng</div>
                </div>
                <div class="vf-gallery-item">
                    <img src="{{ asset('storage/clients/assets/images/posts/chinh-sach-mien-phi-sac-pin.webp') }}" alt="Chính sách sạc pin xe điện VinFast">
                    <div class="vf-gallery-caption">Hạ tầng trạm sạc V-GREEN chuẩn an toàn quốc tế</div>
                </div>
            </div>
        </div>
    </section>

    {{-- 8. CÂU HỎI THƯỜNG GẶP (FAQ ACCORDION) --}}
    <section class="vf-charge-section">
        <div class="vf-charge-container">
            <div class="vf-charge-sec-header">
                <span class="vf-charge-sec-kicker">Hỏi Đáp Nhanh</span>
                <h2 class="vf-charge-sec-title">Các Câu Hỏi Thường Gặp Về Trạm Sạc & Pin</h2>
                <p class="vf-charge-sec-desc">
                    Giải đáp chi tiết các băn khoăn của khách hàng khi sở hữu và sử dụng xe điện VinFast tại Hải Phòng.
                </p>
            </div>

            <div class="vf-faq-list">
                <details class="vf-faq-item" open>
                    <summary class="vf-faq-summary">Trời mưa bão, ngập lụt tại Hải Phòng sạc xe điện ngoài trời có an toàn không?</summary>
                    <div class="vf-faq-body">
                        Hoàn toàn an toàn. Hệ thống súng sạc và cổng nạp điện trên xe VinFast đều đạt tiêu chuẩn kháng nước chống bụi IP67/IP68 cao cấp. Trước khi dòng điện được kích hoạt, hệ thống sẽ thực hiện quá trình bắt tay điện tử (handshake) để kiểm tra cách điện. Nếu phát hiện rò rỉ hoặc ẩm ướt bất thường, nguồn điện sẽ không được cấp.
                    </div>
                </details>

                <details class="vf-faq-item">
                    <summary class="vf-faq-summary">Trạm sạc VinFast tại Hải Phòng có sạc được cho các dòng xe điện hãng khác không?</summary>
                    <div class="vf-faq-body">
                        Hệ thống trạm sạc công cộng do V-GREEN vận hành được xây dựng riêng biệt nhằm tối ưu hóa công suất và phục vụ độc quyền cho các dòng xe ô tô, xe máy điện của thương hiệu VinFast.
                    </div>
                </details>

                <details class="vf-faq-item">
                    <summary class="vf-faq-summary">Có nên luôn luôn sạc đầy 100% pin xe điện không?</summary>
                    <div class="vf-faq-body">
                        Đối với nhu cầu di chuyển trong đô thị hàng ngày, bạn nên duy trì mức pin trong khoảng 20% đến 80-90% để tối ưu hóa tuổi thọ cell pin. Bạn chỉ cần nạp đầy 100% khi chuẩn bị khởi hành cho những hành trình xa liên tỉnh.
                    </div>
                </details>

                <details class="vf-faq-item">
                    <summary class="vf-faq-summary">Chi phí sạc xe điện VinFast so với đổ xăng tiết kiệm như thế nào?</summary>
                    <div class="vf-faq-body">
                        Với đơn giá sạc công cộng khoảng 3.858 đ/kWh (hoặc 0 đồng trong các chương trình khuyến mại của hãng), chi phí năng lượng cho xe điện VinFast chỉ khoảng 400 - 600 đ/km. So với xe xăng cùng phân khúc tiêu hao khoảng 1.600 - 2.200 đ/km, xe điện giúp tiết kiệm tới 65% - 75% chi phí vận hành hàng tháng.
                    </div>
                </details>

                <details class="vf-faq-item">
                    <summary class="vf-faq-summary">Khi gặp sự cố hết pin hoặc lỗi trạm sạc tại Hải Phòng, tôi cần liên hệ ai?</summary>
                    <div class="vf-faq-body">
                        Quý khách có thể bấm gọi trực tiếp Hotline Cứu hộ dịch vụ Showroom VinFast Hải Phòng qua số <strong>{{ $settings['site_phone_service'] ?? '0915 286 506' }}</strong> hoặc Tổng đài Chăm sóc khách hàng VinFast toàn quốc <strong>1900 23 23 89</strong> để được hỗ trợ xe cứu hộ pin cơ động 24/7.
                    </div>
                </details>
            </div>
        </div>
    </section>

    {{-- 9. CALL TO ACTION CUỐI TRANG --}}
    <section class="vf-charge-section" style="padding-top: 0;">
        <div class="vf-charge-container">
            <div class="vf-charge-cta-box">
                <div class="vf-charge-cta-content">
                    <h2>Đồng Hành Cùng Bạn Trên Hành Trình Xanh</h2>
                    <p>
                        Liên hệ Showroom VinFast Hải Phòng để được tư vấn các giải pháp sạc tại nhà, đăng ký lái thử các dòng ô tô điện VinFast mới nhất.
                    </p>
                </div>
                <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                    <a href="{{ route('client.contact.index') }}" class="vf-charge-btn vf-charge-btn-primary" style="background: #ffffff; color: #0f172a; border-color: #ffffff;">
                        Liên hệ tư vấn lắp sạc
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['site_phone_service'] ?? '0915286506') }}" class="vf-charge-btn vf-charge-btn-outline">
                        Hotline: {{ $settings['site_phone_service'] ?? '0915 286 506' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Quản lý Presets dòng xe với hình ảnh
    const carThumbButtons = document.querySelectorAll('#car-visual-selector .vf-car-thumb-btn');
    const batteryCapacityInput = document.getElementById('battery-capacity');
    const activeCarImg = document.getElementById('active-car-img');
    const activeCarTitle = document.getElementById('active-car-title');
    const activeCarRange = document.getElementById('active-car-range');

    let currentCarName = 'VinFast VF 5 Plus';

    carThumbButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            carThumbButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            batteryCapacityInput.value = this.dataset.capacity;
            currentCarName = 'VinFast ' + this.dataset.name;
            if (activeCarImg && this.dataset.photo) {
                activeCarImg.src = this.dataset.photo;
            }
            if (activeCarTitle) {
                activeCarTitle.textContent = currentCarName;
            }
            calculateCharging();
        });
    });

    batteryCapacityInput.addEventListener('input', function () {
        carThumbButtons.forEach(b => b.classList.remove('active'));
        currentCarName = 'Xe tùy chỉnh (' + this.value + ' kWh)';
        if (activeCarTitle) {
            activeCarTitle.textContent = currentCarName;
        }
        calculateCharging();
    });

    // 2. Logic tính toán sạc
    const currentChargeInput = document.getElementById('current-charge');
    const targetChargeInput = document.getElementById('target-charge');
    const chargerTypeSelect = document.getElementById('charger-type');
    const energyPriceInput = document.getElementById('energy-price');
    const btnCalculate = document.getElementById('btn-calculate');
    const calcError = document.getElementById('calc-error');

    const resultKwh = document.getElementById('result-kwh');
    const resultTime = document.getElementById('result-time');
    const resultCost = document.getElementById('result-cost');
    const resultChargerName = document.getElementById('result-charger-name');

    function calculateCharging() {
        const capacity = parseFloat(batteryCapacityInput.value) || 0;
        const current = parseFloat(currentChargeInput.value) || 0;
        const target = parseFloat(targetChargeInput.value) || 0;
        const chargerPower = parseFloat(chargerTypeSelect.value) || 60;
        const price = parseFloat(energyPriceInput.value) || 0;

        if (current < 0 || current > 99 || target <= current || target > 100) {
            calcError.textContent = 'Mức pin mong muốn phải lớn hơn mức pin hiện tại (0 - 100%).';
            calcError.hidden = false;
            return;
        }

        calcError.hidden = true;

        // Tính kWh cần nạp
        const diffPercent = (target - current) / 100;
        const energyKwh = capacity * diffPercent;

        // Tính thời gian sạc ước tính (giờ)
        let effectivePower = chargerPower;
        if (target > 80) {
            effectivePower = chargerPower * 0.75;
        }
        const hours = energyKwh / (effectivePower * 0.9);
        const totalMinutes = Math.round(hours * 60);

        let timeStr = '';
        if (totalMinutes < 60) {
            timeStr = '~ ' + totalMinutes + ' Phút';
        } else {
            const h = Math.floor(totalMinutes / 60);
            const m = totalMinutes % 60;
            timeStr = '~ ' + h + ' Giờ ' + (m > 0 ? m + ' Phút' : '');
        }

        // Tính chi phí
        const totalCost = Math.round(energyKwh * price);

        // Hiển thị kết quả
        const nf = new Intl.NumberFormat('vi-VN');
        resultKwh.textContent = nf.format(energyKwh.toFixed(2)) + ' kWh';
        resultTime.textContent = timeStr;
        resultCost.textContent = nf.format(totalCost) + ' đ';

        if (activeCarRange) {
            activeCarRange.textContent = 'Sạc từ ' + current + '% lên ' + target + '%';
        }

        const selectedOptionText = chargerTypeSelect.options[chargerTypeSelect.selectedIndex].text;
        resultChargerName.textContent = selectedOptionText;
    }

    [currentChargeInput, targetChargeInput, chargerTypeSelect, energyPriceInput].forEach(el => {
        el.addEventListener('input', calculateCharging);
        el.addEventListener('change', calculateCharging);
    });

    btnCalculate.addEventListener('click', calculateCharging);

    // Tính toán ban đầu
    calculateCharging();
});
</script>
@endpush
