@extends('clients.layouts.app')

@section('title', $cars->currentPage() > 1 ? 'Các dòng xe VinFast tại Hải Phòng | Trang '.$cars->currentPage() : 'Các dòng xe VinFast tại Hải Phòng | Giá tham khảo')
@section('meta_description', $cars->currentPage() > 1
    ? 'Xem tiếp các dòng xe VinFast tại Hải Phòng ở trang '.$cars->currentPage().'. So sánh thông tin, giá tham khảo và xem chi tiết từng mẫu xe.'
    : 'Khám phá các dòng ô tô VinFast tại Hải Phòng, xem thông tin giá xe và liên hệ tư vấn lựa chọn xe phù hợp.')
@section('canonical', $cars->currentPage() > 1 ? route('client.catalog.page', ['page' => $cars->currentPage()]) : route('client.catalog.index'))

@push('schema')
{{-- ItemList Schema cho trang danh mục ô tô VinFast --}}
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'ItemList',
    'itemListElement' => $cars->map(function ($car, $index) use ($cars) {
        return [
            '@type' => 'ListItem',
            'position' => (($cars->currentPage() - 1) * $cars->perPage()) + $index + 1,
            'name' => $car->name,
            'url' => url('/xe/' . $car->slug),
            'image' => $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
        ];
    })->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>

