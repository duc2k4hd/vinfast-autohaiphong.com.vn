@if ($paginator->hasPages())
    <nav class="catalog-pagination" aria-label="Phân trang danh sách xe">
        @if ($paginator->onFirstPage())
            <span class="catalog-pagination__item" aria-disabled="true">‹ Trước</span>
        @else
            <a class="catalog-pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Trang trước">‹ Trước</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="catalog-pagination__dots" aria-hidden="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="catalog-pagination__item" aria-current="page" aria-label="Trang {{ $page }}">{{ $page }}</span>
                    @else
                        <a class="catalog-pagination__item" href="{{ $url }}" aria-label="Trang {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="catalog-pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Trang sau">Sau ›</a>
        @else
            <span class="catalog-pagination__item" aria-disabled="true">Sau ›</span>
        @endif
    </nav>
@endif