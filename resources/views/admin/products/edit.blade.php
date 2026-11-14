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

    /* Box Bài Viết Giới Thiệu & Sticky Scroll Architecture */
    .vf-editor-anchor-wrapper {
        min-height: 1050px;
        height: fit-content;
        margin-bottom: 24px;
        position: relative;
    }
    #bai-viet-gioi-thieu {
        min-height: 1000px;
        height: fit-content;
        position: sticky;
        top: 15px;
        z-index: 30;
        margin-bottom: 0;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.25s ease, border-color 0.25s ease;
    }
    #bai-viet-gioi-thieu.is-stuck-top {
        height: calc(100vh - 95px) !important;
        max-height: calc(100vh - 95px) !important;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(20, 100, 244, 0.2);
        border-color: #93c5fd;
    }
    #bai-viet-gioi-thieu .tox-tinymce {
        min-height: 850px;
        height: fit-content;
        border-radius: 6px;
        border: 1px solid var(--admin-border);
    }
    #bai-viet-gioi-thieu.is-stuck-top .tox-tinymce {
        flex: 1;
        min-height: 0 !important;
        height: 100% !important;
        max-height: 100% !important;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    #bai-viet-gioi-thieu.is-stuck-top .tox-editor-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
    }
    #bai-viet-gioi-thieu.is-stuck-top .tox-sidebar-wrap {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
    }
    #bai-viet-gioi-thieu.is-stuck-top .tox-edit-area {
        flex: 1;
        min-height: 0 !important;
        height: 100% !important;
        overflow: hidden;
    }
    #bai-viet-gioi-thieu.is-stuck-top .tox-edit-area iframe {
        height: 100% !important;
        min-height: 0 !important;
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

    /* Quick Anchor Nav */
    .vf-admin-quick-nav {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding: 6px 0 16px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--admin-border);
        scrollbar-width: thin;
    }
    .vf-admin-quick-nav-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: #ffffff;
        border: 1px solid var(--admin-border);
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--admin-text);
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .vf-admin-quick-nav-pill:hover {
        background: #eff6ff;
        color: var(--admin-primary);
        border-color: #bfdbfe;
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
    <a href="#bo-suu-tap-mau-sac" class="vf-admin-quick-nav-pill">
        <span>④ Màu Sắc (Studio)</span>
        <span class="vf-admin-card-badge" id="pill-count-colors">{{ $colors->count() }}</span>
    </a>
    <a href="#banner-hero-san-pham" class="vf-admin-quick-nav-pill">
        <span>⑤ Banner Hero 19:6</span>
        <span class="vf-admin-card-badge" id="pill-count-banners">{{ $banners->count() }}</span>
    </a>
    <a href="#anh-noi-that-bento" class="vf-admin-quick-nav-pill">
        <span>⑥ Ảnh Nội Thất (Bento)</span>
        <span class="vf-admin-card-badge" id="pill-count-interiors">{{ $interiors->count() }}</span>
    </a>
    <a href="#thong-so-noi-bat" class="vf-admin-quick-nav-pill">
        <span>⑦ Thông Số Nổi Bật</span>
        <span class="vf-admin-card-badge" id="pill-count-highlights">{{ $specHighlights->count() }}</span>
    </a>
    <a href="#thong-so-ky-thuat-specs" class="vf-admin-quick-nav-pill">
        <span>⑧ Thông Số Key-Value</span>
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
                        <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>🟢 Đang kinh doanh</option>
                        <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>⚪ Tạm dừng bán</option>
                        <option value="coming_soon" {{ old('status', $product->status) === 'coming_soon' ? 'selected' : '' }}>🟡 Sắp ra mắt</option>
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
                        <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 6px;">
                            <select name="thumbnail_media_id" id="main_thumbnail_select" onchange="updateMainThumbPreview(this)" class="vf-admin-select" style="font-size: 0.82rem; flex: 1;">
                                <option value="" data-src="">-- Chọn ảnh xe từ Thư viện Media --</option>
                                @foreach($mediaList as $m)
                                    <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ $product->thumbnail_media_id == $m->id ? 'selected' : '' }}>
                                        {{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="openMainThumbnailMediaPicker()" style="padding: 7px 12px; font-size: 0.82rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; white-space: nowrap; display: inline-flex; align-items: center; gap: 5px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                🖼 Mở Thư Viện Ảnh
                            </button>
                        </div>
                        <div class="vf-admin-helper-text">
                            Hỗ trợ chọn ảnh từ thư viện hoặc tải lên hàng loạt ảnh qua popup chung.
                        </div>
                    </div>
                </div>
            </div>

            <div class="vf-admin-input-group" style="margin-bottom: 0;">
                <label class="vf-admin-label">Mô Tả Ngắn Gọn (Hiển thị thẻ SEO & Meta)</label>
                <textarea name="short_description" rows="2" class="vf-admin-textarea" placeholder="Mô tả tóm tắt tính năng, ưu điểm nổi bật của dòng xe...">{{ old('short_description', $product->short_description) }}</textarea>
            </div>
        </div>

        {{-- BOX 2: PHIÊN BẢN & BIẾN THỂ XE (VARIANTS) --}}
        <div class="vinfast-autohaiphong_admin_card" id="phien-ban-xe" style="margin-bottom: 0;">
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
                            <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
                                <div class="variant-img-preview" style="width: 54px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @if(!empty($variant->thumbnail_path))
                                        <img src="{{ asset('storage/' . $variant->thumbnail_path) }}" alt="{{ $variant->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    @else
                                        <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>
                                    @endif
                                </div>
                                <div style="flex: 1; display: flex; gap: 6px; align-items: center;">
                                    <div style="flex: 1;">
                                        <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Ảnh Riêng Cho Phiên Bản Này</label>
                                        <select name="variant_thumbnail_media_ids[]" onchange="updateVariantImgPreview(this)" class="vf-admin-select variant-thumb-select" style="padding: 5px 8px; font-size: 0.82rem;">
                                            <option value="" data-src="">-- Dùng ảnh chính của xe --</option>
                                            @foreach($mediaList as $m)
                                                <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($variant->thumbnail_media_id) && $variant->thumbnail_media_id == $m->id) ? 'selected' : '' }}>
                                                    {{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" onclick="chooseVariantImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                                        🖼 Chọn
                                    </button>
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
    <div id="bai-viet-gioi-thieu-anchor" class="vf-editor-anchor-wrapper">
        <div class="vinfast-autohaiphong_admin_card" id="bai-viet-gioi-thieu">
            <div class="vf-admin-card-header">
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
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 10px; padding: 8px 12px; background: #f8fafc; border-radius: 6px; border: 1px solid var(--admin-border); align-items: center;">
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

            <textarea name="description_html" id="article-editor" rows="12" class="vf-admin-textarea" 
                      style="font-family: Consolas, Monaco, 'Courier New', monospace; font-size: 0.88rem; line-height: 1.6;"
                      placeholder="Nhập nội dung HTML bài viết giới thiệu chi tiết, đánh giá vận hành, thiết kế, pin và bảng giá ưu đãi xe..."
                      oninput="updateArticleWordCount()">{{ old('description_html', $product->description_html) }}</textarea>
            <div class="vf-admin-helper-text">
                Nội dung hiển thị trọn vẹn tại mục Bài Viết Giới Thiệu của trang xe. Hệ thống tự động lọc thẻ HTML an toàn chuẩn bảo mật.
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- HÀNG 3: [BỘ SƯU TẬP MÀU SẮC XE] (Trái) & [BANNER HERO SẢN PHẨM] (Phải)    --}}
    {{-- ========================================================================= --}}
    <div class="vf-admin-section-grid vf-admin-grid-middle">
        {{-- BOX 4: BỘ SƯU TẬP MÀU SẮC XE (COLOR STUDIO) --}}
        <div class="vinfast-autohaiphong_admin_card" id="bo-suu-tap-mau-sac" style="margin-bottom: 0;">
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
                            <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
                                <div class="color-img-preview" style="width: 58px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @if(!empty($col->image_path))
                                        <img src="{{ asset('storage/' . $col->image_path) }}" alt="{{ $col->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                                    @else
                                        <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
                                    @endif
                                </div>
                                <div style="flex: 1; display: flex; gap: 6px; align-items: center;">
                                    <div style="flex: 1;">
                                        <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Ảnh Xe Góc Ngang Side-View Theo Màu</label>
                                        <select name="color_image_media_ids[]" onchange="updateColorImgPreview(this)" class="vf-admin-select color-img-select" style="padding: 5px 8px; font-size: 0.82rem;">
                                            <option value="" data-src="">-- Chọn ảnh xe theo màu này --</option>
                                            @foreach($mediaList as $m)
                                                <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($col->image_media_id) && $col->image_media_id == $m->id) ? 'selected' : '' }}>
                                                    {{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" onclick="chooseColorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                                        🖼 Chọn
                                    </button>
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
                                <div class="banner-img-preview" style="width: 110px; height: 35px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @php
                                        $bImgPath = $banner->media_path ?: $banner->image_path;
                                    @endphp
                                    @if(!empty($bImgPath))
                                        <img src="{{ asset('storage/' . ltrim($bImgPath, '/')) }}" alt="{{ $banner->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">19:6</span>
                                    @endif
                                </div>
                                <div style="flex: 1.2; display: flex; gap: 6px; align-items: center;">
                                    <div style="flex: 1;">
                                        <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Chọn từ Thư viện Media</label>
                                        <select name="banner_image_media_ids[]" onchange="updateBannerImgPreview(this)" class="vf-admin-select banner-img-select" style="padding: 5px 8px; font-size: 0.82rem;">
                                            <option value="" data-src="">-- Chọn ảnh banner tỷ lệ 19:6 --</option>
                                            @foreach($mediaList as $m)
                                                <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($banner->image_media_id) && $banner->image_media_id == $m->id) ? 'selected' : '' }}>
                                                    {{ $m->filename }} ({{ $m->alt_text ?: 'Banner 19:6' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" onclick="chooseBannerImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                                        🖼 Chọn
                                    </button>
                                </div>
                                <div style="flex: 1;">
                                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Hoặc đường dẫn ảnh</label>
                                    <input type="text" name="banner_image_paths[]" value="{{ $banner->image_path }}" placeholder="storage/... (nếu có)" class="vf-admin-input" style="padding: 5px 8px; font-size: 0.82rem;">
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
                            <div style="flex: 1; display: flex; gap: 6px; align-items: center;">
                                <div style="flex: 1;">
                                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Chọn từ Media</label>
                                    <select name="interior_image_media_ids[]" onchange="updateInteriorImgPreview(this)" class="vf-admin-select interior-img-select" style="padding: 5px 8px; font-size: 0.82rem;">
                                        <option value="" data-src="">-- Chọn ảnh nội thất --</option>
                                        @foreach($mediaList as $m)
                                            <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($interior->image_media_id) && $interior->image_media_id == $m->id) ? 'selected' : '' }}>
                                                {{ $m->filename }} ({{ $m->alt_text ?: 'Nội thất' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" onclick="chooseInteriorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                                    🖼 Chọn
                                </button>
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
            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                <span class="vf-admin-card-badge" id="badge-count-specs">{{ $specifications->count() }} mục thông số</span>
                {{-- Ô tìm kiếm nhanh thông số --}}
                <div style="position: relative;">
                    <input type="text" id="spec-search-input" placeholder="🔍 Lọc nhanh thông số (pin, động cơ, lốp...)" 
                           oninput="filterSpecRows(this.value)"
                           style="padding: 5px 12px; border: 1px solid var(--admin-border); border-radius: 20px; font-size: 0.8rem; width: 250px;">
                </div>
                <button type="button" onclick="addNewSpecRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 5px 12px; font-size: 0.8rem;">
                    + Thêm Dòng Thông Số
                </button>
            </div>
        </div>

        <p class="vf-admin-helper-text" style="margin-bottom: 14px;">
            Các cặp <strong>Key (Tên thông số)</strong> và <strong>Value (Giá trị kỹ thuật)</strong> hiển thị tại bảng tra cứu thông số của trang chi tiết xe. Bạn có thể dùng ô tìm kiếm phía trên để lọc nhanh các thông số cần chỉnh sửa.
        </p>

        <div id="specs-container">
            @if($specifications->isNotEmpty())
                @foreach($specifications as $spec)
                    <div class="spec-row" style="display: flex; gap: 10px; margin-bottom: 8px; align-items: center;">
                        <input type="text" name="specs_labels[]" value="{{ $spec->label }}" placeholder="Tên thông số (Key) - VD: Chiều dài cơ sở, Công suất..." 
                               class="vf-admin-input spec-key-input" style="flex: 1.2; padding: 7px 10px; font-size: 0.85rem;">
                        <input type="text" name="specs_values[]" value="{{ $spec->value }}" placeholder="Giá trị (Value) - VD: 2.075 mm, 32 kW..." 
                               class="vf-admin-input spec-val-input" style="flex: 1.5; padding: 7px 10px; font-size: 0.85rem;">
                        <button type="button" onclick="this.parentElement.remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa dòng này">
                            &times;
                        </button>
                    </div>
                @endforeach
            @else
                <div class="spec-row" style="display: flex; gap: 10px; margin-bottom: 8px; align-items: center;">
                    <input type="text" name="specs_labels[]" value="Số chỗ ngồi" placeholder="Tên thông số (Key)" class="vf-admin-input spec-key-input" style="flex: 1.2; padding: 7px 10px; font-size: 0.85rem;">
                    <input type="text" name="specs_values[]" value="4 chỗ" placeholder="Giá trị (Value)" class="vf-admin-input spec-val-input" style="flex: 1.5; padding: 7px 10px; font-size: 0.85rem;">
                    <button type="button" onclick="this.parentElement.remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;">&times;</button>
                </div>
            @endif
        </div>
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
const mediaOptionsTemplate = `
    <option value="" data-src="">-- Chọn ảnh tương ứng --</option>
    @foreach($mediaList as $m)
        <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}">{{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})</option>
    @endforeach
`;

// Cập nhật tên xe trên thanh bottom bar thời gian thực
document.getElementById('product-name')?.addEventListener('input', function() {
    const val = this.value.trim();
    const barEl = document.getElementById('bar-product-name');
    if (barEl) barEl.textContent = val || 'Dòng xe mới';
});

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

// Preview ảnh chính của xe
function updateMainThumbPreview(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const src = selectedOption ? selectedOption.getAttribute('data-src') : '';
    const previewBox = document.getElementById('product-thumb-preview');
    if (previewBox) {
        if (src) {
            previewBox.innerHTML = `<img src="${src}" style="width: 100%; height: 100%; object-fit: contain;">`;
        } else {
            previewBox.innerHTML = `<span style="font-size: 0.72rem; color: var(--admin-muted);">Chưa có</span>`;
        }
    }
}

// Preview ảnh biến thể
function updateVariantImgPreview(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const src = selectedOption ? selectedOption.getAttribute('data-src') : '';
    const previewBox = selectEl.closest('.variant-row').querySelector('.variant-img-preview');
    if (previewBox) {
        if (src) {
            previewBox.innerHTML = `<img src="${src}" style="width: 100%; height: 100%; object-fit: contain;">`;
        } else {
            previewBox.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>`;
        }
    }
}

// Thêm biến thể mới
function addNewVariantRow(data = {}) {
    const placeholder = document.getElementById('no-variants-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('variants-container');
    const div = document.createElement('div');
    div.className = 'variant-row';
    div.style.cssText = 'background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;';
    
    const count = container.querySelectorAll('.variant-row').length + 1;
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
        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="variant-img-preview" style="width: 54px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>
            </div>
            <div style="flex: 1; display: flex; gap: 6px; align-items: center;">
                <div style="flex: 1;">
                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Ảnh Riêng Cho Phiên Bản Này</label>
                    <select name="variant_thumbnail_media_ids[]" onchange="updateVariantImgPreview(this)" class="vf-admin-select variant-thumb-select" style="padding: 5px 8px; font-size: 0.82rem;">
                        ${mediaOptionsTemplate}
                    </select>
                </div>
                <button type="button" onclick="chooseVariantImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                    🖼 Chọn
                </button>
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
    addNewVariantRow({
        name: name ? name + ' (Bản sao)' : '',
        sku: sku ? sku + '-COPY' : '',
        regular_price: reg,
        sale_price: sale,
        color_name: color
    });
}

// Preview ảnh màu sơn
function updateColorImgPreview(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const src = selectedOption ? selectedOption.getAttribute('data-src') : '';
    const previewBox = selectEl.closest('.color-row').querySelector('.color-img-preview');
    if (previewBox) {
        if (src) {
            previewBox.innerHTML = `<img src="${src}" style="width: 100%; height: 100%; object-fit: contain;">`;
        } else {
            previewBox.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>`;
        }
    }
}

// Thêm màu sắc mới
function addNewColorRow(name = '', code = '#d83a3a') {
    const placeholder = document.getElementById('no-colors-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('colors-container');
    const div = document.createElement('div');
    div.className = 'color-row';
    div.style.cssText = 'background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;';
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
        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="color-img-preview" style="width: 58px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
            </div>
            <div style="flex: 1; display: flex; gap: 6px; align-items: center;">
                <div style="flex: 1;">
                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Ảnh Xe Góc Ngang Side-View Theo Màu</label>
                    <select name="color_image_media_ids[]" onchange="updateColorImgPreview(this)" class="vf-admin-select color-img-select" style="padding: 5px 8px; font-size: 0.82rem;">
                        ${mediaOptionsTemplate}
                    </select>
                </div>
                <button type="button" onclick="chooseColorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                    🖼 Chọn
                </button>
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

// Preview Banner Hero 19:6
function updateBannerImgPreview(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const src = selectedOption ? selectedOption.getAttribute('data-src') : '';
    const previewBox = selectEl.closest('.banner-row').querySelector('.banner-img-preview');
    if (previewBox) {
        if (src) {
            previewBox.innerHTML = `<img src="${src}" style="width: 100%; height: 100%; object-fit: cover;">`;
        } else {
            previewBox.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">19:6</span>`;
        }
    }
}

// Thêm Banner mới
function addNewBannerRow() {
    const placeholder = document.getElementById('no-banners-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('banners-container');
    const div = document.createElement('div');
    div.className = 'banner-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px; margin-bottom: 12px;';
    div.innerHTML = `
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
            <input type="text" name="banner_titles[]" placeholder="Tiêu đề Banner (VD: VINFAST VF 3)" 
                   class="vf-admin-input" style="flex: 1.2; padding: 6px 10px; font-size: 0.85rem; font-weight: 600;">
            <input type="text" name="banner_subtitles[]" placeholder="Phụ đề ngắn..." 
                   class="vf-admin-input" style="flex: 2; padding: 6px 10px; font-size: 0.85rem;">
            <button type="button" onclick="this.closest('.banner-row').remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa banner này">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="banner-img-preview" style="width: 110px; height: 35px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">19:6</span>
            </div>
            <div style="flex: 1.2; display: flex; gap: 6px; align-items: center;">
                <div style="flex: 1;">
                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Chọn từ Thư viện Media</label>
                    <select name="banner_image_media_ids[]" onchange="updateBannerImgPreview(this)" class="vf-admin-select banner-img-select" style="padding: 5px 8px; font-size: 0.82rem;">
                        <option value="" data-src="">-- Chọn ảnh banner tỷ lệ 19:6 --</option>
                        ${mediaOptionsTemplate}
                    </select>
                </div>
                <button type="button" onclick="chooseBannerImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                    🖼 Chọn
                </button>
            </div>
            <div style="flex: 1;">
                <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Hoặc đường dẫn ảnh</label>
                <input type="text" name="banner_image_paths[]" placeholder="storage/... (nếu có)" class="vf-admin-input" style="padding: 5px 8px; font-size: 0.82rem;">
            </div>
        </div>
    `;
    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

// Preview ảnh nội thất
function updateInteriorImgPreview(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const src = selectedOption ? selectedOption.getAttribute('data-src') : '';
    const previewBox = selectEl.closest('.interior-row').querySelector('.interior-img-preview');
    if (previewBox) {
        if (src) {
            previewBox.innerHTML = `<img src="${src}" style="width: 100%; height: 100%; object-fit: cover;">`;
        } else {
            previewBox.innerHTML = `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>`;
        }
    }
}

// Thêm ảnh nội thất mới
function addNewInteriorRow(data = {}) {
    const placeholder = document.getElementById('no-interiors-placeholder');
    if (placeholder) placeholder.remove();

    const container = document.getElementById('interiors-container');
    const div = document.createElement('div');
    div.className = 'interior-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px;';
    
    const previewContent = data.media_url 
        ? `<img src="${data.media_url}" style="width: 100%; height: 100%; object-fit: cover;">`
        : `<span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>`;

    let customOption = '';
    if (data.media_id && data.media_url) {
        customOption = `<option value="${data.media_id}" data-src="${data.media_url}" selected>${data.caption || 'Ảnh nội thất đã chọn'}</option>`;
    }

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
            <div style="flex: 1; display: flex; gap: 6px; align-items: center;">
                <div style="flex: 1;">
                    <label class="vf-admin-label" style="font-size: 0.72rem; margin-bottom: 2px;">Chọn từ Media</label>
                    <select name="interior_image_media_ids[]" onchange="updateInteriorImgPreview(this)" class="vf-admin-select interior-img-select" style="padding: 5px 8px; font-size: 0.82rem;">
                        ${customOption}
                        <option value="" data-src="">-- Chọn ảnh nội thất --</option>
                        ${mediaOptionsTemplate}
                    </select>
                </div>
                <button type="button" onclick="chooseInteriorImage(this)" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.78rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; margin-top: 14px; white-space: nowrap;" title="Chọn ảnh từ Thư viện">
                    🖼 Chọn
                </button>
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

// Thêm dòng thông số Key - Value
function addNewSpecRow(key = '', val = '') {
    const container = document.getElementById('specs-container');
    const div = document.createElement('div');
    div.className = 'spec-row';
    div.style.cssText = 'display: flex; gap: 10px; margin-bottom: 8px; align-items: center;';
    div.innerHTML = `
        <input type="text" name="specs_labels[]" value="${key}" placeholder="Tên thông số (Key)" class="vf-admin-input spec-key-input" style="flex: 1.2; padding: 7px 10px; font-size: 0.85rem;">
        <input type="text" name="specs_values[]" value="${val}" placeholder="Giá trị (Value)" class="vf-admin-input spec-val-input" style="flex: 1.5; padding: 7px 10px; font-size: 0.85rem;">
        <button type="button" onclick="this.parentElement.remove(); updateCounters(); formIsDirty = true;" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;">&times;</button>
    `;
    container.appendChild(div);
    updateCounters();
    markFormDirty();
}

// Lọc thông số theo từ khóa tìm kiếm nhanh
function filterSpecRows(keyword) {
    const term = (keyword || '').toLowerCase().trim();
    const rows = document.querySelectorAll('#specs-container .spec-row');
    rows.forEach(row => {
        const key = (row.querySelector('.spec-key-input')?.value || '').toLowerCase();
        const val = (row.querySelector('.spec-val-input')?.value || '').toLowerCase();
        if (!term || key.includes(term) || val.includes(term)) {
            row.style.display = 'flex';
        } else {
            row.style.display = 'none';
        }
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
    const vCount = document.querySelectorAll('#variants-container .variant-row').length;
    const cCount = document.querySelectorAll('#colors-container .color-row').length;
    const bCount = document.querySelectorAll('#banners-container .banner-row').length;
    const iCount = document.querySelectorAll('#interiors-container .interior-row').length;
    const hCount = document.querySelectorAll('#highlights-container .highlight-row').length;
    const sCount = document.querySelectorAll('#specs-container .spec-row').length;

    const elV = document.getElementById('badge-count-variants'); if (elV) elV.textContent = `${vCount} phiên bản`;
    const elC = document.getElementById('badge-count-colors'); if (elC) elC.textContent = `${cCount} màu`;
    const elB = document.getElementById('badge-count-banners'); if (elB) elB.textContent = `${bCount} banner`;
    const elI = document.getElementById('badge-count-interiors'); if (elI) elI.textContent = `${iCount} ảnh nội thất`;
    const elH = document.getElementById('badge-count-highlights'); if (elH) elH.textContent = `${hCount} thông số`;
    const elS = document.getElementById('badge-count-specs'); if (elS) elS.textContent = `${sCount} mục thông số`;

    const pV = document.getElementById('pill-count-variants'); if (pV) pV.textContent = vCount;
    const pC = document.getElementById('pill-count-colors'); if (pC) pC.textContent = cCount;
    const pB = document.getElementById('pill-count-banners'); if (pB) pB.textContent = bCount;
    const pI = document.getElementById('pill-count-interiors'); if (pI) pI.textContent = iCount;
    const pH = document.getElementById('pill-count-highlights'); if (pH) pH.textContent = hCount;
    const pS = document.getElementById('pill-count-specs'); if (pS) pS.textContent = sCount;
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

// Helper gán ảnh chọn từ Media Manager vào bất kỳ Select và Preview nào
function assignMediaToSelect(selectEl, previewBox, media) {
    if (!selectEl || !media) return;
    let option = selectEl.querySelector(`option[value="${media.id}"]`);
    if (!option) {
        option = document.createElement('option');
        option.value = media.id;
        option.setAttribute('data-src', media.url);
        option.textContent = `${media.filename} (${media.alt_text || 'Ảnh vừa chọn'})`;
        selectEl.appendChild(option);
    }
    selectEl.value = media.id;
    
    if (previewBox) {
        previewBox.innerHTML = `<img src="${media.url}" alt="${media.alt_text || media.filename}" style="width: 100%; height: 100%; object-fit: contain;">`;
    }
    selectEl.dispatchEvent(new Event('change'));
    markFormDirty();
}

// 1. Chọn ảnh đại diện xe chính
function openMainThumbnailMediaPicker() {
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn làm ảnh đại diện',
        onSelect: function(media) {
            const select = document.getElementById('main_thumbnail_select');
            const preview = document.getElementById('product-thumb-preview');
            assignMediaToSelect(select, preview, media);
        }
    });
}

// 2. Chọn ảnh cho phiên bản (Variant)
function chooseVariantImage(btn) {
    const row = btn.closest('.variant-row');
    const select = row.querySelector('.variant-thumb-select');
    const preview = row.querySelector('.variant-img-preview');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh cho phiên bản này',
        onSelect: function(media) {
            assignMediaToSelect(select, preview, media);
        }
    });
}

// 3. Chọn ảnh theo màu sắc (Color Studio)
function chooseColorImage(btn) {
    const row = btn.closest('.color-row');
    const select = row.querySelector('.color-img-select');
    const preview = row.querySelector('.color-img-preview');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh xe theo màu này',
        onSelect: function(media) {
            assignMediaToSelect(select, preview, media);
        }
    });
}

// 4. Chọn ảnh Banner Hero 19:6
function chooseBannerImage(btn) {
    const row = btn.closest('.banner-row');
    const select = row.querySelector('.banner-img-select');
    const preview = row.querySelector('.banner-img-preview');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh banner tỷ lệ 19:6',
        onSelect: function(media) {
            assignMediaToSelect(select, preview, media);
            if (preview && preview.querySelector('img')) {
                preview.querySelector('img').style.objectFit = 'cover';
            }
        }
    });
}

// 5. Chọn ảnh nội thất đơn lẻ
function chooseInteriorImage(btn) {
    const row = btn.closest('.interior-row');
    const select = row.querySelector('.interior-img-select');
    const preview = row.querySelector('.interior-img-preview');
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn ảnh nội thất này',
        onSelect: function(media) {
            assignMediaToSelect(select, preview, media);
            if (preview && preview.querySelector('img')) {
                preview.querySelector('img').style.objectFit = 'cover';
            }
        }
    });
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
                    media_url: img.url
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
        min_height: 1000,
        autoresize_bottom_margin: 30,
        autoresize_overflow_padding: 20,
        menubar: 'file edit view insert format tools table help',
        menu: {
            insert: {
                title: 'Chèn',
                items: 'mediaManager | image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor | insertdatetime'
            }
        },
        plugins: [
            'autoresize', 'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
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
            body {
                font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                font-size: 15px;
                line-height: 1.8;
                color: #334155;
                padding: 18px 24px;
                max-width: 100%;
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
                        reject('Tải ảnh thất bại: HTTP ' + xhr.status);
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

            // Tự động đồng bộ số từ & trạng thái dirty & chiều cao Anchor
            function syncEditorData() {
                const badge = document.getElementById('word-count-badge');
                if (badge) {
                    const wordCountPlugin = editor.plugins.wordcount;
                    const words = wordCountPlugin ? wordCountPlugin.getCount() : (editor.getContent({ format: 'text' }).trim() ? editor.getContent({ format: 'text' }).trim().split(/\s+/).length : 0);
                    badge.textContent = `${words} từ`;
                }
                syncEditorAnchorHeight();
            }

            editor.on('init', function () {
                syncEditorData();
                setTimeout(syncEditorAnchorHeight, 300);
            });
            editor.on('keyup change undo redo NodeChange', function () {
                syncEditorData();
                markFormDirty();
                editor.save();
            });
        }
    });
}