{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
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
            'name' => 'Ô Tô VinFast',
            'item' => url('/o-to-vinfast')
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@push('styles')
<style>
.catalog-intro{background:#0f1f38;color:#fff;padding:44px 0 52px 0}.catalog-intro span{display:inline-block;color:#9dbdec;font-weight:700;font-size:.75rem;letter-spacing:.14em;text-transform:uppercase;margin-bottom:8px}.catalog-intro h1{color:white;font-size:clamp(2rem,3.5vw,2.75rem);font-weight:800;line-height:1.25;margin:0 0 12px;max-width:760px}.catalog-intro p{color:#d4deec;max-width:650px;line-height:1.65;margin:0;font-size:.95rem}.catalog-intro__banner-wrap{margin-top:26px;width:100%;border-radius:14px;overflow:hidden;box-shadow:0 10px 28px rgba(0,0,0,.28)}.catalog-intro__banner{display:block;width:100%;aspect-ratio:19 / 6;object-fit:cover;object-position:center}.vinfast-autohaiphong_catalog_section{background:#f5f7fa}.vinfast-autohaiphong_catalog_header h1{color:#14243b}.vinfast-autohaiphong_catalog_section .vinfast-autohaiphong_home_car_card{background:white;border:1px solid #e1e7ee;border-radius:14px;overflow:hidden}.vinfast-autohaiphong_catalog_section .vinfast-autohaiphong_home_car_thumb{background:#edf1f5}.vinfast-autohaiphong_catalog_section .vinfast-autohaiphong_home_car_body{padding:24px}.vinfast-autohaiphong_catalog_header>div:last-child>div{flex-wrap:wrap}.catalog-help{display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;margin-top:50px;padding:30px;background:#e8eff8;border-radius:14px}.catalog-help h2{font-size:1.3rem;margin:0 0 8px;color:#14243b}.catalog-help p{margin:0;color:#52657d}@media(max-width:600px){.catalog-intro{padding:32px 0 36px}.catalog-intro__banner-wrap{margin-top:18px;border-radius:10px}.catalog-help{padding:24px}}
.catalog-pagination{display:flex;justify-content:center;align-items:center;flex-wrap:wrap;gap:8px;margin-top:40px}.catalog-pagination__item{display:inline-flex;align-items:center;justify-content:center;gap:4px;min-width:44px;height:44px;padding:0 14px;border:1px solid #d6e0eb;border-radius:9px;background:#fff;color:#263d59;font-size:.9rem;font-weight:600;text-decoration:none;transition:background .2s,border-color .2s,color .2s}.catalog-pagination a:hover{border-color:#1768cf;color:#1768cf}.catalog-pagination a:focus-visible{outline:3px solid #83b7ff;outline-offset:2px}.catalog-pagination__item[aria-current="page"]{background:#1768cf;border-color:#1768cf;color:#fff}.catalog-pagination__item[aria-disabled="true"]{color:#a5b2c1;background:#f5f7fa}.catalog-pagination__dots{padding:0 3px;color:#718096}@media(max-width:480px){.catalog-pagination{gap:6px}.catalog-pagination__item{min-width:40px;height:40px;padding:0 11px}}
</style>
@endpush
@section('content')
{{-- Breadcrumb --}}
<div class="vinfast-autohaiphong_catalog_breadcrumb_wrapper" style="background-color: var(--client-color-surface); border-bottom: 1px solid var(--client-color-border); padding: 12px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <nav style="font-size: 0.85rem; color: var(--client-color-muted);">
            <a href="{{ route('client.home') }}" style="color: var(--client-color-text);">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: var(--client-color-primary); font-weight: 600;">Ô Tô VinFast</span>
        </nav>
    </div>
</div>

<section class="catalog-intro">
    <div class="vinfast-autohaiphong_layout_container">
        <span>VinFast Hải Phòng</span>
        <h1>Chọn chiếc VinFast phù hợp với bạn</h1>
        <p>Khám phá các dòng ô tô VinFast, tìm hiểu giá xe và nhận tư vấn phù hợp với nhu cầu của bạn tại Hải Phòng.</p>
        @if($catalogIntroImage)
            <div class="catalog-intro__banner-wrap">
                <img class="catalog-intro__banner catalog-intro__image catalog-intro__background" 
                     src="{{ asset('storage/'.ltrim($catalogIntroImage, '/')) }}" 
                     alt="VinFast Hải Phòng - Chọn chiếc xe phù hợp với bạn" 
                     loading="lazy">
            </div>
        @endif
    </div>
</section>
<div class="vinfast-autohaiphong_catalog_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        {{-- Tiêu đề trang & Thanh công cụ lọc --}}
        <div class="vinfast-autohaiphong_catalog_header" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px; margin-bottom: 30px; border-bottom: 1px solid var(--client-color-border); padding-bottom: 20px;">
            <div>
                <h2 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 6px;">
                    Các dòng xe ô tô VinFast
                </h2>
                <p style="font-size: 0.95rem; color: var(--client-color-muted); margin: 0;">
                    Hiển thị {{ $cars->total() }} mẫu xe điện thông minh chính hãng tại đại lý Hải Phòng
                </p>
            </div>

            {{-- Bộ lọc & Sắp xếp --}}
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                {{-- Lọc danh mục --}}
                <div style="display: flex; gap: 6px;">
                    <a href="{{ route('client.catalog.index', ['sort' => $currentSort]) }}" 
                       class="vinfast-autohaiphong_btn {{ empty($currentCategory) ? 'vinfast-autohaiphong_btn_primary' : 'vinfast-autohaiphong_btn_neutral' }}" 
                       style="padding: 6px 14px; font-size: 0.825rem;">
                        Tất Cả
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('client.catalog.index', ['category' => $cat->slug, 'sort' => $currentSort]) }}" 
                           class="vinfast-autohaiphong_btn {{ $currentCategory === $cat->slug ? 'vinfast-autohaiphong_btn_primary' : 'vinfast-autohaiphong_btn_neutral' }}" 
                           style="padding: 6px 14px; font-size: 0.825rem;">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                {{-- Sắp xếp theo giá --}}
                <form action="{{ route('client.catalog.index') }}" method="GET" style="display: inline-block;">
                    @if($currentCategory)
                        <input type="hidden" name="category" value="{{ $currentCategory }}">
                    @endif
                    <label for="catalog-sort" class="sr-only">Sắp xếp theo</label><select id="catalog-sort" name="sort" onchange="this.form.submit()" style="padding: 7px 12px; border: 1px solid var(--client-color-border); border-radius: 4px; font-size: 0.85rem; background: #ffffff; color: var(--client-color-heading); outline: none;">
                        <option value="default" {{ $currentSort === 'default' ? 'selected' : '' }}>Sắp xếp: Mặc định</option>
                        <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                        <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                        <option value="latest" {{ $currentSort === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    </select><noscript><button type="submit">Áp dụng</button></noscript>
                </form>
            </div>
        </div>

        {{-- Lưới sản phẩm (Grid Max-width 1200px) --}}
        <div class="vinfast-autohaiphong_home_grid">
            @if($cars->isNotEmpty())
                @foreach($cars as $car)
                    <div class="vinfast-autohaiphong_home_car_card">
                        {{-- Thumbnail --}}
                        <div class="vinfast-autohaiphong_home_car_thumb">
                            <img src="{{ $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                                 alt="{{ $car->thumbnail_alt ?? $car->name }}" 
                                 loading="lazy" 
                                 width="600" 
                                 height="338">
                        </div>

                        {{-- Body --}}
                        <div class="vinfast-autohaiphong_home_car_body">
                            <span style="font-size: 0.75rem; color: var(--client-color-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                                {{ $car->category_name ?? 'Ô tô điện' }}
                            </span>
                            <h2 class="vinfast-autohaiphong_home_car_name" style="font-size: 1.25rem;">
                                <a href="{{ url('/xe/' . $car->slug) }}">{{ $car->name }}</a>
                            </h2>

                            {{-- Giá --}}
                            <div class="vinfast-autohaiphong_home_car_price_box">
                                <span class="vinfast-autohaiphong_home_car_price_label">Giá từ:</span>
                                @if($car->price_on_request || (!$car->sale_price && !$car->regular_price))
                                    <span class="vinfast-autohaiphong_home_car_price" style="font-size: 1.1rem;">Liên hệ báo giá</span>
                                @else
                                    <span class="vinfast-autohaiphong_home_car_price">
                                        {{ number_format($car->sale_price ?: $car->regular_price, 0, ',', '.') }} VNĐ
                                    </span>
                                @endif
                            </div>

                            {{-- Mô tả ngắn --}}
                            <p style="font-size: 0.85rem; color: var(--client-color-muted); line-height: 1.5; margin-bottom: 14px;">
                                {{ Str::limit($car->short_description ?? '', 85) }}
                            </p>

                            {{-- Actions --}}
                            <div class="vinfast-autohaiphong_home_car_actions">
                                <button type="button" onclick="openQuoteModal({{ $car->id }}, {{ Illuminate\Support\Js::from($car->name) }})" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
                                    Báo Giá Lăn Bánh
                                </button>
                                <a href="{{ url('/xe/' . $car->slug) }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_neutral">
                                    Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0;">
                    <p style="font-size: 1.1rem; color: var(--client-color-muted);">Không tìm thấy dòng xe nào phù hợp với bộ lọc hiện tại.</p>
                    <a href="{{ route('client.catalog.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="margin-top: 12px;">
                        Xem Toàn Bộ Các Dòng Xe
                    </a>
                </div>
            @endif
        </div>

        <div class="catalog-help"><div><h2>Bạn cần tư vấn chọn xe?</h2><p>Liên hệ VinFast Hải Phòng để tìm hiểu thêm về dòng xe bạn quan tâm.</p></div><a href="{{ route('client.contact.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">Liên hệ tư vấn</a></div>
        {{-- Phân trang (Pagination) --}}
        @if($cars->hasPages())
            {{ $cars->onEachSide(1)->links('clients.pages.catalog.pagination') }}
        @endif
    </div>
</div>
@endsection
