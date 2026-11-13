<?php

namespace App\Services\Client;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CatalogService
{
    /**
     * Lấy danh sách sản phẩm phân trang kèm bộ lọc và sắp xếp.
     *
     * @param  array  $filters  (category_slug, sort, per_page)
     */
    public function getPaginatedProducts(array $filters = []): LengthAwarePaginator
    {
        $perPage = (int) ($filters['per_page'] ?? 9);
        $sort = $filters['sort'] ?? 'default';

        $query = DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->where('products.status', 'published')
            ->where(function ($q) {
                $q->whereNull('products.published_at')
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
                'product_categories.name as category_name',
                'product_categories.slug as category_slug',
                'media.path as thumbnail_path',
                'media.alt_text as thumbnail_alt',
            ]);

        // Lọc theo danh mục
        if (! empty($filters['category'])) {
            $query->where('product_categories.slug', $filters['category']);
        }

        // Sắp xếp
        match ($sort) {
            'price_asc' => $query->orderBy('products.sale_price', 'asc'),
            'price_desc' => $query->orderBy('products.sale_price', 'desc'),
            'latest' => $query->orderBy('products.id', 'desc'),
            default => $query->orderBy('products.sort_order', 'asc')->orderBy('products.id', 'asc'),
        };

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Lấy danh sách các danh mục xe phục vụ bộ lọc.
     */
    public function getCategories(): Collection
    {
        return DB::table('product_categories')
            ->where('status', 'active')
            ->select(['id', 'name', 'slug'])
            ->orderBy('sort_order', 'asc')
            ->get();
    }
}
