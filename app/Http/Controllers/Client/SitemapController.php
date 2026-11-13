<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SitemapController extends Controller
{
    /**
     * Sinh sitemap.xml động phục vụ công cụ tìm kiếm Google.
     */
    public function index(): Response
    {
        $cars = DB::table('products')
            ->where('status', 'published')
            ->select(['slug', 'updated_at'])
            ->get();

        $posts = DB::table('posts')
            ->where('status', 'published')
            ->select(['slug', 'updated_at'])
            ->get();

        $staticPages = [
            ['url' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => url('/o-to-vinfast'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => url('/pin-va-tram-sac'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => url('/trai-nghiem-khach-hang'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => url('/chuyen-muc/tin-tuc'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['url' => url('/lien-he'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => url('/chinh-sach-thanh-toan'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => url('/chinh-sach-bao-mat'), 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => url('/chinh-sach-bao-hanh'), 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => url('/dieu-khoan-su-dung'), 'priority' => '0.5', 'changefreq' => 'yearly'],
        ];

        $content = view('clients.pages.seo.sitemap', [
            'staticPages' => $staticPages,
            'cars' => $cars,
            'posts' => $posts,
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Hiển thị Sơ đồ trang web (HTML Sitemap) thân thiện cho người dùng và SEO.
     */
    public function html(): View
    {
        $cars = DB::table('products')
            ->where('status', 'published')
            ->select(['id', 'name', 'slug', 'sale_price', 'regular_price'])
            ->orderBy('id', 'asc')
            ->get();

        $posts = DB::table('posts')
            ->where('status', 'published')
            ->select(['id', 'title', 'slug', 'published_at'])
            ->orderBy('published_at', 'desc')
            ->limit(30)
            ->get();

        $staticPages = [
            ['title' => 'Trang chủ', 'url' => route('client.home')],
            ['title' => 'Tất cả các dòng xe ô tô VinFast', 'url' => route('client.catalog.index')],
            ['title' => 'Hệ thống Pin và Trạm sạc VinFast', 'url' => route('client.pages.charging_stations')],
            ['title' => 'Trải nghiệm khách hàng', 'url' => route('client.pages.customer_experience')],
            ['title' => 'Tin tức & Khuyến mại', 'url' => route('client.posts.index')],
            ['title' => 'Liên hệ & Đặt lịch hẹn Showroom', 'url' => route('client.contact.index')],
            ['title' => 'Chính sách thanh toán tiền mặt', 'url' => route('client.pages.payment_policy')],
            ['title' => 'Chính sách bảo hành chính hãng', 'url' => route('client.pages.warranty_policy')],
            ['title' => 'Chính sách bảo mật thông tin', 'url' => route('client.pages.privacy_policy')],
            ['title' => 'Điều khoản sử dụng website', 'url' => route('client.pages.terms')],
        ];

        return view('clients.pages.sitemap.index', [
            'staticPages' => $staticPages,
            'cars' => $cars,
            'posts' => $posts,
        ]);
    }
}
