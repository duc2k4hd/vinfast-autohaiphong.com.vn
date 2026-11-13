@extends('clients.layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' | VinFast Hải Phòng')
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content_html), 150))
@section('canonical', url('/chuyen-muc/tin-tuc/' . $post->slug))

@section('content')
<div class="vinfast-autohaiphong_post_breadcrumb" style="background: var(--client-color-surface); border-bottom: 1px solid var(--client-color-border); padding: 12px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <nav style="font-size: 0.85rem; color: var(--client-color-muted);">
            <a href="{{ route('client.home') }}" style="color: var(--client-color-text);">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            <a href="{{ url('/chuyen-muc/tin-tuc') }}" style="color: var(--client-color-text);">Tin Tức</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: var(--client-color-primary); font-weight: 600;">{{ Str::limit($post->title, 40) }}</span>
        </nav>
    </div>
</div>

<div class="vinfast-autohaiphong_post_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container" style="max-width: 900px;">
        <article style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <div style="font-size: 0.85rem; color: var(--client-color-muted); margin-bottom: 12px;">
                📅 Đăng ngày {{ date('d/m/Y', strtotime($post->published_at)) }} • VinFast Hải Phòng
            </div>
            
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); line-height: 1.3; margin-bottom: 20px;">
                {{ $post->title }}
            </h1>

            @if($post->excerpt)
                <div style="font-size: 1.05rem; font-weight: 500; line-height: 1.7; color: #334155; border-left: 4px solid var(--client-color-primary); padding-left: 16px; margin-bottom: 28px; background: #f8fafc; padding-top: 10px; padding-bottom: 10px;">
                    {{ $post->excerpt }}
                </div>
            @endif

            <div class="vinfast-autohaiphong_post_body" style="font-size: 1rem; line-height: 1.8; color: #1e293b;">
                {!! $post->content_html !!}
            </div>

            <div style="border-top: 1px solid var(--client-color-border); margin-top: 40px; padding-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <span style="font-size: 0.875rem; color: var(--client-color-muted);">
                    Showroom VinFast Minh Đạo — Số 1 Bạch Đằng, Hồng Bàng, Hải Phòng
                </span>
                <a href="{{ url('/chuyen-muc/tin-tuc') }}" style="color: var(--client-color-primary); font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                    &larr; Quay lại danh sách tin tức
                </a>
            </div>
        </article>

        {{-- Bài viết liên quan --}}
        @if($relatedPosts->isNotEmpty())
            <div style="margin-top: 40px;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 20px;">
                    BÀI VIẾT KHÁC CÙNG CHUYÊN MỤC
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
                    @foreach($relatedPosts as $rel)
                        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 6px; padding: 18px;">
                            <div style="font-size: 0.75rem; color: var(--client-color-muted); margin-bottom: 6px;">
                                {{ date('d/m/Y', strtotime($rel->published_at)) }}
                            </div>
                            <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 8px;">
                                <a href="{{ url('/chuyen-muc/tin-tuc/' . $rel->slug) }}" style="color: var(--client-color-heading); text-decoration: none;">
                                    {{ $rel->title }}
                                </a>
                            </h4>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

