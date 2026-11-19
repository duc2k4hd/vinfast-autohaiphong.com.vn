<!DOCTYPE html>
<html lang="vi" class="vinfast-autohaiphong_html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $pageTitle = trim((string) View::yieldContent('title', $siteSettings['seo_title'] ?? 'VinFast Hải Phòng | Đại lý xe điện VinFast'));
        $pageDescription = trim((string) View::yieldContent('meta_description', $siteSettings['seo_description'] ?? 'Tìm hiểu các dòng xe điện VinFast, thông số, giá tham khảo và dịch vụ tại VinFast Hải Phòng.'));
        $hasQueryParameters = request()->attributes->get('seo_has_query_parameters', request()->query->count() > 0);
        $explicitRobots = trim((string) View::yieldContent('robots'));
        $middlewareRobots = request()->attributes->get('seo_robots');
        $isPrivateUtilityPage = is_string($middlewareRobots) && str_contains($middlewareRobots, 'nofollow');
        $robotsContent = $middlewareRobots
            ?: ($isPrivateUtilityPage
            ? 'noindex, nofollow'
            : ($hasQueryParameters
                ? 'noindex, follow'
                : ($explicitRobots !== ''
                    ? $explicitRobots
                    : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')));

        $canonicalCandidate = trim((string) View::yieldContent('canonical'));
        $canonicalCandidate = $canonicalCandidate !== '' ? $canonicalCandidate : request()->url();
        $canonicalPath = parse_url($canonicalCandidate, PHP_URL_PATH);
        $canonicalPath = is_string($canonicalPath) && $canonicalPath !== '' ? $canonicalPath : '/';
        $canonicalUrl = request()->getSchemeAndHttpHost().($canonicalPath === '/' ? '/' : '/'.ltrim($canonicalPath, '/'));
        $ogTitle = trim((string) View::yieldContent('og_title')) ?: $pageTitle;
        $ogDescription = trim((string) View::yieldContent('og_description')) ?: $pageDescription;
        $ogImage = trim((string) View::yieldContent('og_image')) ?: asset('storage/clients/assets/images/banners/vinfast-banner-54gf5.png');
        $ogImageAlt = trim((string) View::yieldContent('og_image_alt')) ?: $pageTitle;
    @endphp

    {{-- Metadata quan trọng được render trực tiếp trong HTML đầu tiên. --}}
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $robotsContent }}">
    @unless($isPrivateUtilityPage)
        <link rel="canonical" href="{{ $canonicalUrl }}">
    @endunless

    {{-- Open Graph --}}
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'VinFast Hải Phòng' }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ $ogImageAlt }}">
    @if(str_starts_with($ogImage, 'https://'))
        <meta property="og:image:secure_url" content="{{ $ogImage }}">
    @endif
    @hasSection('og_published_time')
        <meta property="article:published_time" content="@yield('og_published_time')">
    @endif
    @hasSection('og_modified_time')
        <meta property="article:modified_time" content="@yield('og_modified_time')">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="twitter:image:alt" content="{{ $ogImageAlt }}">

    {{-- Open Sans Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    {{-- Assets qua Vite --}}
    @vite(['resources/css/clients/app.css', 'resources/js/clients/app.js'])

    {{-- Structured Data JSON-LD (AutoDealer Schema) --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@'.'context' => 'https://schema.org',
        '@type' => 'AutoDealer',
        '@id' => url('/#autodealer'),
        'name' => $siteSettings['site_name'] ?? 'VinFast Hải Phòng',
        'url' => url('/'),
        'image' => asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
        'logo' => asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
        'telephone' => $siteSettings['site_phone'] ?? '0988 302 882',
        'url' => url('/'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $siteSettings['site_address'] ?? 'Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng',
            'addressLocality' => 'Hải Phòng',
            'addressRegion' => 'Hải Phòng',
            'postalCode' => '180000',
            'addressCountry' => 'VN',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 20.8548,
            'longitude' => 106.6974,
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'opens' => '07:30',
                'closes' => '18:00',
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Sunday'],
                'opens' => '07:00',
                'closes' => '18:00',
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
    </script>

    @stack('styles')
    @stack('schema')
</head>
<body class="vinfast-autohaiphong_body @yield('body_class')">

    {{-- Header --}}
    @include('clients.layouts.header')

    {{-- Main Content --}}
    <main class="vinfast-autohaiphong_layout_main">
        @if(session('success'))
            <div class="vinfast-autohaiphong_layout_container" style="margin-top: 16px;">
                <div style="background-color: #ecfdf5; border: 1px solid #10b981; color: #065f46; padding: 12px 18px; border-radius: 6px; font-weight: 500;">
                    ✓ {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="vinfast-autohaiphong_layout_container" style="margin-top: 16px;">
                <div style="background-color: #fef2f2; border: 1px solid #ef4444; color: #991b1b; padding: 12px 18px; border-radius: 6px; font-weight: 500;">
                    ⚠ {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    @include('clients.layouts.footer')

    {{-- Modal Báo Giá --}}
    @include('clients.components.modals.quote-modal')

    @stack('scripts')
</body>
</html>
