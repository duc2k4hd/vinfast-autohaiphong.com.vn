@extends('admin.layouts.app')

@section('title', 'Thư Viện Media Tập Trung')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <span>Thư viện media</span>
@endsection
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

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <form action="{{ route('admin.media.index') }}" method="GET" style="display: flex; gap: 6px;">
                @if($currentFolder)
                    <input type="hidden" name="folder" value="{{ $currentFolder }}">
                @endif
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}" placeholder="Tìm tên ảnh, mô tả..." 
                       style="padding: 5px 10px; border: 1px solid var(--admin-border); border-radius: 5px; font-size: 0.8rem; width: 170px;">
                <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 10px; font-size: 0.8rem;">
                    Tìm
                </button>
            </form>

            <div style="display: flex; gap: 6px;">
                <a href="{{ route('admin.media.index', array_filter(['search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ !$currentFolder ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Tất Cả
                </a>
                <a href="{{ route('admin.media.index', array_filter(['folder' => 'products', 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'products' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Dòng Xe
                </a>
                <a href="{{ route('admin.media.index', array_filter(['folder' => 'banners', 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'banners' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Banners
                </a>
                <a href="{{ route('admin.media.index', array_filter(['folder' => 'business', 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'business' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Logo
                </a>
                <a href="{{ route('admin.media.index', array_filter(['folder' => 'posts', 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentFolder === 'posts' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Tin Tức
                </a>
            </div>
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

                        <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed var(--admin-border); padding-top: 6px; gap: 6px;">
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="{{ asset('storage/' . $media->path) }}" target="_blank" style="font-size: 0.75rem; color: var(--admin-primary); font-weight: 600; display: inline-flex; align-items: center; gap: 2px;" title="Xem ảnh">
                                    Mở &nearr;
                                </a>
                                <button type="button" 
                                        onclick="navigator.clipboard.writeText('{{ asset('storage/' . $media->path) }}').then(() => { this.textContent = '✓ Đã chép'; setTimeout(() => this.textContent = 'Sao chép', 1500); })" 
                                        style="background: none; border: none; font-size: 0.72rem; color: var(--admin-muted); cursor: pointer; padding: 2px 4px; border-radius: 3px; font-weight: 600;" 
                                        title="Sao chép URL ảnh">
                                    Sao chép
                                </button>
                            </div>
                            <form action="{{ route('admin.media.destroy', $media->id) }}" method="POST" data-confirm="Bạn có chắc chắn muốn xóa tệp ảnh '{{ $media->filename }}' khỏi hệ thống?" data-confirm-title="Xóa Tệp Ảnh" data-confirm-type="danger" data-confirm-btn="Xóa Tệp">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; display: inline-flex; align-items: center; padding: 2px;" title="Xóa ảnh">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
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

