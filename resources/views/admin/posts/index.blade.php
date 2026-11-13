@extends('admin.layouts.app')

@section('title', 'Quản Lý Bài Viết Tin Tức')
@section('header_title', 'DANH SÁCH BÀI VIẾT TIN TỨC & SỰ KIỆN')

@section('content')
<div class="vinfast-autohaiphong_admin_card">
    <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
        <span>TẤT CẢ BÀI VIẾT</span>
        <a href="{{ route('admin.posts.create') }}" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="font-size: 0.85rem;">
            + Viết Bài Mới
        </a>
    </div>

    @if($posts->isEmpty())
        <p style="color: var(--admin-muted); padding: 24px 0; text-align: center;">Chưa có bài viết nào.</p>
    @else
        <table class="vinfast-autohaiphong_admin_table">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 80px;">Hình Ảnh</th>
                    <th>Tiêu Đề Bài Viết</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đăng</th>
                    <th style="text-align: right;">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            <img src="{{ $post->thumbnail_path ? asset('storage/' . $post->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                                 alt="{{ $post->title }}" 
                                 style="width: 70px; height: 44px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--admin-heading);">{{ $post->title }}</div>
                            <div style="font-size: 0.8rem; color: var(--admin-muted);">Slug: {{ $post->slug }}</div>
                        </td>
                        <td>
                            @if($post->status === 'published')
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">Đã xuất bản</span>
                            @else
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_warning">Bản nháp</span>
                            @endif
                        </td>
                        <td style="font-size: 0.85rem; color: var(--admin-muted);">
                            {{ $post->published_at ? date('d/m/Y H:i', strtotime($post->published_at)) : 'Chưa đăng' }}
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 10px; font-size: 0.8rem;">
                                Sửa
                            </a>
                            <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}" target="_blank" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 8px; font-size: 0.8rem;" title="Xem bài">
                                👁️
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 10px; font-size: 0.8rem; color: #ef4444; border-color: #fca5a5;">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection

