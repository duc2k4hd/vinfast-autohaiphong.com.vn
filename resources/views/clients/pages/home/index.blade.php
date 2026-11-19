@extends('clients.layouts.app')

@section('title', $siteSettings['seo_title'] ?? 'VinFast Hải Phòng | Khám phá xe, nhận tư vấn')
@section('meta_description', $siteSettings['seo_description'] ?? 'Tìm hiểu các dòng xe điện VinFast, thông số, giá tham khảo và dịch vụ tại VinFast Hải Phòng.')
@section('canonical', route('client.home'))
@section('og_title', $siteSettings['seo_title'] ?? 'VinFast Hải Phòng | Khám phá xe, nhận tư vấn')
@section('og_description', $siteSettings['seo_description'] ?? 'Tìm hiểu các dòng xe điện VinFast, thông số, giá tham khảo và dịch vụ tại VinFast Hải Phòng.')

@push('schema')
{{-- WebSite schema dùng cho nhận diện site name; site hiện chưa có tìm kiếm nội bộ. --}}
<script type="application/ld+json">
{!! json_encode([
    '@'.'context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => 'VinFast Hải Phòng',
    'alternateName' => ['VinFast Auto Hải Phòng', 'Đại lý VinFast Hải Phòng'],
            'url' => request()->getSchemeAndHttpHost().'/',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endpush

@push('styles')
<style>
    .home {--ink:#152638;--muted:#617080;--blue:#1354b7;--line:#dce4eb;color:var(--ink);background:#fff}
    .home * {box-sizing:border-box}.home [hidden] {display:none!important}.home a {text-decoration:none}.home-wrap {width:min(1200px,calc(100% - 48px));margin:auto}
    .home-decision {background:#f3f7fa}.home-decision-grid {display:grid;grid-template-columns:1fr 1fr;gap:20px}.home-decision-card {background:#fff;border:1px solid var(--line);padding:28px}.home-decision-card h3 {margin:0 0 10px;font-size:1.25rem}.home-decision-card p {color:var(--muted);line-height:1.65}.home-decision-card details {border-top:1px solid var(--line);padding:15px 0}.home-decision-card summary {cursor:pointer;font-weight:700}.home-compare-controls {display:grid;grid-template-columns:1fr 1fr;gap:12px}.home-compare-controls label {display:grid;gap:6px;font-size:.85rem;font-weight:700}.home-compare-controls select {width:100%;min-width:0;min-height:44px;border:1px solid #a8b7c4;background:white;padding:8px}.home-comparison {margin:20px 0;border-top:1px solid var(--line)}.home-comparison p {margin:0;padding:12px 0;border-bottom:1px solid var(--line)}.home :focus-visible {outline:3px solid #eb9b2f;outline-offset:3px}@media(max-width:700px){.home-decision-grid,.home-compare-controls {grid-template-columns:1fr}}
    .home-hero {background:#0c2035;color:#fff;display:grid;grid-template-columns:minmax(0, .85fr) minmax(0, 1.15fr);min-height:450px}
    .home-hero-copy {padding:70px max(32px,calc((100vw - 1200px)/2)) 70px max(24px,calc((100vw - 1200px)/2));padding-right:40px;display:flex;flex-direction:column;align-items:flex-start;justify-content:center}
    .home-kicker {font-size:.72rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:#66a9ff}.home-hero h1 {font-size:clamp(2.35rem,4vw,4.3rem);line-height:1.08;letter-spacing:-.045em;margin:20px 0}.home-hero p {max-width:420px;color:#c5d2df;line-height:1.7;margin:0 0 28px}.home-hero-image {min-height:350px;position:relative;overflow:hidden}.home-hero-image img {width:100%;height:100%;position:absolute;inset:0;object-fit:cover}.home-hero-image:after {content:"";position:absolute;inset:0;background:linear-gradient(90deg,#0c2035,transparent 35%);pointer-events:none}
    .home-button {display:inline-flex;align-items:center;justify-content:center;gap:12px;min-height:48px;padding:12px 21px;background:var(--blue);color:white!important;font-weight:700;font-size:.88rem;border:1px solid var(--blue);cursor:pointer}.home-button:hover {background:#0b3f90}.home-button-light {background:white!important;color:var(--ink)!important;border-color:white}.home-button-outline {background:transparent;color:var(--ink)!important;border-color:#a8b7c4}.home-button-outline:hover {background:#eef4fa}
    .home-shortcuts {background:#f2f5f7;border-bottom:1px solid var(--line)}.home-shortcuts-inner {display:grid;grid-template-columns:repeat(3,1fr)}.home-shortcut {padding:24px 20px 24px 0;display:flex;gap:16px;align-items:center;color:var(--ink);border-right:1px solid var(--line)}.home-shortcut:not(:first-child){padding-left:28px}.home-shortcut:last-child{border:0}.home-shortcut-num{color:var(--blue);font-size:.75rem;font-weight:700}.home-shortcut strong{display:block;font-size:.94rem}.home-shortcut small{display:block;color:var(--muted);margin-top:4px}.home-shortcut-arrow{margin-left:auto;font-size:1.2rem}
    .home-section {padding:82px 0}.home-section-head {display:flex;justify-content:space-between;align-items:end;gap:24px;margin-bottom:30px}.home-eyebrow {color:var(--blue);font-size:.72rem;letter-spacing:.16em;font-weight:700;text-transform:uppercase}.home h2 {font-size:clamp(2rem,3vw,2.8rem);letter-spacing:-.04em;line-height:1.15;margin:10px 0}.home-intro{color:var(--muted);margin:0;line-height:1.6}.home-text-link{color:var(--blue)!important;font-weight:700;font-size:.9rem;white-space:nowrap}
    .home-tools {display:flex;gap:12px;align-items:end;margin:0 0 24px}.home-tools label{display:grid;gap:7px;font-size:.78rem;font-weight:700;color:#43566a}.home-tools input,.home-tools select {font:inherit;font-size:.9rem;color:var(--ink);background:#fff;border:1px solid #cbd6df;min-height:44px;padding:0 12px}.home-tools input{width:min(280px,100%)}.home-result{margin-left:auto;color:var(--muted);font-size:.82rem}.home-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}.home-card {border:1px solid var(--line);background:white;display:flex;flex-direction:column;min-width:0}.home-car-image{height:220px;background:#f2f5f7;display:flex;align-items:center;justify-content:center}.home-car-image img{width:100%;height:100%;object-fit:contain}.home-card-body{padding:24px;display:flex;flex-direction:column;flex:1}.home-card h3{font-size:1.35rem;letter-spacing:-.025em;margin:0 0 8px}.home-card h3 a{color:var(--ink)}.home-price-label{color:var(--muted);font-size:.78rem;margin-top:4px}.home-price{font-size:1.05rem;font-weight:700;margin:4px 0 20px}.home-card-actions{margin-top:auto;display:flex;gap:10px}.home-card-actions .home-button{flex:1;padding:10px;font-size:.8rem}.home-empty{padding:30px;background:#f5f7f9;color:var(--muted)}
    .home-guide{background:#0c2035;color:white}.home-guide .home-wrap{display:grid;grid-template-columns:1fr 1.1fr;gap:60px;align-items:center}.home-guide h2{max-width:480px}.home-guide p{color:#bac9d6;line-height:1.7;max-width:480px}.home-guide-links{display:grid;gap:1px;background:#415264}.home-guide-links a{background:#102a43;color:white;display:flex;justify-content:space-between;align-items:center;padding:21px 24px;font-weight:600}.home-guide-links a:hover{background:#1b3c5b}.home-news{background:#f5f7f9}.home-news-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}.home-news-card{background:white;display:flex;flex-direction:column}.home-news-card img{width:100%;aspect-ratio:16/9;object-fit:cover}.home-news-body{padding:24px}.home-news-body time{font-size:.75rem;color:var(--muted)}.home-news-body h3{font-size:1.1rem;line-height:1.4;margin:10px 0}.home-news-body h3 a{color:var(--ink)}.home-news-body p{font-size:.88rem;color:var(--muted);line-height:1.6}.home a:focus-visible,.home button:focus-visible,.home input:focus-visible,.home select:focus-visible{outline:3px solid #5e9eff;outline-offset:3px}
    @media(max-width:800px){.home-hero{grid-template-columns:1fr}.home-hero-copy{padding:55px 24px 35px}.home-hero-image{min-height:260px}.home-hero-image:after{background:linear-gradient(180deg,#0c2035,transparent 40%)}.home-grid,.home-news-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.home-guide .home-wrap{grid-template-columns:1fr;gap:24px}.home-section{padding:60px 0}}
    @media(max-width:550px){.home-wrap{width:calc(100% - 32px)}.home-shortcuts-inner{grid-template-columns:1fr}.home-shortcut,.home-shortcut:not(:first-child){padding:16px 0;border-right:0;border-bottom:1px solid var(--line)}.home-section-head{align-items:start;flex-direction:column}.home-tools{align-items:stretch;flex-wrap:wrap}.home-tools label{flex:1;min-width:140px}.home-tools input{width:100%}.home-result{width:100%;margin:0}.home-grid,.home-news-grid{grid-template-columns:1fr}.home-car-image{height:210px}}
    @media (prefers-reduced-motion: no-preference) {
        .home-card, .home-news-card, .home-decision-card {transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease}
        .home-shortcut-arrow, .home-guide-links a {transition: transform .3s ease, background-color .3s ease}
        @media (hover: hover) {
            .home-card:hover, .home-news-card:hover, .home-decision-card:hover {transform: translateY(-4px);box-shadow: 0 16px 35px rgba(21,38,56,.1)}
            .home-shortcut:hover .home-shortcut-arrow {transform: translate(4px,-4px)}
            .home-guide-links a:hover {transform: translateX(4px)}
        }
    }
    /* The introduction and promotional banner are separate visual regions. */
    .home-hero {display:block;min-height:0;background:#f5f8fb;color:var(--ink)}
    .home-hero-copy {width:min(1200px,calc(100% - 48px));margin:auto;padding:60px 0 54px;align-items:flex-start}
    .home-kicker {color:var(--blue)}
    .home-hero h1 {max-width:1000px;font-size:clamp(2.15rem,4.2vw,3.8rem);line-height:1.12;margin:16px 0}
    .home-hero p {max-width:680px;color:#53677a;margin-bottom:24px}
    .home-hero .home-button-light {background:var(--blue)!important;color:#fff!important;border-color:var(--blue)}
    .home-hero .home-button-light:hover {background:#0b3f90!important}
    .home-hero-image {min-height:0;padding:0;overflow:visible;background:#fff}
    .home-hero-image picture {display:block}
    .home-hero-image img {position:static;display:block;width:100%;height:auto;object-fit:contain}
    .home-hero-image:after {content:none}
    @media(max-width:800px) {
        .home-hero-copy {padding:46px 0 40px}
        .home-hero-image {min-height:0}
    }
    @media(max-width:550px) {
        .home-hero-copy {width:calc(100% - 32px);padding:36px 0 32px}
        .home-hero h1 {font-size:clamp(2rem,8vw,2.6rem)}
    }
</style>
@endpush

@section('content')
<div class="home">
    <section class="home-hero" aria-labelledby="home-title">
        <div class="home-hero-image">
            @php($heroBanner = $banners->first(fn ($banner) => $banner->desktop_image))
            <picture>
                @if($heroBanner && $heroBanner->mobile_image)<source media="(max-width: 550px)" srcset="{{ asset('storage/' . $heroBanner->mobile_image) }}">@endif
                <img src="{{ $heroBanner ? asset('storage/' . $heroBanner->desktop_image) : asset('storage/clients/assets/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp') }}" alt="{{ $heroBanner->title ?? 'Khám phá xe điện VinFast' }}" fetchpriority="high">
            </picture>
        </div>
        <div class="home-hero-copy">
            <span class="home-kicker">VinFast Hải Phòng / Khởi đầu hành trình xanh</span>
            <h1 id="home-title">Cùng VinFast Hải Phòng tìm chiếc xe phù hợp.</h1>
            <p>Khám phá các dòng xe điện VinFast, tìm hiểu thông tin và nhận tư vấn cho hành trình tiếp theo của bạn.</p>
            <a class="home-button home-button-light" href="#dong-xe">Khám phá dòng xe <span aria-hidden="true">↗</span></a>
        </div>
    </section>

    <nav class="home-shortcuts" aria-label="Lối tắt hữu ích">
        <div class="home-wrap home-shortcuts-inner">
            <a class="home-shortcut" href="{{ route('client.catalog.index') }}"><span class="home-shortcut-num">01</span><span><strong>Khám phá dòng xe</strong><small>Thông tin và giá tham khảo</small></span><span class="home-shortcut-arrow" aria-hidden="true">↗</span></a>
            <a class="home-shortcut" href="{{ route('client.pages.charging_stations') }}"><span class="home-shortcut-num">02</span><span><strong>Pin &amp; trạm sạc</strong><small>Tìm hiểu về xe điện</small></span><span class="home-shortcut-arrow" aria-hidden="true">↗</span></a>
            <a class="home-shortcut" href="{{ route('client.contact.index') }}"><span class="home-shortcut-num">03</span><span><strong>Liên hệ tư vấn</strong><small>Chúng tôi sẵn sàng hỗ trợ</small></span><span class="home-shortcut-arrow" aria-hidden="true">↗</span></a>
        </div>
    </nav>

    <section class="home-section" id="dong-xe" aria-labelledby="cars-heading">
        <div class="home-wrap">
            <div class="home-section-head"><div><span class="home-eyebrow">01 / Dòng xe VinFast</span><h2 id="cars-heading">Một lựa chọn cho mỗi hành trình.</h2><p class="home-intro">Khám phá các mẫu xe và tìm hiểu mức giá phù hợp với bạn.</p></div><a class="home-text-link" href="{{ route('client.catalog.index') }}">Xem tất cả dòng xe ↗</a></div>
            @if($cars->isNotEmpty())
                <div class="home-tools" id="home-tools" hidden>
                    <label for="home-search">Tìm theo tên xe<input id="home-search" type="search" placeholder="Ví dụ: VF 5"></label>
                    <label for="home-sort">Sắp xếp<select id="home-sort"><option value="default">Thứ tự nổi bật</option><option value="low">Giá thấp đến cao</option><option value="high">Giá cao đến thấp</option></select></label>
                    <span class="home-result" id="home-result" aria-live="polite"></span>
                </div>
                <p class="home-intro" style="font-size:.82rem;margin-bottom:20px">Giá hiển thị chỉ mang tính tham khảo, chưa bao gồm chi phí lăn bánh; vui lòng liên hệ để nhận báo giá phù hợp.</p><div class="home-grid" id="home-car-grid">
                    @foreach($cars as $car)
                        @php($price = $car->price_on_request ? null : ($car->sale_price ?: $car->regular_price))
                        <article class="home-card" data-name="{{ mb_strtolower($car->name) }}" data-price="{{ $price ?: '' }}" data-order="{{ $loop->index }}">
                            <a class="home-car-image" href="{{ route('client.products.show', $car->slug) }}" tabindex="-1" aria-hidden="true"><img src="{{ $car->thumbnail_path ? asset('storage/' . $car->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" alt="" loading="lazy" width="600" height="338"></a>
                            <div class="home-card-body"><h3><a href="{{ route('client.products.show', $car->slug) }}">{{ $car->name }}</a></h3><span class="home-price-label">Giá tham khảo từ</span><p class="home-price">{{ $price ? number_format($price, 0, ',', '.') . ' VNĐ' : 'Liên hệ báo giá' }}</p><div class="home-card-actions"><button class="home-button" type="button" data-car-name="{{ $car->name }}" onclick="openQuoteModal({{ $car->id }}, this.dataset.carName)">Nhận báo giá</button><a class="home-button home-button-outline" href="{{ route('client.products.show', $car->slug) }}">Chi tiết ↗</a></div></div>
                        </article>
                    @endforeach
                </div>
                <p class="home-empty" id="home-no-results" hidden>Không tìm thấy dòng xe phù hợp. Hãy thử tên khác hoặc <a href="{{ route('client.contact.index') }}">liên hệ tư vấn</a>.</p>
            @else
                <p class="home-empty">Thông tin dòng xe đang được cập nhật. <a href="{{ route('client.contact.index') }}">Liên hệ với chúng tôi</a> để được tư vấn.</p>
            @endif
        </div>
    </section>

    <section class="home-section home-decision" aria-labelledby="decision-heading">
        <div class="home-wrap">
            <div class="home-section-head"><div><span class="home-eyebrow">Chọn xe tự tin hơn</span><h2 id="decision-heading">Những điều cần cân nhắc.</h2><p class="home-intro">So sánh giá tham khảo và chuẩn bị những câu hỏi trước khi quyết định.</p></div></div>
            <div class="home-decision-grid">
                <div class="home-decision-card">
                    <h3>Đặt hai dòng xe cạnh nhau</h3>
                    <p>Chọn hai mẫu để xem nhanh giá đang hiển thị. Thông số và phiên bản có thể khác nhau; hãy xem chi tiết từng xe.</p>
                    @if($cars->isNotEmpty())
                        <noscript><p>Để so sánh giá tại đây, vui lòng bật JavaScript. Bạn vẫn có thể xem giá và chi tiết từng xe trong danh sách ở trên.</p></noscript><div class="home-compare-controls" hidden>
                            @foreach([1, 2] as $number)
                                <label for="home-compare-{{ $number }}">Dòng xe {{ $number }}
                                    <select id="home-compare-{{ $number }}" class="home-compare-select">
                                        <option value="">Chọn dòng xe</option>
                                        @foreach($cars as $car)
                                            @php($comparePrice = $car->price_on_request ? null : ($car->sale_price ?: $car->regular_price))
                                            <option value="{{ $car->id }}" data-price="{{ $comparePrice ? number_format($comparePrice, 0, ',', '.') . ' VNĐ' : 'Liên hệ báo giá' }}" data-url="{{ route('client.products.show', $car->slug) }}">{{ $car->name }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            @endforeach
                        </div>
                        <div class="home-comparison" id="home-comparison" aria-live="polite"><p>Chọn dòng xe để bắt đầu so sánh.</p></div>
                        <p><small>Giá tham khảo, chưa bao gồm chi phí lăn bánh; liên hệ để xác nhận giá và ưu đãi tại thời điểm mua.</small></p>
                    @else
                        <p>Thông tin dòng xe đang được cập nhật.</p>
                    @endif
                </div>
                <div class="home-decision-card">
                    <h3>Chuẩn bị cho chi phí sở hữu</h3>
                    <p>Giá xe chỉ là một phần của quyết định. Hãy hỏi tư vấn viên về các khoản áp dụng cho trường hợp của bạn.</p>
                    <details><summary>Giá lăn bánh gồm những gì?</summary><p>Hỏi về giá phiên bản, các khoản thuế, phí đăng ký, biển số, bảo hiểm và chi phí khác tại địa phương. Các khoản thực tế phụ thuộc chính sách và thời điểm mua.</p></details>
                    <details><summary>Sạc xe và sử dụng hàng ngày</summary><p>Cân nhắc nơi sạc ở nhà hoặc trên hành trình, phương án lắp đặt và chi phí điện. Chi phí thực tế phụ thuộc mức sử dụng và biểu giá áp dụng.</p><a class="home-text-link" href="{{ route('client.pages.charging_stations') }}">Tìm hiểu trạm sạc ↗</a></details>
                    <details><summary>Bảo hành và hậu mãi</summary><p>Kiểm tra điều kiện, phạm vi bảo hành và lịch bảo dưỡng cho phiên bản bạn quan tâm.</p><a class="home-text-link" href="{{ route('client.pages.warranty_policy') }}">Xem chính sách bảo hành ↗</a></details>
                    <a class="home-text-link" href="{{ route('client.contact.index') }}">Trao đổi với tư vấn viên ↗</a>
                </div>
            </div>
        </div>
    </section>
<section class="home-section" aria-labelledby="visit-heading"><div class="home-wrap"><div class="home-section-head"><div><span class="home-eyebrow">VinFast Hải Phòng / Liên hệ</span><h2 id="visit-heading">Gặp chúng tôi tại Hải Phòng.</h2><p class="home-intro"><strong>Showroom:</strong> {{ $siteSettings['site_address'] ?? 'Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng' }}</p><p class="home-intro">Liên hệ trước để được hỗ trợ tìm hiểu dòng xe và báo giá.</p></div><a class="home-button" href="{{ route('client.contact.index') }}">Thông tin liên hệ ↗</a></div></div></section>
    @if($latestPosts->isNotEmpty())
    <section class="home-section home-news" aria-labelledby="news-heading"><div class="home-wrap"><div class="home-section-head"><div><span class="home-eyebrow">03 / Tin tức &amp; cập nhật</span><h2 id="news-heading">Thông tin mới nhất.</h2></div><a class="home-text-link" href="{{ route('client.posts.index') }}">Xem tất cả tin tức ↗</a></div><div class="home-news-grid">@foreach($latestPosts as $post)<article class="home-news-card">@if($post->featured_image_path)<a href="{{ route('client.posts.show', $post->slug) }}" tabindex="-1" aria-hidden="true"><img src="{{ asset('storage/' . $post->featured_image_path) }}" alt="" loading="lazy"></a>@endif<div class="home-news-body">@if($post->published_at)<time datetime="{{ date('Y-m-d', strtotime($post->published_at)) }}">{{ date('d/m/Y', strtotime($post->published_at)) }}</time>@endif<h3><a href="{{ route('client.posts.show', $post->slug) }}">{{ $post->title }}</a></h3>@if($post->excerpt)<p>{{ Str::limit($post->excerpt, 100) }}</p>@endif<a class="home-text-link" href="{{ route('client.posts.show', $post->slug) }}">Đọc bài viết ↗</a></div></article>@endforeach</div></div></section>
    @endif
</div>
@endsection

@push('scripts')
<script>
    (() => {
        if (!window.matchMedia || !('IntersectionObserver' in window) || !('animate' in Element.prototype)) return;
        const motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
        if (motionPreference.matches) return;

        const selector = '.home-hero-copy, .home-hero-image, .home-shortcut, .home-section-head, .home-card, .home-decision-card, .home-guide .home-wrap > div, .home-guide-links a, .home-news-card';
        const groupedSelector = '.home-shortcut, .home-card, .home-decision-card, .home-guide-links a, .home-news-card';
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                observer.unobserve(entry.target);
                if (motionPreference.matches || entry.target.contains(document.activeElement)) return;
                const siblings = Array.from(entry.target.parentElement.children).filter(child => child.matches(groupedSelector));
                const delay = Math.max(0, Math.min(siblings.indexOf(entry.target), 3)) * 90;
                const animation = entry.target.animate(
                    [{ opacity: .15, transform: 'translateY(32px)' }, { opacity: 1, transform: 'translateY(0)' }],
                    { duration: 750, delay, easing: 'cubic-bezier(.22, 1, .36, 1)' }
                );
                const cancel = () => animation.cancel();
                entry.target.addEventListener('focusin', cancel, { once: true });
                if (motionPreference.addEventListener) motionPreference.addEventListener('change', cancel, { once: true });
                animation.finished.then(() => {
                    entry.target.removeEventListener('focusin', cancel);
                    if (motionPreference.removeEventListener) motionPreference.removeEventListener('change', cancel);
                }).catch(() => {});
            });
        }, { threshold: 0, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll(selector).forEach(target => observer.observe(target));
    })();
</script>
<script>
    (() => {
        const compareSelectors = document.querySelectorAll('.home-compare-select');
        const comparison = document.getElementById('home-comparison');
        const updateComparison = () => {
            const selected = Array.from(compareSelectors).map(select => select.selectedOptions[0]).filter(option => option.value);
            comparison.replaceChildren();
            if (!selected.length) {
                const message = document.createElement('p');
                message.textContent = 'Chọn dòng xe để bắt đầu so sánh.';
                comparison.appendChild(message);
                return;
            }
            selected.forEach(option => {
                const row = document.createElement('p');
                const name = document.createElement('strong');
                const link = document.createElement('a');
                name.textContent = option.textContent;
                link.href = option.dataset.url;
                link.textContent = ' Xem chi tiết ↗';
                row.append(name, document.createTextNode(` — ${option.dataset.price}.`), link);
                comparison.appendChild(row);
            });
        };
        compareSelectors.forEach(select => select.addEventListener('change', updateComparison));
        document.querySelectorAll('.home-compare-controls').forEach(controls => controls.hidden = false);
        const grid = document.getElementById('home-car-grid');
        if (!grid) return;
        const tools = document.getElementById('home-tools');
        const search = document.getElementById('home-search');
        const sort = document.getElementById('home-sort');
        const cards = Array.from(grid.children);
        const update = () => {
            const term = search.value.trim().toLocaleLowerCase('vi');
            let count = 0;
            cards.forEach(card => { const matches = card.dataset.name.includes(term); card.hidden = !matches; if (matches) count++; });
            cards.sort((a, b) => {
                if (sort.value === 'default') return Number(a.dataset.order) - Number(b.dataset.order);
                if (!a.dataset.price || !b.dataset.price) return !a.dataset.price - !b.dataset.price;
                return sort.value === 'low' ? Number(a.dataset.price) - Number(b.dataset.price) : Number(b.dataset.price) - Number(a.dataset.price);
            }).forEach(card => grid.appendChild(card));
            document.getElementById('home-result').textContent = `${count} dòng xe`;
            document.getElementById('home-no-results').hidden = count !== 0;
        };
        tools.hidden = false;
        search.addEventListener('input', update);
        sort.addEventListener('change', update);
        update();
    })();
</script>
@endpush
