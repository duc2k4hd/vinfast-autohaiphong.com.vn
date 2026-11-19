@extends('clients.layouts.app')

@section('title', ($currentCategory ? $currentCategory->name.' | ' : 'Tin tức xe VinFast | ').($posts->currentPage() > 1 ? 'Trang '.$posts->currentPage().' | ' : '').'VinFast Hải Phòng')
@section('meta_description', $currentCategory
    ? ($currentCategory->description ?: 'Bài viết trong chuyên mục '.$currentCategory->name.' của VinFast Hải Phòng.')
    : ($posts->currentPage() > 1
        ? 'Xem tiếp tin tức xe điện VinFast, hướng dẫn về giá xe, pin và trạm sạc tại Hải Phòng - trang '.$posts->currentPage().'.'
        : 'Tin tức và hướng dẫn về xe điện VinFast, giá xe, pin và trạm sạc tại Hải Phòng.'))
@section('canonical', $posts->currentPage() > 1 ? route('client.posts.page', ['page' => $posts->currentPage()]) : route('client.posts.index'))

@push('schema')
{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => array_filter([
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Trang chủ',
            'item' => route('client.home'),
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Tin Tức & Blog',
            'item' => url('/blogs'),
        ],
        $currentCategory ? [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $currentCategory->name,
            'item' => url('/blogs?category=' . $currentCategory->slug),
        ] : null,
    ]),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>

