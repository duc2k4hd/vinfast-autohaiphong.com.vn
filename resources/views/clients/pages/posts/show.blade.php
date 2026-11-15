@extends('clients.layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' | VinFast Hải Phòng')
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content_html), 150))
@section('canonical', url('/blog/' . $post->slug))
@section('og_type', 'article')
@section('og_title', $post->meta_title ?: $post->title)
@section('og_description', $post->meta_description ?: Str::limit(strip_tags($post->content_html), 150))
@section('og_image', $post->thumbnail_path ? asset('storage/' . $post->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png'))

@push('schema')
{{-- Article Schema JSON-LD cho Google News & Search --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $post->title,
    'description' => $post->meta_description ?: Str::limit(strip_tags($post->content_html), 150),
    'image' => [
        $post->thumbnail_path ? asset('storage/' . $post->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
    ],
    'datePublished' => date('c', strtotime($post->published_at ?: $post->created_at)),
    'dateModified' => date('c', strtotime($post->updated_at ?: $post->published_at)),
    'author' => [
        '@type' => 'Organization',
        'name' => 'Ban Biên Tập VinFast Hải Phòng',
        'url' => url('/'),
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'VinFast Hải Phòng',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
        ],
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => url('/blog/' . $post->slug),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>

{{-- BreadcrumbList Schema --}}
@php
    $breadcrumbItems = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Trang chủ',
            'item' => route('client.home'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Tin Tức & Blog',
            'item' => url('/blogs'),
        ],
    ];

    if (!empty($category)) {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $category->name,
            'item' => url('/blogs?category=' . $category->slug),
        ];
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 4,
            'name' => $post->title,
            'item' => url('/blog/' . $post->slug),
        ];
    } else {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $post->title,
            'item' => url('/blog/' . $post->slug),
        ];
    }
@endphp
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $breadcrumbItems,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@push('styles')
<style>
/* ==========================================================================
   GIAO DIỆN BÀI VIẾT PHONG CÁCH TỐI GIẢN, THANH THOÁT (INSPIRED BY CLOUDZONE)
   - Ít margin / padding dư thừa, bố cục gọn gàng.
   - Ít bo tròn (border-radius 4px - 6px sắc sảo).
   - Font chữ 17px thon gọn, thanh mảnh, ít đậm lại, độ tương phản cao, dễ đọc.
   - CSS toàn diện bao phủ toàn bộ các thẻ HTML trong nội dung bài viết (.post-content).
   ========================================================================== */

.post-page-wrap {
    background: #f8fafc;
    min-height: 100vh;
}

.post-breadcrumb-bar {
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    padding: 10px 0;
}

.post-breadcrumb-bar nav {
    font-size: 0.825rem;
    color: #64748b;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
}

.post-breadcrumb-bar a {
    color: #475569;
    text-decoration: none;
    transition: color 0.15s ease;
}

.post-breadcrumb-bar a:hover {
    color: #0284c7;
}

.post-breadcrumb-bar .sep {
    color: #cbd5e1;
}

.post-breadcrumb-bar .current {
    color: #0284c7;
    font-weight: 600;
}

.post-main-container {
    padding: 24px 0 50px 0;
}

.post-layout-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 320px;
    gap: 32px;
    align-items: start;
}

/* Bài viết chính */
.post-article-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 24px 28px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}

.post-cat-badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 700;
    color: #0284c7;
    background: #e0f2fe;
    padding: 3px 10px;
    border-radius: 3px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    text-decoration: none;
    margin-bottom: 10px;
}

.post-cat-badge:hover {
    background: #bae6fd;
}

.post-title {
    font-size: clamp(1.75rem, 2.4vw, 2.2rem);
    font-weight: 700;
    color: #0f172a;
    line-height: 1.32;
    margin: 0 0 12px 0;
    letter-spacing: -0.015em;
}

.post-meta-line {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 0.825rem;
    color: #64748b;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 20px;
}

.post-meta-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.post-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.post-share-row {
    display: flex;
    align-items: center;
    gap: 6px;
}

.post-share-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 3px;
    font-size: 0.8rem;
    color: #ffffff;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: opacity 0.15s ease, transform 0.1s ease;
}

.post-share-btn:hover {
    opacity: 0.88;
    transform: translateY(-1px);
}

