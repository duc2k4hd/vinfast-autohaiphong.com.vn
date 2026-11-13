@extends('admin.layouts.app')

@section('title', 'Tạo Bài Viết Tin Tức Mới')
@section('header_title', 'TẠO BÀI VIẾT TIN TỨC MỚI')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.posts.index') }}" style="color: var(--admin-primary); font-weight: 600;">
        &larr; Quay lại danh sách bài viết
    </a>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST">
    @csrf

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
        {{-- Cột Trái: Nội dung chính --}}
        <div class="vinfast-autohaiphong_admin_card">
            <div class="vinfast-autohaiphong_admin_card_title">NỘI DUNG BÀI VIẾT</div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Tiêu Đề Bài Viết <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ví dụ: Ưu đãi lệ phí trước bạ xe điện VinFast..."
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.95rem;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Đoạn Tóm Tắt (Excerpt)</label>
                <textarea name="excerpt" rows="3" placeholder="Tóm tắt ngắn gọn nội dung bài viết..."
                          style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border); border-radius: 6px;">{{ old('excerpt') }}</textarea>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Nội Dung Chi Tiết (HTML) <span style="color: #ef4444;">*</span></label>
                <textarea name="content_html" rows="12" required placeholder="Nhập nội dung bài viết với các thẻ HTML..."
                          style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border); border-radius: 6px; font-family: monospace; font-size: 0.9rem;">{{ old('content_html') }}</textarea>
            </div>
        </div>

        {{-- Cột Phải: Xuất bản, Ảnh đại diện & SEO --}}
        <div>
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title">XUẤT BẢN</div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Trạng Thái</label>
                    <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                        <option value="published" selected>Xuất bản ngay</option>
                        <option value="draft">Lưu bản nháp</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Chọn Ảnh Đại Diện (Media ID)</label>
                    <select name="featured_media_id" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                        <option value="">-- Không chọn ảnh --</option>
                        @foreach($mediaList as $m)
                            <option value="{{ $m->id }}">{{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh' }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="width: 100%; padding: 12px; font-size: 0.95rem;">
                    💾 Đăng Bài Viết
                </button>
            </div>

            {{-- Thẻ SEO --}}
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title">THẺ SEO (TÙY CHỌN)</div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 4px;">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Để trống nếu lấy theo tiêu đề"
                           style="width: 100%; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 4px;">Meta Description</label>
                    <textarea name="meta_description" rows="3" placeholder="Tự động trích xuất nếu để trống..."
                              style="width: 100%; padding: 8px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

