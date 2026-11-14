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
     * Lấy danh sách ảnh gallery của xe.
     */
    public function getGalleryImages(int $productId): Collection
    {
        return DB::table('media_usages')
            ->join('media', 'media_usages.media_id', '=', 'media.id')
            ->where('media_usages.usable_type', 'product')
            ->where('media_usages.usable_id', $productId)
            ->where('media_usages.role', 'gallery')
            ->orderBy('media_usages.sort_order', 'asc')
            ->select([
                'media.path',
                'media.alt_text',
            ])
            ->get();
    }

    /**
     * Lấy danh sách các phiên bản (variants) của xe.
     */
    public function getVariants(int $productId): Collection
    {
        return DB::table('product_variants')
            ->leftJoin('media', 'product_variants.thumbnail_media_id', '=', 'media.id')
            ->where('product_variants.product_id', $productId)
            ->where('product_variants.is_active', true)
            ->select([
                'product_variants.id',
                'product_variants.name',
                'product_variants.sku',
                'product_variants.color_name',
                'product_variants.color_code',
                'product_variants.regular_price',
                'product_variants.sale_price',
                'product_variants.is_available',
                'media.path as thumbnail_path',
            ])
            ->orderBy('product_variants.sort_order', 'asc')
            ->get();
    }

    /**
     * Lấy danh sách màu sắc xe kèm ảnh xe tương ứng.
     */
    public function getColors(int $productId): Collection
    {
        return DB::table('product_colors')
            ->leftJoin('media', 'product_colors.image_media_id', '=', 'media.id')
            ->where('product_colors.product_id', $productId)
            ->where('product_colors.is_active', true)
            ->select([
                'product_colors.id',
                'product_colors.name',
                'product_colors.color_code',
                'media.path as image_path',
            ])
            ->orderBy('product_colors.sort_order', 'asc')
            ->get();
    }

    /**
     * Lấy danh sách banner hero riêng của xe (tỷ lệ 16:9).
     */
    public function getBanners(int $productId): Collection
    {
        return DB::table('product_banners')
            ->leftJoin('media', 'product_banners.image_media_id', '=', 'media.id')
            ->where('product_banners.product_id', $productId)
            ->where('product_banners.is_active', true)
            ->select([
                'product_banners.id',
                'product_banners.title',
                'product_banners.subtitle',
                'product_banners.image_path as direct_image_path',
                'media.path as media_image_path',
                'media.alt_text as media_alt',
            ])
            ->orderBy('product_banners.sort_order', 'asc')
            ->get()
            ->map(function ($banner) {
                $path = $banner->media_image_path ?: $banner->direct_image_path;

                return (object) [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'subtitle' => $banner->subtitle,
                    'image_url' => $path ? asset('storage/'.ltrim($path, '/')) : null,
                    'alt_text' => $banner->media_alt ?: ($banner->title ?: 'VinFast Banner'),
                ];
            })
            ->filter(fn ($b) => ! empty($b->image_url))
            ->values();
    }

    /**
     * Lấy danh sách ảnh nội thất xe.
     */
    public function getInteriors(int $productId): Collection
    {
        return DB::table('product_interiors')
            ->leftJoin('media', 'product_interiors.image_media_id', '=', 'media.id')
            ->where('product_interiors.product_id', $productId)
            ->where('product_interiors.is_active', true)
            ->select([
                'product_interiors.id',
                'product_interiors.caption',
                'product_interiors.image_path as direct_image_path',
                'media.path as media_image_path',
                'media.alt_text as media_alt',
            ])
            ->orderBy('product_interiors.sort_order', 'asc')
            ->get()
            ->map(function ($item) {
                $path = $item->media_image_path ?: $item->direct_image_path;

                return (object) [
                    'id' => $item->id,
                    'caption' => $item->caption,
                    'image_url' => $path ? asset('storage/'.ltrim($path, '/')) : null,
                    'alt_text' => $item->caption ?: ($item->media_alt ?: 'Nội thất xe VinFast'),
                ];
            })
            ->filter(fn ($it) => ! empty($it->image_url))
            ->values();
    }

    /**
     * Lấy danh sách thông số nổi bật đầu trang (Spec Highlights).
     */
    public function getSpecHighlights(int $productId): Collection
    {
        return DB::table('product_spec_highlights')
            ->where('product_id', $productId)
            ->where('is_active', true)
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

    /**
     * Xác định thông số so sánh kinh tế chuẩn xác giữa xe điện VinFast và xe xăng tương đương theo phân khúc.
     *
     * @return array{
     *     ev_consumption: float,
     *     ice_consumption: float,
     *     segment_name: string,
     *     ice_label: string,
     *     default_distance: int,
     *     default_electricity_price: int,
     *     default_petrol_price: int,
     *     initial_ev_cost: int,
     *     initial_ice_cost: int,
     *     initial_saving: int
     * }
     */
    public function getComparisonBenchmark(object $car, Collection $specifications): array
    {
        $batteryKwh = null;
        $rangeKm = null;

        foreach ($specifications as $spec) {
            $labelLower = mb_strtolower($spec->label ?? '', 'UTF-8');
            $val = $spec->value ?? '';

            if (str_contains($labelLower, 'pin') && (str_contains($labelLower, 'dung lượng') || str_contains($labelLower, 'khả dụng'))) {
                if (preg_match('/([0-9]+[.,]?[0-9]*)\s*kwh/i', $val, $m)) {
                    $batteryKwh = (float) str_replace(',', '.', $m[1]);
                }
            }

            if (str_contains($labelLower, 'quãng đường') || str_contains($labelLower, 'tầm hoạt động')) {
                if (preg_match('/([0-9]+[.,]?[0-9]*)\s*km/i', $val, $m)) {
                    $rangeKm = (float) str_replace(',', '.', $m[1]);
                }
            }
        }

        $slug = strtolower($car->slug ?? '');
        $name = strtolower($car->name ?? '');

        // Ma trận định mức tiêu chuẩn từng dòng xe VinFast so với xe xăng cùng phân khúc
        if (str_contains($slug, 'vf-3') || str_contains($slug, 'vf-2') || str_contains($slug, 'minio') || str_contains($name, 'vf 3') || str_contains($name, 'vf 2')) {
            $segmentName = 'Mini SUV đô thị';
            $evRate = 8.9;
            $iceRate = 5.5;
            $iceLabel = 'Xe xăng hạng A / cỡ nhỏ (1.0L - 1.2L)';
        } elseif (str_contains($slug, 'vf-5') || str_contains($slug, 'herio') || str_contains($slug, 'ec-van') || str_contains($name, 'vf 5')) {
            $segmentName = 'A-SUV Crossover đô thị';
            $evRate = 11.5;
            $iceRate = 6.5;
            $iceLabel = 'Xe xăng A-SUV tương đương (1.2L - 1.5L)';
        } elseif (str_contains($slug, 'vf-6') || str_contains($slug, 'e34') || str_contains($slug, 'nerio') || str_contains($name, 'vf 6')) {
            $segmentName = 'B-SUV thời thượng';
            $evRate = 14.5;
            $iceRate = 7.6;
            $iceLabel = 'Xe xăng B-SUV tương đương (1.5L)';
        } elseif (str_contains($slug, 'vf-7') || str_contains($slug, 'mpv') || str_contains($name, 'vf 7')) {
            $segmentName = 'C-SUV thể thao & MPV';
            $evRate = 16.8;
            $iceRate = 8.8;
            $iceLabel = 'Xe xăng C-SUV tương đương (1.5T - 2.0L)';
        } elseif (str_contains($slug, 'vf-8') || str_contains($slug, 'wild') || str_contains($name, 'vf 8')) {
            $segmentName = 'D-SUV hạng sang & Bán tải điện';
            $evRate = 19.2;
            $iceRate = 10.5;
            $iceLabel = 'Xe xăng D-SUV tương đương (2.0T - 2.5L)';
        } elseif (str_contains($slug, 'vf-9') || str_contains($slug, 'limo') || str_contains($name, 'vf 9')) {
            $segmentName = 'E-SUV Full-size cao cấp';
            $evRate = 21.5;
            $iceRate = 13.5;
            $iceLabel = 'Xe xăng E-SUV Full-size cỡ lớn (V6 3.0L+)';
        } elseif (str_contains($slug, 'xe-may') || str_contains($name, 'evo') || str_contains($name, 'feliz') || str_contains($name, 'klara') || str_contains($name, 'theon') || str_contains($name, 'vento')) {
            $segmentName = 'Xe máy điện thông minh';
            $evRate = 2.8;
            $iceRate = 2.2;
            $iceLabel = 'Xe máy xăng phổ thông (110cc - 150cc)';
        } else {
            $segmentName = 'Xe điện thông minh';
            $evRate = 13.5;
            $iceRate = 7.5;
            $iceLabel = 'Xe xăng cùng phân khúc tương đương';
        }

        // Ưu tiên tính toán trực tiếp từ thông số pin và tầm hoạt động thực tế nếu có
        if ($batteryKwh && $rangeKm && $rangeKm > 0) {
            $calculatedEv = round(($batteryKwh / $rangeKm) * 100, 1);
            if ($calculatedEv >= 2.0 && $calculatedEv <= 35.0) {
                $evRate = $calculatedEv;
            }
        }

        $defaultDistance = 12000;
        $defaultElecPrice = 3500;
        $defaultPetrolPrice = 23000;

        $initialEvCost = (int) round(($defaultDistance / 100) * $evRate * $defaultElecPrice);
        $initialIceCost = (int) round(($defaultDistance / 100) * $iceRate * $defaultPetrolPrice);
        $initialSaving = $initialIceCost - $initialEvCost;

        return [
            'ev_consumption' => $evRate,
            'ice_consumption' => $iceRate,
            'segment_name' => $segmentName,
            'ice_label' => $iceLabel,
            'default_distance' => $defaultDistance,
            'default_electricity_price' => $defaultElecPrice,
            'default_petrol_price' => $defaultPetrolPrice,
            'initial_ev_cost' => $initialEvCost,
            'initial_ice_cost' => $initialIceCost,
            'initial_saving' => $initialSaving,
        ];
    }
}
