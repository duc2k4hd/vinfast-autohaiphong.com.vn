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

        return view('admin.products.edit', [
            'product' => $product,
            'specifications' => $specifications,
            'variants' => $variants,
            'colors' => $colors,
            'banners' => $banners,
            'interiors' => $interiors,
            'specHighlights' => $specHighlights,
            'mediaList' => $mediaList,
            'categories' => $categories,
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
            'description_html' => '',
            'status' => 'active',
            'featured' => false,
            'thumbnail_media_id' => null,
        ];

        return view('admin.products.edit', [
            'product' => $dummyProduct,
            'specifications' => collect(),
            'variants' => collect(),
            'colors' => collect(),
            'banners' => collect(),
            'interiors' => collect(),
            'specHighlights' => collect(),
            'mediaList' => $mediaList,
            'categories' => $categories,
            'isCreate' => true,
        ]);
    }

    /**
     * Lưu dòng xe mới tạo vào hệ thống.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'sku' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'regular_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description_html' => ['nullable', 'string'],
            'thumbnail_media_id' => ['nullable', 'integer', 'exists:media,id'],
        ]);

        $now = now();
        $slug = Str::slug($request->input('name'));
        $originalSlug = $slug;
        $count = 1;
        while (DB::table('products')->where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.(++$count);
        }

        $id = DB::transaction(function () use ($request, $slug, $now) {
            $newId = DB::table('products')->insertGetId([
                'name' => $request->input('name'),
                'slug' => $slug,
                'sku' => $request->input('sku') ?: strtoupper($slug),
                'category_id' => $request->input('category_id') ?: null,
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'status' => $request->input('status', 'active'),
                'featured' => $request->boolean('featured'),
                'short_description' => $request->input('short_description'),
                'description_html' => HtmlSanitizer::clean($request->input('description_html')),
                'thumbnail_media_id' => $request->input('thumbnail_media_id'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return $newId;
        });

        // Sau khi tạo xong xe thì chuyển sang giao diện edit để tiếp tục cấu hình đầy đủ
        return redirect()->route('admin.products.edit', $id)
            ->with('success', 'Đã thêm dòng xe mới thành công! Bạn có thể tiếp tục cấu hình phiên bản, màu sắc và thông số kỹ thuật.');
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
            'description_html' => '',
            'status' => 'active',
            'featured' => false,
            'thumbnail_media_id' => null,
        ];

        return view('admin.products.edit', [
            'product' => $dummyProduct,
            'specifications' => collect(),
            'variants' => collect(),
            'colors' => collect(),
            'banners' => collect(),
            'interiors' => collect(),
            'specHighlights' => collect(),
            'mediaList' => $mediaList,
            'categories' => $categories,
            'isCreate' => true,
        ]);
    }

    /**
     * Lưu dòng xe mới tạo vào hệ thống.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'sku' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'regular_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description_html' => ['nullable', 'string'],
            'thumbnail_media_id' => ['nullable', 'integer', 'exists:media,id'],
        ]);

        $now = now();
        $slug = \Illuminate\Support\Str::slug($request->input('name'));
        $originalSlug = $slug;
        $count = 1;
        while (DB::table('products')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . (++$count);
        }

        $id = DB::transaction(function () use ($request, $slug, $now) {
            $newId = DB::table('products')->insertGetId([
                'name' => $request->input('name'),
                'slug' => $slug,
                'sku' => $request->input('sku') ?: strtoupper($slug),
                'category_id' => $request->input('category_id') ?: null,
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'status' => $request->input('status', 'active'),
                'featured' => $request->boolean('featured'),
                'short_description' => $request->input('short_description'),
                'description_html' => HtmlSanitizer::clean($request->input('description_html')),
                'thumbnail_media_id' => $request->input('thumbnail_media_id'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

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
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'sku' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'in:active,inactive,coming_soon'],
            'regular_price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description_html' => ['nullable', 'string'],
            'thumbnail_media_id' => ['nullable', 'integer', 'exists:media,id'],
            'specs_labels' => ['nullable', 'array'],
            'specs_values' => ['nullable', 'array'],
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
        ]);

        $now = now();

        DB::transaction(function () use ($request, $id, $now) {
            // Cập nhật bảng products
            $productUpdate = [
                'name' => $request->input('name'),
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'short_description' => $request->input('short_description'),
                'description_html' => HtmlSanitizer::clean($request->input('description_html')),
                'thumbnail_media_id' => $request->input('thumbnail_media_id'),
                'updated_at' => $now,
            ];

            if ($request->filled('sku')) {
                $productUpdate['sku'] = trim($request->input('sku'));
            }
            if ($request->has('category_id')) {
                $productUpdate['category_id'] = $request->input('category_id') ?: null;
            }
            if ($request->filled('status')) {
                $productUpdate['status'] = $request->input('status');
            }
            $productUpdate['featured'] = $request->boolean('featured');

            DB::table('products')->where('id', $id)->update($productUpdate);

            // Cập nhật bảng specifications Key-Value
            if ($request->has('specs_labels') && $request->has('specs_values')) {
                DB::table('product_specifications')->where('product_id', $id)->delete();

                $labels = $request->input('specs_labels', []);
                $values = $request->input('specs_values', []);

                $sort = 1;
                foreach ($labels as $idx => $label) {
                    $val = $values[$idx] ?? '';
                    if (! empty(trim($label))) {
                        DB::table('product_specifications')->insert([
                            'product_id' => $id,
                            'group_id' => null,
                            'label' => trim($label),
                            'value' => trim($val),
                            'unit' => null,
                            'sort_order' => $sort++,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }

            // Cập nhật danh sách biến thể / phiên bản xe
            if ($request->has('variant_names')) {
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
            if ($request->has('color_names')) {
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

            // Cập nhật danh sách ảnh banner hero riêng của sản phẩm (Tỷ lệ 16:9)
            if ($request->has('banner_titles') || $request->has('banner_image_media_ids') || $request->has('banner_image_paths')) {
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
            if ($request->has('interior_captions') || $request->has('interior_image_media_ids') || $request->has('interior_image_paths')) {
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
            if ($request->has('highlight_values') || $request->has('highlight_labels')) {
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
}
