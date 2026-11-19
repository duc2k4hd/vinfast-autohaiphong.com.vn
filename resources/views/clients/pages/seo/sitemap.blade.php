{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Các trang tĩnh cố định --}}
    @foreach($staticPages as $page)
        <url>
            <loc>{{ $page['url'] }}</loc>
        </url>
    @endforeach

    @for($page = 2; $page <= $paginationPages['catalog']; $page++)
        <url><loc>{{ route('client.catalog.page', ['page' => $page]) }}</loc></url>
    @endfor

    @for($page = 2; $page <= $paginationPages['posts']; $page++)
        <url><loc>{{ route('client.posts.page', ['page' => $page]) }}</loc></url>
    @endfor

    {{-- Danh sách 15 dòng xe VinFast --}}
    @foreach($cars as $car)
        <url>
            <loc>{{ url('/xe/' . $car->slug) }}</loc>
            <lastmod>{{ !empty($car->updated_at) ? date('Y-m-d', strtotime($car->updated_at)) : date('Y-m-d') }}</lastmod>
        </url>
    @endforeach

    {{-- Danh sách bài viết tin tức --}}
    @foreach($posts as $post)
        <url>
            <loc>{{ url('/blog/' . $post->slug) }}</loc>
            <lastmod>{{ !empty($post->updated_at) ? date('Y-m-d', strtotime($post->updated_at)) : date('Y-m-d') }}</lastmod>
        </url>
    @endforeach
</urlset>
