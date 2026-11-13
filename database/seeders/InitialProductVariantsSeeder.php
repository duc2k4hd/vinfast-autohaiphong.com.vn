<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class InitialProductVariantsSeeder extends Seeder
{
    /**
     * Nạp dữ liệu biến thể xe VinFast thực tế chuẩn thị trường.
     */
    public function run(): void
    {
        $variantsData = [
            'vinfast-vf-3' => [
                [
                    'sku' => 'VF3-BASE-BAT',
                    'name' => 'Bản Thuê Pin (Chưa kèm pin)',
                    'regular_price' => 240000000,
                    'sale_price' => 240000000,
                    'color_name' => 'Vàng nóc trắng',
                    'color_code' => '#F4D03F',
                    'sort_order' => 1,
                ],
                [
                    'sku' => 'VF3-BASE-INC',
                    'name' => 'Bản Kèm Pin (Mua đứt pin)',
                    'regular_price' => 322000000,
                    'sale_price' => 322000000,
                    'color_name' => 'Xanh bộ đội nóc trắng',
                    'color_code' => '#4A6B52',
                    'sort_order' => 2,
                ],
            ],
            'vinfast-vf-5' => [
                [
                    'sku' => 'VF5-PLUS-BAT',
                    'name' => 'VF 5 Plus (Thuê Pin)',
                    'regular_price' => 468000000,
                    'sale_price' => 468000000,
                    'color_name' => 'Trắng nóc xanh',
                    'color_code' => '#FFFFFF',
                    'sort_order' => 1,
                ],
                [
                    'sku' => 'VF5-PLUS-INC',
                    'name' => 'VF 5 Plus (Kèm Pin)',
                    'regular_price' => 548000000,
                    'sale_price' => 548000000,
                    'color_name' => 'Đỏ nóc trắng',
                    'color_code' => '#C0392B',
                    'sort_order' => 2,
                ],
            ],
            'vinfast-vf-6' => [
                [
                    'sku' => 'VF6-ECO-BAT',
                    'name' => 'VF 6 Eco (Thuê Pin)',
                    'regular_price' => 675000000,
                    'sale_price' => 675000000,
                    'color_name' => 'Xanh VinFast',
                    'color_code' => '#1464F4',
                    'sort_order' => 1,
                ],
                [
                    'sku' => 'VF6-ECO-INC',
                    'name' => 'VF 6 Eco (Kèm Pin)',
                    'regular_price' => 765000000,
                    'sale_price' => 765000000,
                    'color_name' => 'Xanh VinFast',
                    'color_code' => '#1464F4',
                    'sort_order' => 2,
                ],
                [
                    'sku' => 'VF6-PLUS-BAT',
                    'name' => 'VF 6 Plus (Thuê Pin)',
                    'regular_price' => 765000000,
                    'sale_price' => 765000000,
                    'color_name' => 'Xám Bạc',
                    'color_code' => '#7F8C8D',
                    'sort_order' => 3,
                ],
                [
                    'sku' => 'VF6-PLUS-INC',
                    'name' => 'VF 6 Plus (Kèm Pin)',
                    'regular_price' => 855000000,
                    'sale_price' => 855000000,
                    'color_name' => 'Xám Bạc',
                    'color_code' => '#7F8C8D',
                    'sort_order' => 4,
                ],
            ],
            'vinfast-vf-7' => [
                [
                    'sku' => 'VF7-BASE-BAT',
                    'name' => 'VF 7 Base (Thuê Pin)',
                    'regular_price' => 850000000,
                    'sale_price' => 850000000,
                    'color_name' => 'Đen huyền bí',
                    'color_code' => '#1A1A1A',
                    'sort_order' => 1,
                ],
                [
                    'sku' => 'VF7-BASE-INC',
                    'name' => 'VF 7 Base (Kèm Pin)',
                    'regular_price' => 999000000,
                    'sale_price' => 999000000,
                    'color_name' => 'Đen huyền bí',
                    'color_code' => '#1A1A1A',
                    'sort_order' => 2,
                ],
                [
                    'sku' => 'VF7-PLUS-BAT',
                    'name' => 'VF 7 Plus (Thuê Pin)',
                    'regular_price' => 999000000,
                    'sale_price' => 999000000,
                    'color_name' => 'Đỏ Crimson',
                    'color_code' => '#900C3F',
                    'sort_order' => 3,
                ],
                [
                    'sku' => 'VF7-PLUS-INC',
                    'name' => 'VF 7 Plus (Kèm Pin)',
                    'regular_price' => 1199000000,
                    'sale_price' => 1199000000,
                    'color_name' => 'Đỏ Crimson',
                    'color_code' => '#900C3F',
                    'sort_order' => 4,
                ],
            ],
            'vinfast-vf-8' => [
                [
                    'sku' => 'VF8-ECO-BAT',
                    'name' => 'VF 8 Eco (Thuê Pin)',
                    'regular_price' => 1090000000,
                    'sale_price' => 1079000000,
                    'color_name' => 'Trắng ngọc trai',
                    'color_code' => '#F8F9FA',
                    'sort_order' => 1,
                ],
                [
                    'sku' => 'VF8-ECO-INC',
                    'name' => 'VF 8 Eco (Kèm Pin)',
                    'regular_price' => 1290000000,
                    'sale_price' => 1279000000,
                    'color_name' => 'Trắng ngọc trai',
                    'color_code' => '#F8F9FA',
                    'sort_order' => 2,
                ],
                [
                    'sku' => 'VF8-PLUS-BAT',
                    'name' => 'VF 8 Plus (Thuê Pin)',
                    'regular_price' => 1270000000,
                    'sale_price' => 1259000000,
                    'color_name' => 'Xanh VinFast Deep Ocean',
                    'color_code' => '#0F4C81',
                    'sort_order' => 3,
                ],
                [
                    'sku' => 'VF8-PLUS-INC',
                    'name' => 'VF 8 Plus (Kèm Pin)',
                    'regular_price' => 1470000000,
                    'sale_price' => 1459000000,
                    'color_name' => 'Xanh VinFast Deep Ocean',
                    'color_code' => '#0F4C81',
                    'sort_order' => 4,
                ],
            ],
            'vinfast-vf-9' => [
                [
                    'sku' => 'VF9-ECO-BAT',
                    'name' => 'VF 9 Eco (Thuê Pin)',
                    'regular_price' => 1589000000,
                    'sale_price' => 1589000000,
                    'color_name' => 'Đen Sang Trọng',
                    'color_code' => '#111827',
                    'sort_order' => 1,
                ],
                [
                    'sku' => 'VF9-ECO-INC',
                    'name' => 'VF 9 Eco (Kèm Pin)',
                    'regular_price' => 2114000000,
                    'sale_price' => 2114000000,
                    'color_name' => 'Đen Sang Trọng',
                    'color_code' => '#111827',
                    'sort_order' => 2,
                ],
                [
                    'sku' => 'VF9-PLUS-BAT',
                    'name' => 'VF 9 Plus (Thuê Pin)',
                    'regular_price' => 1786000000,
                    'sale_price' => 1786000000,
                    'color_name' => 'Xám Bạc Đẳng Cấp',
                    'color_code' => '#4B5563',
                    'sort_order' => 3,
                ],
                [
                    'sku' => 'VF9-PLUS-INC',
                    'name' => 'VF 9 Plus (Kèm Pin)',
                    'regular_price' => 2314000000,
                    'sale_price' => 2314000000,
                    'color_name' => 'Xám Bạc Đẳng Cấp',
                    'color_code' => '#4B5563',
                    'sort_order' => 4,
                ],
            ],
            'vinfast-vfe34' => [
                [
                    'sku' => 'VFE34-BAT',
                    'name' => 'VF e34 (Thuê Pin)',
                    'regular_price' => 710000000,
                    'sale_price' => 710000000,
                    'color_name' => 'Trắng',
                    'color_code' => '#FFFFFF',
                    'sort_order' => 1,
                ],
                [
                    'sku' => 'VFE34-INC',
                    'name' => 'VF e34 (Kèm Pin)',
                    'regular_price' => 830000000,
                    'sale_price' => 830000000,
                    'color_name' => 'Trắng',
                    'color_code' => '#FFFFFF',
                    'sort_order' => 2,
                ],
            ],
        ];

        foreach ($variantsData as $slug => $variants) {
            $product = Product::where('slug', $slug)->first();
            if (! $product) {
                continue;
            }

            foreach ($variants as $var) {
                ProductVariant::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'name' => $var['name'],
                    ],
                    [
                        'sku' => $var['sku'],
                        'regular_price' => $var['regular_price'],
                        'sale_price' => $var['sale_price'],
                        'color_name' => $var['color_name'] ?? null,
                        'color_code' => $var['color_code'] ?? null,
                        'is_available' => true,
                        'is_active' => true,
                        'sort_order' => $var['sort_order'],
                    ]
                );
            }
        }
    }
}

