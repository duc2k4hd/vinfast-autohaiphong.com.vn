@extends('clients.layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' | VinFast Hải Phòng')
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content_html), 150))
@section('canonical', url('/chuyen-muc/tin-tuc/' . $post->slug))
@section('og_type', 'article')
@section('og_title', $post->meta_title ?: $post->title)
@section('og_description', $post->meta_description ?: Str::limit(strip_tags($post->content_html), 150))

@push('schema')
{{-- Article Schema JSON-LD cho Google News & Search --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $post->title,
    'description' => $post->meta_description ?: Str::limit(strip_tags($post->content_html), 150),
    'image' => [
        $post->featured_media_id ? asset('storage/' . ($post->thumbnail_path ?? '')) : asset('storage/clients/assets/images/banners/vinfast-banner-54gf5.png')
    ],
    'datePublished' => date('c', strtotime($post->published_at ?: $post->created_at)),
    'dateModified' => date('c', strtotime($post->updated_at)),
    'author' => [
        '@type' => 'Organization',
        'name' => 'Ban Biên Tập VinFast Hải Phòng',
        'url' => url('/')
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'VinFast Hải Phòng',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('storage/clients/assets/images/business/vinfast-haiphong.png')
        ]
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => url('/chuyen-muc/tin-tuc/' . $post->slug)
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Trang chủ',
            'item' => route('client.home')
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Tin Tức',
            'item' => url('/chuyen-muc/tin-tuc')
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $post->title,
            'item' => url('/chuyen-muc/tin-tuc/' . $post->slug)
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

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
            <div style="font-size: 0.85rem; color: var(--client-color-muted); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <span>📅 Đăng ngày {{ date('d/m/Y', strtotime($post->published_at)) }}</span>
                <span>•</span>
                <span>VinFast Hải Phòng</span>
            </div>
            
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); line-height: 1.3; margin-bottom: 20px;">
                {{ $post->title }}
            </h1>

            @if($post->excerpt)
                <div style="font-size: 1.05rem; font-weight: 500; line-height: 1.7; color: #334155; border-left: 4px solid var(--client-color-primary); padding-left: 16px; margin-bottom: 28px; background: #f8fafc; padding-top: 10px; padding-bottom: 10px; border-radius: 0 4px 4px 0;">
                    {{ $post->excerpt }}
                </div>
            @endif

            {{-- Khối Mục Lục Bài Viết (Table of Contents Tự Động) --}}
            <div id="vf-post-toc-container" style="display: none; background: #f8fafc; border: 1px solid var(--client-color-border); border-radius: 6px; padding: 18px 22px; margin-bottom: 32px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <span style="font-size: 0.95rem; font-weight: 700; color: var(--client-color-heading);">
                        📑 MỤC LỤC BÀI VIẾT
                    </span>
                    <button type="button" onclick="togglePostToc()" id="vf-toc-toggle-btn" style="background: none; border: none; color: var(--client-color-primary); cursor: pointer; font-size: 0.8rem; font-weight: 600;">
                        [Ẩn]
                    </button>
                </div>
                <ul id="vf-post-toc-list" style="list-style: none; padding: 0; margin: 0; line-height: 1.8; font-size: 0.9rem;"></ul>
            </div>

            <div class="vinfast-autohaiphong_post_body" style="font-size: 1.05rem; line-height: 1.85; color: #1e293b;">
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
                        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 6px; padding: 18px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const postBody = document.querySelector('.vinfast-autohaiphong_post_body');
    const tocContainer = document.getElementById('vf-post-toc-container');
    const tocList = document.getElementById('vf-post-toc-list');

    if (!postBody || !tocContainer || !tocList) return;

    const headings = postBody.querySelectorAll('h2, h3');
    if (headings.length < 2) return; // Nếu dưới 2 tiêu đề thì không cần hiện TOC

    headings.forEach(function (heading, index) {
        const id = 'heading-' + index;
        heading.id = id;

        const li = document.createElement('li');
        li.style.marginBottom = '6px';
        if (heading.tagName.toLowerCase() === 'h3') {
            li.style.paddingLeft = '20px';
            li.style.fontSize = '0.85rem';
        }

        const a = document.createElement('a');
        a.href = '#' + id;
        a.textContent = heading.textContent;
        a.style.color = 'var(--client-color-text)';
        a.style.textDecoration = 'none';
        a.addEventListener('mouseenter', () => a.style.color = 'var(--client-color-primary)');
        a.addEventListener('mouseleave', () => a.style.color = 'var(--client-color-text)');

        li.appendChild(a);
        tocList.appendChild(li);
    });

    tocContainer.style.display = 'block';
});

function togglePostToc() {
    const list = document.getElementById('vf-post-toc-list');
    const btn = document.getElementById('vf-toc-toggle-btn');
    if (list.style.display === 'none') {
        list.style.display = 'block';
        btn.textContent = '[Ẩn]';
    } else {
        list.style.display = 'none';
        btn.textContent = '[Hiện]';
    }
}
</script>
@endsection

