@extends('admin.layouts.app')

@php
    $isCreate = $isCreate ?? empty($product->id);
    $pageTitle = $isCreate ? 'Thêm Mới Dòng Xe Ô Tô' : 'Chỉnh Sửa Dòng Xe ' . $product->name;
    $formAction = $isCreate ? route('admin.products.store') : route('admin.products.update', $product->id);
@endphp

@section('title', $pageTitle)
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <a href="{{ route('admin.products.index') }}" style="color: var(--admin-muted);">Dòng xe</a> &rsaquo; 
    <span>{{ $isCreate ? 'Thêm mới' : $product->name }}</span>
@endsection
@section('header_title', $isCreate ? 'THÊM MỚI DÒNG XE Ô TÔ VINFAST' : 'QUẢN LÝ DÒNG XE & CẤU HÌNH CHI TIẾT')

@push('styles')
<style>
    /* Admin Product Form Styling & Layout */
    .vf-admin-section-grid {
        display: grid;
        gap: 24px;
        margin-bottom: 24px;
    }
    .vf-admin-grid-top {
        grid-template-columns: minmax(360px, 1.15fr) minmax(420px, 1.85fr);
    }
    .vf-admin-grid-middle {
        grid-template-columns: minmax(360px, 1.15fr) minmax(420px, 1.85fr);
    }
    @media (max-width: 1024px) {
        .vf-admin-grid-top,
        .vf-admin-grid-middle {
            grid-template-columns: 1fr;
        }
    }
    .vf-admin-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        border-bottom: 1px solid var(--admin-border);
        padding-bottom: 12px;
        margin-bottom: 18px;
    }
    .vf-admin-card-title-text {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--admin-heading);
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .vf-admin-card-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 12px;
        background: #eff6ff;
        color: var(--admin-primary);
        border: 1px solid #bfdbfe;
    }
    .vf-admin-input-group {
        margin-bottom: 16px;
    }
    .vf-admin-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--admin-text);
        margin-bottom: 6px;
    }
    .vf-admin-input, .vf-admin-select, .vf-admin-textarea {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid var(--admin-border);
        border-radius: 6px;
        font-size: 0.88rem;
        font-family: inherit;
        color: var(--admin-text);
        background: #ffffff;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .vf-admin-input:focus, .vf-admin-select:focus, .vf-admin-textarea:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(20, 100, 244, 0.12);
        outline: none;
    }
    .vf-admin-helper-text {
        font-size: 0.75rem;
        color: var(--admin-muted);
        margin-top: 4px;
        line-height: 1.4;
    }

    /* Box Bài Viết Giới Thiệu */
    #bai-viet-gioi-thieu {
        margin-bottom: 24px;
        position: relative;
    }
    .vf-admin-editor-sticky-header {
        position: relative;
        background: #ffffff;
        margin: -24px -24px 14px -24px;
        padding: 16px 24px 12px 24px;
        border-bottom: 1px solid var(--admin-border);
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    #bai-viet-gioi-thieu .tox-tinymce {
        height: calc(100vh - 90px) !important;
        min-height: 550px !important;
        border-radius: 6px;
        border: 1px solid var(--admin-border);
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
    }
    #bai-viet-gioi-thieu .tox-editor-header {
        flex-shrink: 0 !important;
        background: #ffffff !important;
        border-bottom: 1px solid var(--admin-border) !important;
        z-index: 2 !important;
    }
    #bai-viet-gioi-thieu .tox-editor-container {
        flex: 1 1 auto !important;
        display: flex !important;
        flex-direction: column !important;
        min-height: 0 !important;
        overflow: hidden !important;
    }
    #bai-viet-gioi-thieu .tox-sidebar-wrap {
        flex: 1 1 auto !important;
        display: flex !important;
        flex-direction: column !important;
        min-height: 0 !important;
        overflow: hidden !important;
    }
    #bai-viet-gioi-thieu .tox-edit-area {
        flex: 1 1 auto !important;
        display: flex !important;
        flex-direction: column !important;
        min-height: 0 !important;
        overflow: hidden !important;
    }
    #bai-viet-gioi-thieu .tox-edit-area iframe {
        flex: 1 1 auto !important;
        height: 100% !important;
        width: 100% !important;
        min-height: 0 !important;
        border: 0 !important;
    }
    #bai-viet-gioi-thieu .tox-statusbar {
        flex-shrink: 0 !important;
        border-top: 1px solid var(--admin-border) !important;
    }

    /* Fixed Bottom Action Bar */
    .vf-admin-bottom-bar-spacer {
        height: 80px;
    }
    .vf-admin-fixed-bottom-bar {
        position: fixed;
        bottom: 0;
        right: 0;
        left: 250px;
        height: 68px;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid #cbd5e1;
        box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
        z-index: 1000;
        gap: 16px;
    }
    @media (max-width: 860px) {
        .vf-admin-fixed-bottom-bar {
            left: 0;
            padding: 0 16px;
        }
    }
    .vf-admin-bottom-status {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.85rem;
    }
    .vf-admin-bottom-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Quick Anchor Nav - Gọn gàng, chuyên nghiệp, không thanh scroll, ít bo tròn, ít padding */
    .vf-admin-quick-nav {
        position: sticky;
        top: 0;
        z-index: 50;
        display: flex;
        gap: 6px;
        align-items: center;
        overflow-x: auto;
        padding: 7px 20px;
        margin: -6px -28px 16px -28px;
        background: #ffffff;
        border-bottom: 1px solid var(--admin-border);
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        
        /* Ẩn hoàn toàn thanh cuộn ngang */
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .vf-admin-quick-nav::-webkit-scrollbar {
        display: none;
        width: 0;
        height: 0;
    }
    .vf-admin-quick-nav-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 9px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        font-size: 0.77rem;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.12s ease;
        line-height: 1.25;
    }
    .vf-admin-quick-nav-pill:hover {
        background: #f1f5f9;
        color: var(--admin-primary);
        border-color: #cbd5e1;
    }
    .vf-admin-quick-nav-pill.active {
        background: var(--admin-primary);
        color: #ffffff;
        border-color: var(--admin-primary);
        box-shadow: 0 1px 3px rgba(20, 100, 244, 0.25);
    }
    .vf-admin-quick-nav-pill.active span {
        color: #ffffff;
    }
    .vf-admin-quick-nav-pill .vf-admin-card-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 1px 5px;
        border-radius: 3px;
        line-height: 1.1;
        background: #e2e8f0;
        color: #475569;
        border: none;
    }
    .vf-admin-quick-nav-pill:hover .vf-admin-card-badge {
        background: #dbeafe;
        color: #1e40af;
    }
    .vf-admin-quick-nav-pill.active .vf-admin-card-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        border: none;
    }

    /* Scroll Margin for smooth jump navigation */
    html {
        scroll-behavior: smooth;
    }
    .vinfast-autohaiphong_admin_card,
    .vf-admin-section-grid {
        scroll-margin-top: 55px;
    }

    /* Preview items */
    .vf-admin-preset-btn {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 3px 8px;
        font-size: 0.72rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .vf-admin-preset-btn:hover {
        background: var(--admin-primary);
        color: #ffffff;
        border-color: var(--admin-primary);
    }

/* Product specification editor */
.vf-spec-help { margin: 2px 0 14px; line-height: 1.5; }
.vf-spec-toolbar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 16px; }
.vf-spec-toolbar .vf-admin-input { min-width: 0; height: 36px; font-size: 0.83rem; }
.vf-spec-search { flex: 1 1 210px; }
.vf-spec-control { display: flex; flex: 1 1 270px; gap: 6px; min-width: 0; }
.vf-spec-control .vf-admin-input { flex: 1; width: 1px; }
.vf-spec-toolbar .vf-spec-action, .vf-spec-add-row { white-space: nowrap; padding: 7px 10px; font-size: 0.8rem; }
.spec-section { border: 1px solid var(--admin-border); border-radius: 8px; margin-bottom: 10px; overflow: visible; }
.vf-spec-section-header { display: flex; justify-content: space-between; align-items: center; gap: 8px; padding: 9px 12px; background: #f8fafc; border-radius: 8px 8px 0 0; }
.spec-section-title { font-size: 0.88rem; color: #334155; }
.spec-section-rows { padding: 4px 12px; }
.spec-section-rows:empty { padding: 0; }
.spec-row { display: flex; align-items: center; gap: 8px; padding: 6px 0; }
.spec-row + .spec-row { border-top: 1px solid #f1f5f9; }
.spec-row > .vf-admin-input { min-width: 0; height: 36px; font-size: 0.83rem; }
.spec-key-input { flex: 1; }
.spec-val-input { flex: 1.3; }
.vf-spec-move { position: relative; flex: none; font-size: 0.8rem; }
.vf-spec-move summary { cursor: pointer; color: #475569; white-space: nowrap; padding: 7px; border-radius: 5px; }
.vf-spec-move summary:hover { background: #f1f5f9; }
.vf-spec-move label { position: absolute; z-index: 5; right: 0; top: 100%; width: 210px; padding: 10px; background: white; border: 1px solid var(--admin-border); border-radius: 6px; box-shadow: 0 4px 14px #0f172a1a; }
.vf-spec-move select { margin-top: 5px; width: 100%; }
.vf-spec-remove { border: 0; background: transparent; color: #dc2626; cursor: pointer; font-size: 1.3rem; line-height: 1; padding: 5px 8px; border-radius: 5px; }
.vf-spec-remove:hover { background: #fef2f2; }
@media (max-width: 640px) {
    .vf-spec-toolbar, .vf-spec-control { width: 100%; }
    .vf-spec-search, .vf-spec-control { flex-basis: 100%; }
    .spec-row { flex-wrap: wrap; }
    .spec-row > .vf-admin-input { flex: 1 1 calc(50% - 8px); }
    .vf-spec-move { margin-left: auto; }
}
</style>
@endpush

@section('content')
{{-- Thanh điều hướng nhanh đến 8 khối giao diện --}}
<nav class="vf-admin-quick-nav" aria-label="Điều hướng nhanh các mục">
    <a href="#thong-tin-xe-co-ban" class="vf-admin-quick-nav-pill">
        <span>① Thông Tin Cơ Bản</span>
    </a>
    <a href="#phien-ban-xe" class="vf-admin-quick-nav-pill">
        <span>② Biến Thể Xe</span>
        <span class="vf-admin-card-badge" id="pill-count-variants">{{ $variants->count() }}</span>
    </a>
    <a href="#bai-viet-gioi-thieu" class="vf-admin-quick-nav-pill">
        <span>③ Bài Viết Giới Thiệu</span>
    </a>
    <a href="#video-gioi-thieu-xe" class="vf-admin-quick-nav-pill">
        <span>④ Video 16:9</span>
        <span class="vf-admin-card-badge" id="pill-count-videos">{{ $videos->count() }}</span>
    </a>
    <a href="#bo-suu-tap-mau-sac" class="vf-admin-quick-nav-pill">
        <span>⑤ Màu Sắc (Studio)</span>
        <span class="vf-admin-card-badge" id="pill-count-colors">{{ $colors->count() }}</span>
    </a>
    <a href="#banner-hero-san-pham" class="vf-admin-quick-nav-pill">
        <span>⑥ Banner Hero 19:6</span>
        <span class="vf-admin-card-badge" id="pill-count-banners">{{ $banners->count() }}</span>
    </a>
    <a href="#anh-noi-that-bento" class="vf-admin-quick-nav-pill">
        <span>⑦ Ảnh Nội Thất (Bento)</span>
        <span class="vf-admin-card-badge" id="pill-count-interiors">{{ $interiors->count() }}</span>
    </a>
    <a href="#thong-so-noi-bat" class="vf-admin-quick-nav-pill">
        <span>⑧ Thông Số Nổi Bật</span>
        <span class="vf-admin-card-badge" id="pill-count-highlights">{{ $specHighlights->count() }}</span>
    </a>
    <a href="#thong-so-ky-thuat-specs" class="vf-admin-quick-nav-pill">
        <span>⑨ Thông Số Key-Value</span>
        <span class="vf-admin-card-badge" id="pill-count-specs">{{ $specifications->count() }}</span>
    </a>
</nav>

{{-- FORM CHÍNH: BỐ CỤC 6 HÀNG CHUẨN XÁC 100% THEO SƠ ĐỒ --}}
<form id="vf-product-form" action="{{ $formAction }}" method="POST" class="form-track-changes">
    @csrf
    @if(!$isCreate)
        @method('PUT')
    @endif

    {{-- ========================================================================= --}}
    {{-- HÀNG 1: [THÔNG TIN XE CƠ BẢN] (Trái) & [PHIÊN BẢN & BIẾN THỂ XE] (Phải)   --}}
    {{-- ========================================================================= --}}
    <div class="vf-admin-section-grid vf-admin-grid-top">
        {{-- BOX 1: THÔNG TIN XE CƠ BẢN --}}
        <div class="vinfast-autohaiphong_admin_card" id="thong-tin-xe-co-ban" style="margin-bottom: 0;">
            <div class="vf-admin-card-header">
                <div class="vf-admin-card-title-text">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18M3 9h18"/></svg>
                    <span>THÔNG TIN XE CƠ BẢN</span>
                </div>
                <span class="vf-admin-card-badge">Bắt buộc</span>
            </div>

            <div class="vf-admin-input-group">
                <label class="vf-admin-label">Tên Dòng Xe <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" id="product-name" value="{{ old('name', $product->name) }}" required 
                       class="vf-admin-input" placeholder="VD: VinFast VF 3, VinFast VF 7...">
            </div>

            <div class="vf-admin-input-group">
                <label class="vf-admin-label">
                    Đường Dẫn Tĩnh (Slug)
                    @if(!$isCreate)
                        <span style="font-size: 0.75rem; font-weight: normal; color: var(--admin-muted); margin-left: 4px;">(Bảo lưu slug cũ, chỉ đổi khi bạn tự nhập mới)</span>
                    @else
                        <span style="font-size: 0.75rem; font-weight: normal; color: var(--admin-muted); margin-left: 4px;">(Để trống sẽ tự động tạo theo tên dòng xe)</span>
                    @endif
                </label>
                <div style="display: flex; align-items: center;">
                    <span style="display: inline-flex; align-items: center; padding: 0 10px; height: 38px; background: #f8fafc; border: 1px solid var(--admin-border); border-right: none; border-radius: 6px 0 0 6px; font-size: 0.82rem; color: var(--admin-muted); font-family: Consolas, monospace; font-weight: 600;">/xe/</span>
                    <input type="text" name="slug" id="product-slug" value="{{ old('slug', $product->slug) }}" 
                           class="vf-admin-input" style="border-radius: 0 6px 6px 0; font-family: Consolas, monospace; font-size: 0.85rem;" 
                           placeholder="{{ $isCreate ? 'tu-dong-tao-theo-ten-xe' : 'duong-dan-tinh' }}">
                </div>
                @if(!$isCreate && $product->slug)
                    <div class="vf-admin-helper-text" style="margin-top: 4px; display: flex; justify-content: space-between; align-items: center;">
                        <span>URL xem xe ngoài website: <a href="{{ route('client.products.show', $product->slug) }}" target="_blank" style="color: var(--admin-primary); font-family: Consolas, monospace; text-decoration: underline;">/xe/{{ $product->slug }}</a> ↗</span>
                    </div>
                @else
                    <div class="vf-admin-helper-text">
                        Chỉ tự động tạo theo tên xe khi tạo lần đầu nếu không nhập slug. Khi chỉnh sửa, hệ thống sẽ luôn tuân thủ slug cũ trừ khi bạn chủ động nhập slug mới.
                    </div>
                @endif
                @error('slug')
                    <div style="color: #ef4444; font-size: 0.78rem; margin-top: 4px; font-weight: 600;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;" class="vf-admin-input-group">
                <div>
                    <label class="vf-admin-label">Mã SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" 
                           class="vf-admin-input" placeholder="VD: VF3-2026">
                </div>
                <div>
                    <label class="vf-admin-label">Phân Loại Dòng Xe</label>
                    <select name="category_id" class="vf-admin-select">
                        <option value="">-- Chọn danh mục xe --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id) == $cat->id) ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;" class="vf-admin-input-group">
                <div>
                    <label class="vf-admin-label">Giá Niêm Yết (đ)</label>
                    <input type="number" name="regular_price" id="regular-price-input" value="{{ old('regular_price', $product->regular_price) }}" 
                           class="vf-admin-input" placeholder="VD: 322000000" oninput="calculateDiscount()">
                </div>
                <div>
                    <label class="vf-admin-label">Giá Khuyến Mại (đ)</label>
                    <input type="number" name="sale_price" id="sale-price-input" value="{{ old('sale_price', $product->sale_price) }}" 
                           class="vf-admin-input" placeholder="VD: 240000000" oninput="calculateDiscount()">
                </div>
            </div>
            <div id="discount-calc-badge" style="display: none; margin-top: -8px; margin-bottom: 14px; font-size: 0.78rem; color: #166534; background: #dcfce7; padding: 4px 10px; border-radius: 4px; border: 1px solid #bbf7d0;"></div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;" class="vf-admin-input-group">
                <div>
                    <label class="vf-admin-label">Trạng Thái Kinh Doanh</label>
                    <select name="status" class="vf-admin-select">
                        <option value="published" {{ in_array(old('status', $product->status), ['published', 'active']) ? 'selected' : '' }}>🟢 Đang kinh doanh (Hiển thị website)</option>
                        <option value="coming_soon" {{ old('status', $product->status) === 'coming_soon' ? 'selected' : '' }}>🟡 Sắp ra mắt (Hiển thị website)</option>
                        <option value="inactive" {{ in_array(old('status', $product->status), ['inactive', 'draft']) ? 'selected' : '' }}>⚪ Tạm dừng bán (Ẩn khỏi website)</option>
                        <option value="archived" {{ old('status', $product->status) === 'archived' ? 'selected' : '' }}>🔴 Ngừng kinh doanh (Lưu trữ)</option>
                    </select>
                </div>
                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <label class="vf-admin-label">Đặc Quyền</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 8px 0;">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--admin-primary);">
                        <span style="font-size: 0.85rem; font-weight: 600;">⭐ Đánh dấu xe nổi bật</span>
                    </label>
                </div>
            </div>

            <div class="vf-admin-input-group">
                <label class="vf-admin-label">Ảnh Đại Diện Xe (Thumbnail Chính)</label>
                <div style="display: flex; gap: 14px; align-items: center;">
                    <div id="product-thumb-preview" class="vinfast-autohaiphong_admin_product_preview" style="width: 90px; height: 60px; border: 1px dashed var(--admin-border); border-radius: 6px; overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        @php
                            $currentMedia = $mediaList->firstWhere('id', $product->thumbnail_media_id);
                        @endphp
                        @if($currentMedia)
                            <img src="{{ asset('storage/' . $currentMedia->path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                        @else
                            <span style="font-size: 0.72rem; color: var(--admin-muted);">Chưa có</span>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <input type="hidden" name="thumbnail_media_id" id="main_thumbnail_media_id" value="{{ $product->thumbnail_media_id }}">
                        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 6px; flex-wrap: wrap;">
                            <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="openMainThumbnailMediaPicker()" style="padding: 7px 14px; font-size: 0.82rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px; border-radius: 5px; cursor: pointer;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                🖼 Chọn ảnh từ Thư viện
                            </button>
                            <button type="button" id="btn_clear_main_thumb" onclick="removeMainThumbnail()" class="vinfast-autohaiphong_admin_btn" style="padding: 7px 12px; font-size: 0.82rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; font-weight: 500; display: {{ $currentMedia ? 'inline-flex' : 'none' }}; align-items: center; gap: 4px; border-radius: 5px; cursor: pointer;">
                                ✕ Xóa
                            </button>
                        </div>
                        <div id="main_thumb_filename" style="font-size: 0.75rem; color: var(--admin-muted); word-break: break-all;">
                            {{ $currentMedia ? ($currentMedia->filename . ($currentMedia->alt_text ? ' (' . $currentMedia->alt_text . ')' : '')) : 'Chưa chọn ảnh đại diện cho xe (Bấm nút trên để chọn từ popup)' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="vf-admin-input-group">
                <label class="vf-admin-label">Mô Tả Ngắn Gọn (Giới thiệu nhanh dòng xe)</label>
                <textarea name="short_description" id="product-short-description" rows="2" class="vf-admin-textarea" placeholder="Mô tả tóm tắt tính năng, ưu điểm nổi bật của dòng xe...">{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            {{-- ========================================================= --}}
            {{-- CẤU HÌNH META SEO CHUẨN GOOGLE (SERP & SOCIAL ON-PAGE)    --}}
            {{-- ========================================================= --}}
            <div style="margin-top: 18px; padding-top: 16px; border-top: 1px dashed var(--admin-border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span style="font-size: 0.88rem; font-weight: 700; color: var(--admin-heading); text-transform: uppercase; letter-spacing: 0.02em;">Tối Ưu Hóa Meta SEO (Google On-Page)</span>
                    </div>
                    <span style="font-size: 0.72rem; font-weight: 600; color: #166534; background: #dcfce7; padding: 2px 8px; border-radius: 12px; border: 1px solid #bbf7d0;">Chuẩn SEO 2026</span>
                </div>
                <p class="vf-admin-helper-text" style="margin-bottom: 12px; font-size: 0.78rem;">
                    Tùy biến tiêu đề, mô tả và từ khóa tìm kiếm khi khách hàng Google dòng xe này. Nếu để trống, hệ thống sẽ tự động tối ưu hóa theo tên và mô tả xe.
                </p>

                {{-- Meta Title --}}
                <div class="vf-admin-input-group" style="margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label class="vf-admin-label" style="margin-bottom: 0;">Tiêu Đề SEO (Meta Title)</label>
                        <span id="product-meta-title-counter" style="font-size: 0.75rem; color: var(--admin-muted); font-family: Consolas, monospace;">0 / 60 ký tự</span>
                    </div>
                    <input type="text" name="meta_title" id="product-meta-title" value="{{ old('meta_title', $product->meta_title ?? '') }}" 
                           class="vf-admin-input" placeholder="VD: VinFast VF 3 - Giá Lăn Bánh, Khuyến Mãi Mới Nhất Tại Hải Phòng">
                    <div class="vf-admin-helper-text" style="margin-top: 3px; font-size: 0.74rem;">
                        Hiển thị làm dòng tiêu đề xanh trên Google Search (khuyến nghị từ 40 - 65 ký tự).
                    </div>
                </div>

                {{-- Meta Description --}}
                <div class="vf-admin-input-group" style="margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label class="vf-admin-label" style="margin-bottom: 0;">Mô Tả SEO (Meta Description)</label>
                        <span id="product-meta-desc-counter" style="font-size: 0.75rem; color: var(--admin-muted); font-family: Consolas, monospace;">0 / 160 ký tự</span>
                    </div>
                    <textarea name="meta_description" id="product-meta-description" rows="3" class="vf-admin-textarea" 
                              placeholder="VD: Khám phá xe điện VinFast VF 3 tại Hải Phòng. Thiết kế nhỏ gọn, quãng đường 215km, sạc siêu nhanh, giá lăn bánh ưu đãi kèm bảo hành chính hãng 10 năm...">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                    <div class="vf-admin-helper-text" style="margin-top: 3px; font-size: 0.74rem;">
                        Đoạn trích dẫn mô tả hiển thị bên dưới tiêu đề trên Google (khuyến nghị từ 120 - 160 ký tự).
                    </div>
                </div>

                {{-- Meta Keywords & Canonical URL (2 cột) --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;" class="vf-admin-input-group">
                    <div>
                        <label class="vf-admin-label">Từ Khóa SEO (Focus Keywords)</label>
                        <input type="text" name="meta_keywords" id="product-meta-keywords" value="{{ old('meta_keywords', $product->meta_keywords ?? '') }}" 
                               class="vf-admin-input" placeholder="VD: vinfast vf 3, gia xe vf 3 hai phong, xe dien vinfast">
                        <div class="vf-admin-helper-text" style="margin-top: 3px; font-size: 0.73rem;">Các từ khóa phân cách bằng dấu phẩy.</div>
                    </div>
                    <div>
                        <label class="vf-admin-label">Đường Dẫn Canonical (Tùy chọn)</label>
                        <input type="text" name="canonical_url" id="product-canonical-url" value="{{ old('canonical_url', $product->canonical_url ?? '') }}" 
                               class="vf-admin-input" placeholder="Mặc định: Tự động trỏ về URL của xe">
                        <div class="vf-admin-helper-text" style="margin-top: 3px; font-size: 0.73rem;">Chỉ nhập khi cần trỏ canonical về URL khác.</div>
                    </div>
                </div>

                {{-- Google SERP Snippet Live Preview --}}
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; margin-top: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 6px;">
                        <span style="font-size: 0.76rem; font-weight: 700; color: #475569; text-transform: uppercase; display: flex; align-items: center; gap: 6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ea4335" stroke-width="2.5"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M12 6v6l4 2"/></svg>
                            Mô Phỏng Hiển Thị Trên Google Tìm Kiếm (SERP Preview)
                        </span>
                        <span style="font-size: 0.7rem; color: #94a3b8;">Google Desktop & Mobile</span>
                    </div>

                    {{-- Google URL breadcrumb --}}
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <div style="width: 22px; height: 22px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #e2e8f0;">
                            <img src="{{ asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" alt="VinFast Hải Phòng" style="width: 14px; height: 14px; object-fit: contain;">
                        </div>
                        <div style="display: flex; flex-direction: column; line-height: 1.2;">
                            <span style="font-size: 0.76rem; font-weight: 600; color: #202124;">VinFast Hải Phòng</span>
                            <span id="serp-preview-url" style="font-size: 0.72rem; color: #4d5156; word-break: break-all;">
                                {{ url('/xe/' . ($product->slug ?: 'ten-xe-vinfast')) }}
                            </span>
                        </div>
                    </div>

                    {{-- Google Title --}}
                    <div id="serp-preview-title" style="font-size: 1.05rem; line-height: 1.35; color: #1a0dab; font-weight: 500; cursor: pointer; margin-top: 4px; margin-bottom: 6px; word-break: break-word;">
                        {{ $product->meta_title ?: (($product->name ?: 'VinFast VF') . ' - Bảng Giá Lăn Bánh & Thông Số Kỹ Thuật | VinFast Hải Phòng') }}
                    </div>

                    {{-- Google Snippet Description --}}
                    <div id="serp-preview-desc" style="font-size: 0.82rem; line-height: 1.5; color: #4d5156; word-break: break-word;">
                        {{ $product->meta_description ?: ($product->short_description ?: 'Xem thông số kỹ thuật xe ' . ($product->name ?: 'VinFast') . ': Bảng giá niêm yết, thông số chi tiết, pin, quãng đường và hỗ trợ mua xe thanh toán tiền mặt tại VinFast Hải Phòng.') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- BOX 2: PHIÊN BẢN & BIẾN THỂ XE (VARIANTS) --}}
        <div class="vinfast-autohaiphong_admin_card" id="phien-ban-xe" style="margin-bottom: 0;">
            <input type="hidden" name="variants_present" value="1">
            <div class="vf-admin-card-header">
                <div class="vf-admin-card-title-text">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                    <span>PHIÊN BẢN & BIẾN THỂ XE (VARIANTS)</span>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <span class="vf-admin-card-badge" id="badge-count-variants">{{ $variants->count() }} phiên bản</span>
                    <button type="button" onclick="addNewVariantRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 5px 12px; font-size: 0.8rem;">
                        + Thêm Phiên Bản
                    </button>
                </div>
            </div>

            <p class="vf-admin-helper-text" style="margin-bottom: 14px;">
                Thiết lập các phiên bản (Thuê Pin, Kèm Pin, Eco, Plus) để khách hàng chọn trực tiếp tại trang xe. Hệ thống tự động cập nhật giá bán và ảnh xe tương ứng theo phiên bản được chọn.
            </p>

            <div id="variants-container">
                @if($variants->isNotEmpty())
                    @foreach($variants as $vIdx => $variant)
                        <div class="variant-row" style="background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-primary); background: #eff6ff; padding: 2px 8px; border-radius: 10px;">
                                    Phiên bản #{{ $vIdx + 1 }}
                                </span>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <button type="button" onclick="duplicateVariantRow(this)" class="vf-admin-preset-btn" title="Nhân bản phiên bản này">
                                        📋 Nhân bản
                                    </button>
                                    <button type="button" onclick="this.closest('.variant-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.1rem; padding: 0 4px;" title="Xóa phiên bản">
                                        &times;
                                    </button>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 10px; margin-bottom: 8px;">
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Tên Phiên Bản</label>
                                    <input type="text" name="variant_names[]" value="{{ $variant->name }}" placeholder="VD: Thuê Pin, Kèm Pin, Eco, Plus..." class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                </div>
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Mã SKU</label>
                                    <input type="text" name="variant_skus[]" value="{{ $variant->sku }}" placeholder="VD: VF3-BAT" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 8px;">
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Giá Niêm Yết (đ)</label>
                                    <input type="number" name="variant_regular_prices[]" value="{{ $variant->regular_price }}" placeholder="322000000" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                </div>
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Giá Khuyến Mại (đ)</label>
                                    <input type="number" name="variant_sale_prices[]" value="{{ $variant->sale_price }}" placeholder="240000000" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                </div>
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Màu Sắc Đại Diện</label>
                                    <input type="text" name="variant_color_names[]" value="{{ $variant->color_name }}" placeholder="VD: Vàng nóc trắng" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                </div>
                            </div>
                            <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
                                <div class="variant-img-preview" style="width: 60px; height: 42px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @if(!empty($variant->thumbnail_path))
                                        <img src="{{ asset('storage/' . $variant->thumbnail_path) }}" alt="{{ $variant->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    @else
                                        <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>
                                    @endif
                                </div>
                                <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                    <input type="hidden" name="variant_thumbnail_media_ids[]" class="variant-media-id-input" value="{{ $variant->thumbnail_media_id }}">
                                    <button type="button" onclick="chooseVariantImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        🖼 Chọn ảnh
                                    </button>
                                    <button type="button" onclick="removeVariantImage(this)" class="variant-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: {{ !empty($variant->thumbnail_media_id) ? 'inline-flex' : 'none' }}; align-items: center; gap: 4px;">
                                        ✕ Xóa
                                    </button>
                                    <span class="variant-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ !empty($variant->thumbnail_filename) ? $variant->thumbnail_filename : 'Dùng ảnh chính của xe' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="no-variants-placeholder" style="text-align: center; padding: 24px; background: var(--admin-bg); border-radius: 6px; border: 1px dashed var(--admin-border); color: var(--admin-muted); font-size: 0.85rem;">
                        Chưa có phiên bản riêng nào. Bấm <strong>+ Thêm Phiên Bản</strong> ở trên để tạo phiên bản xe.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- HÀNG 2: [BÀI VIẾT GIỚI THIỆU XE] (Full 100% Width)                         --}}
    {{-- ========================================================================= --}}
    <div class="vinfast-autohaiphong_admin_card" id="bai-viet-gioi-thieu">
        {{-- Sticky Header: Tiêu đề box + Nút chèn nhanh dính ở đỉnh khi cuộn --}}
        <div class="vf-admin-editor-sticky-header">
            <div class="vf-admin-card-header" style="margin-bottom: 8px;">
                <div class="vf-admin-card-title-text">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <span>BÀI VIẾT GIỚI THIỆU XE (CHI TIẾT ĐÁNH GIÁ & TÍNH NĂNG)</span>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <span id="word-count-badge" class="vf-admin-card-badge">0 từ</span>
                    <button type="button" onclick="openArticleLivePreview()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 12px; font-size: 0.8rem;">
                        👁 Xem Trước Bài Viết
                    </button>
                </div>
            </div>

            {{-- Thanh công cụ chèn nội dung nhanh --}}
            <div style="display: flex; gap: 6px; flex-wrap: wrap; padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--admin-border); align-items: center;">
                <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-muted); margin-right: 4px;">CHÈN NHANH:</span>
                <button type="button" class="vf-admin-preset-btn" onclick="openArticleMediaPicker()" style="background: #eff6ff; color: #1464f4; border-color: #bfdbfe; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    🖼 Chèn Ảnh & Chú Thích (Figcaption)
                </button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('h2')">+ Tiêu đề H2</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('h3')">+ Tiêu đề H3</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('p')">+ Đoạn văn</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('strong')">Bôi đậm</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('ul')">+ Danh sách điểm mạnh</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('table')">+ Bảng so sánh</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('callout')">+ Hộp ưu đãi VinFast</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('quote')">+ Trích dẫn đánh giá</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('accordion')">+ Hỏi đáp FAQ</button>
                <button type="button" class="vf-admin-preset-btn" onclick="insertArticleSnippet('cta')">+ Nút Đặt cọc</button>
            </div>
        </div>

        <textarea name="description_html" id="article-editor" rows="12" class="vf-admin-textarea" 
                  style="font-family: Consolas, Monaco, 'Courier New', monospace; font-size: 0.88rem; line-height: 1.6;"
                  placeholder="Nhập nội dung HTML bài viết giới thiệu chi tiết, đánh giá vận hành, thiết kế, pin và bảng giá ưu đãi xe..."
                  oninput="updateArticleWordCount()">{{ old('description_html', $product->description_html) }}</textarea>
        <div class="vf-admin-helper-text">
            Nội dung hiển thị trọn vẹn tại mục Bài Viết Giới Thiệu của trang xe. Hệ thống tự động lọc thẻ HTML an toàn chuẩn bảo mật.
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- HÀNG: [VIDEO GIỚI THIỆU XE (TỶ LỆ 16:9)] (Full Width)                    --}}
    {{-- ========================================================================= --}}
    <div class="vinfast-autohaiphong_admin_card" id="video-gioi-thieu-xe" style="margin-bottom: 24px;">
        <input type="hidden" name="videos_present" value="1">
        <div class="vf-admin-card-header">
            <div class="vf-admin-card-title-text">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/><path d="M19 12H5"/></svg>
                <span>VIDEO GIỚI THIỆU XE (TỶ LỆ 16:9 FULL VIỀN)</span>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <span class="vf-admin-card-badge" id="badge-count-videos">{{ $videos->count() }} video</span>
                <button type="button" onclick="addNewVideoRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 5px 12px; font-size: 0.8rem;">
                    + Thêm Video
                </button>
            </div>
        </div>
        <div class="vf-admin-card-body" style="padding: 20px;">
            <p style="font-size: 0.82rem; color: var(--admin-muted); margin-bottom: 16px;">
                Video hiển thị tỷ lệ 16:9 với độ rộng tối đa 100% (full viền) dính đuôi nhau phía trên khối Màu sắc ngoài website. Khi cuộn tới đâu video đó sẽ tự động phát (tắt tiếng) và chỉ 1 video được phát tại 1 thời điểm. Hỗ trợ tải lên video tối đa 50MB từ thư viện Media.
            </p>

            <div id="videos-container">
                @if(!empty($videos) && $videos->isNotEmpty())
                    @foreach($videos as $vIdx => $video)
                        @php
                            $vUrl = !empty($video->video_path) 
                                ? (str_starts_with($video->video_path, 'http') ? $video->video_path : asset('storage/' . ltrim($video->video_path, '/')))
                                : (!empty($video->video_media_path) ? asset('storage/' . ltrim($video->video_media_path, '/')) : '');
                            $pUrl = !empty($video->poster_path)
                                ? (str_starts_with($video->poster_path, 'http') ? $video->poster_path : asset('storage/' . ltrim($video->poster_path, '/')))
                                : (!empty($video->poster_media_path) ? asset('storage/' . ltrim($video->poster_media_path, '/')) : '');
                        @endphp
                        <div class="video-row" style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 16px; margin-bottom: 16px; position: relative;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                                <span style="font-size: 0.8rem; font-weight: 700; color: #4338ca; background: #eef2ff; padding: 3px 10px; border-radius: 12px;">
                                    Video #<span class="video-index">{{ $vIdx + 1 }}</span>
                                </span>
                                <button type="button" onclick="this.closest('.video-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.3rem; padding: 0 6px; line-height: 1;" title="Xóa video này">
                                    &times;
                                </button>
                            </div>

                            <div style="display: grid; grid-template-columns: 1.1fr 1.3fr; gap: 20px; align-items: start;">
                                {{-- Preview --}}
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 6px;">Xem trước Video (16:9)</label>
                                    <div class="video-preview-wrapper" style="position: relative; width: 100%; aspect-ratio: 16 / 9; background: #0f172a; border-radius: 6px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid var(--admin-border);">
                                        <video class="admin-row-video-player"
                                               controls
                                               playsinline
                                               poster="{{ $pUrl }}"
                                               style="width: 100%; height: 100%; object-fit: contain; {{ $vUrl ? '' : 'display: none;' }}">
                                            <source class="admin-row-video-source" src="{{ $vUrl }}" type="video/mp4">
                                            Trình duyệt không hỗ trợ thẻ video.
                                        </video>
                                        <div class="admin-row-video-placeholder" style="text-align: center; color: #94a3b8; padding: 16px; {{ $vUrl ? 'display: none;' : '' }}">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 6px; display: block; opacity: 0.6;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                            <span style="font-size: 0.8rem;">Chưa chọn file video. Bấm "Chọn Media" để thêm.</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Inputs --}}
                                <div style="display: flex; flex-direction: column; gap: 12px;">
                                    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 10px;">
                                        <div>
                                            <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Tiêu đề Video</label>
                                            <input type="text" name="video_titles[]" value="{{ $video->title ?? '' }}" placeholder="VD: Video mô phỏng xe điện VinFast VF 3" class="vf-admin-input video-title-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                        </div>
                                        <div>
                                            <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Phụ đề / Ghi chú</label>
                                            <input type="text" name="video_subtitles[]" value="{{ $video->subtitle ?? '' }}" placeholder="VD: Khám phá ngoại thất" class="vf-admin-input video-subtitle-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Tệp Video (MP4 / WEBM - tối đa 50MB)</label>
                                        <div style="display: flex; gap: 8px;">
                                            <input type="text" name="video_paths[]" value="{{ $video->video_path ?? '' }}" placeholder="clients/assets/videos/..." class="vf-admin-input video-path-input" style="padding: 6px 10px; font-size: 0.85rem;" readonly>
                                            <input type="hidden" name="video_media_ids[]" value="{{ $video->video_media_id ?? '' }}" class="video-media-id-input">
                                            <button type="button" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="white-space: nowrap; padding: 6px 12px; font-size: 0.8rem;" onclick="chooseVideoMedia(this)">
                                                Chọn Media
                                            </button>
                                            <button type="button" class="vinfast-autohaiphong_admin_btn" style="white-space: nowrap; padding: 6px 10px; font-size: 0.8rem; color: #ef4444; border-color: #fca5a5;" onclick="clearVideoMedia(this)">
                                                Xóa
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Ảnh Bìa Video (Poster - tối ưu SEO)</label>
                                        <div style="display: flex; gap: 8px;">
                                            <input type="text" name="video_poster_paths[]" value="{{ $video->poster_path ?? '' }}" placeholder="Để trống sẽ dùng ảnh đại diện xe" class="vf-admin-input video-poster-path-input" style="padding: 6px 10px; font-size: 0.85rem;" readonly>
                                            <input type="hidden" name="video_poster_media_ids[]" value="{{ $video->poster_media_id ?? '' }}" class="video-poster-media-id-input">
                                            <button type="button" class="vinfast-autohaiphong_admin_btn" style="white-space: nowrap; padding: 6px 12px; font-size: 0.8rem;" onclick="chooseVideoPoster(this)">
                                                Chọn ảnh bìa
                                            </button>
                                            <button type="button" class="vinfast-autohaiphong_admin_btn" style="white-space: nowrap; padding: 6px 10px; font-size: 0.8rem; color: #ef4444; border-color: #fca5a5;" onclick="clearVideoPoster(this)">
                                                Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="no-videos-placeholder" style="text-align: center; padding: 24px; background: var(--admin-bg); border-radius: 6px; border: 1px dashed var(--admin-border); color: var(--admin-muted); font-size: 0.85rem;">
                        Chưa có video giới thiệu nào. Bấm <strong>+ Thêm Video</strong> để thêm video mô phỏng (16:9 full viền).
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- HÀNG 3: [BỘ SƯU TẬP MÀU SẮC XE] (Trái) & [BANNER HERO SẢN PHẨM] (Phải)    --}}
    {{-- ========================================================================= --}}
    <div class="vf-admin-section-grid vf-admin-grid-middle">
        {{-- BOX 4: BỘ SƯU TẬP MÀU SẮC XE (COLOR STUDIO) --}}
        <div class="vinfast-autohaiphong_admin_card" id="bo-suu-tap-mau-sac" style="margin-bottom: 0;">
            <input type="hidden" name="colors_present" value="1">
            <div class="vf-admin-card-header">
                <div class="vf-admin-card-title-text">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a7 7 0 0 0 0 14c2.5 0 4-1.5 4-3a2 2 0 0 0-2-2h-2"/></svg>
                    <span>BỘ SƯU TẬP MÀU SẮC (COLOR STUDIO)</span>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <span class="vf-admin-card-badge" id="badge-count-colors">{{ $colors->count() }} màu</span>
                    <button type="button" onclick="addNewColorRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 5px 12px; font-size: 0.8rem;">
                        + Thêm Màu
                    </button>
                </div>
            </div>

            {{-- Gợi ý mã màu VinFast thông dụng --}}
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; align-items: center;">
                <span style="font-size: 0.72rem; font-weight: 600; color: var(--admin-muted);">Gợi ý màu VinFast:</span>
                <button type="button" class="vf-admin-preset-btn" onclick="quickAddColor('Solar Ruby', '#d83a3a')">🔴 Solar Ruby</button>
                <button type="button" class="vf-admin-preset-btn" onclick="quickAddColor('Electric Yellow', '#f2d852')">🟡 Electric Yellow</button>
                <button type="button" class="vf-admin-preset-btn" onclick="quickAddColor('Desert Sage', '#82917d')">🟢 Desert Sage</button>
                <button type="button" class="vf-admin-preset-btn" onclick="quickAddColor('Infinity Blanc', '#f4f6f8')">⚪ Infinity Blanc</button>
                <button type="button" class="vf-admin-preset-btn" onclick="quickAddColor('Zenith Grey', '#565d68')">⚫ Zenith Grey</button>
            </div>

            <div id="colors-container">
                @if($colors->isNotEmpty())
                    @foreach($colors as $cIdx => $col)
                        <div class="color-row" style="background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;">
                            <div style="display: grid; grid-template-columns: 55px 1.5fr auto; gap: 10px; align-items: center; margin-bottom: 8px;">
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Màu</label>
                                    <input type="color" name="color_codes[]" value="{{ $col->color_code }}" style="width: 100%; height: 34px; padding: 2px; border: 1px solid var(--admin-border); border-radius: 4px; cursor: pointer;">
                                </div>
                                <div>
                                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Tên Màu Sơn</label>
                                    <input type="text" name="color_names[]" value="{{ $col->name }}" placeholder="VD: Solar Ruby, Electric Yellow..." class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
                                </div>
                                <button type="button" onclick="this.closest('.color-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 6px; margin-top: 14px;" title="Xóa màu này">
                                    &times;
                                </button>
                            </div>
                            <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
                                <div class="color-img-preview" style="width: 65px; height: 42px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @if(!empty($col->image_path))
                                        <img src="{{ asset('storage/' . $col->image_path) }}" alt="{{ $col->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    @else
                                        <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
                                    @endif
                                </div>
                                <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                    <input type="hidden" name="color_image_media_ids[]" class="color-media-id-input" value="{{ $col->image_media_id }}">
                                    <button type="button" onclick="chooseColorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        🖼 Chọn ảnh
                                    </button>
                                    <button type="button" onclick="removeColorImage(this)" class="color-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: {{ !empty($col->image_media_id) ? 'inline-flex' : 'none' }}; align-items: center; gap: 4px;">
                                        ✕ Xóa
                                    </button>
                                    <span class="color-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ !empty($col->image_filename) ? $col->image_filename : 'Chưa có ảnh góc ngang' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="no-colors-placeholder" style="text-align: center; padding: 24px; background: var(--admin-bg); border-radius: 6px; border: 1px dashed var(--admin-border); color: var(--admin-muted); font-size: 0.85rem;">
                        Chưa có màu sơn nào. Chọn gợi ý ở trên hoặc bấm <strong>+ Thêm Màu</strong> để bắt đầu.
                    </div>
                @endif
            </div>
        </div>

        {{-- BOX 5: BANNER HERO SẢN PHẨM (TỶ LỆ 19:6) --}}
        <div class="vinfast-autohaiphong_admin_card" id="banner-hero-san-pham" style="margin-bottom: 0;">
            <input type="hidden" name="banners_present" value="1">
            <div class="vf-admin-card-header">
                <div class="vf-admin-card-title-text">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    <span>BANNER HERO SẢN PHẨM (TỶ LỆ 19:6)</span>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <span class="vf-admin-card-badge" id="badge-count-banners">{{ $banners->count() }} banner</span>
                    <button type="button" onclick="addNewBannerRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 5px 12px; font-size: 0.8rem;">
                        + Thêm Banner
                    </button>
                </div>
            </div>

            <p class="vf-admin-helper-text" style="margin-bottom: 14px;">
                Ảnh slider lớn ở đầu trang xe chuẩn tỷ lệ 19:6. Tiêu đề và phụ đề sẽ hiển thị nổi bật ở <strong>khoảng trên chính giữa</strong> của từng ảnh banner.
            </p>

            <div id="banners-container">
                @if(!empty($banners) && $banners->isNotEmpty())
                    @foreach($banners as $bIdx => $banner)
                        <div class="banner-row" style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px; margin-bottom: 12px;">
                            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
                                <input type="text" name="banner_titles[]" value="{{ $banner->title }}" placeholder="Tiêu đề Banner (VD: VINFAST VF 3)" 
                                       class="vf-admin-input" style="flex: 1.2; padding: 6px 10px; font-size: 0.85rem; font-weight: 600;">
                                <input type="text" name="banner_subtitles[]" value="{{ $banner->subtitle }}" placeholder="Phụ đề ngắn..." 
                                       class="vf-admin-input" style="flex: 2; padding: 6px 10px; font-size: 0.85rem;">
                                <button type="button" onclick="this.closest('.banner-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa banner này">
                                    &times;
                                </button>
                            </div>
                            <div style="display: flex; gap: 12px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
                                <div class="banner-img-preview" style="width: 110px; height: 40px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @php
                                        $bImgPath = $banner->media_path ?: $banner->image_path;
                                    @endphp
                                    @if(!empty($bImgPath))
                                        <img src="{{ asset('storage/' . ltrim($bImgPath, '/')) }}" alt="{{ $banner->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">16:9 / 19:6</span>
                                    @endif
                                </div>
                                <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                    <input type="hidden" name="banner_image_media_ids[]" class="banner-media-id-input" value="{{ $banner->image_media_id }}">
                                    <button type="button" onclick="chooseBannerImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        🖼 Chọn ảnh Banner
                                    </button>
                                    <button type="button" onclick="removeBannerImage(this)" class="banner-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: {{ (!empty($banner->image_media_id) || !empty($banner->image_path)) ? 'inline-flex' : 'none' }}; align-items: center; gap: 4px;">
                                        ✕ Xóa
                                    </button>
                                    <span class="banner-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ !empty($banner->media_filename) ? $banner->media_filename : (!empty($banner->image_path) ? basename($banner->image_path) : 'Chưa chọn ảnh banner') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="no-banners-placeholder" style="text-align: center; padding: 24px; background: var(--admin-bg); border-radius: 6px; border: 1px dashed var(--admin-border); color: var(--admin-muted); font-size: 0.85rem;">
                        Chưa có banner nào. Bấm <strong>+ Thêm Banner</strong> để tạo slider đầu trang.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- HÀNG 4: [BỘ SƯU TẬP ẢNH NỘI THẤT XE (BENTO / MOSAIC GALLERY)] (Full Width)  --}}
    {{-- ========================================================================= --}}
    <div class="vinfast-autohaiphong_admin_card" id="anh-noi-that-bento">
        <input type="hidden" name="interiors_present" value="1">
        <div class="vf-admin-card-header">
            <div class="vf-admin-card-title-text">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                <span>BỘ SƯU TẬP ẢNH NỘI THẤT XE (BENTO / MOSAIC GALLERY)</span>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <span class="vf-admin-card-badge" id="badge-count-interiors">{{ $interiors->count() }} ảnh nội thất</span>
                <button type="button" onclick="batchAddInteriorsFromMedia()" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    ⚡ Thêm Hàng Loạt từ Media
                </button>
                <button type="button" onclick="addNewInteriorRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 5px 12px; font-size: 0.8rem;">
                    + Thêm Ảnh Thủ Công
                </button>
            </div>
        </div>

        <p class="vf-admin-helper-text" style="margin-bottom: 14px;">
            Toàn bộ ảnh nội thất (Khoang lái, táp-lô, vô lăng, màn hình cảm ứng, hàng ghế...) sẽ tự động kết hợp thành một <strong>khối hình chữ nhật dài hoàn chỉnh (Bento Grid)</strong> tại mục Không Gian Nội Thất của trang sản phẩm.
        </p>

        <div id="interiors-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 14px;">
            @if(!empty($interiors) && $interiors->isNotEmpty())
                @foreach($interiors as $iIdx => $interior)
                    <div class="interior-row" style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px;">
                        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 8px;">
                            <input type="text" name="interior_captions[]" value="{{ $interior->caption }}" placeholder="Chú thích ảnh (VD: Khoang lái công thái học, Màn hình 10 inch...)" 
                                   class="vf-admin-input" style="flex: 1; padding: 6px 10px; font-size: 0.85rem; font-weight: 500;">
                            <button type="button" onclick="this.closest('.interior-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa ảnh này">
                                &times;
                            </button>
                        </div>
                        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
                            <div class="interior-img-preview" style="width: 72px; height: 48px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                @php
                                    $iImgPath = $interior->media_path ?: $interior->image_path;
                                @endphp
                                @if(!empty($iImgPath))
                                    <img src="{{ asset('storage/' . ltrim($iImgPath, '/')) }}" alt="{{ $interior->caption }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
                                @endif
                            </div>
                            <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                <input type="hidden" name="interior_image_media_ids[]" class="interior-media-id-input" value="{{ $interior->image_media_id }}">
                                <button type="button" onclick="chooseInteriorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    🖼 Chọn ảnh
                                </button>
                                <button type="button" onclick="removeInteriorImage(this)" class="interior-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: {{ (!empty($interior->image_media_id) || !empty($interior->image_path)) ? 'inline-flex' : 'none' }}; align-items: center; gap: 4px;">
                                    ✕ Xóa
                                </button>
                                <span class="interior-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ !empty($interior->media_filename) ? $interior->media_filename : (!empty($interior->image_path) ? basename($interior->image_path) : 'Chưa có ảnh nội thất') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div id="no-interiors-placeholder" style="grid-column: 1 / -1; text-align: center; padding: 24px; background: var(--admin-bg); border-radius: 6px; border: 1px dashed var(--admin-border); color: var(--admin-muted); font-size: 0.85rem;">
                    Chưa có ảnh nội thất nào. Bấm <strong>+ Thêm Ảnh Nội Thất</strong> để hiển thị Bento Grid.
                </div>
            @endif
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- HÀNG 5: [THÔNG SỐ NỔI BẬT ĐẦU TRANG (SPEC HIGHLIGHTS)] (Full Width)        --}}
    {{-- ========================================================================= --}}
    <div class="vinfast-autohaiphong_admin_card" id="thong-so-noi-bat">
        <input type="hidden" name="highlights_present" value="1">
        <div class="vf-admin-card-header">
            <div class="vf-admin-card-title-text">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <span>THÔNG SỐ NỔI BẬT ĐẦU TRANG (SPEC HIGHLIGHTS)</span>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <span class="vf-admin-card-badge" id="badge-count-highlights">{{ $specHighlights->count() }} thông số</span>
                <button type="button" onclick="loadDefaultVf3Highlights()" class="vf-admin-preset-btn">
                    ⚡ Nạp mẫu VF 3 chuẩn
                </button>
                <button type="button" onclick="addNewHighlightRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 5px 12px; font-size: 0.8rem;">
                    + Thêm Thông Số Nổi Bật
                </button>
            </div>
        </div>

        <p class="vf-admin-helper-text" style="margin-bottom: 14px;">
            Các khối thông số kích thước lớn hiển thị cạnh ảnh xe ở đầu trang (VD: Quãng đường 215 km/1 lần sạc, Sạc nhanh 36 phút, Bảo hành 7 năm hoặc 160.000km...).
        </p>

        <div id="highlights-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 14px;">
            @if(!empty($specHighlights) && $specHighlights->isNotEmpty())
                @foreach($specHighlights as $highlight)
                    <div class="highlight-row" style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 14px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-primary);">THÔNG SỐ NỔI BẬT</span>
                            <button type="button" onclick="this.closest('.highlight-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa thông số này">
                                &times;
                            </button>
                        </div>
                        <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                            <input type="text" name="highlight_values[]" value="{{ $highlight->value }}" placeholder="Giá trị (VD: 215, 36, 7 năm...)" 
                                   class="vf-admin-input" style="flex: 1.2; padding: 6px 10px; font-size: 0.95rem; font-weight: 700;">
                            <input type="text" name="highlight_units[]" value="{{ $highlight->unit }}" placeholder="Đơn vị (VD: km/1 lần sạc, phút...)" 
                                   class="vf-admin-input" style="flex: 1; padding: 6px 10px; font-size: 0.85rem;">
                        </div>
                        <div style="margin-bottom: 6px;">
                            <input type="text" name="highlight_subtitles[]" value="{{ $highlight->subtitle }}" placeholder="Phụ đề nhỏ (VD: (Tùy điều kiện nào đến trước)...)" 
                                   class="vf-admin-input" style="padding: 5px 8px; font-size: 0.8rem; color: #64748b;">
                        </div>
                        <div>
                            <input type="text" name="highlight_labels[]" value="{{ $highlight->label }}" placeholder="Tên nhãn (VD: Quãng đường di chuyển, Bảo hành...)" 
                                   class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem; font-weight: 600;">
                        </div>
                    </div>
                @endforeach
            @else
                <div id="no-highlights-placeholder" style="grid-column: 1 / -1; text-align: center; padding: 24px; background: var(--admin-bg); border-radius: 6px; border: 1px dashed var(--admin-border); color: var(--admin-muted); font-size: 0.85rem;">
                    Chưa có thông số nổi bật nào. Bấm <strong>⚡ Nạp mẫu VF 3 chuẩn</strong> hoặc <strong>+ Thêm Thông Số Nổi Bật</strong> để cấu hình.
                </div>
            @endif
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- HÀNG 6: [THÔNG SỐ KỸ THUẬT KEY - VALUE] (Full Width)                        --}}
    {{-- ========================================================================= --}}
    <div class="vinfast-autohaiphong_admin_card" id="thong-so-ky-thuat-specs">
        <div class="vf-admin-card-header">
            <div class="vf-admin-card-title-text">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                <span>THÔNG SỐ KỸ THUẬT KEY - VALUE</span>
            </div>
            <span class="vf-admin-card-badge" id="badge-count-specs">{{ $specifications->count() }} mục thông số</span>
        </div>
        <p class="vf-admin-helper-text vf-spec-help">Thêm thông số vào từng nhóm hoặc chuyển dòng sang nhóm khác. Nhóm mới cần ít nhất một thông số có tên để được lưu và dùng chung cho các xe.</p>
        <div class="vf-spec-toolbar">
            <input type="search" id="spec-search-input" class="vf-admin-input vf-spec-search" aria-label="Tìm thông số" placeholder="Tìm nhóm hoặc thông số..." oninput="filterSpecRows(this.value)">
            <div class="vf-spec-control">
                <select id="spec-add-group" aria-label="Chọn nhóm thông số có sẵn" class="vf-admin-input">
                    <option value="">Chọn nhóm có sẵn</option>
                    @foreach($specificationGroups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                    @foreach(old('new_spec_groups', []) as $key => $name)
                        <option value="new:{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
                <button type="button" onclick="addSpecGroup()" class="vinfast-autohaiphong_admin_btn vf-spec-action">+ Thêm nhóm</button>
            </div>
            <div class="vf-spec-control">
                <input id="spec-new-group-name" class="vf-admin-input" maxlength="150" aria-label="Tên nhóm mới" placeholder="Tên nhóm mới">
                <button type="button" onclick="createSpecGroup()" class="vinfast-autohaiphong_admin_btn vf-spec-action">+ Tạo nhóm</button>
            </div>
        </div>

        @php
            $specRows = old('specs_labels') !== null
                ? collect(old('specs_labels'))->map(fn ($label, $index) => (object) [
                    'label' => $label,
                    'value' => old("specs_values.$index"),
                    'group_id' => old("specs_groups.$index"),
                    'unit' => old("specs_units.$index"),
                ])
                : $specifications;
        @endphp
        <input type="hidden" name="specs_present" value="1">
        @php
            $rowsByGroup = $specRows->groupBy(fn ($spec) => (string) ($spec->group_id ?? ''));
            $groupNames = $specificationGroups->keyBy('id');
            $groupIds = $rowsByGroup->keys()->map(fn ($id) => (string) $id)->all();
            if (! in_array('', $groupIds, true)) {
                array_unshift($groupIds, '');
            }
        @endphp
        <div id="new-spec-groups">
            @foreach(old('new_spec_groups', []) as $key => $name)
                <input type="hidden" name="new_spec_groups[{{ $key }}]" value="{{ $name }}">
            @endforeach
        </div>
        <div id="specs-container">
            @foreach($groupIds as $groupId)
                <section class="spec-section" data-group-id="{{ $groupId }}">
                    <div class="vf-spec-section-header">
                        <strong class="spec-section-title">{{ $groupId === '' ? 'Không phân nhóm' : ($groupNames->get($groupId)?->name ?? (str_starts_with($groupId, 'new:') ? old('new_spec_groups.'.substr($groupId, 4), 'Nhóm mới') : 'Nhóm không còn tồn tại (#'.$groupId.')')) }}</strong>
                        <button type="button" onclick="addNewSpecRow(this.closest('.spec-section'))" class="vinfast-autohaiphong_admin_btn vf-spec-add-row">+ Thêm thông số</button>
                    </div>
                    <div class="spec-section-rows">
                        @foreach($rowsByGroup->get($groupId, collect()) as $spec)
                            <div class="spec-row">
                                <input type="hidden" name="specs_groups[]" value="{{ $spec->group_id }}">
                                <input type="hidden" name="specs_units[]" value="{{ $spec->unit }}">
                                <input type="text" name="specs_labels[]" value="{{ $spec->label }}" aria-label="Tên thông số" placeholder="Tên thông số (Key)" class="vf-admin-input spec-key-input">
                                <input type="text" name="specs_values[]" value="{{ $spec->value }}" aria-label="Giá trị thông số" placeholder="Giá trị (Value)" class="vf-admin-input spec-val-input">
                                <details class="vf-spec-move"><summary>Chuyển nhóm</summary><label>Nhóm đích <select class="vf-admin-input" onchange="moveSpecRow(this)"><option value="">Không phân nhóm</option>@foreach($specificationGroups as $group)<option value="{{ $group->id }}" @selected((string) $spec->group_id === (string) $group->id)>{{ $group->name }}</option>@endforeach @foreach(old('new_spec_groups', []) as $key => $name)<option value="new:{{ $key }}" @if(isset($spec)) @selected((string) $spec->group_id === 'new:'.$key) @endif>{{ $name }}</option>@endforeach</select></label></details>
                                <button type="button" onclick="removeSpecRow(this)" aria-label="Xóa dòng thông số" title="Xóa thông số" class="vf-spec-remove">&times;</button>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
        <template id="spec-row-template">
            <div class="spec-row">
                <input type="hidden" name="specs_groups[]" value="">
                <input type="hidden" name="specs_units[]" value="">
                <input type="text" name="specs_labels[]" aria-label="Tên thông số" placeholder="Tên thông số (Key)" class="vf-admin-input spec-key-input">
                <input type="text" name="specs_values[]" aria-label="Giá trị thông số" placeholder="Giá trị (Value)" class="vf-admin-input spec-val-input">
                <details class="vf-spec-move"><summary>Chuyển nhóm</summary><label>Nhóm đích <select class="vf-admin-input" onchange="moveSpecRow(this)"><option value="">Không phân nhóm</option>@foreach($specificationGroups as $group)<option value="{{ $group->id }}">{{ $group->name }}</option>@endforeach @foreach(old('new_spec_groups', []) as $key => $name)<option value="new:{{ $key }}">{{ $name }}</option>@endforeach</select></label></details>
                <button type="button" onclick="removeSpecRow(this)" aria-label="Xóa dòng thông số" title="Xóa thông số" class="vf-spec-remove">&times;</button>
            </div>
        </template>
        <template id="spec-section-template">
            <section class="spec-section">
                <div class="vf-spec-section-header">
                    <strong class="spec-section-title"></strong>
                    <button type="button" onclick="addNewSpecRow(this.closest('.spec-section'))" class="vinfast-autohaiphong_admin_btn vf-spec-add-row">+ Thêm thông số</button>
                </div>
                <div class="spec-section-rows"></div>
            </section>
        </template>
    </div>

    {{-- Khoảng trống dự phòng để nội dung không bị thanh fixed bottom che mất --}}
    <div class="vf-admin-bottom-bar-spacer"></div>

    {{-- ========================================================================= --}}
    {{-- THANH NÚT CHÍNH CỐ ĐỊNH Ở DƯỚI BOTTOM (FIXED BOTTOM ACTION BAR)           --}}
    {{-- ========================================================================= --}}
    <div class="vf-admin-fixed-bottom-bar">
        <div class="vf-admin-bottom-status">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 1.1rem;">🚗</span>
                <div>
                    <strong id="bar-product-name">{{ $product->name ?: 'Dòng xe mới' }}</strong>
                    <span style="color: var(--admin-muted); font-size: 0.78rem;">({{ $product->sku ?: 'Chưa có SKU' }})</span>
                </div>
            </div>
            <span id="unsaved-status-indicator" style="font-size: 0.75rem; color: #166534; background: #dcfce7; padding: 3px 8px; border-radius: 12px; font-weight: 600;">
                ● Sẵn sàng
            </span>
        </div>

        <div class="vf-admin-bottom-actions">
            @if(!$isCreate && !empty($product->slug))
                <a href="{{ route('client.products.show', $product->slug) }}" target="_blank" 
                   class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" 
                   style="padding: 9px 14px; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    <span>Xem Ngoài Web</span>
                </a>
            @endif

            <a href="{{ route('admin.products.index') }}" 
               class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" 
               style="padding: 9px 16px; font-size: 0.85rem;">
                Quay Lại
            </a>

            <button type="submit" id="btn-save-product" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" 
                    style="padding: 10px 24px; font-size: 0.95rem; font-weight: 700; box-shadow: 0 4px 12px rgba(20, 100, 244, 0.25);">
                <span id="save-btn-text">💾 LƯU DỮ LIỆU SẢN PHẨM</span>
                <span style="font-size: 0.72rem; font-weight: normal; margin-left: 6px; opacity: 0.85;">(Ctrl+S)</span>
            </button>
        </div>
    </div>
</form>

{{-- MODAL XEM TRƯỚC BÀI VIẾT (LIVE ARTICLE PREVIEW MODAL) --}}
<div id="article-preview-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 2000; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border-radius: 12px; width: 100%; max-width: 900px; max-height: 85vh; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
        <div style="padding: 16px 24px; border-bottom: 1px solid var(--admin-border); display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <strong style="font-size: 1rem; color: var(--admin-heading);">XEM TRƯỚC BÀI VIẾT GIỚI THIỆU XE</strong>
            <button type="button" onclick="closeArticleLivePreview()" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
        </div>
        <div id="article-preview-content" style="padding: 24px; overflow-y: auto; flex: 1; line-height: 1.7; font-size: 0.95rem; color: #334155;">
        </div>
        <div style="padding: 12px 24px; border-top: 1px solid var(--admin-border); text-align: right; background: #f8fafc;">
            <button type="button" onclick="closeArticleLivePreview()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline">Đóng</button>
        </div>
    </div>
</div>

<script>
// Cập nhật tên xe trên thanh bottom bar thời gian thực
document.getElementById('product-name')?.addEventListener('input', function() {
    const val = this.value.trim();
    const barEl = document.getElementById('bar-product-name');
    if (barEl) barEl.textContent = val || 'Dòng xe mới';
});

@if($isCreate)
// Khi tạo mới xe lần đầu: tự động tạo slug theo tên xe nếu người dùng chưa tự nhập
(function() {
    let slugTouched = false;
    const nameEl = document.getElementById('product-name');
    const slugEl = document.getElementById('product-slug');
    if (!nameEl || !slugEl) return;

    slugEl.addEventListener('input', function() {
        slugTouched = this.value.trim().length > 0;
    });

    nameEl.addEventListener('input', function() {
        if (!slugTouched) {
            slugEl.value = convertToSlug(this.value);
        }
    });

    function convertToSlug(str) {
        if (!str) return '';
        let slug = str.toLowerCase();
        slug = slug.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        slug = slug.replace(/[đĐ]/g, 'd');
        slug = slug.replace(/[^0-9a-z-\s]/g, '');
        slug = slug.replace(/\s+/g, '-');
        slug = slug.replace(/-+/g, '-');
        slug = slug.replace(/^-+|-+$/g, '');
        return slug;
    }
})();
@endif

// Tính toán tự động phần trăm giảm giá và số tiền tiết kiệm
function calculateDiscount() {
    const regInput = document.getElementById('regular-price-input');
    const saleInput = document.getElementById('sale-price-input');
    const badge = document.getElementById('discount-calc-badge');
    if (!regInput || !saleInput || !badge) return;

    const reg = parseFloat(regInput.value) || 0;
    const sale = parseFloat(saleInput.value) || 0;

    if (reg > 0 && sale > 0 && sale < reg) {
        const diff = reg - sale;
        const percent = Math.round((diff / reg) * 100);
        badge.style.display = 'block';
        badge.innerHTML = `🎉 Giảm: <strong>${new Intl.NumberFormat('vi-VN').format(diff)} đ</strong> (Tiết kiệm -${percent}%)`;
    } else {
        badge.style.display = 'none';
    }
}
calculateDiscount();

// Quản lý Meta SEO & Live SERP Preview thời gian thực
(function() {
    const metaTitleInput = document.getElementById('product-meta-title');
    const metaDescInput = document.getElementById('product-meta-description');
    const nameInput = document.getElementById('product-name');
    const slugInput = document.getElementById('product-slug');
    const shortDescInput = document.getElementById('product-short-description');

    const metaTitleCounter = document.getElementById('product-meta-title-counter');
    const metaDescCounter = document.getElementById('product-meta-desc-counter');
    const serpUrl = document.getElementById('serp-preview-url');
    const serpTitle = document.getElementById('serp-preview-title');
    const serpDesc = document.getElementById('serp-preview-desc');

    const baseUrl = '{{ url('/xe') }}';

    function updateSeoCountersAndPreview() {
        const carName = nameInput ? nameInput.value.trim() : '';
        const carSlug = slugInput ? slugInput.value.trim() : '';
        const metaTitleVal = metaTitleInput ? metaTitleInput.value.trim() : '';
        const metaDescVal = metaDescInput ? metaDescInput.value.trim() : '';
        const shortDescVal = shortDescInput ? shortDescInput.value.trim() : '';

        // Đếm ký tự Title (40 - 65 là xanh)
        if (metaTitleInput && metaTitleCounter) {
            const tLen = metaTitleInput.value.length;
            metaTitleCounter.textContent = `${tLen} / 60 ký tự`;
            metaTitleCounter.style.color = (tLen >= 40 && tLen <= 65) ? '#16a34a' : (tLen > 65 ? '#ef4444' : 'var(--admin-muted)');
        }

        // Đếm ký tự Description (120 - 160 là xanh)
        if (metaDescInput && metaDescCounter) {
            const dLen = metaDescInput.value.length;
            metaDescCounter.textContent = `${dLen} / 160 ký tự`;
            metaDescCounter.style.color = (dLen >= 120 && dLen <= 160) ? '#16a34a' : (dLen > 160 ? '#ef4444' : 'var(--admin-muted)');
        }

        // Cập nhật SERP URL
        if (serpUrl) {
            serpUrl.textContent = `${baseUrl}/${carSlug || 'ten-xe-vinfast'}`;
        }

        // Cập nhật SERP Title
        if (serpTitle) {
            serpTitle.textContent = metaTitleVal || `${carName || 'VinFast VF'} - Bảng Giá Lăn Bánh & Thông Số Kỹ Thuật | VinFast Hải Phòng`;
        }

        // Cập nhật SERP Description
        if (serpDesc) {
            serpDesc.textContent = metaDescVal || (shortDescVal || `Xem thông số kỹ thuật xe ${carName || 'VinFast'}: Bảng giá niêm yết, thông số chi tiết, pin, quãng đường và hỗ trợ mua xe thanh toán tiền mặt tại VinFast Hải Phòng.`);
        }
    }

    if (metaTitleInput) metaTitleInput.addEventListener('input', updateSeoCountersAndPreview);
    if (metaDescInput) metaDescInput.addEventListener('input', updateSeoCountersAndPreview);
    if (nameInput) nameInput.addEventListener('input', updateSeoCountersAndPreview);
    if (slugInput) slugInput.addEventListener('input', updateSeoCountersAndPreview);
    if (shortDescInput) shortDescInput.addEventListener('input', updateSeoCountersAndPreview);

    updateSeoCountersAndPreview();
})();

// Thêm biến thể mới
function addNewVariantRow(data = {}) {
    const placeholder = document.getElementById('no-variants-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('variants-container');
    const div = document.createElement('div');
    div.className = 'variant-row';
    div.style.cssText = 'background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;';
    
    const count = container.querySelectorAll('.variant-row').length + 1;
    const hasMedia = !!data.thumbnail_media_id && !!data.media_url;
    const previewContent = hasMedia
        ? `<img src="${data.media_url}" style="width: 100%; height: 100%; object-fit: contain;">`
        : `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>`;
    const fileName = hasMedia ? (data.media_filename || 'Ảnh đã chọn') : 'Dùng ảnh chính của xe';
    const removeBtnStyle = hasMedia ? 'inline-flex' : 'none';

    div.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-primary); background: #eff6ff; padding: 2px 8px; border-radius: 10px;">
                Phiên bản #${count}
            </span>
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" onclick="duplicateVariantRow(this)" class="vf-admin-preset-btn" title="Nhân bản phiên bản này">📋 Nhân bản</button>
                <button type="button" onclick="this.closest('.variant-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.1rem; padding: 0 4px;" title="Xóa">&times;</button>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 10px; margin-bottom: 8px;">
            <div>
                <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Tên Phiên Bản</label>
                <input type="text" name="variant_names[]" value="${data.name || ''}" placeholder="VD: Thuê Pin, Kèm Pin, Eco, Plus..." class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
            </div>
            <div>
                <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Mã SKU</label>
                <input type="text" name="variant_skus[]" value="${data.sku || ''}" placeholder="VD: VF3-BAT" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 8px;">
            <div>
                <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Giá Niêm Yết (đ)</label>
                <input type="number" name="variant_regular_prices[]" value="${data.regular_price || ''}" placeholder="322000000" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
            </div>
            <div>
                <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Giá Khuyến Mại (đ)</label>
                <input type="number" name="variant_sale_prices[]" value="${data.sale_price || ''}" placeholder="240000000" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
            </div>
            <div>
                <label class="vf-admin-label" style="font-size: 0.75rem; margin-bottom: 2px;">Màu Sắc Đại Diện</label>
                <input type="text" name="variant_color_names[]" value="${data.color_name || ''}" placeholder="VD: Vàng nóc trắng" class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
            </div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="variant-img-preview" style="width: 60px; height: 42px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                ${previewContent}
            </div>
            <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="variant_thumbnail_media_ids[]" class="variant-media-id-input" value="${data.thumbnail_media_id || ''}">
                <button type="button" onclick="chooseVariantImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    🖼 Chọn ảnh
                </button>
                <button type="button" onclick="removeVariantImage(this)" class="variant-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: ${removeBtnStyle}; align-items: center; gap: 4px;">
                    ✕ Xóa
                </button>
                <span class="variant-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    ${fileName}
                </span>
            </div>
        </div>
    `;
    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

// Nhân bản phiên bản
function duplicateVariantRow(btn) {
    const row = btn.closest('.variant-row');
    const name = row.querySelector('input[name="variant_names[]"]')?.value || '';
    const sku = row.querySelector('input[name="variant_skus[]"]')?.value || '';
    const reg = row.querySelector('input[name="variant_regular_prices[]"]')?.value || '';
    const sale = row.querySelector('input[name="variant_sale_prices[]"]')?.value || '';
    const color = row.querySelector('input[name="variant_color_names[]"]')?.value || '';
    const mediaId = row.querySelector('.variant-media-id-input')?.value || '';
    const imgSrc = row.querySelector('.variant-img-preview img')?.src || '';
    const imgName = row.querySelector('.variant-img-name')?.textContent.trim() || '';

    addNewVariantRow({
        name: name ? name + ' (Bản sao)' : '',
        sku: sku ? sku + '-COPY' : '',
        regular_price: reg,
        sale_price: sale,
        color_name: color,
        thumbnail_media_id: mediaId,
        media_url: imgSrc,
        media_filename: imgName
    });
}

// Thêm màu sắc mới
function addNewColorRow(name = '', code = '#d83a3a', data = {}) {
    const placeholder = document.getElementById('no-colors-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('colors-container');
    const div = document.createElement('div');
    div.className = 'color-row';
    div.style.cssText = 'background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;';
    
    const hasMedia = !!data.image_media_id && !!data.media_url;
    const previewContent = hasMedia
        ? `<img src="${data.media_url}" style="width: 100%; height: 100%; object-fit: contain;">`
        : `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>`;
    const fileName = hasMedia ? (data.media_filename || 'Ảnh đã chọn') : 'Chưa có ảnh góc ngang';
    const removeBtnStyle = hasMedia ? 'inline-flex' : 'none';

    div.innerHTML = `
        <div style="display: grid; grid-template-columns: 55px 1.5fr auto; gap: 10px; align-items: center; margin-bottom: 8px;">
            <div>
                <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Màu</label>
                <input type="color" name="color_codes[]" value="${code}" style="width: 100%; height: 34px; padding: 2px; border: 1px solid var(--admin-border); border-radius: 4px; cursor: pointer;">
            </div>
            <div>
                <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Tên Màu Sơn</label>
                <input type="text" name="color_names[]" value="${name}" placeholder="VD: Solar Ruby, Electric Yellow..." class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem;">
            </div>
            <button type="button" onclick="this.closest('.color-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 6px; margin-top: 14px;" title="Xóa màu này">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="color-img-preview" style="width: 65px; height: 42px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                ${previewContent}
            </div>
            <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="color_image_media_ids[]" class="color-media-id-input" value="${data.image_media_id || ''}">
                <button type="button" onclick="chooseColorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    🖼 Chọn ảnh
                </button>
                <button type="button" onclick="removeColorImage(this)" class="color-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: ${removeBtnStyle}; align-items: center; gap: 4px;">
                    ✕ Xóa
                </button>
                <span class="color-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    ${fileName}
                </span>
            </div>
        </div>
    `;
    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

function quickAddColor(name, code) {
    addNewColorRow(name, code);
}

// Thêm Banner mới
function addNewBannerRow(data = {}) {
    const placeholder = document.getElementById('no-banners-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('banners-container');
    const div = document.createElement('div');
    div.className = 'banner-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px; margin-bottom: 12px;';
    
    const hasMedia = !!data.image_media_id && !!data.media_url;
    const previewContent = hasMedia
        ? `<img src="${data.media_url}" style="width: 100%; height: 100%; object-fit: cover;">`
        : `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">16:9 / 19:6</span>`;
    const fileName = hasMedia ? (data.media_filename || 'Ảnh đã chọn') : 'Chưa chọn ảnh banner';
    const removeBtnStyle = hasMedia ? 'inline-flex' : 'none';

    div.innerHTML = `
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
            <input type="text" name="banner_titles[]" value="${data.title || ''}" placeholder="Tiêu đề Banner (VD: VINFAST VF 3)" 
                   class="vf-admin-input" style="flex: 1.2; padding: 6px 10px; font-size: 0.85rem; font-weight: 600;">
            <input type="text" name="banner_subtitles[]" value="${data.subtitle || ''}" placeholder="Phụ đề ngắn..." 
                   class="vf-admin-input" style="flex: 2; padding: 6px 10px; font-size: 0.85rem;">
            <button type="button" onclick="this.closest('.banner-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa banner này">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="banner-img-preview" style="width: 110px; height: 40px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                ${previewContent}
            </div>
            <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="banner_image_media_ids[]" class="banner-media-id-input" value="${data.image_media_id || ''}">
                <button type="button" onclick="chooseBannerImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    🖼 Chọn ảnh Banner
                </button>
                <button type="button" onclick="removeBannerImage(this)" class="banner-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: ${removeBtnStyle}; align-items: center; gap: 4px;">
                    ✕ Xóa
                </button>
                <span class="banner-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    ${fileName}
                </span>
            </div>
        </div>
    `;
    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

// Thêm ảnh nội thất mới
function addNewInteriorRow(data = {}) {
    const placeholder = document.getElementById('no-interiors-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('interiors-container');
    const div = document.createElement('div');
    div.className = 'interior-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px;';
    
    const hasMedia = !!data.media_id && !!data.media_url;
    const previewContent = hasMedia
        ? `<img src="${data.media_url}" style="width: 100%; height: 100%; object-fit: cover;">`
        : `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>`;
    const fileName = hasMedia ? (data.media_filename || data.caption || 'Ảnh đã chọn') : 'Chưa có ảnh nội thất';
    const removeBtnStyle = hasMedia ? 'inline-flex' : 'none';

    div.innerHTML = `
        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 8px;">
            <input type="text" name="interior_captions[]" value="${data.caption || ''}" placeholder="Chú thích ảnh (VD: Khoang lái công thái học, Màn hình 10 inch...)" 
                   class="vf-admin-input" style="flex: 1; padding: 6px 10px; font-size: 0.85rem; font-weight: 500;">
            <button type="button" onclick="this.closest('.interior-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa ảnh này">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="interior-img-preview" style="width: 72px; height: 48px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                ${previewContent}
            </div>
            <div style="flex: 1; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="interior_image_media_ids[]" class="interior-media-id-input" value="${data.media_id || ''}">
                <button type="button" onclick="chooseInteriorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; cursor: pointer;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    🖼 Chọn ảnh
                </button>
                <button type="button" onclick="removeInteriorImage(this)" class="interior-img-remove-btn" style="padding: 6px 10px; font-size: 0.78rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer; display: ${removeBtnStyle}; align-items: center; gap: 4px;">
                    ✕ Xóa
                </button>
                <span class="interior-img-name" style="font-size: 0.75rem; color: var(--admin-muted); flex: 1; min-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    ${fileName}
                </span>
            </div>
        </div>
    `;
    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

// Thêm thông số nổi bật mới
function addNewHighlightRow(data = {}) {
    const placeholder = document.getElementById('no-highlights-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('highlights-container');
    const div = document.createElement('div');
    div.className = 'highlight-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 14px;';
    div.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.75rem; font-weight: 700; color: var(--admin-primary);">THÔNG SỐ NỔI BẬT</span>
            <button type="button" onclick="this.closest('.highlight-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa thông số này">&times;</button>
        </div>
        <div style="display: flex; gap: 8px; margin-bottom: 8px;">
            <input type="text" name="highlight_values[]" value="${data.value || ''}" placeholder="Giá trị (VD: 215, 36...)" 
                   class="vf-admin-input" style="flex: 1.2; padding: 6px 10px; font-size: 0.95rem; font-weight: 700;">
            <input type="text" name="highlight_units[]" value="${data.unit || ''}" placeholder="Đơn vị (VD: km/1 lần sạc, phút...)" 
                   class="vf-admin-input" style="flex: 1; padding: 6px 10px; font-size: 0.85rem;">
        </div>
        <div style="margin-bottom: 6px;">
            <input type="text" name="highlight_subtitles[]" value="${data.subtitle || ''}" placeholder="Phụ đề nhỏ..." 
                   class="vf-admin-input" style="padding: 5px 8px; font-size: 0.8rem; color: #64748b;">
        </div>
        <div>
            <input type="text" name="highlight_labels[]" value="${data.label || ''}" placeholder="Tên nhãn (VD: Quãng đường di chuyển...)" 
                   class="vf-admin-input" style="padding: 6px 10px; font-size: 0.85rem; font-weight: 600;">
        </div>
    `;
    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

// Nạp mẫu chuẩn 3 thông số VF 3
function loadDefaultVf3Highlights() {
    addNewHighlightRow({ value: '215', unit: 'km/1 lần sạc (NEDC)', subtitle: '', label: 'Quãng đường di chuyển' });
    addNewHighlightRow({ value: '36', unit: 'phút', subtitle: '', label: 'Sạc nhanh từ 10% - 70%' });
    addNewHighlightRow({ value: '7 năm hoặc 160.000km', unit: '', subtitle: '(Tùy điều kiện nào đến trước)', label: 'Bảo hành' });
}

// Các mảng đầu vào vẫn được gửi theo từng dòng.
function ensureSpecGroup(id, name) {
    const container = document.getElementById('specs-container');
    let section = Array.from(container.querySelectorAll('.spec-section')).find(item => item.dataset.groupId === id);
    if (!section) {
        section = document.getElementById('spec-section-template').content.firstElementChild.cloneNode(true);
        section.dataset.groupId = id;
        section.querySelector('.spec-section-title').textContent = name;
        container.appendChild(section);
    }
    return section;
}

function createSpecGroup() {
    const input = document.getElementById('spec-new-group-name');
    const name = input.value.trim();
    if (!name) {
        input.focus();
        return;
    }
    const selects = [...document.querySelectorAll('#spec-add-group, #specs-container .spec-row select'), document.getElementById('spec-row-template').content.querySelector('select')];
    const existing = Array.from(document.getElementById('spec-add-group').options).find(option => option.value && option.textContent.trim().toLocaleLowerCase() === name.toLocaleLowerCase());
    if (existing) {
        ensureSpecGroup(existing.value, existing.textContent).querySelector('button').focus();
        input.value = '';
        return;
    }
    const key = 'g' + Date.now() + Math.random().toString(36).slice(2, 8);
    const id = 'new:' + key;
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'new_spec_groups[' + key + ']';
    hidden.value = name;
    document.getElementById('new-spec-groups').appendChild(hidden);
    selects.forEach(select => select.add(new Option(name, id)));
    const section = ensureSpecGroup(id, name);
    input.value = '';
    markFormDirty();
    section.querySelector('button').focus();
}

function addSpecGroup() {
    const select = document.getElementById('spec-add-group');
    if (!select.value) return;
    const section = ensureSpecGroup(select.value, select.selectedOptions[0].textContent);
    select.value = '';
    section.querySelector('button').focus();
}

function addNewSpecRow(section) {
    const row = document.getElementById('spec-row-template').content.firstElementChild.cloneNode(true);
    row.querySelector('[name="specs_groups[]"]').value = section.dataset.groupId;
    row.querySelector('select').value = section.dataset.groupId;
    section.querySelector('.spec-section-rows').appendChild(row);
    document.getElementById('spec-search-input').value = '';
    filterSpecRows('');
    updateCounters();
    markFormDirty();
    row.querySelector('.spec-key-input').focus();
}

function removeSpecRow(button) {
    const section = button.closest('.spec-section');
    button.closest('.spec-row').remove();
    updateCounters();
    markFormDirty();
    section.querySelector('button').focus();
}

function moveSpecRow(select) {
    const row = select.closest('.spec-row');
    const section = ensureSpecGroup(select.value, select.selectedOptions[0].textContent);
    row.querySelector('[name="specs_groups[]"]').value = select.value;
    section.querySelector('.spec-section-rows').appendChild(row);
    row.querySelector('details').open = false;
    filterSpecRows(document.getElementById('spec-search-input').value);
    markFormDirty();
    row.querySelector('summary').focus();
}

function filterSpecRows(keyword) {
    const term = (keyword || '').toLowerCase().trim();
    document.querySelectorAll('#specs-container .spec-section').forEach(section => {
        const groupMatches = section.querySelector('.spec-section-title').textContent.toLowerCase().includes(term);
        section.querySelectorAll('.spec-row').forEach(row => {
            const key = row.querySelector('.spec-key-input').value.toLowerCase();
            const val = row.querySelector('.spec-val-input').value.toLowerCase();
            row.style.display = !term || groupMatches || key.includes(term) || val.includes(term) ? 'flex' : 'none';
        });
    });
}

// Chèn nhanh đoạn mẫu HTML vào bài viết giới thiệu
function insertArticleSnippet(type) {
    const tiny = window.tinymce ? tinymce.get('article-editor') : null;

    let snippet = '';
    switch (type) {
        case 'h2':
            snippet = '<h2>ĐỘT PHÁ THIẾT KẾ ĐÔ THỊ TƯƠNG LAI</h2>';
            break;
        case 'h3':
            snippet = '<h3>Không gian tối ưu từng centimet</h3>';
            break;
        case 'p':
            snippet = '<p>Mẫu xe điện thông minh mang lại trải nghiệm tiện nghi, trẻ trung và hiện đại cho mọi gia đình đô thị.</p>';
            break;
        case 'strong':
            snippet = '<strong>bền bỉ, tiết kiệm vượt trội</strong> ';
            break;
        case 'ul':
            snippet = '<ul><li>Khả năng di chuyển linh hoạt trên mọi cung đường phố hẹp.</li><li>Tiết kiệm chi phí vận hành tối đa chỉ bằng 1/3 xe xăng.</li><li>Bảo hành chính hãng vượt trội lên đến 7–10 năm.</li></ul>';
            break;
        case 'table':
            snippet = '<table style="width: 100%; border-collapse: collapse; margin: 20px 0;" border="1"><thead><tr style="background: #f1f5f9;"><th style="padding: 10px; border: 1px solid #cbd5e1;">Phiên bản</th><th style="padding: 10px; border: 1px solid #cbd5e1;">Giá niêm yết</th><th style="padding: 10px; border: 1px solid #cbd5e1;">Ưu đãi đặc quyền</th></tr></thead><tbody><tr><td style="padding: 10px; border: 1px solid #cbd5e1;">Thuê Pin</td><td style="padding: 10px; border: 1px solid #cbd5e1; font-weight: bold; color: #1464f4;">240.000.000 VNĐ</td><td style="padding: 10px; border: 1px solid #cbd5e1;">Miễn phí sạc 1 năm</td></tr><tr><td style="padding: 10px; border: 1px solid #cbd5e1;">Kèm Pin</td><td style="padding: 10px; border: 1px solid #cbd5e1; font-weight: bold; color: #1464f4;">322.000.000 VNĐ</td><td style="padding: 10px; border: 1px solid #cbd5e1;">Tặng sạc tại nhà 2.2kW</td></tr></tbody></table>';
            break;
        case 'callout':
            snippet = '<div style="background: #eff6ff; border-left: 4px solid #1464f4; padding: 14px 18px; border-radius: 6px; margin: 18px 0;"><p style="margin: 0; font-weight: 600; color: #1e3a8a;">🎉 Ưu đãi đặc quyền: Miễn phí sạc pin 1 năm tại tất cả các trạm sạc V-GREEN trên toàn quốc!</p></div>';
            break;
        case 'cta':
            snippet = '<div style="text-align: center; margin: 28px 0;"><a href="#dau-trang" style="display: inline-block; background: #1464f4; color: #ffffff; padding: 12px 28px; border-radius: 6px; font-weight: bold; text-decoration: none; box-shadow: 0 4px 12px rgba(20, 100, 244, 0.3);">🚗 ĐẶT CỌC NGAY CHỈ VỚI 15 TRIỆU ĐỒNG</a></div>';
            break;
        case 'quote':
            snippet = '<blockquote style="border-left: 4px solid #1464f4; padding: 12px 18px; color: #475569; font-style: italic; background: #f8fafc; border-radius: 0 6px 6px 0; margin: 18px 0;">"Mẫu ô tô điện quốc dân dẫn đầu xu hướng sống xanh và thông minh tại đô thị Việt Nam." — Đánh giá chuyên gia xe</blockquote>';
            break;
        case 'accordion':
            snippet = '<details class="mce-accordion" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px 16px; margin: 12px 0;"><summary style="font-weight: 700; cursor: pointer; color: #0f172a;">Thời gian sạc đầy pin xe mất bao lâu?</summary><p style="margin-top: 10px; color: #475569;">Với trụ sạc nhanh siêu tốc DC, xe chỉ mất 36 phút để sạc từ 10% đến 70% dung lượng pin.</p></details>';
            break;
    }

    if (tiny) {
        tiny.insertContent(snippet);
        tiny.save();
        updateArticleWordCount();
        markFormDirty();
        return;
    }

    // Fallback nếu TinyMCE chưa tải xong
    const editor = document.getElementById('article-editor');
    if (!editor) return;

    const startPos = editor.selectionStart;
    const endPos = editor.selectionEnd;
    const currentVal = editor.value;

    editor.value = currentVal.substring(0, startPos) + snippet + currentVal.substring(endPos, currentVal.length);
    editor.focus();
    editor.selectionStart = startPos + snippet.length;
    editor.selectionEnd = startPos + snippet.length;
    updateArticleWordCount();
    markFormDirty();
}

// Đếm số từ của bài viết
function updateArticleWordCount() {
    const tiny = window.tinymce ? tinymce.get('article-editor') : null;
    const badge = document.getElementById('word-count-badge');
    if (!badge) return;

    if (tiny) {
        const wordCountPlugin = tiny.plugins.wordcount;
        const words = wordCountPlugin ? wordCountPlugin.getCount() : (tiny.getContent({ format: 'text' }).trim() ? tiny.getContent({ format: 'text' }).trim().split(/\s+/).length : 0);
        badge.textContent = `${words} từ`;
        return;
    }

    const editor = document.getElementById('article-editor');
    if (!editor) return;
    const text = editor.value.replace(/<[^>]*>/g, ' ').trim();
    const words = text ? text.split(/\s+/).length : 0;
    badge.textContent = `${words} từ`;
}
updateArticleWordCount();

// Modal Live Preview bài viết
function openArticleLivePreview() {
    const tiny = window.tinymce ? tinymce.get('article-editor') : null;
    const content = tiny ? tiny.getContent() : (document.getElementById('article-editor')?.value || '');
    const modal = document.getElementById('article-preview-modal');
    const container = document.getElementById('article-preview-content');
    if (!modal || !container) return;
    container.innerHTML = content || '<p style="color: #94a3b8; text-align: center;">Chưa có nội dung bài viết để xem trước.</p>';
    modal.style.display = 'flex';
}
function closeArticleLivePreview() {
    const modal = document.getElementById('article-preview-modal');
    if (modal) modal.style.display = 'none';
}

// Cập nhật số đếm trên các badge và pill nav
function updateCounters() {
    const vRows = document.querySelectorAll('#variants-container .variant-row');
    const vCount = vRows.length;
    const cCount = document.querySelectorAll('#colors-container .color-row').length;
    const bCount = document.querySelectorAll('#banners-container .banner-row').length;
    const vdCount = document.querySelectorAll('#videos-container .video-row').length;
    const iCount = document.querySelectorAll('#interiors-container .interior-row').length;
    const hCount = document.querySelectorAll('#highlights-container .highlight-row').length;
    const sCount = document.querySelectorAll('#specs-container .spec-row').length;

    // Cập nhật lại số thứ tự phiên bản #1, #2...
    vRows.forEach((row, idx) => {
        const badge = row.querySelector('span[style*="background: #eff6ff"]');
        if (badge) {
            badge.textContent = `Phiên bản #${idx + 1}`;
        }
    });

    if (vCount === 0 && !document.getElementById('no-variants-placeholder')) {
        const vc = document.getElementById('variants-container');
        if (vc) {
            vc.innerHTML = '<div id="no-variants-placeholder" style="text-align: center; padding: 24px; background: var(--admin-bg); border-radius: 6px; border: 1px dashed var(--admin-border); color: var(--admin-muted); font-size: 0.85rem;">Chưa có phiên bản riêng nào. Bấm <strong>+ Thêm Phiên Bản</strong> ở trên để tạo phiên bản xe.</div>';
        }
    }

    const elV = document.getElementById('badge-count-variants'); if (elV) elV.textContent = `${vCount} phiên bản`;
    const elC = document.getElementById('badge-count-colors'); if (elC) elC.textContent = `${cCount} màu`;
    const elB = document.getElementById('badge-count-banners'); if (elB) elB.textContent = `${bCount} banner`;
    const elVd = document.getElementById('badge-count-videos'); if (elVd) elVd.textContent = `${vdCount} video`;
    const elI = document.getElementById('badge-count-interiors'); if (elI) elI.textContent = `${iCount} ảnh nội thất`;
    const elH = document.getElementById('badge-count-highlights'); if (elH) elH.textContent = `${hCount} thông số`;
    const elS = document.getElementById('badge-count-specs'); if (elS) elS.textContent = `${sCount} mục thông số`;

    const pV = document.getElementById('pill-count-variants'); if (pV) pV.textContent = vCount;
    const pC = document.getElementById('pill-count-colors'); if (pC) pC.textContent = cCount;
    const pB = document.getElementById('pill-count-banners'); if (pB) pB.textContent = bCount;
    const pVd = document.getElementById('pill-count-videos'); if (pVd) pVd.textContent = vdCount;
    const pI = document.getElementById('pill-count-interiors'); if (pI) pI.textContent = iCount;
    const pH = document.getElementById('pill-count-highlights'); if (pH) pH.textContent = hCount;
    const pS = document.getElementById('pill-count-specs'); if (pS) pS.textContent = sCount;

    if (typeof markFormDirty === 'function') {
        markFormDirty();
    }
}

// Quản lý trạng thái Dirty của Form & Phím tắt Ctrl + S
let formIsDirty = false;
function markFormDirty() {
    formIsDirty = true;
    const status = document.getElementById('unsaved-status-indicator');
    if (status) {
        status.style.color = '#9a3412';
        status.style.background = '#ffedd5';
        status.textContent = '● Có thay đổi chưa lưu';
    }
}

const productForm = document.getElementById('vf-product-form');
if (productForm) {
    productForm.addEventListener('input', markFormDirty);
    productForm.addEventListener('change', markFormDirty);
    productForm.addEventListener('submit', () => {
        if (window.tinymce) {
            tinymce.triggerSave();
        }
        formIsDirty = false;
        const btn = document.getElementById('btn-save-product');
        const text = document.getElementById('save-btn-text');
        if (btn && text) {
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
            text.textContent = '⏳ Đang lưu dữ liệu...';
        }
    });
}

// Bắt phím tắt Ctrl + S hoặc Cmd + S để lưu nhanh
window.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
        e.preventDefault();
        if (window.tinymce) {
            tinymce.triggerSave();
        }
        const form = document.getElementById('vf-product-form');
        if (form) form.requestSubmit();
    }
});