.post-share-fb { background: #1877f2; }
.post-share-zalo { background: #0068ff; font-weight: 700; font-size: 0.72rem; }
.post-share-copy { background: #475569; }

.post-featured-figure {
    margin: 0 0 22px 0;
    border-radius: 4px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

.post-featured-figure img {
    display: block;
    width: 100%;
    aspect-ratio: 16 / 9;
    object-fit: cover;
}

.post-lead-excerpt {
    font-size: 1.05rem;
    font-style: italic;
    color: #334155;
    line-height: 1.7;
    background: #f8fafc;
    border-left: 3px solid #0284c7;
    padding: 12px 16px;
    margin-bottom: 22px;
    border-radius: 0 3px 3px 0;
}

/* Mục lục bài viết (Table of Contents) */
.post-toc-widget {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 14px 18px;
    margin-bottom: 26px;
}

.post-toc-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.post-toc-title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 6px;
}

.post-toc-toggle-btn {
    background: none;
    border: none;
    color: #0284c7;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    padding: 2px 6px;
}

.post-toc-list {
    list-style: none;
    padding: 0;
    margin: 10px 0 0 0;
    line-height: 1.75;
    font-size: 0.88rem;
    border-top: 1px dashed #e2e8f0;
    padding-top: 10px;
}

.post-toc-list li {
    margin-bottom: 5px;
}

.post-toc-list a {
    color: #334155;
    text-decoration: none;
    transition: color 0.15s ease;
}

.post-toc-list a:hover {
    color: #0284c7;
    text-decoration: underline;
}

/* ==========================================================================
   CSS TOÀN DIỆN CHO TẤT CẢ CÁC THẺ TRONG NỘI DUNG BÀI VIẾT (.post-content)
   - Text thon gọn, thanh mảnh, ít đậm lại, độ tương phản cao, dễ đọc.
   - Định dạng bảng biểu chuẩn CloudZone (bảng báo giá, thông số).
   ========================================================================== */

.post-content {
    font-size: 1.06rem; /* 17px chuẩn chữ to vừa phải, dễ đọc */
    line-height: 1.82;
    font-weight: 400; /* Thanh mảnh, thon gọn */
    color: #334155;
    letter-spacing: -0.01em;
    word-break: break-word;
}

/* Đoạn văn */
.post-content p {
    margin: 0 0 16px 0;
}

/* Tiêu đề trong bài viết (ít đậm lại, thanh thoát) */
.post-content h1,
.post-content h2,
.post-content h3,
.post-content h4,
.post-content h5,
.post-content h6 {
    color: #0f172a;
    line-height: 1.35;
    scroll-margin-top: 75px;
}

.post-content h1 {
    font-size: 1.6rem;
    font-weight: 700;
    margin: 28px 0 14px 0;
}

.post-content h2 {
    font-size: 1.38rem;
    font-weight: 700;
    margin: 28px 0 12px 0;
    padding-bottom: 6px;
    border-bottom: 1px solid #f1f5f9;
}

.post-content h3 {
    font-size: 1.18rem;
    font-weight: 600;
    color: #1e293b;
    margin: 22px 0 10px 0;
}

.post-content h4 {
    font-size: 1.05rem;
    font-weight: 600;
    color: #334155;
    margin: 18px 0 8px 0;
}

.post-content h5,
.post-content h6 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #475569;
    margin: 14px 0 6px 0;
}

/* Liên kết */
.post-content a {
    color: #0284c7;
    text-decoration: none;
    transition: color 0.15s ease;
}

.post-content a:hover {
    color: #0369a1;
    text-decoration: underline;
}

/* Nhấn mạnh chữ: Giảm độ đậm theo yêu cầu "ít đậm lại" */
.post-content strong,
.post-content b {
    font-weight: 600;
    color: #0f172a;
}

.post-content em,
.post-content i {
    font-style: italic;
}

.post-content u {
    text-decoration: underline;
    text-underline-offset: 3px;
}

.post-content s,
.post-content strike,
.post-content del {
    text-decoration: line-through;
    color: #94a3b8;
}

.post-content ins {
    background: #dcfce7;
    color: #166534;
    text-decoration: none;
    padding: 1px 4px;
    border-radius: 2px;
}

.post-content mark {
    background: #fef08a;
    color: #713f12;
    padding: 2px 6px;
    border-radius: 2px;
}

.post-content small {
    font-size: 0.85em;
    color: #64748b;
}

.post-content sub,
.post-content sup {
    font-size: 75%;
    line-height: 0;
    position: relative;
    vertical-align: baseline;
}

.post-content sub { bottom: -0.25em; }
.post-content sup { top: -0.5em; }

.post-content abbr {
    border-bottom: 1px dotted #94a3b8;
    cursor: help;
    text-decoration: none;
}

.post-content cite {
    font-style: italic;
    color: #64748b;
}

.post-content dfn {
    font-style: italic;
    font-weight: 600;
}

.post-content time {
    font-variant-numeric: tabular-nums;
}

.post-content address {
    font-style: normal;
    margin-bottom: 16px;
    color: #475569;
}

/* Danh sách (Lists) */
.post-content ul {
    list-style: disc;
    padding-left: 22px;
    margin: 0 0 18px 0;
}

.post-content ol {
    list-style: decimal;
    padding-left: 22px;
    margin: 0 0 18px 0;
}

.post-content li {
    margin-bottom: 7px;
    line-height: 1.75;
}

.post-content li > ul,
.post-content li > ol {
    margin: 6px 0 6px 0;
    padding-left: 18px;
}

.post-content dl {
    margin: 0 0 18px 0;
}

.post-content dt {
    font-weight: 600;
    color: #0f172a;
    margin-top: 10px;
}

.post-content dd {
    margin-left: 18px;
    margin-bottom: 8px;
}

/* BẢNG BIỂU (TABLES) — CHUẨN CLOUDZONE DỄ XEM, TỐI ƯU MOBILE */
.post-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 0.92rem;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
    background: #ffffff;
}

.post-content thead {
    background: #f0f7ff;
    border-bottom: 2px solid #bae6fd;
}

.post-content th {
    padding: 10px 14px;
    font-weight: 700;
    color: #0369a1;
    border: 1px solid #e2e8f0;
    font-size: 0.84rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    text-align: left;
}

.post-content td {
    padding: 9px 14px;
    border: 1px solid #e2e8f0;
    color: #334155;
    line-height: 1.55;
    vertical-align: middle;
}

.post-content tbody tr:nth-child(even) {
    background: #f8fafc;
}

.post-content tbody tr:hover {
    background: #f1f5f9;
}

.post-content caption {
    font-weight: 600;
    font-size: 0.88rem;
    color: #475569;
    padding: 8px 12px;
    text-align: left;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-bottom: 0;
    caption-side: top;
}

/* Tự động cuộn ngang nếu bảng quá rộng trên mobile */
.post-content .table-responsive,
.table-scroll-wrap {
    width: 100%;
    overflow-x: auto;
    margin: 20px 0;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    -webkit-overflow-scrolling: touch;
}

.post-content .table-responsive table,
.table-scroll-wrap table {
    margin: 0;
    border: none;
}

/* Trích dẫn (Blockquote) */
.post-content blockquote {
    margin: 20px 0;
    padding: 12px 18px;
    background: #f8fafc;
    border-left: 3px solid #0284c7;
    border-radius: 0 4px 4px 0;
    color: #334155;
    font-style: italic;
}

.post-content blockquote p:last-child {
    margin-bottom: 0;
}

.post-content q {
    quotes: "“" "”" "‘" "’";
}

/* Code & Preformatted */
.post-content code {
    background: #f1f5f9;
    color: #0369a1;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 0.88em;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    border: 1px solid #e2e8f0;
}

.post-content pre {
    background: #0f172a;
    color: #f8fafc;
    padding: 16px 20px;
    border-radius: 4px;
    overflow-x: auto;
    margin: 18px 0;
    font-size: 0.88rem;
    line-height: 1.6;
}

.post-content pre code {
    background: transparent;
    color: inherit;
    padding: 0;
    border: none;
    font-size: inherit;
}

.post-content kbd {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-bottom-width: 2px;
    padding: 2px 6px;
    font-size: 0.82em;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.05);
}

