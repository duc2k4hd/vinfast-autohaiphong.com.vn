@extends('clients.layouts.app')

@section('title', 'Bảng Giá Các Dòng Xe Ô Tô VinFast Hải Phòng Mới Nhất')
@section('meta_description', 'Khám phá toàn bộ các dòng xe ô tô điện VinFast chính hãng tại Hải Phòng: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9, Minio, EC Van... Báo giá lăn bánh ưu đãi.')
@section('canonical', url('/o-to-vinfast'))

@push('schema')
{{-- ItemList Schema cho trang danh mục ô tô VinFast --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'itemListElement' => $cars->map(function ($car, $index) {
        return [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $car->name,
            'url' => url('/xe/' . $car->slug),
            'image' => $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
        ];
    })->values()->all(),
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
            'name' => 'Ô Tô VinFast',
            'item' => url('/o-to-vinfast')
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
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

<div class="vinfast-autohaiphong_catalog_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        {{-- Tiêu đề trang & Thanh công cụ lọc --}}
        <div class="vinfast-autohaiphong_catalog_header" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px; margin-bottom: 30px; border-bottom: 1px solid var(--client-color-border); padding-bottom: 20px;">
            <div>
                <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 6px;">
                    CÁC DÒNG XE Ô TÔ VINFAST
                </h1>
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
                    <select name="sort" onchange="this.form.submit()" style="padding: 7px 12px; border: 1px solid var(--client-color-border); border-radius: 4px; font-size: 0.85rem; background: #ffffff; color: var(--client-color-heading); outline: none;">
                        <option value="default" {{ $currentSort === 'default' ? 'selected' : '' }}>Sắp xếp: Mặc định</option>
                        <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                        <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                        <option value="latest" {{ $currentSort === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    </select>
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
                            <img src="{{ $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
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
                                {{ Str::limit($car->short_description ?? 'Mẫu xe ô tô điện thông minh hàng đầu của VinFast.', 85) }}
                            </p>

                            {{-- Actions --}}
                            <div class="vinfast-autohaiphong_home_car_actions">
                                <button type="button" onclick="openQuoteModal({{ $car->id }}, '{{ addslashes($car->name) }}')" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary">
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

        {{-- Phân trang (Pagination) --}}
        @if($cars->hasPages())
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $cars->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

