@extends('admin.layouts.app')

@section('title', 'Tạo Bài Viết Tin Tức Mới')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <a href="{{ route('admin.posts.index') }}" style="color: var(--admin-muted);">Tin tức</a> &rsaquo; 
    <span>Tạo mới</span>
@endsection
@section('header_title', 'TẠO BÀI VIẾT TIN TỨC MỚI')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.posts.index') }}" style="color: var(--admin-primary); font-weight: 600;">
        &larr; Quay lại danh sách bài viết
    </a>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST" class="form-track-changes">
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

            @include('admin.components.editor', [
                'name' => 'content_html',
                'id' => 'content_html',
                'value' => old('content_html'),
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
                        <option value="published" selected>Xuất bản ngay</option>
                        <option value="draft">Lưu bản nháp</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Ảnh Đại Diện Bài Viết</label>
                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 8px;">
                        <div id="post-featured-preview" style="width: 80px; height: 60px; border: 1px dashed var(--admin-border); border-radius: 6px; overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <span style="font-size: 0.72rem; color: var(--admin-muted);">Chưa có</span>
                        </div>
                        <div style="flex: 1;">
                            <input type="hidden" name="featured_media_id" id="post_featured_media_id" value="{{ old('featured_media_id') }}">
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="choosePostFeaturedImage()" style="padding: 6px 12px; font-size: 0.8rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    🖼 Chọn ảnh từ Thư viện
                                </button>
                                <button type="button" class="vinfast-autohaiphong_admin_btn" onclick="clearPostFeaturedImage()" style="padding: 6px 10px; font-size: 0.8rem; background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0;">
                                    Xóa
                                </button>
                            </div>
                            <div id="post-featured-filename" style="font-size: 0.75rem; color: var(--admin-muted); margin-top: 4px;">
                                Chưa chọn ảnh đại diện
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="width: 100%; padding: 12px; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Đăng Bài Viết
                </button>
            </div>

            {{-- Thẻ SEO Tối Ưu Hóa Chuẩn evondevKit & Nobi Fashion --}}
            @include('admin.components.seo-analyzer', [
                'metaTitle' => old('meta_title'),
                'metaDescription' => old('meta_description'),
            ])
        </div>
    </div>
</form>

<script>
let formIsDirty = false;
const postCreateForm = document.querySelector('form[action*="admin/posts"]');
if (postCreateForm) {
    postCreateForm.addEventListener('input', () => { formIsDirty = true; });
    postCreateForm.addEventListener('change', () => { formIsDirty = true; });
    postCreateForm.addEventListener('submit', () => { formIsDirty = false; });
}
window.addEventListener('beforeunload', (e) => {
    if (formIsDirty) {
        e.preventDefault();
        e.returnValue = '';
    }
});

function choosePostFeaturedImage() {
    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn làm ảnh đại diện',
        onSelect: function(media) {
            if (!media || !media.id) return;
            document.getElementById('post_featured_media_id').value = media.id;
            const preview = document.getElementById('post-featured-preview');
            if (preview) {
                preview.innerHTML = `<img src="${media.url}" alt="${media.alt_text || media.filename}" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            const nameEl = document.getElementById('post-featured-filename');
            if (nameEl) {
                nameEl.textContent = media.filename;
            }
            formIsDirty = true;
        }
    });
}

function clearPostFeaturedImage() {
    document.getElementById('post_featured_media_id').value = '';
    const preview = document.getElementById('post-featured-preview');
    if (preview) {
        preview.innerHTML = `<span style="font-size: 0.72rem; color: var(--admin-muted);">Chưa có</span>`;
    }
    const nameEl = document.getElementById('post-featured-filename');
    if (nameEl) {
        nameEl.textContent = 'Chưa chọn ảnh đại diện';
    }
    formIsDirty = true;
}
</script>
@endsection