.post-content samp,
.post-content var {
    font-family: monospace;
    color: #0369a1;
}

/* Hình ảnh, Figure & Media */
.post-content img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 18px auto;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
}

.post-content figure {
    margin: 20px 0;
    text-align: center;
}

.post-content figure img {
    margin: 0 auto;
}

.post-content figcaption {
    font-size: 0.84rem;
    color: #64748b;
    margin-top: 6px;
    font-style: italic;
    text-align: center;
}

.post-content picture {
    display: block;
    margin: 18px auto;
}

.post-content video,
.post-content audio,
.post-content iframe,
.post-content embed,
.post-content object {
    max-width: 100%;
    display: block;
    margin: 18px auto;
    border-radius: 4px;
}

/* Phân cách (Horizontal Rule) */
.post-content hr {
    border: 0;
    border-top: 1px solid #e2e8f0;
    margin: 24px 0;
}

/* Details & Summary */
.post-content details {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 12px 16px;
    margin: 16px 0;
}

.post-content summary {
    font-weight: 600;
    cursor: pointer;
    color: #0f172a;
    outline: none;
}

/* Các hộp thông báo CMS (Callouts / Alerts) */
.post-content .alert,
.post-content .callout {
    padding: 12px 16px;
    margin: 18px 0;
    border-radius: 4px;
    font-size: 0.95rem;
    border-left: 3px solid;
}

