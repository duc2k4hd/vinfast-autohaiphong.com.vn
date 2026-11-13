<?php

namespace App\Services\Client;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * Tìm kiếm chi tiết xe theo slug.
     */
    public function findBySlug(string $slug): ?object
    {
        return DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->where('products.slug', $slug)
            ->where('products.status', 'published')
            ->where(function ($q) {
                $q->whereNull('products.published_at')
                    ->orWhere('products.published_at', '<=', now());
            })
            ->select([
                'products.id',
                'products.category_id',
                'products.sku',
                'products.name',
                'products.slug',
                'products.short_description',
                'products.description_html',
                'products.regular_price',
                'products.sale_price',
                'products.price_on_request',
                'products.created_at',
                'product_categories.name as category_name',
                'product_categories.slug as category_slug',
                'media.path as thumbnail_path',
                'media.alt_text as thumbnail_alt',
            ])
            ->first();
    }

    /**
     * Lấy thư viện ảnh gallery được gắn cho sản phẩm.
     *
     * @return Collection<int, object>
     */
    public function getGalleryImages(int $productId): Collection
    {
        return DB::table('media_usages')
            ->join('media', 'media_usages.media_id', '=', 'media.id')
            ->where('media_usages.usable_type', 'product')
            ->where('media_usages.usable_id', $productId)
            ->where('media_usages.role', 'gallery')
            ->where('media.status', 'active')
            ->select([
                'media.path',
                'media.alt_text',
                'media_usages.sort_order',
            ])
            ->orderBy('media_usages.sort_order')
            ->orderBy('media_usages.id')
            ->get();
    }

    /**
     * Lấy danh sách các phiên bản (variants) của xe.
     */
    public function getVariants(int $productId): Collection
    {
        return DB::table('product_variants')
            ->where('product_id', $productId)
            ->where('is_active', true)
            ->select([
                'id',
                'name',
                'sku',
                'color_name',
                'color_code',
                'regular_price',
                'sale_price',
                'is_available',
            ])
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Lấy các thông số kỹ thuật chi tiết của xe.
     */
    public function getSpecifications(int $productId): Collection
    {
        return DB::table('product_specifications')
            ->leftJoin('product_specification_groups', 'product_specifications.group_id', '=', 'product_specification_groups.id')
            ->where('product_specifications.product_id', $productId)
            ->select([
                'product_specifications.label',
                'product_specifications.value',
                'product_specifications.unit',
                'product_specification_groups.name as group_name',
            ])
            ->orderBy('product_specifications.sort_order', 'asc')
            ->get();
    }

    /**
     * Lấy các xe liên quan trong cùng danh mục.
     */
    public function getRelatedCars(int $categoryId, int $excludeId, int $limit = 3): Collection
    {
        return DB::table('products')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->where('products.category_id', $categoryId)
            ->where('products.id', '!=', $excludeId)
            ->where('products.status', 'published')
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.regular_price',
                'products.sale_price',
                'products.price_on_request',
                'media.path as thumbnail_path',
                'media.alt_text as thumbnail_alt',
            ])
            ->limit($limit)
            ->get();
    }
}
