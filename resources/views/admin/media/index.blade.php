@extends('admin.layouts.app')

@section('title', 'Thư Viện Media Tập Trung')
@section('header_title', 'QUẢN LÝ THƯ VIỆN MEDIA & HÌNH ẢNH')

@section('content')
{{-- Khối tải lên ảnh mới --}}
<div class="vinfast-autohaiphong_admin_card" style="margin-bottom: 24px;">
    <div class="vinfast-autohaiphong_admin_card_title">TẢI LÊN HÌNH ẢNH MỚI</div>

    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
        @csrf
        <div style="flex: 1; min-width: 240px;">
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 4px;">Chọn tệp ảnh (Max 5MB)</label>
            <input type="file" name="file" required accept="image/*" 
                   style="width: 100%; padding: 6px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem; background: #ffffff;">
        </div>

        <div style="width: 180px;">
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 4px;">Thư mục lưu trữ</label>
            <select name="folder" style="width: 100%; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                <option value="products">Dòng xe (products)</option>
                <option value="banners">Banner (banners)</option>
                <option value="business">Đại lý & Logo (business)</option>
                <option value="posts">Tin tức (posts)</option>
            </select>
        </div>

        <div style="flex: 1.2; min-width: 200px;">
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 4px;">Văn bản thay thế (Alt Text)</label>
            <input type="text" name="alt_text" placeholder="Mô tả ảnh cho SEO..." 
                   style="width: 100%; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
        </div>

        <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="padding: 9px 20px;">
            ⬆ Tải Lên Media
        </button>
    </form>
</div>

{{-- Bộ lọc thư mục & Danh sách ảnh --}}
<div class="vinfast-autohaiphong_admin_card">
    <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <span>DANH SÁCH TÀI NGUYÊN MEDIA</span>

        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.media.index') }}" class="vinfast-autohaiphong_admin_btn {{ !$currentFolder ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Tất Cả
            </a>
            <a href="{{ route('admin.media.index', ['folder' => 'products']) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'products' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Dòng Xe
            </a>
            <a href="{{ route('admin.media.index', ['folder' => 'banners']) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'banners' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Banners
            </a>
            <a href="{{ route('admin.media.index', ['folder' => 'business']) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'business' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Logo & Showroom
            </a>
            <a href="{{ route('admin.media.index', ['folder' => 'posts']) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'posts' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Tin Tức
            </a>
        </div>
    </div>

    @if($mediaItems->isEmpty())
        <p style="color: var(--admin-muted); padding: 32px 0; text-align: center;">Thư viện chưa có hình ảnh nào trong danh mục này.</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px;">
            @foreach($mediaItems as $media)
                <div style="border: 1px solid var(--admin-border); border-radius: 6px; overflow: hidden; background: #f8fafc; display: flex; flex-direction: column;">
                    <div style="position: relative; padding-top: 65%; background: #e2e8f0; overflow: hidden;">
                        <img src="{{ asset('storage/' . $media->path) }}" 
                             alt="{{ $media->alt_text }}" 
                             loading="lazy" 
                             style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 10px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="font-weight: 700; font-size: 0.8rem; color: var(--admin-heading); word-break: break-all; margin-bottom: 2px;">
                                {{ Str::limit($media->filename, 22) }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--admin-muted);">
                                {{ round($media->file_size / 1024, 1) }} KB • ID: {{ $media->id }}
                            </div>
                        </div>

                        <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed var(--admin-border); padding-top: 6px;">
                            <a href="{{ asset('storage/' . $media->path) }}" target="_blank" style="font-size: 0.75rem; color: var(--admin-primary); font-weight: 600;" title="Xem ảnh">
                                Mở &nearr;
                            </a>
                            <form action="{{ route('admin.media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tệp ảnh này khỏi hệ thống?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 0.85rem;" title="Xóa ảnh">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $mediaItems->links() }}
        </div>
    @endif
</div>
@endsection