.post-content .alert-info,
.post-content .callout-info {
    background: #f0f9ff;
    border-color: #0284c7;
    color: #0369a1;
}

.post-content .alert-success,
.post-content .callout-success {
    background: #f0fdf4;
    border-color: #16a34a;
    color: #15803d;
}

.post-content .alert-warning,
.post-content .callout-warning {
    background: #fffbeb;
    border-color: #d97706;
    color: #b45309;
}

/* Khung tư vấn & CTA cuối bài */
.post-author-cta-box {
    margin-top: 32px;
    padding: 20px 22px;
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 4px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}

.post-author-cta-info h4 {
    margin: 0 0 6px 0;
    font-size: 1.05rem;
    font-weight: 700;
    color: #0369a1;
}

.post-author-cta-info p {
    margin: 0;
    font-size: 0.88rem;
    color: #334155;
    line-height: 1.5;
}

.post-author-cta-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

/* CỘT PHẢI (SIDEBAR STICKY) */
.post-sidebar-sticky {
    position: sticky;
    top: 24px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.post-widget {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 18px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}

.post-widget-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: #0f172a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 0 14px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #0284c7;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Widget: Bài viết mới nhất (Tương tự TIN MỚI CloudZone) */
.post-latest-list {
    display: flex;
    flex-direction: column;
}

.post-latest-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
    text-decoration: none;
    transition: background 0.15s ease;
}

.post-latest-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.post-latest-item:first-child {
    padding-top: 0;
}

.post-latest-thumb {
    width: 76px;
    height: 52px;
    border-radius: 3px;
    object-fit: cover;
    flex-shrink: 0;
    border: 1px solid #e2e8f0;
    background: #f1f5f9;
}

.post-latest-info {
    flex: 1;
    min-width: 0;
}

.post-latest-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.35;
    margin: 0 0 4px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.15s ease;
}

.post-latest-item:hover .post-latest-title {
    color: #0284c7;
}

.post-latest-date {
    font-size: 0.74rem;
    color: #94a3b8;
}

/* Widget: Bảng giá xe hot */
.post-car-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 0;
    border-bottom: 1px solid #f1f5f9;
    text-decoration: none;
}

.post-car-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.post-car-name {
    font-size: 0.86rem;
    font-weight: 600;
    color: #1e293b;
}

.post-car-price {
    font-size: 0.82rem;
    font-weight: 700;
    color: #0284c7;
}

/* BÀI VIẾT LIÊN QUAN (GRID 3 CỘT) */
.related-posts-section {
    margin-top: 40px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 24px 28px;
}

.related-section-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #0f172a;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #0284c7;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.related-post-card {
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
}

.related-post-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
    border-color: #bae6fd;
}

.related-post-thumb-wrap {
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #f1f5f9;
    overflow: hidden;
}

