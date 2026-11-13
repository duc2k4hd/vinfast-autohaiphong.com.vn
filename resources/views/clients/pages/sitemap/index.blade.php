@extends('clients.layouts.app')

@section('title', 'Sơ Đồ Trang Web (HTML Sitemap) | VinFast Hải Phòng')
@section('meta_description', 'Sơ đồ liên kết toàn bộ website VinFast Hải Phòng: Danh mục các dòng xe điện VinFast, tin tức khuyến mại, chính sách thanh toán tiền mặt và thông tin liên hệ.')
@section('canonical', url('/so-do-trang-web'))

@section('content')
<div class="vinfast-autohaiphong_breadcrumb_wrapper" style="background-color: var(--client-color-surface); border-bottom: 1px solid var(--client-color-border); padding: 12px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <nav style="font-size: 0.85rem; color: var(--client-color-muted);">
            <a href="{{ route('client.home') }}" style="color: var(--client-color-text);">Trang chủ</a>
            <span style="margin: 0 6px;">/</span>
            <span style="color: var(--client-color-primary); font-weight: 600;">Sơ đồ website</span>
        </nav>
    </div>
</div>

<div class="vinfast-autohaiphong_sitemap_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="text-align: center; max-width: 700px; margin: 0 auto 40px auto;">
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 12px;">
                SƠ ĐỒ TRANG WEB (HTML SITEMAP)
            </h1>
            <p style="font-size: 0.95rem; color: var(--client-color-muted); line-height: 1.6;">
                Khám phá toàn bộ danh mục sản phẩm xe ô tô điện VinFast, bài viết tin tức và hệ thống chính sách dịch vụ tại đại lý VinFast Hải Phòng.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px; align-items: start;">
            {{-- Nhóm 1: Các dòng xe ô tô VinFast --}}
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-primary); margin-bottom: 16px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px;">
                    DÒNG XE Ô TÔ VINFAST
                </h2>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                    @foreach($cars as $car)
                        <li style="border-bottom: 1px dashed var(--client-color-border); padding: 8px 0; display: flex; justify-content: space-between; align-items: center;">
                            <a href="{{ url('/xe/' . $car->slug) }}" style="font-weight: 600; color: var(--client-color-text); text-decoration: none;">
                                &bull; {{ $car->name }}
                            </a>
                            <span style="font-size: 0.8rem; color: var(--client-color-muted);">
                                {{ $car->sale_price ? number_format($car->sale_price, 0, ',', '.') . ' đ' : 'Liên hệ' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Nhóm 2: Trang Thông Tin & Dịch Vụ --}}
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-primary); margin-bottom: 16px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px;">
                    TRANG DỊCH VỤ & CHÍNH SÁCH
                </h2>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                    @foreach($staticPages as $page)
                        <li style="border-bottom: 1px dashed var(--client-color-border); padding: 8px 0;">
                            <a href="{{ $page['url'] }}" style="font-weight: 600; color: var(--client-color-text); text-decoration: none;">
                                &bull; {{ $page['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Nhóm 3: Bài Viết & Tin Tức Mới Nhất --}}
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-primary); margin-bottom: 16px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 8px;">
                    TIN TỨC & BÀI VIẾT MỚI
                </h2>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2;">
                    @foreach($posts as $post)
                        <li style="border-bottom: 1px dashed var(--client-color-border); padding: 8px 0;">
                            <a href="{{ url('/tin-tuc/' . $post->slug) }}" style="font-weight: 600; color: var(--client-color-text); text-decoration: none;">
                                &bull; {{ $post->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