// =========================================================================
// KIẾN TRÚC STICKY & CUỘN NỘI BỘ TRÌNH SOẠN THẢO KHI CHẠM TOP
// =========================================================================

// Đồng bộ chiều cao thẻ Anchor để tránh hiện tượng giật trang khi sticky
function syncEditorAnchorHeight() {
    const card = document.getElementById('bai-viet-gioi-thieu');
    const anchor = document.getElementById('bai-viet-gioi-thieu-anchor');
    if (!card || !anchor) return;

    if (!card.classList.contains('is-stuck-top')) {
        const measuredHeight = Math.max(1050, card.offsetHeight);
        anchor.style.minHeight = measuredHeight + 'px';
        anchor.style.height = measuredHeight + 'px';
    }
}

// Kiểm tra khi cuộn trang: box chạm top thì neo lại và bắt đầu cuộn bên trong
function updateEditorStickyState() {
    const card = document.getElementById('bai-viet-gioi-thieu');
    const anchor = document.getElementById('bai-viet-gioi-thieu-anchor');
    if (!card || !anchor) return;

    const anchorRect = anchor.getBoundingClientRect();
    const topThreshold = 16; // Chạm mép top 16px

    // Khi đỉnh của anchor chạm top và chưa trôi qua hết phạm vi anchor
    const shouldStick = anchorRect.top <= topThreshold && (anchorRect.bottom - card.offsetHeight) > 0;

    if (shouldStick) {
        if (!card.classList.contains('is-stuck-top')) {
            card.classList.add('is-stuck-top');
        }
    } else {
        if (card.classList.contains('is-stuck-top')) {
            card.classList.remove('is-stuck-top');
            syncEditorAnchorHeight();
        }
    }
}

window.addEventListener('scroll', updateEditorStickyState, { passive: true });
window.addEventListener('resize', function () {
    syncEditorAnchorHeight();
    updateEditorStickyState();
}, { passive: true });
</script>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.key', 'no-api-key') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initProductArticleTinyMCE();
});
</script>
@endpush
@endsection