.related-post-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-post-body {
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.related-post-date {
    font-size: 0.74rem;
    color: #94a3b8;
    margin-bottom: 6px;
}

.related-post-title {
    font-size: 0.92rem;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.4;
    margin: 0 0 8px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.15s ease;
}

.related-post-card:hover .related-post-title {
    color: #0284c7;
}

.related-post-excerpt {
    font-size: 0.825rem;
    color: #64748b;
    line-height: 1.5;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .post-layout-grid {
        grid-template-columns: 1fr;
        gap: 28px;
    }
    .post-sidebar-sticky {
        position: static;
    }
    .related-posts-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .post-article-box {
        padding: 18px 16px;
    }
    .post-title {
        font-size: 1.45rem;
    }
    .post-content {
        font-size: 1rem;
        line-height: 1.75;
    }
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="post-page-wrap">
    {{-- Thanh Breadcrumb nhỏ gọn, sạch sẽ --}}
    <div class="post-breadcrumb-bar">
        <div class="vinfast-autohaiphong_layout_container">
            <nav aria-label="Breadcrumb">
                <a href="{{ route('client.home') }}">Trang chủ</a>
                <span class="sep">/</span>
                <a href="{{ url('/blogs') }}">Tin Tức & Blog</a>
                @if(!empty($category))
                    <span class="sep">/</span>
                    <a href="{{ url('/blogs?category=' . $category->slug) }}">{{ $category->name }}</a>
                @endif
                <span class="sep">/</span>
                <span class="current" title="{{ $post->title }}">{{ Str::limit($post->title, 45) }}</span>
            </nav>
        </div>
    </div>

    {{-- Khung bài viết chính & Sidebar --}}
    <div class="vinfast-autohaiphong_layout_container post-main-container">
        <div class="post-layout-grid">
            
            {{-- Cột trái: Nội dung bài viết --}}
            <main class="post-main-column">
                <article class="post-article-box">
                    
                    {{-- Danh mục --}}
                    @if(!empty($category))
                        <a href="{{ url('/blogs?category=' . $category->slug) }}" class="post-cat-badge">
                            {{ $category->name }}
                        </a>
                    @else
                        <span class="post-cat-badge">TIN TỨC VINFAST</span>
                    @endif

                    {{-- Tiêu đề H1 --}}
                    <h1 class="post-title">{{ $post->title }}</h1>

                    {{-- Meta info bar & Chia sẻ mạng xã hội --}}
                    <div class="post-meta-line">
                        <div class="post-meta-info">
                            <span class="post-meta-item">
                                📅 {{ date('d/m/Y', strtotime($post->published_at ?: $post->created_at)) }}
                            </span>
                            <span>•</span>
                            <span class="post-meta-item">
                                ✍️ Ban Biên Tập VinFast Hải Phòng
                            </span>
                            <span>•</span>
                            <span class="post-meta-item">
                                ⏱️ ~ {{ max(1, (int) round(str_word_count(strip_tags($post->content_html)) / 200)) }} phút đọc
                            </span>
                        </div>

                        {{-- Nút chia sẻ mạng xã hội --}}
                        <div class="post-share-row" aria-label="Chia sẻ bài viết">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/blog/' . $post->slug)) }}" target="_blank" rel="noopener noreferrer" class="post-share-btn post-share-fb" title="Chia sẻ lên Facebook">
                                f
                            </a>
                            <a href="https://zalo.me/share?url={{ urlencode(url('/blog/' . $post->slug)) }}" target="_blank" rel="noopener noreferrer" class="post-share-btn post-share-zalo" title="Chia sẻ qua Zalo">
                                Z
                            </a>
                            <button type="button" class="post-share-btn post-share-copy" onclick="copyPostLink()" title="Sao chép đường dẫn bài viết">
                                🔗
                            </button>
                        </div>
                    </div>

                    {{-- Ảnh đại diện chính (Featured Image) --}}
                    @if($post->thumbnail_path)
                        <figure class="post-featured-figure">
                            <img src="{{ asset('storage/' . $post->thumbnail_path) }}" 
                                 alt="{{ $post->title }}" 
                                 loading="eager" 
                                 decoding="async"
                                 width="1200" 
                                 height="675">
                        </figure>
                    @endif

                    {{-- Tóm tắt / Sapo --}}
                    @if($post->excerpt)
                        <div class="post-lead-excerpt">
                            {{ $post->excerpt }}
                        </div>
                    @endif

                    {{-- Mục lục bài viết (Table of Contents tự động phát hiện h2, h3) --}}
                    <div id="vf-post-toc-container" class="post-toc-widget" style="display: none;">
                        <div class="post-toc-header" onclick="togglePostToc()">
                            <div class="post-toc-title">
                                📑 MỤC LỤC BÀI VIẾT
                            </div>
                            <button type="button" id="vf-toc-btn" class="post-toc-toggle-btn">[Ẩn]</button>
                        </div>
                        <ol id="vf-post-toc-list" class="post-toc-list"></ol>
                    </div>

                    {{-- Nội dung bài viết với đầy đủ CSS bao phủ toàn bộ thẻ HTML --}}
                    <div class="post-content">
                        {!! $post->content_html !!}
                    </div>

                    {{-- Hộp thông tin Showroom & Kêu gọi hành động CTA --}}
                    <div class="post-author-cta-box">
                        <div class="post-author-cta-info">
                            <h4>ĐẠI LÝ ỦY QUYỀN VINFAST HẢI PHÒNG (3S CHÍNH HÃNG)</h4>
                            <p>
                                📍 <strong>Địa chỉ:</strong> Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng.<br>
                                📞 <strong>Hotline Kinh Doanh:</strong> 0988 302 882 &bull; <strong>Dịch vụ 3S:</strong> 0915 286 506
                            </p>
                        </div>
                        <div class="post-author-cta-actions">
                            <a href="tel:0988302882" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 9px 18px; font-size: 0.88rem; text-decoration: none;">
                                Gọi Tư Vấn Ngay
                            </a>
                            <a href="{{ route('client.catalog.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_neutral" style="padding: 9px 16px; font-size: 0.88rem; text-decoration: none;">
                                Xem Bảng Giá Xe
                            </a>
                        </div>
                    </div>

                </article>

                {{-- Khối Bài Viết Liên Quan (Grid 3 thẻ) --}}
                @if(!empty($relatedPosts) && $relatedPosts->isNotEmpty())
                    <section class="related-posts-section">
                        <h3 class="related-section-title">BÀI VIẾT LIÊN QUAN</h3>
                        <div class="related-posts-grid">
                            @foreach($relatedPosts as $rel)
                                <a href="{{ url('/blog/' . $rel->slug) }}" class="related-post-card">
                                    <div class="related-post-thumb-wrap">
                                        <img src="{{ $rel->thumbnail_path ? asset('storage/' . $rel->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                                             alt="{{ $rel->title }}" 
                                             class="related-post-thumb" 
                                             loading="lazy" 
                                             decoding="async">
                                    </div>
                                    <div class="related-post-body">
                                        <span class="related-post-date">📅 {{ date('d/m/Y', strtotime($rel->published_at)) }}</span>
                                        <h4 class="related-post-title">{{ $rel->title }}</h4>
                                        @if(!empty($rel->excerpt))
                                            <p class="related-post-excerpt">{{ Str::limit($rel->excerpt, 75) }}</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            {{-- Cột phải: Sidebar Sticky (Tin mới nhất + Bảng giá xe + Hỗ trợ showroom) --}}
            <aside class="post-sidebar-column">
                <div class="post-sidebar-sticky">

                    {{-- Widget 1: Bài viết mới nhất (Tương tự tin mới ở CloudZone) --}}
                    @if(!empty($latestPosts) && $latestPosts->isNotEmpty())
                        <div class="post-widget">
                            <h3 class="post-widget-title">
                                <span>TIN MỚI NHẤT</span>
                                <span style="font-size: 0.72rem; color: #0284c7; font-weight: 600;">VINFAST</span>
                            </h3>
                            <div class="post-latest-list">
                                @foreach($latestPosts as $late)
                                    <a href="{{ url('/blog/' . $late->slug) }}" class="post-latest-item">
                                        <img src="{{ $late->thumbnail_path ? asset('storage/' . $late->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                                             alt="{{ $late->title }}" 
                                             class="post-latest-thumb" 
                                             loading="lazy" 
                                             decoding="async">
                                        <div class="post-latest-info">
                                            <h4 class="post-latest-title">{{ $late->title }}</h4>
                                            <span class="post-latest-date">📅 {{ date('d/m/Y', strtotime($late->published_at)) }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Widget 2: Bảng giá các dòng xe ô tô điện VinFast --}}
                    @if(!empty($featuredCars) && $featuredCars->isNotEmpty())
                        <div class="post-widget">
                            <h3 class="post-widget-title">
                                <span>BẢNG GIÁ XE VINFAST</span>
                                <span style="font-size: 0.72rem; color: #16a34a; font-weight: 600;">2026</span>
                            </h3>
                            <div style="display: flex; flex-direction: column;">
                                @foreach($featuredCars as $fcar)
                                    <a href="{{ url('/xe/' . $fcar->slug) }}" class="post-car-item">
                                        <span class="post-car-name">{{ $fcar->name }}</span>
                                        <span class="post-car-price">
                                            @if($fcar->sale_price || $fcar->regular_price)
                                                {{ number_format(($fcar->sale_price ?: $fcar->regular_price) / 1000000, 0, ',', '.') }} triệu
                                            @else
                                                Liên hệ
                                            @endif
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <div style="margin-top: 14px; text-align: center;">
                                <a href="{{ route('client.catalog.index') }}" style="font-size: 0.82rem; color: #0284c7; text-decoration: none; font-weight: 600;">
                                    Xem toàn bộ bảng giá & ưu đãi &rarr;
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Widget 3: Showroom 3S VinFast Hải Phòng --}}
                    <div class="post-widget" style="background: #f0f9ff; border-color: #bae6fd;">
                        <h3 class="post-widget-title" style="border-bottom-color: #0284c7; color: #0369a1;">
                            <span>ĐẠI LÝ VINFAST HẢI PHÒNG</span>
                        </h3>
                        <p style="font-size: 0.84rem; color: #334155; line-height: 1.6; margin: 0 0 12px 0;">
                            📍 Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, TP. Hải Phòng.<br>
                            ⏰ Giờ mở cửa: 07:30 - 18:00 (Cả CN)
                        </p>
                        <div style="font-size: 0.88rem; font-weight: 700; color: #0284c7; margin-bottom: 12px;">
                            📞 Hotline: <a href="tel:0988302882" style="color: #0284c7; text-decoration: none;">0988 302 882</a>
                        </div>
                        <a href="{{ route('client.contact.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="display: block; text-align: center; padding: 9px; font-size: 0.84rem; text-decoration: none;">
                            Đặt Hẹn Showroom & Lái Thử
                        </a>
                    </div>

                </div>
            </aside>

        </div>
    </div>
