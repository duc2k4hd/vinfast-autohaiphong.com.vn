<!DOCTYPE html>
<html lang="vi" class="vinfast-autohaiphong_html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Metadata --}}
    <title>@yield('title', $siteSettings['seo_title'] ?? 'VinFast Hải Phòng - Đại lý ủy quyền của VinFast Việt Nam')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['seo_description'] ?? 'VinFast Hải Phòng chuyên phân phối ô tô điện VinFast chính hãng: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9... Giá tốt nhất, hỗ trợ trả góp 80%.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', $siteSettings['seo_title'] ?? 'VinFast Hải Phòng')">
    <meta property="og:description" content="@yield('og_description', $siteSettings['seo_description'] ?? '')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'VinFast Hải Phòng' }}">
    <meta property="og:image" content="@yield('og_image', asset('storage/clients/assets/images/banners/vinfast-banner-54gf5.png'))">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $siteSettings['seo_title'] ?? 'VinFast Hải Phòng')">
    <meta name="twitter:description" content="@yield('og_description', $siteSettings['seo_description'] ?? '')">
    <meta name="twitter:image" content="@yield('og_image', asset('storage/clients/assets/images/banners/vinfast-banner-54gf5.png'))">

    {{-- Open Sans Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    {{-- Assets qua Vite --}}
    @vite(['resources/css/clients/app.css', 'resources/js/clients/app.js'])

    {{-- Structured Data JSON-LD (AutoDealer Schema) --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'AutoDealer',
        'name' => $siteSettings['site_name'] ?? 'VinFast Hải Phòng',
        'image' => asset('storage/clients/assets/images/business/vinfast-haiphong.png'),
        'telephone' => $siteSettings['site_phone'] ?? '0988 302 882',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Số 1 Bạch Đằng, Phường Thượng Lý',
            'addressLocality' => 'Quận Hồng Bàng',
            'addressRegion' => 'Hải Phòng',
            'addressCountry' => 'VN',
        ],
        'url' => url('/'),
        'priceRange' => '$$$$',
        'paymentAccepted' => 'Cash',
        'openingHours' => 'Mo-Sa 07:30-18:00, Su 07:00-18:00',
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
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

