<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class Vf3OfficialSpecificationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $productId = DB::table('products')->where('slug', 'vinfast-vf-3')->value('id');

            if (! $productId) {
                throw new RuntimeException('Không tìm thấy sản phẩm vinfast-vf-3.');
            }

            $groups = [
                ['Kích thước', 'kich-thuoc', 1],
                ['Pin & Sạc', 'pin-sac', 2],
                ['Công nghệ trang bị', 'cong-nghe-trang-bi', 3],
            ];

            $groupIds = [];
            foreach ($groups as [$name, $slug, $order]) {
                $group = DB::table('product_specification_groups')->where('slug', $slug)->first();
                $groupIds[$slug] = $group?->id ?? DB::table('product_specification_groups')->insertGetId([
                    'name' => $name,
                    'slug' => $slug,
                    'sort_order' => $order,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $specifications = [
                ['kich-thuoc', 'Dài x Rộng x Cao (mm)', '3.190 x 1.679 x 1.652', ['Dài x Rộng x Cao']],
                ['kich-thuoc', 'Đường kính quay đầu tối thiểu (m/ft)', '9m', []],
                ['kich-thuoc', 'Mô men xoắn cực đại', '110 Nm', ['Mô-men xoắn cực đại']],
                ['kich-thuoc', 'Công suất tối đa', '30 kW/hp', []],
                ['kich-thuoc', 'Số chỗ ngồi', '4', []],
                ['pin-sac', 'Quãng đường di chuyển (NEDC)*', '215km/1 lần sạc', ['Quãng đường di chuyển (NEDC)']],
                ['pin-sac', 'Dung lượng pin khả dụng', '18.64', []],
                ['pin-sac', 'Sạc nhanh từ 10% - 70%', '36 phút', ['Thời gian sạc nhanh (10% - 70%)']],
                ['pin-sac', 'Công suất sạc nhanh DC tối đa', '24 kW', []],
                ['cong-nghe-trang-bi', 'Hỗ trợ khởi hành ngang dốc (HSA)', 'Có', []],
                ['cong-nghe-trang-bi', 'Hệ thống chống bó cứng phanh (ABS)', 'Có', []],
                ['cong-nghe-trang-bi', 'Cảm biến sau hỗ trợ đỗ xe', 'Có', []],
                ['cong-nghe-trang-bi', 'Hệ thống túi khí', '1 túi khí', []],
                ['cong-nghe-trang-bi', 'Màn hình giải trí cảm ứng', '10 inch', []],
            ];

            foreach ($specifications as $index => [$group, $label, $value, $aliases]) {
                $existing = DB::table('product_specifications')
                    ->where('product_id', $productId)
                    ->whereIn('label', [$label, ...$aliases])
                    ->orderBy('id')
                    ->first();

                $attributes = [
                    'group_id' => $groupIds[$group],
                    'label' => $label,
                    'value' => $value,
                    'unit' => null,
                    'sort_order' => $index + 1,
                    'updated_at' => now(),
                ];

                if ($existing) {
                    DB::table('product_specifications')->where('id', $existing->id)->update($attributes);
                } else {
                    DB::table('product_specifications')->insert([
                        ...$attributes,
                        'product_id' => $productId,
                        'created_at' => now(),
                    ]);
                }
            }
        });
    }
}