</div>

{{-- Script tự động sinh mục lục TOC và sao chép liên kết --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Tự động bọc bảng trong wrapper cuộn ngang để không vỡ layout trên mobile
    const postBody = document.querySelector('.post-content');
    if (postBody) {
        const tables = postBody.querySelectorAll('table');
        tables.forEach(function (table) {
            if (!table.parentElement.classList.contains('table-responsive') && !table.parentElement.classList.contains('table-scroll-wrap')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-scroll-wrap';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            }
        });
    }

    // 2. Tự động trích xuất H2, H3 để tạo Mục lục bài viết (Table of Contents)
    const tocWidget = document.getElementById('vf-post-toc-container');
    const tocList = document.getElementById('vf-post-toc-list');

    if (postBody && tocWidget && tocList) {
        const headings = postBody.querySelectorAll('h2, h3');
        if (headings.length >= 2) {
            headings.forEach(function (heading, index) {
                const id = 'section-heading-' + (index + 1);
                heading.id = id;

                const li = document.createElement('li');
                if (heading.tagName.toLowerCase() === 'h3') {
                    li.style.paddingLeft = '18px';
                    li.style.fontSize = '0.84rem';
                    li.style.color = '#64748b';
                }

                const a = document.createElement('a');
                a.href = '#' + id;
                a.textContent = heading.textContent.trim();
                
                li.appendChild(a);
                tocList.appendChild(li);
            });

            tocWidget.style.display = 'block';
        }
    }
});

// Bật/tắt ẩn hiện mục lục
function togglePostToc() {
    const list = document.getElementById('vf-post-toc-list');
    const btn = document.getElementById('vf-toc-btn');
    if (!list || !btn) return;
    
    if (list.style.display === 'none') {
        list.style.display = 'block';
        btn.textContent = '[Ẩn]';
    } else {
        list.style.display = 'none';
        btn.textContent = '[Hiện]';
    }
}

// Sao chép liên kết bài viết vào clipboard
function copyPostLink() {
    navigator.clipboard.writeText(window.location.href).then(function () {
        alert('Đã sao chép liên kết bài viết vào bộ nhớ tạm!');
    }).catch(function () {
        prompt('Sao chép liên kết tại đây:', window.location.href);
    });
}
</script>
@endsection