// Cảnh báo khi rời trang nếu có thay đổi chưa lưu
window.addEventListener('beforeunload', (e) => {
    if (formIsDirty) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// =========================================================================
// HÀM TÍCH HỢP MEDIA MANAGER POPUP CHUNG VÀO CÁC Ô CHỌN ẢNH SẢN PHẨM
// =========================================================================

// 1. Chọn & Xóa ảnh đại diện xe chính
function openMainThumbnailMediaPicker() {
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn làm ảnh đại diện',
        onSelect: function(media) {
            const input = document.getElementById('main_thumbnail_media_id');
            const preview = document.getElementById('product-thumb-preview');
            const nameEl = document.getElementById('main_thumb_filename');
            const clearBtn = document.getElementById('btn_clear_main_thumb');
            if (input) input.value = media.id;
            if (preview) {
                preview.innerHTML = `<img src="${media.url}" alt="${media.alt_text || media.filename}" style="width: 100%; height: 100%; object-fit: contain;">`;
            }
            if (nameEl) {
                nameEl.textContent = `${media.filename} ${media.alt_text ? '(' + media.alt_text + ')' : ''}`;
            }
            if (clearBtn) clearBtn.style.display = 'inline-flex';
            markFormDirty();
        }
    });
}

function removeMainThumbnail() {
    const input = document.getElementById('main_thumbnail_media_id');
    const preview = document.getElementById('product-thumb-preview');
    const nameEl = document.getElementById('main_thumb_filename');
    const clearBtn = document.getElementById('btn_clear_main_thumb');
    if (input) input.value = '';
    if (preview) {
        preview.innerHTML = `<span style="font-size: 0.72rem; color: var(--admin-muted);">Chưa có</span>`;
    }
    if (nameEl) {
        nameEl.textContent = 'Chưa chọn ảnh đại diện cho xe (Bấm nút trên để chọn từ popup)';
    }
    if (clearBtn) clearBtn.style.display = 'none';
    markFormDirty();
}

