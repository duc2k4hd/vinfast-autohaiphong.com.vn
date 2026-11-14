<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Shared\HtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        return view('admin.products.edit', [
            'product' => $product,
            'specifications' => $specifications,
            'variants' => $variants,
            'mediaList' => $mediaList,
        ]);
    }

    /**
     * Cập nhật thông tin dòng xe & bảng thông số kỹ thuật key-value.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
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
        ]);

        $now = now();

        DB::transaction(function () use ($request, $id, $now) {
            // Cập nhật bảng products
            DB::table('products')->where('id', $id)->update([
                'name' => $request->input('name'),
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'short_description' => $request->input('short_description'),
                'description_html' => HtmlSanitizer::clean($request->input('description_html')),
                'thumbnail_media_id' => $request->input('thumbnail_media_id'),
                'updated_at' => $now,
            ]);

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
        });

        return redirect()->route('admin.products.edit', $id)
            ->with('success', 'Đã lưu cập nhật thông tin xe, biến thể phiên bản và thông số kỹ thuật thành công!');
    }
}
