@extends('clients.layouts.app')

@section('title', 'Tin Tức & Hoạt Động | VinFast Hải Phòng')
@section('meta_description', 'Cập nhật tin tức mới nhất về các dòng ô tô điện VinFast, chính sách khuyến mãi, trạm sạc và kinh nghiệm sử dụng xe tại Hải Phòng.')
@section('canonical', url('/chuyen-muc/tin-tuc'))

@section('content')
<div class="vinfast-autohaiphong_posts_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 32px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            TIN TỨC & SỰ KIỆN VINFAST
        </h1>
        <p style="color: var(--client-color-muted); font-size: 0.95rem;">
            Thông tin ưu đãi giá xe, chính sách pin, trạm sạc và cẩm nang vận hành xe ô tô điện thông minh.
        </p>
    </div>
</div>

<div class="vinfast-autohaiphong_posts_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        @if($posts->isEmpty())
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 40px; text-align: center; color: var(--client-color-muted);">
                Chưa có bài viết nào được đăng tải. Vui lòng quay lại sau!
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 28px; margin-bottom: 40px;">
                @foreach($posts as $post)
                    <article style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s ease, box-shadow 0.2s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                        <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}" style="display: block; position: relative; padding-top: 55%; overflow: hidden; background: #e2e8f0;">
                            <img src="{{ $post->thumbnail_path ? asset('storage/' . $post->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy" 
                                 style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                        </a>
                        <div style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
                            <div style="font-size: 0.8rem; color: var(--client-color-muted); margin-bottom: 8px;">
                                📅 {{ date('d/m/Y', strtotime($post->published_at)) }}
                            </div>
                            <h2 style="font-size: 1.1rem; font-weight: 700; line-height: 1.4; margin-bottom: 10px;">
                                <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}" style="color: var(--client-color-heading); text-decoration: none;">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p style="font-size: 0.875rem; color: #475569; line-height: 1.6; margin-bottom: 16px; flex: 1;">
                                {{ Str::limit($post->excerpt, 120) }}
                            </p>
                            <div>
                                <a href="{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}" style="color: var(--client-color-primary); font-size: 0.875rem; font-weight: 600; text-decoration: none;">
                                    Đọc tiếp &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="display: flex; justify-content: center;">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