// 2. Chọn & Xóa ảnh cho phiên bản (Variant)
function chooseVariantImage(btn) {
    const row = btn.closest('.variant-row');
    const input = row.querySelector('.variant-media-id-input');
    const preview = row.querySelector('.variant-img-preview');
    const nameEl = row.querySelector('.variant-img-name');
    const removeBtn = row.querySelector('.variant-img-remove-btn');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh cho phiên bản này',
        onSelect: function(media) {
            if (input) input.value = media.id;
            if (preview) {
                preview.innerHTML = `<img src="${media.url}" alt="${media.alt_text || media.filename}" style="width: 100%; height: 100%; object-fit: contain;">`;
            }
            if (nameEl) nameEl.textContent = media.filename;
            if (removeBtn) removeBtn.style.display = 'inline-flex';
            markFormDirty();
        }
    });
}

function removeVariantImage(btn) {
    const row = btn.closest('.variant-row');
    const input = row.querySelector('.variant-media-id-input');
    const preview = row.querySelector('.variant-img-preview');
    const nameEl = row.querySelector('.variant-img-name');
    if (input) input.value = '';
    if (preview) {
        preview.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>`;
    }
    if (nameEl) nameEl.textContent = 'Dùng ảnh chính của xe';
    btn.style.display = 'none';
    markFormDirty();
}

// 3. Chọn & Xóa ảnh theo màu sắc (Color Studio)
function chooseColorImage(btn) {
    const row = btn.closest('.color-row');
    const input = row.querySelector('.color-media-id-input');
    const preview = row.querySelector('.color-img-preview');
    const nameEl = row.querySelector('.color-img-name');
    const removeBtn = row.querySelector('.color-img-remove-btn');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh xe theo màu này',
        onSelect: function(media) {
            if (input) input.value = media.id;
            if (preview) {
                preview.innerHTML = `<img src="${media.url}" alt="${media.alt_text || media.filename}" style="width: 100%; height: 100%; object-fit: contain;">`;
            }
            if (nameEl) nameEl.textContent = media.filename;
            if (removeBtn) removeBtn.style.display = 'inline-flex';
            markFormDirty();
        }
    });
}

function removeColorImage(btn) {
    const row = btn.closest('.color-row');
    const input = row.querySelector('.color-media-id-input');
    const preview = row.querySelector('.color-img-preview');
    const nameEl = row.querySelector('.color-img-name');
    if (input) input.value = '';
    if (preview) {
        preview.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>`;
    }
    if (nameEl) nameEl.textContent = 'Chưa có ảnh góc ngang';
    btn.style.display = 'none';
    markFormDirty();
}

