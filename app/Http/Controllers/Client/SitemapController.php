<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
}

