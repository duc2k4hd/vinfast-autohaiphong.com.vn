{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Các trang tĩnh cố định --}}
    @foreach($staticPages as $page)
        <url>
            <loc>{{ $page['url'] }}</loc>
            <changefreq>{{ $page['changefreq'] }}</changefreq>
            <priority>{{ $page['priority'] }}</priority>
        </url>
    @endforeach

    {{-- Danh sách 15 dòng xe VinFast --}}
    @foreach($cars as $car)
        <url>
            <loc>{{ url('/xe/' . $car->slug) }}</loc>
            <lastmod>{{ !empty($car->updated_at) ? date('Y-m-d', strtotime($car->updated_at)) : date('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

    {{-- Danh sách bài viết tin tức --}}
    @foreach($posts as $post)
        <url>
            <loc>{{ url('/chuyen-muc/tin-tuc/' . $post->slug) }}</loc>
            <lastmod>{{ !empty($post->updated_at) ? date('Y-m-d', strtotime($post->updated_at)) : date('Y-m-d') }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>

