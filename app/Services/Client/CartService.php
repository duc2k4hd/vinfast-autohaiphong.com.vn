<?php

namespace App\Services\Client;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected const SESSION_KEY = 'vinfast_cart';

    /**
     * Thêm sản phẩm hoặc phiên bản vào giỏ hàng.
     */
    public function add(int $productId, int $quantity = 1, ?int $variantId = null): void
    {
        $cart = Session::get(self::SESSION_KEY, []);
        $itemKey = $variantId ? "{$productId}_{$variantId}" : "{$productId}_0";

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += max(1, $quantity);
        } else {
            $cart[$itemKey] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => max(1, $quantity),
            ];
        }

        Session::put(self::SESSION_KEY, $cart);
    }

    /**
     * Đặt lại toàn bộ giỏ hàng thành 1 sản phẩm duy nhất (dùng cho Mua ngay / Đặt cọc trực tiếp).
     */
    public function setSingleItem(int $productId, int $quantity = 1, ?int $variantId = null): void
    {
        $itemKey = $variantId ? "{$productId}_{$variantId}" : "{$productId}_0";
        Session::put(self::SESSION_KEY, [
            $itemKey => [
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => max(1, $quantity),
            ],
        ]);
    }

    /**
     * Cập nhật số lượng của một dòng trong giỏ hàng.
     */
    public function update(string $itemKey, int $quantity): void
    {
        $cart = Session::get(self::SESSION_KEY, []);

        if (isset($cart[$itemKey])) {
            if ($quantity <= 0) {
                unset($cart[$itemKey]);
            } else {
                $cart[$itemKey]['quantity'] = min(10, $quantity);
            }
            Session::put(self::SESSION_KEY, $cart);
        }
    }

    /**
     * Xóa một dòng khỏi giỏ hàng.
     */
    public function remove(string $itemKey): void
    {
        $cart = Session::get(self::SESSION_KEY, []);

        if (isset($cart[$itemKey])) {
            unset($cart[$itemKey]);
            Session::put(self::SESSION_KEY, $cart);
        }
    }

    /**
     * Xóa sạch giỏ hàng sau khi đặt hàng thành công.
     */
    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Kiểm tra giỏ hàng có rỗng không.
     */
    public function isEmpty(): bool
    {
        $cart = Session::get(self::SESSION_KEY, []);

        return empty($cart);
    }

    /**
     * Lấy danh sách sản phẩm trong giỏ hàng và định giá lại từ database (không tin client).
     */
    public function getCartDetails(): object
    {
        $rawCart = Session::get(self::SESSION_KEY, []);

        if (empty($rawCart)) {
            return (object) [
                'items' => collect(),
                'subtotal' => 0,
                'total' => 0,
                'item_count' => 0,
            ];
        }

        $productIds = array_unique(array_column($rawCart, 'product_id'));
        $products = DB::table('products')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->whereIn('products.id', $productIds)
            ->where('products.status', 'published')
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.sku',
                'products.regular_price',
                'products.sale_price',
                'media.path as thumbnail_path',
            ])
            ->get()
            ->keyBy('id');

        $variantIds = array_filter(array_column($rawCart, 'variant_id'));
        $variants = collect();
        if (! empty($variantIds)) {
            $variants = DB::table('product_variants')
                ->whereIn('id', $variantIds)
                ->select(['id', 'product_id', 'name', 'sku', 'color_name', 'regular_price', 'sale_price'])
                ->get()
                ->keyBy('id');
        }

        $items = collect();
        $subtotal = 0;
        $itemCount = 0;

        foreach ($rawCart as $key => $item) {
            $product = $products->get($item['product_id']);
            if (! $product) {
                continue;
            }

            $variant = $item['variant_id'] ? $variants->get($item['variant_id']) : null;

            // Đơn giá ưu tiên theo variant nếu có, sau đó là product sale_price / regular_price
            $unitPrice = 0;
            if ($variant) {
                $unitPrice = (float) ($variant->sale_price ?: $variant->regular_price);
            } else {
                $unitPrice = (float) ($product->sale_price ?: $product->regular_price);
            }

            $quantity = (int) $item['quantity'];
            $lineTotal = $unitPrice * $quantity;
            $subtotal += $lineTotal;
            $itemCount += $quantity;

            $items->push((object) [
                'key' => $key,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'product_sku' => $product->sku,
                'thumbnail_path' => $product->thumbnail_path,
                'variant_id' => $variant ? $variant->id : null,
                'variant_name' => $variant ? $variant->name : null,
                'color_name' => $variant ? $variant->color_name : null,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ]);
        }

        return (object) [
            'items' => $items,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'item_count' => $itemCount,
        ];
    }
}
