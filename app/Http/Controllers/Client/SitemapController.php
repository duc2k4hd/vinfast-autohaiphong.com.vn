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
            ->whereIn('status', ['published', 'active', 'coming_soon'])
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->select(['slug', 'updated_at'])
            ->orderBy('id')
            ->get();

        $posts = DB::table('posts')
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->select(['slug', 'updated_at'])
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        $staticPages = [
            ['url' => route('client.home')],
            ['url' => route('client.catalog.index')],
            ['url' => route('client.pages.charging_stations')],
            ['url' => route('client.pages.customer_experience')],
            ['url' => route('client.posts.index')],
            ['url' => route('client.contact.index')],
            ['url' => route('client.pages.policies')],
            ['url' => route('client.pages.payment_policy')],
            ['url' => route('client.pages.privacy_policy')],
            ['url' => route('client.pages.warranty_policy')],
            ['url' => route('client.pages.terms')],
            ['url' => route('client.sitemap.html')],
        ];

        $productCount = DB::table('products')
            ->whereIn('status', ['published', 'active', 'coming_soon'])
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->count();
        $postCount = DB::table('posts')
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->count();

        $paginationPages = [
            'catalog' => max(1, (int) ceil($productCount / 9)),
            'posts' => max(1, (int) ceil($postCount / 9)),
        ];

        $content = view('clients.pages.seo.sitemap', [
            'staticPages' => $staticPages,
            'cars' => $cars,
            'posts' => $posts,
            'paginationPages' => $paginationPages,
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
            ->whereIn('status', ['published', 'active', 'coming_soon'])
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->select(['id', 'name', 'slug', 'sale_price', 'regular_price'])
            ->orderBy('id', 'asc')
            ->get();

        $posts = DB::table('posts')
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where(function ($query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
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
            ['title' => 'Trung tâm chính sách', 'url' => route('client.pages.policies')],
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
