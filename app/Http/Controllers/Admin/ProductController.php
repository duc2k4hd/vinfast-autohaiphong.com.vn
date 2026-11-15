<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Shared\HtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Danh sách sản phẩm các dòng xe kèm bộ lọc tìm kiếm.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = DB::table('products')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.sku',
                'products.regular_price',
                'products.sale_price',
                'products.status',
                'products.featured',
                'product_categories.name as category_name',
                'media.path as thumbnail_path',
            ]);

        if (! empty($search)) {
            $cleanSearch = trim($search);
            $query->where(function ($q) use ($cleanSearch) {
                $q->where('products.name', 'like', "%{$cleanSearch}%")
                    ->orWhere('products.sku', 'like', "%{$cleanSearch}%")
                    ->orWhere('products.slug', 'like', "%{$cleanSearch}%");
            });
        }

        $products = $query->orderBy('products.id', 'asc')->paginate(15)->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'currentSearch' => $search,
        ]);
    }

    /**
     * Giao diện chỉnh sửa sản phẩm xe & thông số key-value.
     */
    public function edit(int $id): View
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (! $product) {
            abort(404, 'Không tìm thấy dòng xe này.');
        }

        $specifications = DB::table('product_specifications')
            ->where('product_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get();

        $variants = DB::table('product_variants')
            ->leftJoin('media', 'product_variants.thumbnail_media_id', '=', 'media.id')
            ->where('product_variants.product_id', $id)
            ->select([
                'product_variants.*',
                'media.path as thumbnail_path',
                'media.filename as thumbnail_filename',
            ])
            ->orderBy('product_variants.sort_order', 'asc')
            ->get();

        $mediaList = DB::table('media')
            ->orderBy('created_at', 'desc')
            ->get();

        $colors = DB::table('product_colors')
            ->leftJoin('media', 'product_colors.image_media_id', '=', 'media.id')
            ->where('product_colors.product_id', $id)
            ->select([
                'product_colors.*',
                'media.path as image_path',
                'media.filename as image_filename',
            ])
            ->orderBy('product_colors.sort_order', 'asc')
            ->get();

        $banners = DB::table('product_banners')
            ->leftJoin('media', 'product_banners.image_media_id', '=', 'media.id')
            ->where('product_banners.product_id', $id)
            ->select([
                'product_banners.*',
                'media.path as media_path',
                'media.filename as media_filename',
            ])
            ->orderBy('product_banners.sort_order', 'asc')
            ->get();

        $interiors = DB::table('product_interiors')
            ->leftJoin('media', 'product_interiors.image_media_id', '=', 'media.id')
            ->where('product_interiors.product_id', $id)
            ->select([
                'product_interiors.*',
                'media.path as media_path',
                'media.filename as media_filename',
            ])
            ->orderBy('product_interiors.sort_order', 'asc')
            ->get();

        $specHighlights = DB::table('product_spec_highlights')
            ->where('product_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get();

        $categories = DB::table('product_categories')
            ->orderBy('sort_order', 'asc')
            ->get();

        $videos = DB::table('product_videos')
            ->leftJoin('media as video_media', 'product_videos.video_media_id', '=', 'video_media.id')
            ->leftJoin('media as poster_media', 'product_videos.poster_media_id', '=', 'poster_media.id')
            ->where('product_videos.product_id', $id)
            ->select([
                'product_videos.*',
                'video_media.path as video_media_path',
                'video_media.filename as video_media_filename',
                'poster_media.path as poster_media_path',
                'poster_media.filename as poster_media_filename',
            ])
            ->orderBy('product_videos.sort_order', 'asc')
            ->get();

        // Nếu bảng product_videos chưa có mà products đã có video cũ, chuyển đổi thành 1 video trong mảng
        if ($videos->isEmpty() && (! empty($product->video_path) || ! empty($product->video_media_id))) {
            $fallbackVideoMedia = ! empty($product->video_media_id) ? DB::table('media')->where('id', $product->video_media_id)->first() : null;
            $fallbackPosterMedia = ! empty($product->video_poster_media_id) ? DB::table('media')->where('id', $product->video_poster_media_id)->first() : null;

            $videos = collect([(object) [
                'id' => 0,
                'product_id' => $id,
                'title' => $product->video_title,
                'subtitle' => null,
                'video_path' => $product->video_path,
                'video_media_id' => $product->video_media_id,
                'video_media_path' => $fallbackVideoMedia?->path,
                'video_media_filename' => $fallbackVideoMedia?->filename,
                'poster_path' => $product->video_poster_path,
                'poster_media_id' => $product->video_poster_media_id,
                'poster_media_path' => $fallbackPosterMedia?->path,
                'poster_media_filename' => $fallbackPosterMedia?->filename,
                'sort_order' => 1,
                'is_active' => 1,
            ]]);
        }

        $videoMedia = null;
        if (! empty($product->video_media_id)) {
            $videoMedia = DB::table('media')->where('id', $product->video_media_id)->first();
        }
        $videoPosterMedia = null;
        if (! empty($product->video_poster_media_id)) {
            $videoPosterMedia = DB::table('media')->where('id', $product->video_poster_media_id)->first();
        }

        return view('admin.products.edit', [
            'product' => $product,
            'specifications' => $specifications,
            'specificationGroups' => DB::table('product_specification_groups')->orderBy('sort_order')->orderBy('name')->get(),
            'variants' => $variants,
            'colors' => $colors,
            'banners' => $banners,
            'interiors' => $interiors,
            'videos' => $videos,
            'specHighlights' => $specHighlights,
            'mediaList' => $mediaList,
            'categories' => $categories,
            'videoMedia' => $videoMedia,
            'videoPosterMedia' => $videoPosterMedia,
        ]);
    }

    /**
     * Giao diện thêm mới dòng xe ô tô.
     */
    public function create(): View
    {
        $categories = DB::table('product_categories')->orderBy('sort_order', 'asc')->get();
        $mediaList = DB::table('media')->orderBy('created_at', 'desc')->get();

        $dummyProduct = (object) [
            'id' => null,
            'name' => '',
            'slug' => '',
            'sku' => '',
            'category_id' => $categories->first()?->id ?? null,
            'regular_price' => null,
            'sale_price' => null,
            'short_description' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'canonical_url' => '',
            'description_html' => '',
            'status' => 'active',
            'featured' => false,
            'thumbnail_media_id' => null,
        ];

        return view('admin.products.edit', [
            'product' => $dummyProduct,
            'specifications' => collect(),
            'specificationGroups' => DB::table('product_specification_groups')->orderBy('sort_order')->orderBy('name')->get(),
            'variants' => collect(),
            'colors' => collect(),
            'banners' => collect(),
            'interiors' => collect(),
            'videos' => collect(),
            'specHighlights' => collect(),
            'mediaList' => $mediaList,
            'categories' => $categories,
            'videoMedia' => null,
            'videoPosterMedia' => null,
            'isCreate' => true,
        ]);
    }

    /**
     * Lưu dòng xe mới tạo vào hệ thống.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'specs_labels' => ['nullable', 'array'],
            'specs_labels.*' => ['nullable', 'string', 'max:150'],
            'specs_values' => ['nullable', 'array'],
            'specs_values.*' => ['nullable', 'string', 'max:500'],
            'specs_groups' => ['nullable', 'array'],
            'specs_groups.*' => ['nullable', function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
                if (is_string($value) && str_starts_with($value, 'new:')) {
                    $key = substr($value, 4);
                    if (! preg_match('/^[a-zA-Z0-9_-]+$/', $key) || ! is_array($request->input('new_spec_groups')) || ! array_key_exists($key, $request->input('new_spec_groups'))) {
                        $fail('Nhóm thông số mới không hợp lệ.');
                    }
                } elseif (! is_scalar($value) || ! ctype_digit((string) $value) || ! DB::table('product_specification_groups')->where('id', $value)->exists()) {
                    $fail('Nhóm thông số không hợp lệ.');
                }
            }],
            'specs_units' => ['nullable', 'array'],
            'specs_units.*' => ['nullable', 'string', 'max:50'],
            'new_spec_groups' => ['nullable', 'array', 'max:100'],
            'new_spec_groups.*' => ['required', 'string', 'max:150'],
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160'],
            'sku' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'regular_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
            'description_html' => ['nullable', 'string'],
            'thumbnail_media_id' => ['nullable', 'integer', 'exists:media,id'],
        ], [
            'name.required' => 'Vui lòng nhập tên dòng xe.',
            'slug.max' => 'Đường dẫn tĩnh không được vượt quá 160 ký tự.',
        ]);

        $now = now();
        $inputSlug = trim((string) $request->input('slug'));
        if ($inputSlug !== '') {
            $slug = Str::slug($inputSlug);
        } else {
            // Chỉ tạo theo tên khi tạo lần đầu khi không nhập slug thôi
            $slug = Str::slug($request->input('name'));
        }

        if (empty($slug)) {
            $slug = 'xe-vinfast-'.time();
        }

        $originalSlug = $slug;
        $count = 1;
        while (DB::table('products')->where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.(++$count);
        }

        $statusVal = $request->input('status', 'published');
        if ($statusVal === 'active') {
            $statusVal = 'published';
        }

        $id = DB::transaction(function () use ($request, $slug, $now, $statusVal) {
            $newId = DB::table('products')->insertGetId([
                'name' => $request->input('name'),
                'slug' => $slug,
                'sku' => $request->input('sku') ?: strtoupper($slug),
                'category_id' => $request->input('category_id') ?: null,
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'status' => $statusVal,
                'published_at' => in_array($statusVal, ['published', 'coming_soon']) ? $now : null,
                'featured' => $request->boolean('featured'),
                'short_description' => $request->input('short_description'),
                'meta_title' => $request->input('meta_title') ?: null,
                'meta_description' => $request->input('meta_description') ?: null,
                'meta_keywords' => $request->input('meta_keywords') ?: null,
                'canonical_url' => $request->input('canonical_url') ?: null,
                'description_html' => HtmlSanitizer::clean($request->input('description_html')),
                'thumbnail_media_id' => $request->input('thumbnail_media_id'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->saveSpecifications($request, $newId, $now);

            return $newId;
        });

        // Sau khi tạo xong xe thì chuyển sang giao diện edit để tiếp tục cấu hình đầy đủ
        return redirect()->route('admin.products.edit', $id)
            ->with('success', 'Đã thêm dòng xe mới thành công! Bạn có thể tiếp tục cấu hình phiên bản, màu sắc và thông số kỹ thuật.');
    }

    /**
     * Cập nhật thông tin dòng xe & bảng thông số kỹ thuật key-value.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (! $product) {
            return redirect()->route('admin.products.index')->with('error', 'Không tìm thấy dòng xe.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160'],
            'sku' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'in:published,active,inactive,draft,coming_soon,archived'],
            'regular_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'canonical_url' => ['nullable', 'string', 'max:500'],
            'description_html' => ['nullable', 'string'],
            'thumbnail_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'video_path' => ['nullable', 'string', 'max:500'],
            'video_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'video_poster_path' => ['nullable', 'string', 'max:500'],
            'video_poster_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'video_title' => ['nullable', 'string', 'max:255'],
            'video_titles' => ['nullable', 'array'],
            'video_subtitles' => ['nullable', 'array'],
            'video_paths' => ['nullable', 'array'],
            'video_media_ids' => ['nullable', 'array'],
            'video_poster_paths' => ['nullable', 'array'],
            'video_poster_media_ids' => ['nullable', 'array'],
            'specs_labels' => ['nullable', 'array'],
            'specs_labels.*' => ['nullable', 'string', 'max:150'],
            'specs_values' => ['nullable', 'array'],
            'specs_values.*' => ['nullable', 'string', 'max:500'],
            'specs_groups' => ['nullable', 'array'],
            'specs_groups.*' => ['nullable', function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
                if (is_string($value) && str_starts_with($value, 'new:')) {
                    $key = substr($value, 4);
                    if (! preg_match('/^[a-zA-Z0-9_-]+$/', $key) || ! is_array($request->input('new_spec_groups')) || ! array_key_exists($key, $request->input('new_spec_groups'))) {
                        $fail('Nhóm thông số mới không hợp lệ.');
                    }
                } elseif (! is_scalar($value) || ! ctype_digit((string) $value) || ! DB::table('product_specification_groups')->where('id', $value)->exists()) {
                    $fail('Nhóm thông số không hợp lệ.');
                }
            }],
            'specs_units' => ['nullable', 'array'],
            'specs_units.*' => ['nullable', 'string', 'max:50'],
            'new_spec_groups' => ['nullable', 'array', 'max:100'],
            'new_spec_groups.*' => ['required', 'string', 'max:150'],
            'variant_names' => ['nullable', 'array'],
            'variant_skus' => ['nullable', 'array'],
            'variant_regular_prices' => ['nullable', 'array'],
            'variant_sale_prices' => ['nullable', 'array'],
            'variant_color_names' => ['nullable', 'array'],
            'variant_thumbnail_media_ids' => ['nullable', 'array'],
            'color_names' => ['nullable', 'array'],
            'color_codes' => ['nullable', 'array'],
            'color_image_media_ids' => ['nullable', 'array'],
            'banner_titles' => ['nullable', 'array'],
            'banner_subtitles' => ['nullable', 'array'],
            'banner_image_media_ids' => ['nullable', 'array'],
            'banner_image_paths' => ['nullable', 'array'],
        ], [
            'name.required' => 'Vui lòng nhập tên dòng xe.',
            'slug.max' => 'Đường dẫn tĩnh không được vượt quá 160 ký tự.',
        ]);

        $now = now();

        // Xử lý slug khi cập nhật:
        // - Nếu người dùng nhập slug mới: chuẩn hóa và kiểm tra trùng lặp
        // - Nếu người dùng để trống hoặc không nhập: TUÂN THỦ SLUG CŨ ($product->slug), KHÔNG tự tạo theo tên
        $newSlug = null;
        $inputSlug = trim((string) $request->input('slug'));
        if ($inputSlug !== '') {
            $formattedSlug = Str::slug($inputSlug);
            if ($formattedSlug !== '' && $formattedSlug !== $product->slug) {
                $exists = DB::table('products')
                    ->where('slug', $formattedSlug)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($exists) {
                    return back()->withInput()->withErrors([
                        'slug' => 'Đường dẫn tĩnh (slug) "'.$formattedSlug.'" đã được sử dụng bởi dòng xe khác.',
                    ]);
                }

                $newSlug = $formattedSlug;
            }
        }

        DB::transaction(function () use ($request, $id, $now, $newSlug) {
            // Cập nhật bảng products
            $productUpdate = [
                'name' => $request->input('name'),
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'short_description' => $request->input('short_description'),
                'meta_title' => $request->input('meta_title') ?: null,
                'meta_description' => $request->input('meta_description') ?: null,
                'meta_keywords' => $request->input('meta_keywords') ?: null,
                'canonical_url' => $request->input('canonical_url') ?: null,
                'description_html' => HtmlSanitizer::clean($request->input('description_html')),
                'thumbnail_media_id' => $request->input('thumbnail_media_id'),
                'video_path' => $request->input('video_path') ?: null,
                'video_media_id' => $request->input('video_media_id') ?: null,
                'video_poster_path' => $request->input('video_poster_path') ?: null,
                'video_poster_media_id' => $request->input('video_poster_media_id') ?: null,
                'video_title' => $request->input('video_title') ?: null,
                'updated_at' => $now,
            ];

            if ($newSlug !== null) {
                $productUpdate['slug'] = $newSlug;
            }

            if ($request->filled('sku')) {
                $productUpdate['sku'] = trim($request->input('sku'));
            }
            if ($request->has('category_id')) {
                $productUpdate['category_id'] = $request->input('category_id') ?: null;
            }
            if ($request->filled('status')) {
                $statusVal = $request->input('status');
                if ($statusVal === 'active') {
                    $statusVal = 'published';
                }
                $productUpdate['status'] = $statusVal;
                if (in_array($statusVal, ['published', 'coming_soon']) && empty($product->published_at)) {
                    $productUpdate['published_at'] = $now;
                }
            }
            $productUpdate['featured'] = $request->boolean('featured');

            DB::table('products')->where('id', $id)->update($productUpdate);

            $this->saveSpecifications($request, $id, $now);

            // Cập nhật danh sách biến thể / phiên bản xe
            if ($request->has('variants_present') || $request->has('variant_names')) {
                DB::table('product_variants')->where('product_id', $id)->delete();

                $names = $request->input('variant_names', []);
                $skus = $request->input('variant_skus', []);
                $regularPrices = $request->input('variant_regular_prices', []);
                $salePrices = $request->input('variant_sale_prices', []);
                $colorNames = $request->input('variant_color_names', []);
                $thumbnailMediaIds = $request->input('variant_thumbnail_media_ids', []);

                $varSort = 1;
                foreach ($names as $idx => $vName) {
                    if (! empty(trim($vName))) {
                        DB::table('product_variants')->insert([
                            'product_id' => $id,
                            'name' => trim($vName),
                            'sku' => ! empty($skus[$idx]) ? trim($skus[$idx]) : null,
                            'regular_price' => ! empty($regularPrices[$idx]) ? (int) $regularPrices[$idx] : null,
                            'sale_price' => ! empty($salePrices[$idx]) ? (int) $salePrices[$idx] : null,
                            'color_name' => ! empty($colorNames[$idx]) ? trim($colorNames[$idx]) : null,
                            'thumbnail_media_id' => ! empty($thumbnailMediaIds[$idx]) ? (int) $thumbnailMediaIds[$idx] : null,
                            'is_available' => true,
                            'is_active' => true,
                            'sort_order' => $varSort++,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // Cập nhật danh sách màu sắc xe ngoại thất (Color Studio)
            if ($request->has('colors_present') || $request->has('color_names')) {
                DB::table('product_colors')->where('product_id', $id)->delete();

                $colNames = $request->input('color_names', []);
                $colCodes = $request->input('color_codes', []);
                $colMediaIds = $request->input('color_image_media_ids', []);

                $colSort = 1;
                foreach ($colNames as $cIdx => $cName) {
                    if (! empty(trim($cName))) {
                        DB::table('product_colors')->insert([
                            'product_id' => $id,
                            'name' => trim($cName),
                            'color_code' => ! empty($colCodes[$cIdx]) ? trim($colCodes[$cIdx]) : '#1464fa',
                            'image_media_id' => ! empty($colMediaIds[$cIdx]) ? (int) $colMediaIds[$cIdx] : null,
                            'sort_order' => $colSort++,
                            'is_active' => true,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // Cập nhật danh sách video giới thiệu xe 16:9 full viền (Multi-video)
            if ($request->has('videos_present') || $request->has('video_titles') || $request->has('video_paths') || $request->has('video_media_ids')) {
                DB::table('product_videos')->where('product_id', $id)->delete();

                $vTitles = $request->input('video_titles', []);
                $vSubtitles = $request->input('video_subtitles', []);
                $vMediaIds = $request->input('video_media_ids', []);
                $vPaths = $request->input('video_paths', []);
                $vPosterMediaIds = $request->input('video_poster_media_ids', []);
                $vPosterPaths = $request->input('video_poster_paths', []);

                $vSort = 1;
                $firstVideoPath = null;
                $firstVideoMediaId = null;
                $firstPosterPath = null;
                $firstPosterMediaId = null;
                $firstTitle = null;

                foreach ($vTitles as $vIdx => $vTitle) {
                    $vMediaId = ! empty($vMediaIds[$vIdx]) ? (int) $vMediaIds[$vIdx] : null;
                    $vDirectPath = ! empty($vPaths[$vIdx]) ? trim($vPaths[$vIdx]) : null;
                    $vPosterMediaId = ! empty($vPosterMediaIds[$vIdx]) ? (int) $vPosterMediaIds[$vIdx] : null;
                    $vPosterDirectPath = ! empty($vPosterPaths[$vIdx]) ? trim($vPosterPaths[$vIdx]) : null;
                    $vSub = ! empty($vSubtitles[$vIdx]) ? trim($vSubtitles[$vIdx]) : null;

                    if ($vMediaId || ! empty($vDirectPath) || ! empty(trim((string) $vTitle))) {
                        DB::table('product_videos')->insert([
                            'product_id' => $id,
                            'title' => trim((string) $vTitle) ?: null,
                            'subtitle' => $vSub,
                            'video_media_id' => $vMediaId,
                            'video_path' => $vDirectPath,
                            'poster_media_id' => $vPosterMediaId,
                            'poster_path' => $vPosterDirectPath,
                            'sort_order' => $vSort++,
                            'is_active' => true,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                        if ($firstVideoPath === null && ($vMediaId || $vDirectPath)) {
                            $firstVideoPath = $vDirectPath;
                            $firstVideoMediaId = $vMediaId;
                            $firstPosterPath = $vPosterDirectPath;
                            $firstPosterMediaId = $vPosterMediaId;
                            $firstTitle = trim((string) $vTitle) ?: null;
                        }
                    }
                }

                // Đồng bộ video đầu tiên vào bảng products để tương thích ngược 100%
                DB::table('products')->where('id', $id)->update([
                    'video_path' => $firstVideoPath,
                    'video_media_id' => $firstVideoMediaId,
                    'video_poster_path' => $firstPosterPath,
                    'video_poster_media_id' => $firstPosterMediaId,
                    'video_title' => $firstTitle,
                ]);
            }

            // Cập nhật danh sách ảnh banner hero riêng của sản phẩm (Tỷ lệ 16:9)
            if ($request->has('banners_present') || $request->has('banner_titles') || $request->has('banner_image_media_ids') || $request->has('banner_image_paths')) {
                DB::table('product_banners')->where('product_id', $id)->delete();

                $bTitles = $request->input('banner_titles', []);
                $bSubtitles = $request->input('banner_subtitles', []);
                $bMediaIds = $request->input('banner_image_media_ids', []);
                $bPaths = $request->input('banner_image_paths', []);

                $bSort = 1;
                foreach ($bTitles as $bIdx => $bTitle) {
                    $mediaId = ! empty($bMediaIds[$bIdx]) ? (int) $bMediaIds[$bIdx] : null;
                    $directPath = ! empty($bPaths[$bIdx]) ? trim($bPaths[$bIdx]) : null;

                    if (! empty(trim($bTitle)) || $mediaId || ! empty($directPath)) {
                        DB::table('product_banners')->insert([
                            'product_id' => $id,
                            'title' => trim($bTitle),
                            'subtitle' => ! empty($bSubtitles[$bIdx]) ? trim($bSubtitles[$bIdx]) : null,
                            'image_media_id' => $mediaId,
                            'image_path' => $directPath,
                            'sort_order' => $bSort++,
                            'is_active' => true,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // Cập nhật danh sách ảnh nội thất xe (Bento / Mosaic Gallery)
            if ($request->has('interiors_present') || $request->has('interior_captions') || $request->has('interior_image_media_ids') || $request->has('interior_image_paths')) {
                DB::table('product_interiors')->where('product_id', $id)->delete();

                $iCaptions = $request->input('interior_captions', []);
                $iMediaIds = $request->input('interior_image_media_ids', []);
                $iPaths = $request->input('interior_image_paths', []);

                $iSort = 1;
                foreach ($iCaptions as $iIdx => $iCaption) {
                    $mediaId = ! empty($iMediaIds[$iIdx]) ? (int) $iMediaIds[$iIdx] : null;
                    $directPath = ! empty($iPaths[$iIdx]) ? trim($iPaths[$iIdx]) : null;

                    if ($mediaId || ! empty($directPath) || ! empty(trim($iCaption))) {
                        DB::table('product_interiors')->insert([
                            'product_id' => $id,
                            'caption' => trim($iCaption),
                            'image_media_id' => $mediaId,
                            'image_path' => $directPath,
                            'sort_order' => $iSort++,
                            'is_active' => true,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // Cập nhật danh sách thông số nổi bật đầu trang (Spec Highlights)
            if ($request->has('highlights_present') || $request->has('highlight_values') || $request->has('highlight_labels')) {
                DB::table('product_spec_highlights')->where('product_id', $id)->delete();

                $hValues = $request->input('highlight_values', []);
                $hUnits = $request->input('highlight_units', []);
                $hSubtitles = $request->input('highlight_subtitles', []);
                $hLabels = $request->input('highlight_labels', []);

                $hSort = 1;
                foreach ($hValues as $hIdx => $hVal) {
                    $val = trim($hVal);
                    $label = ! empty($hLabels[$hIdx]) ? trim($hLabels[$hIdx]) : '';

                    if ($val !== '' || $label !== '') {
                        DB::table('product_spec_highlights')->insert([
                            'product_id' => $id,
                            'value' => $val,
                            'unit' => ! empty($hUnits[$hIdx]) ? trim($hUnits[$hIdx]) : null,
                            'subtitle' => ! empty($hSubtitles[$hIdx]) ? trim($hSubtitles[$hIdx]) : null,
                            'label' => $label,
                            'sort_order' => $hSort++,
                            'is_active' => true,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.products.edit', $id)
            ->with('success', 'Đã lưu cập nhật thông tin xe, biến thể phiên bản và thông số kỹ thuật thành công!');
    }

    private function saveSpecifications(Request $request, int $productId, \DateTimeInterface $now): void
    {
        if (! $request->has('specs_present') && ! ($request->has('specs_labels') && $request->has('specs_values'))) {
            return;
        }

        DB::table('product_specifications')->where('product_id', $productId)->delete();
        $resolvedGroups = [];
        $sort = 1;
        foreach ($request->input('specs_labels', []) as $index => $label) {
            if (trim((string) $label) === '') {
                continue;
            }
            $group = $request->input("specs_groups.$index");
            if (is_string($group) && str_starts_with($group, 'new:')) {
                $key = substr($group, 4);
                if (! isset($resolvedGroups[$key])) {
                    $name = trim($request->input("new_spec_groups.$key"));
                    $existing = DB::table('product_specification_groups')->where('name', $name)->first();
                    if ($existing) {
                        $resolvedGroups[$key] = $existing->id;
                    } else {
                        $baseSlug = Str::slug($name) ?: 'nhom';
                        $slug = substr($baseSlug, 0, 113).'-'.Str::uuid();
                        $resolvedGroups[$key] = DB::table('product_specification_groups')->insertGetId([
                            'name' => $name, 'slug' => $slug, 'created_at' => $now, 'updated_at' => $now,
                        ]);
                    }
                }
                $group = $resolvedGroups[$key];
            }
            DB::table('product_specifications')->insert([
                'product_id' => $productId,
                'group_id' => $group ?: null,
                'label' => trim($label),
                'value' => trim((string) $request->input("specs_values.$index", '')),
                'unit' => $request->input("specs_units.$index") ?: null,
                'sort_order' => $sort++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
