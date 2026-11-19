@if ($paginator->hasPages())
    @php
        $categoryQuery = ! empty($selectedCategory) ? ['category' => $selectedCategory] : [];
    @endphp
    <nav class="catalog-pagination" aria-label="Phân trang tin tức">
        @if ($paginator->onFirstPage())
            <span class="catalog-pagination__item" aria-disabled="true">‹ Trước</span>
        @else
            @php($previousPageUrl = $paginator->currentPage() === 2 ? route('client.posts.index') : route('client.posts.page', ['page' => $paginator->currentPage() - 1]))
            <a class="catalog-pagination__item" href="{{ $previousPageUrl.($categoryQuery ? '?'.http_build_query($categoryQuery) : '') }}" rel="prev" aria-label="Trang trước">‹ Trước</a>
        @endif

        @foreach (range(1, $paginator->lastPage()) as $page)
            @php($pageUrl = $page === 1 ? route('client.posts.index') : route('client.posts.page', ['page' => $page]))
            @if ($page === $paginator->currentPage())
                <span class="catalog-pagination__item" aria-current="page" aria-label="Trang {{ $page }}">{{ $page }}</span>
            @else
                <a class="catalog-pagination__item" href="{{ $pageUrl.($categoryQuery ? '?'.http_build_query($categoryQuery) : '') }}" aria-label="Trang {{ $page }}">{{ $page }}</a>
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            @php($nextPageUrl = route('client.posts.page', ['page' => $paginator->currentPage() + 1]))
            <a class="catalog-pagination__item" href="{{ $nextPageUrl.($categoryQuery ? '?'.http_build_query($categoryQuery) : '') }}" rel="next" aria-label="Trang sau">Sau ›</a>
        @else
            <span class="catalog-pagination__item" aria-disabled="true">Sau ›</span>
        @endif
    </nav>
@endif
