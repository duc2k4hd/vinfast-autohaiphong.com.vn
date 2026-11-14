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

    <div style="display: grid; grid-template-columns: 1.2fr 1.5fr; gap: 24px; align-items: start;">
        {{-- Thông tin xe cơ bản --}}
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
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Mô Tả Ngắn</label>
                <textarea name="short_description" rows="3" 
                          style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Ảnh Đại Diện Xe (Media Picker)</label>
                <div style="display: flex; gap: 12px; align-items: center;">
                    <div id="product-thumb-preview" class="vinfast-autohaiphong_admin_product_preview">
                        @php
                            $currentMedia = $mediaList->firstWhere('id', $product->thumbnail_media_id);
                        @endphp
                        @if($currentMedia)
                            <img src="{{ asset('storage/' . $currentMedia->path) }}" alt="{{ $product->name }}" class="vinfast-autohaiphong_admin_product_preview_image">
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

            @include('admin.components.editor', [
                'name' => 'description_html',
                'id' => 'description_html',
                'value' => $product->description_html,
                'label' => 'Nội Dung Mô Tả Chi Tiết (TinyMCE Soạn Thảo)',
                'folder' => 'products',
                'height' => 380,
            ])

            <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="width: 100%; padding: 12px; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Lưu Toàn Bộ Cập Nhật
            </button>
        </div>

        {{-- Cột Phải: Biến Thể Xe & Bảng Thông Số Key-Value --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            {{-- Quản lý Biến Thể / Phiên Bản Xe --}}
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>PHIÊN BẢN & BIẾN THỂ XE (VARIANTS)</span>
                    <button type="button" onclick="addNewVariantRow()" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 4px 10px; font-size: 0.8rem;">
                        + Thêm Phiên Bản
                    </button>
                </div>

                <p style="font-size: 0.85rem; color: var(--admin-muted); margin-bottom: 16px;">
                    Thiết lập các phiên bản (Thuê pin, Kèm pin, Eco, Plus) để người dùng chọn trực tiếp tại trang chi tiết xe, tự động cập nhật giá.
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
                                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
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
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Bảng Thông Số Kỹ Thuật Key-Value --}}
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
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
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

