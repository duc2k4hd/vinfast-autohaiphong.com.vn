@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Bài Viết: ' . $post->title)
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <a href="{{ route('admin.posts.index') }}" style="color: var(--admin-muted);">Tin tức</a> &rsaquo; 
    <span>{{ Str::limit($post->title, 40) }}</span>
@endsection
@section('header_title', 'CHỈNH SỬA BÀI VIẾT TIN TỨC')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.posts.index') }}" style="color: var(--admin-primary); font-weight: 600;">
        &larr; Quay lại danh sách bài viết
    </a>
</div>

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
        {{-- Cột Trái: Nội dung chính --}}
        <div class="vinfast-autohaiphong_admin_card">
            <div class="vinfast-autohaiphong_admin_card_title">NỘI DUNG BÀI VIẾT</div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Tiêu Đề Bài Viết <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.95rem;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Đoạn Tóm Tắt (Excerpt)</label>
                <textarea name="excerpt" rows="3" 
                          style="width: 100%; padding: 10px 14px; border: 1px solid var(--admin-border); border-radius: 6px;">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            @include('admin.components.editor', [
                'name' => 'content_html',
                'id' => 'content_html',
                'value' => $post->content_html,
                'label' => 'Nội Dung Chi Tiết Bài Viết (TinyMCE Soạn Thảo)',
                'folder' => 'posts',
                'height' => 450,
            ])
        </div>

        {{-- Cột Phải: Xuất bản, Ảnh đại diện & SEO --}}
        <div>
            <div class="vinfast-autohaiphong_admin_card">
                <div class="vinfast-autohaiphong_admin_card_title">XUẤT BẢN</div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Trạng Thái</label>
                    <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                        <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Xuất bản</option>
                        <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Ảnh Đại Diện (Media ID)</label>
                    <select name="featured_media_id" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px;">
                        <option value="">-- Không chọn ảnh --</option>
                        @foreach($mediaList as $m)
                            <option value="{{ $m->id }}" {{ $post->featured_media_id == $m->id ? 'selected' : '' }}>
                                {{ $m->filename }} ({{ $m->alt_text ?: 'Ảnh' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="width: 100%; padding: 12px; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Lưu Cập Nhật
                </button>
            </div>

            {{-- Thẻ SEO Tối Ưu Hóa Chuẩn evondevKit & Nobi Fashion --}}
            @include('admin.components.seo-analyzer', [
                'metaTitle' => $post->meta_title,
                'metaDescription' => $post->meta_description,
            ])
        </div>
    </div>
</form>

<script>
let formIsDirty = false;
const postForm = document.querySelector('form[action*="admin/posts"]');
if (postForm) {
    postForm.addEventListener('input', () => { formIsDirty = true; });
    postForm.addEventListener('change', () => { formIsDirty = true; });
    postForm.addEventListener('submit', () => { formIsDirty = false; });
}
window.addEventListener('beforeunload', (e) => {
    if (formIsDirty) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>
@endsection