{{-- Blog / CollectionPage Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'Blog',
    'name' => ($currentCategory ? $currentCategory->name . ' - ' : '') . 'Tin Tức & Blog VinFast Hải Phòng',
    'description' => 'Cập nhật tin tức, cẩm nang xe điện và ưu đãi giá lăn bánh tại VinFast Hải Phòng.',
    'url' => url('/blogs'),
    'publisher' => [
        '@type' => 'AutoDealer',
        'name' => 'VinFast Hải Phòng',
        'url' => url('/'),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@section('content')
<div class="vinfast-autohaiphong_posts_header" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); padding: 36px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <nav style="font-size: 0.85rem; color: var(--client-color-muted); margin-bottom: 12px;">
            <a href="{{ route('client.home') }}" style="color: var(--client-color-muted); text-decoration: none;">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            @if($currentCategory)
                <a href="{{ url('/blogs') }}" style="color: var(--client-color-muted); text-decoration: none;">Tin Tức & Blog</a>
                <span style="margin: 0 6px;">/</span>
                <span style="color: var(--client-color-primary); font-weight: 600;">{{ $currentCategory->name }}</span>
            @else
                <span style="color: var(--client-color-primary); font-weight: 600;">Tin Tức & Blog</span>
            @endif
        </nav>

        <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
            {{ $currentCategory ? $currentCategory->name : 'TIN TỨC & BÀI VIẾT VINFAST' }}
        </h1>
        <p style="color: var(--client-color-muted); font-size: 0.95rem; margin: 0; max-width: 760px; line-height: 1.6;">
            {{ $currentCategory ? ($currentCategory->description ?: 'Các bài viết và thông tin cập nhật trong chuyên mục ' . $currentCategory->name) : 'Cập nhật thông tin ưu đãi giá xe, chính sách pin, trạm sạc V-GREEN và cẩm nang vận hành xe ô tô điện thông minh tại Hải Phòng.' }}
        </p>

        {{-- Thanh bộ lọc danh mục (Category filter pills) --}}
        @if(!empty($categories) && $categories->isNotEmpty())
            <div style="margin-top: 24px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;" role="tablist" aria-label="Bộ lọc danh mục tin tức">
                <a href="{{ url('/blogs') }}" 
                   style="display: inline-flex; align-items: center; padding: 7px 16px; border-radius: 9999px; font-size: 0.88rem; font-weight: 600; text-decoration: none; transition: all 0.2s ease; border: 1px solid {{ empty($selectedCategory) ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ empty($selectedCategory) ? 'var(--client-color-primary)' : '#f8fafc' }}; color: {{ empty($selectedCategory) ? '#ffffff' : '#334155' }};"
                   aria-current="{{ empty($selectedCategory) ? 'page' : 'false' }}">
                    Tất cả bài viết
                </a>

                @foreach($categories as $cat)
                    @php $isActive = ($selectedCategory === $cat->slug); @endphp
                    <a href="{{ url('/blogs?category=' . $cat->slug) }}" 
                       style="display: inline-flex; align-items: center; padding: 7px 16px; border-radius: 9999px; font-size: 0.88rem; font-weight: 600; text-decoration: none; transition: all 0.2s ease; border: 1px solid {{ $isActive ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ $isActive ? 'var(--client-color-primary)' : '#f8fafc' }}; color: {{ $isActive ? '#ffffff' : '#334155' }};"
                       aria-current="{{ $isActive ? 'page' : 'false' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach

                @if(!empty($selectedCategory))
                    <a href="{{ url('/blogs') }}" style="font-size: 0.82rem; color: #ef4444; text-decoration: none; font-weight: 600; margin-left: 6px;">
                        &times; Xóa lọc danh mục
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<div class="vinfast-autohaiphong_posts_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        @if($posts->isEmpty())
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 48px 24px; text-align: center; color: var(--client-color-muted);">
                <div style="font-size: 2.5rem; margin-bottom: 12px;">📰</div>
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 8px;">
                    Chưa có bài viết nào trong danh mục này
                </h3>
                <p style="font-size: 0.9rem; margin-bottom: 20px;">
                    Vui lòng chọn danh mục khác hoặc bấm xem toàn bộ bài viết để cập nhật các tin tức mới nhất.
                </p>
                <a href="{{ url('/blogs') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 10px 22px; text-decoration: none; font-size: 0.9rem;">
                    Xem Tất Cả Bài Viết
                </a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 28px; margin-bottom: 40px;">
                @foreach($posts as $post)
                    <article style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s ease, box-shadow 0.2s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                        <a href="{{ url('/blog/' . $post->slug) }}" style="display: block; position: relative; padding-top: 55%; overflow: hidden; background: #e2e8f0;">
                            <img src="{{ $post->thumbnail_path ? asset('storage/' . $post->thumbnail_path) : asset('storage/clients/assets/images/posts/huong-dan-su-dung-tram-sac.webp') }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy" 
                                 style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                        </a>
                        <div style="padding: 20px; display: flex; flex-direction: column; flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.8rem; margin-bottom: 10px;">
                                @if(!empty($post->category_name))
                                    <a href="{{ url('/blogs?category=' . $post->category_slug) }}" style="background: #eff6ff; color: var(--client-color-primary); padding: 3px 8px; border-radius: 4px; font-weight: 600; text-decoration: none;">
                                        {{ $post->category_name }}
                                    </a>
                                @else
                                    <span style="background: #f1f5f9; color: #475569; padding: 3px 8px; border-radius: 4px; font-weight: 600;">Tin tức</span>
                                @endif
                                <span style="color: var(--client-color-muted);">
                                    📅 {{ date('d/m/Y', strtotime($post->published_at)) }}
                                </span>
                            </div>

                            <h2 style="font-size: 1.1rem; font-weight: 700; line-height: 1.4; margin-bottom: 10px;">
                                <a href="{{ url('/blog/' . $post->slug) }}" style="color: var(--client-color-heading); text-decoration: none;">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p style="font-size: 0.875rem; color: #475569; line-height: 1.6; margin-bottom: 16px; flex: 1;">
                                {{ Str::limit($post->excerpt, 120) }}
                            </p>
                            <div>
                                <a href="{{ url('/blog/' . $post->slug) }}" style="color: var(--client-color-primary); font-size: 0.875rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    Đọc tiếp <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="display: flex; justify-content: center;">
                {{ $posts->links('clients.pages.posts.pagination', ['selectedCategory' => $selectedCategory]) }}
            </div>
        @endif
    </div>
</div>
@endsection
