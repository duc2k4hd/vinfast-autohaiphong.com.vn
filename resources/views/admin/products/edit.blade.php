@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Dòng Xe ' . $product->name)
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <a href="{{ route('admin.products.index') }}" style="color: var(--admin-muted);">Dòng xe</a> &rsaquo; 
    <span>{{ $product->name }}</span>
@endsection
@section('header_title', 'CHỈNH SỬA XE & BẢNG THÔNG SỐ KEY-VALUE')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.products.index') }}" style="color: var(--admin-primary); font-weight: 600;">
        &larr; Quay lại danh sách xe
    </a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="form-track-changes">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: 1.15fr 1.55fr; gap: 24px; align-items: start;">
        {{-- Cột Trái: Thông tin xe cơ bản --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title">THÔNG TIN XE CƠ BẢN</div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Tên Dòng Xe</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                           style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 6px;">Giá Niêm Yết (đ)</label>
                        <input type="number" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" 
                               style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 6px;">Giá Khuyến Mãi (đ)</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" 
                               style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Ảnh Đại Diện Xe (Thumbnail Chính)</label>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <div id="product-thumb-preview" class="vinfast-autohaiphong_admin_product_preview" style="width: 64px; height: 48px; border: 1px dashed var(--admin-border); border-radius: 6px; overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            @php
                                $currentMedia = $mediaList->firstWhere('id', $product->thumbnail_media_id);
                            @endphp
                            @if($currentMedia)
                                <img src="{{ asset('storage/' . $currentMedia->path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                            @else
                                <span style="font-size: 0.75rem; color: var(--admin-muted);">Chưa có</span>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <select name="thumbnail_media_id" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.85rem;">
                                <option value="">-- Chọn ảnh từ Thư viện Media --</option>
                                @foreach($mediaList as $m)
                                    <option value="{{ $m->id }}" {{ $product->thumbnail_media_id == $m->id ? 'selected' : '' }}>
                                        {{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})
                                    </option>
                                @endforeach
                            </select>
                            <div style="font-size: 0.75rem; color: var(--admin-muted); margin-top: 4px;">
                                <a href="{{ route('admin.media.index') }}" target="_blank" style="color: var(--admin-primary); font-weight: 600;">+ Tải thêm ảnh lên Thư viện Media</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Mô Tả Ngắn</label>
                    <textarea name="short_description" rows="3" 
                              style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Bài Viết Giới Thiệu Xe</label>
                    <textarea name="description_html" rows="8" 
                              style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-family: monospace;">{{ old('description_html', $product->description_html) }}</textarea>
                </div>

                <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="width: 100%; padding: 12px; font-size: 1rem;">
                    LƯU CẬP NHẬT XE
                </button>
            </div>
        </div>

        {{-- Cột Phải: Biến Thể Xe, Màu Sắc Xe & Bảng Thông Số Key-Value --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- 1. Quản lý Biến Thể / Phiên Bản Xe --}}
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>PHIÊN BẢN & BIẾN THỂ XE (VARIANTS)</span>
                    <button type="button" onclick="addNewVariantRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 4px 10px; font-size: 0.8rem;">
                        + Thêm Phiên Bản
                    </button>
                </div>

                <p style="font-size: 0.85rem; color: var(--admin-muted); margin-bottom: 16px;">
                    Thiết lập các phiên bản (Thuê pin, Kèm pin, Eco, Plus) để người dùng chọn trực tiếp tại trang chi tiết xe, tự động cập nhật giá và ảnh.
                </p>

                <div id="variants-container">
                    @if($variants->isNotEmpty())
                        @foreach($variants as $variant)
                            <div class="variant-row" style="background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;">
                                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 10px; margin-bottom: 8px;">
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Tên Phiên Bản</label>
                                        <input type="text" name="variant_names[]" value="{{ $variant->name }}" placeholder="VD: Thuê Pin, Kèm Pin, Eco..." 
                                               style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Mã SKU</label>
                                        <input type="text" name="variant_skus[]" value="{{ $variant->sku }}" placeholder="VD: VF3-BAT" 
                                               style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end; margin-bottom: 8px;">
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Giá Niêm Yết (đ)</label>
                                        <input type="number" name="variant_regular_prices[]" value="{{ $variant->regular_price }}" placeholder="240000000" 
                                               style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Giá Khuyến Mãi (đ)</label>
                                        <input type="number" name="variant_sale_prices[]" value="{{ $variant->sale_price }}" placeholder="240000000" 
                                               style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Màu Sắc</label>
                                        <input type="text" name="variant_color_names[]" value="{{ $variant->color_name }}" placeholder="VD: Vàng nóc trắng" 
                                               style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    </div>
                                    <button type="button" onclick="this.closest('.variant-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 6px;" title="Xóa phiên bản">
                                        &times;
                                    </button>
                                </div>
                                <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
                                    <div class="variant-img-preview" style="width: 52px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @if(!empty($variant->thumbnail_path))
                                            <img src="{{ asset('storage/' . $variant->thumbnail_path) }}" alt="{{ $variant->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                                        @else
                                            <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Ảnh Riêng Cho Phiên Bản</label>
                                        <select name="variant_thumbnail_media_ids[]" onchange="updateVariantImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                                            <option value="" data-src="">-- Dùng ảnh chính của xe --</option>
                                            @foreach($mediaList as $m)
                                                <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($variant->thumbnail_media_id) && $variant->thumbnail_media_id == $m->id) ? 'selected' : '' }}>
                                                    {{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- 2. Quản lý Bộ Sưu Tập Màu Sắc Xe (Color Studio) --}}
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>BỘ SƯU TẬP MÀU SẮC XE (COLOR STUDIO)</span>
                    <button type="button" onclick="addNewColorRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 4px 10px; font-size: 0.8rem;">
                        + Thêm Màu Sắc
                    </button>
                </div>

                <p style="font-size: 0.85rem; color: var(--admin-muted); margin-bottom: 16px;">
                    Thiết lập danh sách màu sơn ngoại thất kèm ảnh xe tương ứng để hiển thị trong bộ sưu tập màu sắc tương tác ở trang chi tiết xe.
                </p>

                <div id="colors-container">
                    @if($colors->isNotEmpty())
                        @foreach($colors as $col)
                            <div class="color-row" style="background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;">
                                <div style="display: grid; grid-template-columns: 60px 1.5fr auto; gap: 10px; align-items: center; margin-bottom: 8px;">
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Mã Màu</label>
                                        <input type="color" name="color_codes[]" value="{{ $col->color_code }}" style="width: 100%; height: 34px; padding: 2px; border: 1px solid var(--admin-border); border-radius: 4px; cursor: pointer;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Tên Màu Sơn</label>
                                        <input type="text" name="color_names[]" value="{{ $col->name }}" placeholder="VD: Solar Ruby, Infinity Blanc..." 
                                               style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    </div>
                                    <button type="button" onclick="this.closest('.color-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 6px; margin-top: 14px;" title="Xóa màu">
                                        &times;
                                    </button>
                                </div>
                                <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
                                    <div class="color-img-preview" style="width: 52px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @if(!empty($col->image_path))
                                            <img src="{{ asset('storage/' . $col->image_path) }}" alt="{{ $col->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                                        @else
                                            <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Ảnh Xe Góc Ngang Theo Màu Sơn</label>
                                        <select name="color_image_media_ids[]" onchange="updateColorImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                                            <option value="" data-src="">-- Chọn ảnh xe theo màu này --</option>
                                            @foreach($mediaList as $m)
                                                <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($col->image_media_id) && $col->image_media_id == $m->id) ? 'selected' : '' }}>
                                                    {{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- 2.5. Bộ Sưu Tập Ảnh Banner Hero Riêng (Tỷ Lệ 16:9) --}}
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>BANNER HERO SẢN PHẨM (TỶ LỆ 19:6)</span>
                    <button type="button" onclick="addNewBannerRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 4px 10px; font-size: 0.8rem;">
                        + Thêm Banner Hero
                    </button>
                </div>

                <p style="font-size: 0.85rem; color: var(--admin-muted); margin-bottom: 16px;">
                    Các ảnh slider kích thước lớn hiển thị ở đầu trang chi tiết xe (chuẩn tỷ lệ 19:6). Tiêu đề và mô tả ngắn sẽ hiển thị ở <strong>khoảng trên chính giữa</strong> của từng ảnh banner.
                </p>

                <div id="banners-container">
                    @if(!empty($banners) && $banners->isNotEmpty())
                        @foreach($banners as $banner)
                            <div style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 14px; margin-bottom: 14px;" class="banner-row">
                                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
                                    <input type="text" name="banner_titles[]" value="{{ $banner->title }}" placeholder="Tiêu đề Banner (VD: VINFAST VF 3)" 
                                           style="flex: 1.2; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                    <input type="text" name="banner_subtitles[]" value="{{ $banner->subtitle }}" placeholder="Mô tả ngắn (VD: Khởi đầu xu hướng xe điện đô thị tương lai...)" 
                                           style="flex: 2; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    <button type="button" onclick="this.closest('.banner-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa banner này">
                                        &times;
                                    </button>
                                </div>
                                <div style="display: flex; gap: 12px; align-items: center; background: #fff; padding: 10px; border-radius: 4px; border: 1px solid #edf2f7;">
                                    <div class="banner-img-preview" style="width: 95px; height: 30px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @php
                                            $bImgPath = $banner->media_path ?: $banner->image_path;
                                        @endphp
                                        @if(!empty($bImgPath))
                                            <img src="{{ asset('storage/' . ltrim($bImgPath, '/')) }}" alt="{{ $banner->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">19:6</span>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Chọn từ thư viện Media</label>
                                        <select name="banner_image_media_ids[]" onchange="updateBannerImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                                            <option value="" data-src="">-- Chọn ảnh banner tỷ lệ 19:6 --</option>
                                            @foreach($mediaList as $m)
                                                <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($banner->image_media_id) && $banner->image_media_id == $m->id) ? 'selected' : '' }}>
                                                    {{ $m->filename }} ({{ $m->alt_text ?: 'Banner 19:6' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Hoặc đường dẫn ảnh trực tiếp</label>
                                        <input type="text" name="banner_image_paths[]" value="{{ $banner->image_path }}" placeholder="clients/assets/images/... (nếu không chọn media)"
                                               style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- 3. Bộ Sưu Tập Ảnh Nội Thất Xe (Bento / Mosaic Gallery) --}}
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>BỘ SƯU TẬP ẢNH NỘI THẤT XE (BENTO / MOSAIC GALLERY)</span>
                    <button type="button" onclick="addNewInteriorRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 4px 10px; font-size: 0.8rem;">
                        + Thêm Ảnh Nội Thất
                    </button>
                </div>

                <p style="font-size: 0.85rem; color: var(--admin-muted); margin-bottom: 16px;">
                    Các ảnh nội thất (khoang lái, táp-lô, màn hình, hàng ghế...) sẽ tự động kết hợp với nhiều hình dạng khác nhau thành một <strong>khối hình chữ nhật dài hoàn chỉnh (Bento Grid)</strong> tại mục Nội thất của trang xe.
                </p>

                <div id="interiors-container">
                    @if(!empty($interiors) && $interiors->isNotEmpty())
                        @foreach($interiors as $interior)
                            <div style="background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px; margin-bottom: 12px;" class="interior-row">
                                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
                                    <input type="text" name="interior_captions[]" value="{{ $interior->caption }}" placeholder="Chú thích ảnh nội thất (VD: Khoang lái công thái học, Màn hình 10 inch...)" 
                                           style="flex: 1; padding: 7px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                    <button type="button" onclick="this.closest('.interior-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa ảnh này">
                                        &times;
                                    </button>
                                </div>
                                <div style="display: flex; gap: 12px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
                                    <div class="interior-img-preview" style="width: 60px; height: 42px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @php
                                            $iImgPath = $interior->media_path ?: $interior->image_path;
                                        @endphp
                                        @if(!empty($iImgPath))
                                            <img src="{{ asset('storage/' . ltrim($iImgPath, '/')) }}" alt="{{ $interior->caption }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
                                        @endif
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Chọn từ thư viện Media</label>
                                        <select name="interior_image_media_ids[]" onchange="updateInteriorImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                                            <option value="" data-src="">-- Chọn ảnh nội thất từ Media --</option>
                                            @foreach($mediaList as $m)
                                                <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}" {{ (!empty($interior->image_media_id) && $interior->image_media_id == $m->id) ? 'selected' : '' }}>
                                                    {{ $m->filename }} ({{ $m->alt_text ?: 'Nội thất' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div style="flex: 1;">
                                        <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Hoặc đường dẫn ảnh trực tiếp</label>
                                        <input type="text" name="interior_image_paths[]" value="{{ $interior->image_path }}" placeholder="clients/assets/images/... (nếu không chọn media)"
                                               style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- 4. Bảng Thông Số Kỹ Thuật Key-Value --}}
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>THÔNG SỐ KỸ THUẬT KEY - VALUE</span>
                    <button type="button" onclick="addNewSpecRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 4px 10px; font-size: 0.8rem;">
                        + Thêm Dòng Thông Số
                    </button>
                </div>

                <p style="font-size: 0.85rem; color: var(--admin-muted); margin-bottom: 16px;">
                    Các cặp <strong>Key (Tên thông số)</strong> và <strong>Value (Giá trị)</strong> giúp hệ thống trích xuất cực nhanh, hiển thị dạng bảng mượt mà ngay ở đầu trang chi tiết xe.
                </p>

                <div id="specs-container">
                    @if($specifications->isNotEmpty())
                        @foreach($specifications as $spec)
                            <div style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center;" class="spec-row">
                                <input type="text" name="specs_labels[]" value="{{ $spec->label }}" placeholder="Tên thông số (Key)" 
                                       style="flex: 1.2; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                <input type="text" name="specs_values[]" value="{{ $spec->value }}" placeholder="Giá trị (Value)" 
                                       style="flex: 1.5; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                                <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa dòng">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center;" class="spec-row">
                            <input type="text" name="specs_labels[]" value="Số chỗ ngồi" placeholder="Tên thông số (Key)" 
                                   style="flex: 1.2; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                            <input type="text" name="specs_values[]" value="5 chỗ" placeholder="Giá trị (Value)" 
                                   style="flex: 1.5; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;">
                                &times;
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

<script>
const mediaOptionsTemplate = `
    <option value="" data-src="">-- Chọn ảnh xe tương ứng --</option>
    @foreach($mediaList as $m)
        <option value="{{ $m->id }}" data-src="{{ asset('storage/' . $m->path) }}">{{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh xe' }})</option>
    @endforeach
`;

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

function addNewColorRow() {
    const container = document.getElementById('colors-container');
    const div = document.createElement('div');
    div.className = 'color-row';
    div.style.cssText = 'background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;';
    div.innerHTML = `
        <div style="display: grid; grid-template-columns: 60px 1.5fr auto; gap: 10px; align-items: center; margin-bottom: 8px;">
            <div>
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Mã Màu</label>
                <input type="color" name="color_codes[]" value="#c92a2a" style="width: 100%; height: 34px; padding: 2px; border: 1px solid var(--admin-border); border-radius: 4px; cursor: pointer;">
            </div>
            <div>
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Tên Màu Sơn</label>
                <input type="text" name="color_names[]" placeholder="VD: Solar Ruby, Infinity Blanc..." 
                       style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            </div>
            <button type="button" onclick="this.closest('.color-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 6px; margin-top: 14px;" title="Xóa màu">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="color-img-preview" style="width: 52px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Ảnh Xe Góc Ngang Theo Màu Sơn</label>
                <select name="color_image_media_ids[]" onchange="updateColorImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                    ${mediaOptionsTemplate}
                </select>
            </div>
        </div>
    `;
    container.appendChild(div);
    formIsDirty = true;
}

function addNewVariantRow() {
    const container = document.getElementById('variants-container');
    const div = document.createElement('div');
    div.className = 'variant-row';
    div.style.cssText = 'background: var(--admin-bg); padding: 12px; border-radius: 6px; border: 1px solid var(--admin-border); margin-bottom: 12px;';
    div.innerHTML = `
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 10px; margin-bottom: 8px;">
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Tên Phiên Bản</label>
                <input type="text" name="variant_names[]" placeholder="VD: Thuê Pin, Kèm Pin, Eco..." 
                       style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Mã SKU</label>
                <input type="text" name="variant_skus[]" placeholder="VD: VF3-BAT" 
                       style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end; margin-bottom: 8px;">
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Giá Niêm Yết (đ)</label>
                <input type="number" name="variant_regular_prices[]" placeholder="240000000" 
                       style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Giá Khuyến Mãi (đ)</label>
                <input type="number" name="variant_sale_prices[]" placeholder="240000000" 
                       style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            </div>
            <div>
                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Màu Sắc</label>
                <input type="text" name="variant_color_names[]" placeholder="VD: Vàng nóc trắng" 
                       style="width: 100%; padding: 6px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            </div>
            <button type="button" onclick="this.closest('.variant-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 6px;" title="Xóa phiên bản">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; background: #fff; padding: 8px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="variant-img-preview" style="width: 52px; height: 38px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Mặc định</span>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Ảnh Riêng Cho Phiên Bản</label>
                <select name="variant_thumbnail_media_ids[]" onchange="updateVariantImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                    ${mediaOptionsTemplate}
                </select>
            </div>
        </div>
    `;
    container.appendChild(div);
    formIsDirty = true;
}

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

function addNewBannerRow() {
    const container = document.getElementById('banners-container');
    const div = document.createElement('div');
    div.className = 'banner-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 14px; margin-bottom: 14px;';
    div.innerHTML = `
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
            <input type="text" name="banner_titles[]" placeholder="Tiêu đề Banner (VD: VINFAST VF 3)" 
                   style="flex: 1.2; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
            <input type="text" name="banner_subtitles[]" placeholder="Mô tả ngắn (VD: Khởi đầu xu hướng xe điện đô thị tương lai...)" 
                   style="flex: 2; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            <button type="button" onclick="this.closest('.banner-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa banner này">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; background: #fff; padding: 10px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="banner-img-preview" style="width: 95px; height: 30px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">19:6</span>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Chọn từ thư viện Media</label>
                <select name="banner_image_media_ids[]" onchange="updateBannerImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                    <option value="" data-src="">-- Chọn ảnh banner tỷ lệ 19:6 --</option>
                    ${mediaOptionsTemplate}
                </select>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Hoặc đường dẫn ảnh trực tiếp</label>
                <input type="text" name="banner_image_paths[]" placeholder="clients/assets/images/... (nếu không chọn media)"
                       style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
            </div>
        </div>
    `;
    container.appendChild(div);
    formIsDirty = true;
}

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

function addNewInteriorRow() {
    const container = document.getElementById('interiors-container');
    const div = document.createElement('div');
    div.className = 'interior-row';
    div.style.cssText = 'background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px; margin-bottom: 12px;';
    div.innerHTML = `
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
            <input type="text" name="interior_captions[]" placeholder="Chú thích ảnh nội thất (VD: Khoang lái công thái học, Màn hình 10 inch...)" 
                   style="flex: 1; padding: 7px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
            <button type="button" onclick="this.closest('.interior-row').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;" title="Xóa ảnh này">
                &times;
            </button>
        </div>
        <div style="display: flex; gap: 12px; align-items: center; background: #fff; padding: 8px 10px; border-radius: 4px; border: 1px solid #edf2f7;">
            <div class="interior-img-preview" style="width: 60px; height: 42px; border-radius: 4px; border: 1px dashed var(--admin-border); overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span style="font-size: 0.65rem; color: var(--admin-muted); text-align: center;">Chưa có</span>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Chọn từ thư viện Media</label>
                <select name="interior_image_media_ids[]" onchange="updateInteriorImgPreview(this)" style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
                    <option value="" data-src="">-- Chọn ảnh nội thất từ Media --</option>
                    ${mediaOptionsTemplate}
                </select>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.72rem; font-weight: 600; color: var(--admin-muted); margin-bottom: 2px;">Hoặc đường dẫn ảnh trực tiếp</label>
                <input type="text" name="interior_image_paths[]" placeholder="clients/assets/images/... (nếu không chọn media)"
                       style="width: 100%; padding: 5px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.82rem;">
            </div>
        </div>
    `;
    container.appendChild(div);
    formIsDirty = true;
}

function addNewSpecRow() {
    const container = document.getElementById('specs-container');
    const div = document.createElement('div');
    div.className = 'spec-row';
    div.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px; align-items: center;';
    div.innerHTML = `
        <input type="text" name="specs_labels[]" placeholder="Tên thông số (Key)" style="flex: 1.2; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
        <input type="text" name="specs_values[]" placeholder="Giá trị (Value)" style="flex: 1.5; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0 4px;">&times;</button>
    `;
    container.appendChild(div);
    formIsDirty = true;
}

// Cảnh báo khi có dữ liệu chưa lưu
let formIsDirty = false;
const productForm = document.querySelector('form[action*="admin/products"]');
if (productForm) {
    productForm.addEventListener('input', () => { formIsDirty = true; });
    productForm.addEventListener('change', () => { formIsDirty = true; });
    productForm.addEventListener('submit', () => { formIsDirty = false; });
}
window.addEventListener('beforeunload', (e) => {
    if (formIsDirty) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>
@endsection
