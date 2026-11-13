@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Dòng Xe ' . $product->name)
@section('header_title', 'CHỈNH SỬA XE & BẢNG THÔNG SỐ KEY-VALUE')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.products.index') }}" style="color: var(--admin-primary); font-weight: 600;">
        &larr; Quay lại danh sách xe
    </a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST">
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

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Nội Dung Mô Tả Chi Tiết (HTML)</label>
                <textarea name="description_html" rows="8" 
                          style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-family: monospace; font-size: 0.85rem;">{{ old('description_html', $product->description_html) }}</textarea>
            </div>

            <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="width: 100%; padding: 12px;">
                Lưu Toàn Bộ Cập Nhật &rarr;
            </button>
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
</script>
@endsection

