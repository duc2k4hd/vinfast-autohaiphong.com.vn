<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InitialCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. Tạo 2 danh mục chính
        $catPassengerId = DB::table('product_categories')->updateOrInsert(
            ['slug' => 'o-to-dien-du-lich'],
            [
                'name' => 'Ô Tô Điện Du Lịch',
                'description' => 'Các dòng xe ô tô điện cá nhân và gia đình thông minh của VinFast',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $catPassengerId = DB::table('product_categories')->where('slug', 'o-to-dien-du-lich')->value('id');

        $catCommercialId = DB::table('product_categories')->updateOrInsert(
            ['slug' => 'xe-dich-vu-xanh'],
            [
                'name' => 'Xe Dịch Vụ & Vận Tải Xanh',
                'description' => 'Giải pháp phương tiện thuần điện tối ưu chi phí vận hành cho doanh nghiệp và dịch vụ',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $catCommercialId = DB::table('product_categories')->where('slug', 'xe-dich-vu-xanh')->value('id');

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
                'sku' => 'VF5-PLS',
                'regular_price' => 468000000,
                'sale_price' => 468000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV hạng A thông minh, tối ưu cho gia đình trẻ tại Hải Phòng.',
                'sort_order' => 3,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 6',
                'slug' => 'vinfast-vf-6',
                'sku' => 'VF6-STD',
                'regular_price' => 675000000,
                'sale_price' => 675000000,
                'price_on_request' => false,
                'short_description' => 'Tuyệt tác SUV điện hạng B với thiết kế châu Âu thanh lịch và công nghệ vượt trội.',
                'sort_order' => 4,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 7',
                'slug' => 'vinfast-vf-7',
                'sku' => 'VF7-STD',
                'regular_price' => 850000000,
                'sale_price' => 850000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV điện hạng C phong cách phi thuyền tương lai, cảm giác lái đỉnh cao.',
                'sort_order' => 5,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 8',
                'slug' => 'vinfast-vf-8',
                'sku' => 'VF8-STD',
                'regular_price' => 1079000000,
                'sale_price' => 1079000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV điện cỡ trung chuẩn toàn cầu với công nghệ trợ lái thông minh ADAS.',
                'sort_order' => 6,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 8 All New',
                'slug' => 'vinfast-vf8-all-new',
                'sku' => 'VF8-NEW',
                'regular_price' => 1129000000,
                'sale_price' => 1129000000,
                'price_on_request' => false,
                'short_description' => 'Phiên bản cải tiến toàn diện của mẫu SUV D-class sang trọng, êm ái hàng đầu.',
                'sort_order' => 7,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 9',
                'slug' => 'vinfast-vf-9',
                'sku' => 'VF9-STD',
                'regular_price' => 1566000000,
                'sale_price' => 1566000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV điện hạng E đầu bảng 7 chỗ hoặc ghế cơ trưởng VIP sang trọng đẳng cấp.',
                'sort_order' => 8,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF Wild',
                'slug' => 'vinfast-vf-wild',
                'sku' => 'WILD-PUP',
                'regular_price' => 0,
                'sale_price' => 0,
                'price_on_request' => true,
                'short_description' => 'Mẫu bán tải điện thông minh thế hệ mới, mở lối phong cách sống tự do.',
                'sort_order' => 9,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF MPV 7',
                'slug' => 'vinfast-vf-mpv-7',
                'sku' => 'MPV7-ELEC',
                'regular_price' => 790000000,
                'sale_price' => 790000000,
                'price_on_request' => false,
                'short_description' => 'Xe đa dụng 7 chỗ thuần điện rộng rãi, tiết kiệm chi phí tối đa cho gia đình.',
                'sort_order' => 10,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Minio Green',
                'slug' => 'vinfast-minio-green',
                'sku' => 'MINIO-GRN',
                'regular_price' => 239000000,
                'sale_price' => 239000000,
                'price_on_request' => false,
                'short_description' => 'Dòng xe siêu nhỏ gọn chuyên phục vụ giao hàng và dịch vụ đô thị không phát thải.',
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
            $relPath = 'clients/assets/images/products/'.$car['slug'].'.webp';

            // Tìm hoặc tạo media record cho xe
            $mediaId = DB::table('media')->where('path', $relPath)->value('id');
            if (! $mediaId) {
                $mediaId = DB::table('media')->insertGetId([
                    'uuid' => (string) Str::uuid(),
                    'folder_id' => null,
                    'disk' => 'public',
                    'filename' => $car['slug'].'.webp',
                    'original_filename' => $car['slug'].'.webp',
                    'extension' => 'webp',
                    'path' => $relPath,
                    'mime_type' => 'image/webp',
                    'file_size' => 25000,
                    'alt_text' => $car['name'].' tại VinFast Hải Phòng',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $relPath = 'clients/assets/images/products/' . $car['slug'] . '.webp';
            
            // Tìm hoặc tạo media record cho xe
            $mediaId = DB::table('media')->where('path', $relPath)->value('id');
            if (! $mediaId) {
                $mediaId = DB::table('media')->insertGetId([
                    'uuid' => (string) Str::uuid(),
                    'folder_id' => null,
                    'disk' => 'public',
                    'filename' => $car['slug'] . '.webp',
                    'original_filename' => $car['slug'] . '.webp',
                    'extension' => 'webp',
                    'path' => $relPath,
                    'mime_type' => 'image/webp',
                    'file_size' => 25000,
                    'alt_text' => $car['name'] . ' tại VinFast Hải Phòng',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('products')->updateOrInsert(
                ['slug' => $car['slug']],
                array_merge($car, [
                    'thumbnail_media_id' => $mediaId,
                    'status' => 'published',
                    'published_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }
}
