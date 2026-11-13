<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Danh sách sản phẩm các dòng xe.
     */
    public function index(): View
    {
        $products = DB::table('products')
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
                'products.is_featured',
                'product_categories.name as category_name',
                'media.path as thumbnail_path',
            ])
            ->orderBy('products.id', 'asc')
            ->paginate(15);

        return view('admin.products.index', [
            'products' => $products,
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
            ->where('product_id', $id)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.products.edit', [
            'product' => $product,
            'specifications' => $specifications,
            'variants' => $variants,
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
            'specs_labels' => ['nullable', 'array'],
            'specs_values' => ['nullable', 'array'],
        ]);

        $now = now();

        DB::transaction(function () use ($request, $id, $now) {
            // Cập nhật bảng products
            DB::table('products')->where('id', $id)->update([
                'name' => $request->input('name'),
                'regular_price' => $request->input('regular_price'),
                'sale_price' => $request->input('sale_price'),
                'short_description' => $request->input('short_description'),
                'description_html' => $request->input('description_html'),
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
        });

        return redirect()->route('admin.products.edit', $id)
            ->with('success', 'Đã lưu cập nhật thông tin xe và thông số kỹ thuật Key-Value thành công!');
    }
}