// 4. Chọn & Xóa ảnh Banner Hero (Tỷ lệ 16:9 / 19:6)
function chooseBannerImage(btn) {
    const row = btn.closest('.banner-row');
    const input = row.querySelector('.banner-media-id-input');
    const preview = row.querySelector('.banner-img-preview');
    const nameEl = row.querySelector('.banner-img-name');
    const removeBtn = row.querySelector('.banner-img-remove-btn');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh banner',
        onSelect: function(media) {
            if (input) input.value = media.id;
            if (preview) {
                preview.innerHTML = `<img src="${media.url}" alt="${media.alt_text || media.filename}" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            if (nameEl) nameEl.textContent = media.filename;
            if (removeBtn) removeBtn.style.display = 'inline-flex';
            markFormDirty();
        }
    });
}

function removeBannerImage(btn) {
    const row = btn.closest('.banner-row');
    const input = row.querySelector('.banner-media-id-input');
    const preview = row.querySelector('.banner-img-preview');
    const nameEl = row.querySelector('.banner-img-name');
    if (input) input.value = '';
    if (preview) {
        preview.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">16:9 / 19:6</span>`;
    }
    if (nameEl) nameEl.textContent = 'Chưa chọn ảnh banner';
    btn.style.display = 'none';
    markFormDirty();
}

// 4.1. Quản lý danh sách Video 16:9 giới thiệu xe (Multi-video)
function addNewVideoRow(data = {}) {
    const placeholder = document.getElementById('no-videos-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('videos-container');
    const div = document.createElement('div');
    div.className = 'video-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 16px; margin-bottom: 16px; position: relative;';

    const count = container.querySelectorAll('.video-row').length + 1;
    const vUrl = data.video_url || '';
    const pUrl = data.poster_url || '';

    div.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
            <span style="font-size: 0.8rem; font-weight: 700; color: #4338ca; background: #eef2ff; padding: 3px 10px; border-radius: 12px;">
                Video #<span class="video-index">${count}</span>
            </span>
            <button type="button" onclick="this.closest('.video-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.3rem; padding: 0 6px; line-height: 1;" title="Xóa video này">
                &times;
            </button>
        </div>

        <div style="display: grid; grid-template-columns: 1.1fr 1.3fr; gap: 20px; align-items: start;">
            <div>
                <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 6px;">Xem trước Video (16:9)</label>
                <div class="video-preview-wrapper" style="position: relative; width: 100%; aspect-ratio: 16 / 9; background: #0f172a; border-radius: 6px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid var(--admin-border);">
                    <video class="admin-row-video-player"
                           controls
                           playsinline
                           poster="${pUrl}"
                           style="width: 100%; height: 100%; object-fit: contain; ${vUrl ? '' : 'display: none;'}">
                        <source class="admin-row-video-source" src="${vUrl}" type="video/mp4">
                        Trình duyệt không hỗ trợ thẻ video.
                    </video>
                    <div class="admin-row-video-placeholder" style="text-align: center; color: #94a3b8; padding: 16px; ${vUrl ? 'display: none;' : ''}">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 6px; display: block; opacity: 0.6;"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        <span style="font-size: 0.8rem;">Chưa chọn file video. Bấm "Chọn Media" để thêm.</span>
                    </div>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 10px;">
                    <div>
                        <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Tiêu đề Video</label>
                        <input type="text" name="video_titles[]" value="${data.title || ''}" placeholder="VD: Video mô phỏng xe điện VinFast VF 3" class="vf-admin-input video-title-input" style="padding: 6px 10px; font-size: 0.85rem;">
                    </div>
                    <div>
                        <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Phụ đề / Ghi chú</label>
                        <input type="text" name="video_subtitles[]" value="${data.subtitle || ''}" placeholder="VD: Khám phá ngoại thất" class="vf-admin-input video-subtitle-input" style="padding: 6px 10px; font-size: 0.85rem;">
                    </div>
                </div>

                <div>
                    <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Tệp Video (MP4 / WEBM - tối đa 50MB)</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" name="video_paths[]" value="${data.video_path || ''}" placeholder="clients/assets/videos/..." class="vf-admin-input video-path-input" style="padding: 6px 10px; font-size: 0.85rem;" readonly>
                        <input type="hidden" name="video_media_ids[]" value="${data.video_media_id || ''}" class="video-media-id-input">
                        <button type="button" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="white-space: nowrap; padding: 6px 12px; font-size: 0.8rem;" onclick="chooseVideoMedia(this)">
                            Chọn Media
                        </button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="white-space: nowrap; padding: 6px 10px; font-size: 0.8rem; color: #ef4444; border-color: #fca5a5;" onclick="clearVideoMedia(this)">
                            Xóa
                        </button>
                    </div>
                </div>

                <div>
                    <label class="vf-admin-label" style="font-size: 0.75rem; font-weight: 600; margin-bottom: 4px;">Ảnh Bìa Video (Poster - tối ưu SEO)</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" name="video_poster_paths[]" value="${data.poster_path || ''}" placeholder="Để trống sẽ dùng ảnh đại diện xe" class="vf-admin-input video-poster-path-input" style="padding: 6px 10px; font-size: 0.85rem;" readonly>
                        <input type="hidden" name="video_poster_media_ids[]" value="${data.poster_media_id || ''}" class="video-poster-media-id-input">
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="white-space: nowrap; padding: 6px 12px; font-size: 0.8rem;" onclick="chooseVideoPoster(this)">
                            Chọn ảnh bìa
                        </button>
                        <button type="button" class="vinfast-autohaiphong_admin_btn" style="white-space: nowrap; padding: 6px 10px; font-size: 0.8rem; color: #ef4444; border-color: #fca5a5;" onclick="clearVideoPoster(this)">
                            Xóa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

function chooseVideoMedia(btn) {
    const row = btn.closest('.video-row');
    const inputPath = row.querySelector('.video-path-input');
    const inputMediaId = row.querySelector('.video-media-id-input');
    const player = row.querySelector('.admin-row-video-player');
    const source = row.querySelector('.admin-row-video-source');
    const placeholder = row.querySelector('.admin-row-video-placeholder');

    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn video này cho xe',
        onSelect: function(media) {
            if (inputPath) inputPath.value = media.path || '';
            if (inputMediaId) inputMediaId.value = media.id || '';

            if (player && source && media.url) {
                source.src = media.url;
                player.load();
                player.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            }
            markFormDirty();
        }
    });
}

function clearVideoMedia(btn) {
    const row = btn.closest('.video-row');
    const inputPath = row.querySelector('.video-path-input');
    const inputMediaId = row.querySelector('.video-media-id-input');
    const player = row.querySelector('.admin-row-video-player');
    const source = row.querySelector('.admin-row-video-source');
    const placeholder = row.querySelector('.admin-row-video-placeholder');

    if (inputPath) inputPath.value = '';
    if (inputMediaId) inputMediaId.value = '';
    if (source) source.src = '';
    if (player) {
        player.pause();
        player.style.display = 'none';
    }
    if (placeholder) placeholder.style.display = 'block';
    markFormDirty();
}

function chooseVideoPoster(btn) {
    const row = btn.closest('.video-row');
    const inputPath = row.querySelector('.video-poster-path-input');
    const inputMediaId = row.querySelector('.video-poster-media-id-input');
    const player = row.querySelector('.admin-row-video-player');

    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh bìa video',
        onSelect: function(media) {
            if (inputPath) inputPath.value = media.path || '';
            if (inputMediaId) inputMediaId.value = media.id || '';
            if (player && media.url) {
                player.poster = media.url;
            }
            markFormDirty();
        }
    });
}

