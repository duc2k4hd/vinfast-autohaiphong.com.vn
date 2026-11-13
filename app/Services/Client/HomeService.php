<?php

namespace App\Services\Client;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeService
{
    /**
     * Lấy danh sách các dòng xe ô tô điện hiển thị trên trang chủ.
     *
     * @return Collection
     */
    public function getFeaturedCars()
    {
        return DB::table('products')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->where('products.status', 'published')
            ->where(function ($query) {
                $query->whereNull('products.published_at')
                    ->orWhere('products.published_at', '<=', now());
            })
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.regular_price',
                'products.sale_price',
                'products.price_on_request',
                'products.short_description',
                'media.path as thumbnail_path',
                'media.alt_text as thumbnail_alt',
            ])
            ->orderBy('products.sort_order', 'asc')
            ->orderBy('products.id', 'asc')
            ->get();
    }

    /**
     * Lấy danh sách bài viết tin tức mới nhất hiển thị trên trang chủ.
     *
     * @return Collection
     */
    public function getLatestPosts(int $limit = 3)
    {
        return DB::table('posts')
            ->leftJoin('media', 'posts.featured_media_id', '=', 'media.id')
            ->where('posts.status', 'published')
            ->where(function ($query) {
                $query->whereNull('posts.published_at')
                    ->orWhere('posts.published_at', '<=', now());
            })
            ->select([
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.excerpt',
                'posts.published_at',
                'media.path as featured_image_path',
                'media.alt_text as featured_image_alt',
            ])
            ->orderBy('posts.published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Lấy danh sách banner hiển thị tại trang chủ.
     *
     * @return Collection
     */
    public function getHomeBanners()
    {
        return DB::table('banners')
            ->leftJoin('media as desktop_media', 'banners.desktop_media_id', '=', 'desktop_media.id')
            ->leftJoin('media as mobile_media', 'banners.mobile_media_id', '=', 'mobile_media.id')
            ->where('banners.position', 'home_hero')
            ->where('banners.is_active', true)
            ->select([
                'banners.id',
                'banners.title',
                'banners.subtitle',
                'banners.cta_text',
                'banners.cta_url',
                'desktop_media.path as desktop_image',
                'mobile_media.path as mobile_image',
            ])
            ->orderBy('banners.sort_order', 'asc')
            ->get();
    }
}
