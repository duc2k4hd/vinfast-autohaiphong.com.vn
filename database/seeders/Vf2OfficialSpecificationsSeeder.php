<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class Vf2OfficialSpecificationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $productId = DB::table('products')->where('slug', 'vinfast-vf-2')->value('id');

            if (! $productId) {
                throw new RuntimeException('Không tìm thấy sản phẩm vinfast-vf-2.');
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

            // Xóa thông số cũ của VF 2 để thay bằng bộ thông số chính thức có nhóm
            DB::table('product_specifications')->where('product_id', $productId)->delete();

            $specifications = [
                // Nhóm 1: Kích thước
                ['kich-thuoc', 'Kích thước', '3090 x 1496 x 1663.2 (mm)'],
                ['kich-thuoc', 'Chiều dài cơ sở', '2065 (mm)'],
                ['kich-thuoc', 'Mô men xoắn cực đại', '65 Nm'],
                ['kich-thuoc', 'Công suất tối đa', '30 kW/hp'],
                ['kich-thuoc', 'Số chỗ ngồi', '4'],

                // Nhóm 2: Pin & Sạc
                ['pin-sac', 'Quãng đường di chuyển (NEDC)*', '210km/1 lần sạc'],
                ['pin-sac', 'Dung lượng pin khả dụng', '18.3 kWh'],
                ['pin-sac', 'Sạc nhanh từ 10% - 70% trong', '34 phút'],
                ['pin-sac', 'Công suất sạc nhanh DC tối đa', '~24 kW'],

                // Nhóm 3: Công nghệ trang bị
                ['cong-nghe-trang-bi', 'Hệ thống chống bó cứng phanh ABS', 'Có'],
                ['cong-nghe-trang-bi', 'Hệ thống túi khí', '1 túi khí'],
                ['cong-nghe-trang-bi', 'Màn hình thông tin sau vô lăng', '7 inch'],
            ];

            $now = now();
            foreach ($specifications as $index => [$groupSlug, $label, $value]) {
                DB::table('product_specifications')->insert([
                    'product_id' => $productId,
                    'group_id' => $groupIds[$groupSlug],
                    'label' => $label,
                    'value' => $value,
                    'unit' => null,
                    'sort_order' => $index + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        });
    }
}
