<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. Tạo 2 danh mục chính
        $catPassengerId = DB::table('product_categories')->insertGetId([
            'name' => 'Ô Tô Điện Du Lịch',
            'slug' => 'o-to-dien-du-lich',
            'description' => 'Các dòng xe ô tô điện cá nhân và gia đình thông minh của VinFast',
            'status' => 'active',
            'sort_order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $catCommercialId = DB::table('product_categories')->insertGetId([
            'name' => 'Xe Dịch Vụ & Vận Tải Xanh',
            'slug' => 'xe-dich-vu-xanh',
            'description' => 'Giải pháp phương tiện thuần điện tối ưu chi phí vận hành cho doanh nghiệp và dịch vụ',
            'status' => 'active',
            'sort_order' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Danh sách 15 mẫu xe theo kiểm kê
        $cars = [
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 2',
                'slug' => 'vinfast-vf-2',
                'sku' => 'VF2-STD',
                'regular_price' => 188000000,
                'sale_price' => 188000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu xe đô thị cỡ nhỏ thông minh, phong cách trẻ trung và linh hoạt.',
                'sort_order' => 1,
                'featured' => false,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 3',
                'slug' => 'vinfast-vf-3',
                'sku' => 'VF3-STD',
                'regular_price' => 285000000,
                'sale_price' => 285000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu mini-eSUV quốc dân phá cách, mạnh mẽ và tiện nghi cho mọi hành trình.',
                'sort_order' => 2,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 5 Plus',
                'slug' => 'vinfast-vf-5',
                'sku' => 'VF5-PLUS',
                'regular_price' => 496000000,
                'sale_price' => 496000000,
                'price_on_request' => false,
                'short_description' => 'SUV đô thị hạng A dẫn đầu phân khúc, trang bị hàng loạt công nghệ an toàn.',
                'sort_order' => 3,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 6',
                'slug' => 'vinfast-vf-6',
                'sku' => 'VF6-BASE',
                'regular_price' => 646000000,
                'sale_price' => 646000000,
                'price_on_request' => false,
                'short_description' => 'Tuyệt tác thiết kế phong cách châu Âu, trải nghiệm lái thể thao đầy cảm hứng.',
                'sort_order' => 4,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 7',
                'slug' => 'vinfast-vf-7',
                'sku' => 'VF7-BASE',
                'regular_price' => 740000000,
                'sale_price' => 740000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu C-SUV đột phá tương lai, không gian rộng rãi và công nghệ trợ lái ADAS đỉnh cao.',
                'sort_order' => 5,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 8',
                'slug' => 'vinfast-vf-8',
                'sku' => 'VF8-ECO',
                'regular_price' => 850000000,
                'sale_price' => 850000000,
                'price_on_request' => false,
                'short_description' => 'D-SUV điện toàn cầu đẳng cấp, hiệu suất vận hành vượt trội và tiện nghi chuẩn sang.',
                'sort_order' => 6,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 8 All New',
                'slug' => 'vinfast-vf8-all-new',
                'sku' => 'VF8-ALLNEW',
                'regular_price' => 899000000,
                'sale_price' => 899000000,
                'price_on_request' => false,
                'short_description' => 'Phiên bản nâng cấp toàn diện thế hệ mới với nội thất bọc da cao cấp và trợ lý ảo thông minh.',
                'sort_order' => 7,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 9',
                'slug' => 'vinfast-vf-9',
                'sku' => 'VF9-ECO',
                'regular_price' => 1348000000,
                'sale_price' => 1348000000,
                'price_on_request' => false,
                'short_description' => 'E-SUV 7 chỗ cỡ lớn biểu tượng vị thế lãnh đạo, khoang thương gia tiện ích tối tân.',
                'sort_order' => 8,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF Wild',
                'slug' => 'vinfast-vf-wild',
                'sku' => 'VF-WILD',
                'regular_price' => 860000000,
                'sale_price' => 860000000,
                'price_on_request' => true,
                'short_description' => 'Mẫu xe bán tải điện đầu tiên của VinFast với thiết kế phóng khoáng và mạnh mẽ.',
                'sort_order' => 9,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF MPV 7',
                'slug' => 'vinfast-vf-mpv-7',
                'sku' => 'VF-MPV7',
                'regular_price' => 750000000,
                'sale_price' => 750000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu MPV 7 chỗ chuyên dụng, tối ưu hóa không gian cho gia đình và kinh doanh vận tải.',
                'sort_order' => 10,
                'featured' => false,
            ],
            // Nhóm xe dịch vụ xanh Green Series
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Minio Green',
                'slug' => 'vinfast-minio-green',
                'sku' => 'MINIO-GRN',
                'regular_price' => 188000000,
                'sale_price' => 188000000,
                'price_on_request' => false,
                'short_description' => 'Xe đô thị siêu tiết kiệm nhiên liệu chuyên phục vụ đưa đón và dịch vụ xanh.',
                'sort_order' => 11,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Herio Green',
                'slug' => 'vinfast-herio-green',
                'sku' => 'HERIO-GRN',
                'regular_price' => 450000000,
                'sale_price' => 450000000,
                'price_on_request' => false,
                'short_description' => 'Dòng xe kinh doanh dịch vụ bền bỉ, chi phí bảo dưỡng gần như bằng 0.',
                'sort_order' => 12,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Nerio Green',
                'slug' => 'vinfast-nerio-green',
                'sku' => 'NERIO-GRN',
                'regular_price' => 628000000,
                'sale_price' => 628000000,
                'price_on_request' => false,
                'short_description' => 'Dòng sedan xanh chuyên nghiệp cho đội xe dịch vụ công nghệ và đưa đón cao cấp.',
                'sort_order' => 13,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Limo Green',
                'slug' => 'vinfast-limo-green',
                'sku' => 'LIMO-GRN',
                'regular_price' => 699000000,
                'sale_price' => 699000000,
                'price_on_request' => false,
                'short_description' => 'Giải pháp vận tải hành khách VIP cao cấp thuần điện tiêu chuẩn 5 sao.',
                'sort_order' => 14,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast EC Van',
                'slug' => 'vinfast-ec-van',
                'sku' => 'EC-VAN',
                'regular_price' => 268000000,
                'sale_price' => 268000000,
                'price_on_request' => false,
                'short_description' => 'Xe van tải hàng thuần điện đô thị không lo cấm giờ, thể tích thùng hàng lớn.',
                'sort_order' => 15,
                'featured' => false,
            ],
        ];

        foreach ($cars as $car) {
            DB::table('products')->updateOrInsert(
                ['slug' => $car['slug']],
                array_merge($car, [
                    'status' => 'published',
                    'published_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }
}