function clearVideoPoster(btn) {
    const row = btn.closest('.video-row');
    const inputPath = row.querySelector('.video-poster-path-input');
    const inputMediaId = row.querySelector('.video-poster-media-id-input');
    const player = row.querySelector('.admin-row-video-player');

    if (inputPath) inputPath.value = '';
    if (inputMediaId) inputMediaId.value = '';
    if (player) player.poster = '';
    markFormDirty();
}

// 5. Chọn & Xóa ảnh nội thất đơn lẻ
function chooseInteriorImage(btn) {
    const row = btn.closest('.interior-row');
    const input = row.querySelector('.interior-media-id-input');
    const preview = row.querySelector('.interior-img-preview');
    const nameEl = row.querySelector('.interior-img-name');
    const removeBtn = row.querySelector('.interior-img-remove-btn');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh nội thất này',
        onSelect: function(media) {
            if (input) input.value = media.id;
            if (preview) {
                preview.innerHTML = `<img src="${media.url}" alt="${media.alt_text || media.filename}" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            if (nameEl) nameEl.textContent = media.filename;
            if (removeBtn) removeBtn.style.display = 'inline-flex';
            markFormDirty();
        }
    });
}

function removeInteriorImage(btn) {
    const row = btn.closest('.interior-row');
    const input = row.querySelector('.interior-media-id-input');
    const preview = row.querySelector('.interior-img-preview');
    const nameEl = row.querySelector('.interior-img-name');
    if (input) input.value = '';
    if (preview) {
        preview.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>`;
    }
    if (nameEl) nameEl.textContent = 'Chưa có ảnh nội thất';
    btn.style.display = 'none';
    markFormDirty();
}

// 6. Thêm hàng loạt ảnh nội thất từ Media Manager (Batch Add)
function batchAddInteriorsFromMedia() {
    window.openMediaManager({
        mode: 'multiple',
        confirmText: 'Thêm vào bộ sưu tập nội thất',
        onSelect: function(selected) {
            const items = Array.isArray(selected) ? selected : [selected];
            items.forEach(img => {
                addNewInteriorRow({
                    caption: img.alt_text || img.filename.replace(/\.[^/.]+$/, ""),
                    media_id: img.id,
                    media_url: img.url,
                    media_filename: img.filename
                });
            });
        }
    });
}

// 7. Chèn một hoặc nhiều ảnh vào bài viết giới thiệu (Tự động tạo figure & figcaption cho TinyMCE)
function openArticleMediaPicker() {
    window.openMediaManager({
        mode: 'multiple',
        confirmText: 'Chèn vào bài viết',
        onSelect: function(selected) {
            const items = Array.isArray(selected) ? selected : [selected];
            if (items.length === 0) return;

            let htmlToInsert = '';
            items.forEach(img => {
                const alt = img.alt_text || img.filename || 'Ảnh minh họa VinFast';
                const caption = img.alt_text || img.original_filename || img.filename.replace(/\.[^/.]+$/, "");
                htmlToInsert += `
<figure class="image" style="display: table; margin: 24px auto; text-align: center; max-width: 100%;">
    <img src="${img.url}" alt="${alt}" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,0,0,0.08);" />
    <figcaption style="display: table-caption; caption-side: bottom; font-size: 0.85rem; color: #64748b; margin-top: 8px; font-style: italic;">${caption}</figcaption>
</figure><p></p>`;
            });

            const tiny = window.tinymce ? tinymce.get('article-editor') : null;
            if (tiny) {
                tiny.insertContent(htmlToInsert);
                tiny.save();
                updateArticleWordCount();
                markFormDirty();
                return;
            }

            // Fallback nếu TinyMCE chưa bật
            const editor = document.getElementById('article-editor');
            if (!editor) return;
            const startPos = editor.selectionStart;
            const endPos = editor.selectionEnd;
            const currentVal = editor.value;

            editor.value = currentVal.substring(0, startPos) + htmlToInsert + currentVal.substring(endPos, currentVal.length);
            editor.focus();
            editor.selectionStart = startPos + htmlToInsert.length;
            editor.selectionEnd = startPos + htmlToInsert.length;

            updateArticleWordCount();
            markFormDirty();
        }
    });
}

// Khởi tạo TinyMCE 7 Full Chức Năng Free cho Bài Viết Giới Thiệu Xe
function initProductArticleTinyMCE() {
    if (!window.tinymce) {
        console.warn('TinyMCE CDN chưa sẵn sàng.');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const uploadUrl = '{{ route("admin.media.store") }}';

    tinymce.init({
        selector: '#article-editor',
        height: 'calc(100vh - 90px)',
        min_height: 550,
        toolbar_sticky: true,
        toolbar_sticky_offset: document.querySelector('.vf-admin-quick-nav')?.offsetHeight || 0,
        auto_focus: false,
        menubar: 'file edit view insert format tools table help',
        menu: {
            insert: {
                title: 'Chèn',
                items: 'mediaManager | image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor | insertdatetime'
            }
        },
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'wordcount', 'accordion', 'emoticons',
            'directionality', 'quickbars'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                 'alignleft aligncenter alignright alignjustify | ' +
                 'mediaManager image media link table | bullist numlist accordion | ' +
                 'forecolor backcolor removeformat | charmap emoticons | code fullscreen preview',
        quickbars_selection_toolbar: 'bold italic underline | quicklink h2 h3 blockquote',
        quickbars_insert_toolbar: 'mediaManager image table',
        branding: false,
        promotion: false,
        convert_urls: false,
        relative_urls: false,
        image_caption: true,
        image_advtab: true,
        image_title: true,
        table_responsive_width: true,
        table_default_attributes: {
            border: '1'
        },
        table_default_styles: {
            'border-collapse': 'collapse',
            'width': '100%'
        },
        block_formats: 'Đoạn văn=p; Tiêu đề lớn (H2)=h2; Tiêu đề vừa (H3)=h3; Tiêu đề nhỏ (H4)=h4; Tiêu đề phụ (H5)=h5; Trích dẫn khối=blockquote; Khối mã=pre',
        font_family_formats: 'Open Sans=Open Sans,sans-serif; Arial=arial,helvetica,sans-serif; Segoe UI=Segoe UI,sans-serif; Roboto=Roboto,sans-serif; Times New Roman=times new roman,times; Courier New=courier new,courier;',
        font_size_formats: '12px 13px 14px 15px 16px 18px 20px 24px 28px 32px 36px',
        content_style: `
            html, body {
                overflow-y: auto !important;
                min-height: 100%;
            }
            body {
                font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                font-size: 15px;
                line-height: 1.8;
                color: #334155;
                padding: 18px 24px;
                max-width: 100%;
                box-sizing: border-box;
            }
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f5f9;
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
            figure.image {
                display: table;
                margin: 24px auto;
                text-align: center;
                max-width: 100%;
            }
            figure.image img {
                max-width: 100%;
                height: auto;
                border-radius: 8px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.08);
                display: block;
                margin: 0 auto;
            }
            figure.image figcaption {
                display: table-caption;
                caption-side: bottom;
                font-size: 0.85rem;
                color: #64748b;
                margin-top: 8px;
                font-style: italic;
                padding: 4px 8px;
                cursor: text;
            }
            img {
                max-width: 100%;
                height: auto;
                border-radius: 8px;
            }
            h2 { font-size: 1.6rem; font-weight: 700; color: #0f172a; margin-top: 28px; margin-bottom: 12px; line-height: 1.3; }
            h3 { font-size: 1.3rem; font-weight: 600; color: #0f172a; margin-top: 22px; margin-bottom: 10px; line-height: 1.35; }
            h4 { font-size: 1.15rem; font-weight: 600; color: #0f172a; margin-top: 18px; margin-bottom: 8px; }
            p { margin-bottom: 14px; }
            table { border-collapse: collapse; width: 100%; margin: 20px 0; border: 1px solid #cbd5e1; }
            th, td { border: 1px solid #cbd5e1; padding: 10px 14px; }
            th { background-color: #f8fafc; font-weight: 700; color: #1e293b; }
            blockquote { border-left: 4px solid #1464f4; padding: 12px 18px; color: #475569; font-style: italic; background: #f8fafc; border-radius: 0 6px 6px 0; margin: 18px 0; }
        `,
        images_upload_handler: function (blobInfo, progress) {
            return new Promise(function (resolve, reject) {
                const MAX_ADMIN_BYTES = 10 * 1024 * 1024; // 10MB
                if (blobInfo.blob().size > MAX_ADMIN_BYTES) {
                    reject('Dung lượng ảnh vượt quá giới hạn 10MB.');
                    return;
                }

                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', uploadUrl);
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.onprogress = function (e) {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = function () {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        let errMsg = 'Tải ảnh thất bại: HTTP ' + xhr.status;
                        try {
                            const errJson = JSON.parse(xhr.responseText);
                            errMsg = errJson.errors?.file?.[0] || errJson.message || errMsg;
                        } catch (e) {}
                        reject(errMsg);
                        return;
                    }
                    let json;
                    try {
                        json = JSON.parse(xhr.responseText);
                    } catch (err) {
                        reject('Phản hồi server không hợp lệ');
                        return;
                    }
                    if (!json || (!json.location && !json.url)) {
                        reject('Không tìm thấy đường dẫn ảnh trong phản hồi');
                        return;
                    }
                    resolve(json.location || json.url);
                };

                xhr.onerror = function () {
                    reject('Lỗi mạng khi tải ảnh lên.');
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('folder', 'products');
                xhr.send(formData);
            });
        },
        setup: function (editor) {
            // Nút custom mở Popup Thư viện Media Manager
            editor.ui.registry.addButton('mediaManager', {
                icon: 'gallery',
                text: 'Thư viện ảnh',
                tooltip: 'Mở Thư viện Media Manager để chèn ảnh có figure & chú thích tự động',
                onAction: function () {
                    openArticleMediaPicker();
                }
            });

            // Menu item mở Thư viện Media
            editor.ui.registry.addMenuItem('mediaManager', {
                icon: 'gallery',
                text: '🖼 Thư viện ảnh VinFast (Tự động chú thích)',
                onAction: function () {
                    openArticleMediaPicker();
                }
            });

            // Tự động đồng bộ số từ & trạng thái dirty
            function syncEditorData() {
                const badge = document.getElementById('word-count-badge');
                if (badge) {
                    const wordCountPlugin = editor.plugins.wordcount;
                    const words = wordCountPlugin ? wordCountPlugin.getCount() : (editor.getContent({ format: 'text' }).trim() ? editor.getContent({ format: 'text' }).trim().split(/\s+/).length : 0);
                    badge.textContent = `${words} từ`;
                }
            }

            editor.on('init', function () {
                syncEditorData();

            });
            editor.on('keyup change undo redo NodeChange', function () {
                syncEditorData();
                markFormDirty();
                editor.save();
            });
        }
    });
}
function initQuickNavScrollSpy() {
    const navPills = Array.from(document.querySelectorAll('.vf-admin-quick-nav-pill'));
    if (!navPills.length) return;

    const quickNav = document.querySelector('.vf-admin-quick-nav');
    if (quickNav) {
        // Hỗ trợ cuộn ngang mượt mà khi lăn chuột con lăn mà không cần thanh cuộn hiển thị
        quickNav.addEventListener('wheel', (e) => {
            if (e.deltaY !== 0 && quickNav.scrollWidth > quickNav.clientWidth) {
                e.preventDefault();
                quickNav.scrollLeft += e.deltaY;
            }
        }, { passive: false });
    }

    const sections = navPills.map(pill => {
        const hash = pill.getAttribute('href');
        if (hash && hash.startsWith('#')) {
            const el = document.querySelector(hash);
            return el ? { id: hash.substring(1), el, pill } : null;
        }
        return null;
    }).filter(Boolean);

    if (!sections.length) return;

    let isClickScrolling = false;
    let clickTimeout = null;

    navPills.forEach(pill => {
        pill.addEventListener('click', function() {
            navPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            isClickScrolling = true;
            clearTimeout(clickTimeout);
            clickTimeout = setTimeout(() => { isClickScrolling = false; }, 800);
        });
    });

    function onScrollSpy() {
        if (isClickScrolling) return;

        const navHeight = quickNav ? quickNav.offsetHeight : 45;
        const scrollPos = window.scrollY + navHeight + 60;

        let activeIndex = -1;

        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 60) {
            activeIndex = sections.length - 1;
        } else {
            for (let i = sections.length - 1; i >= 0; i--) {
                const rect = sections[i].el.getBoundingClientRect();
                const elTop = rect.top + window.scrollY;
                if (scrollPos >= elTop) {
                    activeIndex = i;
                    break;
                }
            }
        }

        if (activeIndex === -1 && sections.length > 0) {
            activeIndex = 0;
        }

        sections.forEach((sec, idx) => {
            if (idx === activeIndex) {
                sec.pill.classList.add('active');
            } else {
                sec.pill.classList.remove('active');
            }
        });
    }

    window.addEventListener('scroll', onScrollSpy, { passive: true });
    onScrollSpy();
}
</script>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.key', 'no-api-key') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initQuickNavScrollSpy();
    initProductArticleTinyMCE();
});
</script>
@endpush
@endsection
