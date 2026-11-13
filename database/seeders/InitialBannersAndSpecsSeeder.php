<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialBannersAndSpecsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. Cập nhật Banners từ tài nguyên ảnh thực tế
        Schema::disableForeignKeyConstraints();
        DB::table('banners')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('banners')->insert([
            [
                'name' => 'Banner VinFast VF Wild',
                'position' => 'home_hero',
                'title' => 'VinFast VF Wild — Định Hình Phong Cách Bán Tải Điện Tương Lai',
                'subtitle' => 'Thiết kế đột phá, công nghệ thông minh, trải nghiệm tự do trên mọi cung đường.',
                'cta_text' => 'Khám Phá VF Wild',
                'cta_url' => '/xe/vinfast-vf-wild',
                'desktop_media_id' => null,
                'mobile_media_id' => null,
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Banner Vì Tương Lai Xanh',
                'position' => 'home_hero',
                'title' => 'Cùng VinFast Kiến Tạo Tương Lai Xanh Tại Hải Phòng',
                'subtitle' => 'Chính sách ưu đãi lệ phí trước bạ 0%, miễn phí sạc pin và hỗ trợ trả góp lãi suất thấp.',
                'cta_text' => 'Xem Các Dòng Xe',
                'cta_url' => '/o-to-vinfast',
                'desktop_media_id' => null,
                'mobile_media_id' => null,
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Banner Đại Lý Minh Đạo',
                'position' => 'home_hero',
                'title' => 'Showroom VinFast Minh Đạo — Số 1 Bạch Đằng, Hải Phòng',
                'subtitle' => 'Đại lý ủy quyền 3S chuẩn quốc tế: Bán hàng, Dịch vụ bảo dưỡng và Phụ tùng chính hãng.',
                'cta_text' => 'Liên Hệ Showroom',
                'cta_url' => '/lien-he',
                'desktop_media_id' => null,
                'mobile_media_id' => null,
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // 2. Nạp thông số kỹ thuật chuẩn hóa Key - Value
        $cars = DB::table('products')->pluck('id', 'slug');

        $specsMap = [
            'vinfast-vf-2' => [
                'Số chỗ ngồi' => '2 chỗ',
                'Quãng đường di chuyển (NEDC)' => '180 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => 'Khoảng 30 phút',
                'Công suất tối đa' => '28 kW',
                'Mô-men xoắn cực đại' => '90 Nm',
                'Kích thước tổng thể' => '2.950 x 1.490 x 1.550 mm',
                'Thời hạn bảo hành' => '7 năm hoặc 160.000 km',
                'Hệ dẫn động' => 'Cầu sau (RWD)',
            ],
            'vinfast-vf-3' => [
                'Số chỗ ngồi' => '4 chỗ',
                'Quãng đường di chuyển (NEDC)' => '210 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => 'Khoảng 36 phút',
                'Công suất tối đa' => '32 kW (43 hp)',
                'Mô-men xoắn cực đại' => '110 Nm',
                'Dung lượng pin khả dụng' => '18.64 kWh',
                'Dài x Rộng x Cao' => '3.190 x 1.679 x 1.622 mm',
                'Chiều dài cơ sở' => '2.075 mm',
                'Khoảng sáng gầm xe' => '191 mm',
                'Thời hạn bảo hành' => '7 năm hoặc 160.000 km',
            ],
            'vinfast-vf-5' => [
                'Số chỗ ngồi' => '5 chỗ',
                'Quãng đường di chuyển (NEDC)' => '326 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => '30 phút',
                'Công suất tối đa' => '100 kW (134 hp)',
                'Mô-men xoắn cực đại' => '135 Nm',
                'Dung lượng pin khả dụng' => '37.23 kWh',
                'Dài x Rộng x Cao' => '3.967 x 1.723 x 1.578 mm',
                'Chiều dài cơ sở' => '2.514 mm',
                'Khoảng sáng gầm xe' => '168 mm',
                'Thời hạn bảo hành' => '7 năm hoặc 160.000 km',
            ],
            'vinfast-vf-6' => [
                'Số chỗ ngồi' => '5 chỗ',
                'Quãng đường di chuyển (WLTP)' => '399 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => '25 phút',
                'Công suất tối đa' => '150 kW (201 hp)',
                'Mô-men xoắn cực đại' => '310 Nm',
                'Dung lượng pin khả dụng' => '59.6 kWh',
                'Dài x Rộng x Cao' => '4.238 x 1.820 x 1.594 mm',
                'Chiều dài cơ sở' => '2.730 mm',
                'Màn hình giải trí' => 'Cảm ứng 12.9 inch',
                'Thời hạn bảo hành' => '7 năm hoặc 160.000 km',
            ],
            'vinfast-vf-7' => [
                'Số chỗ ngồi' => '5 chỗ',
                'Quãng đường di chuyển (WLTP)' => '431 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => '24 phút',
                'Công suất tối đa' => '260 kW (349 hp) - Bản Plus',
                'Mô-men xoắn cực đại' => '500 Nm',
                'Dung lượng pin khả dụng' => '75.3 kWh',
                'Dài x Rộng x Cao' => '4.545 x 1.890 x 1.635 mm',
                'Chiều dài cơ sở' => '2.840 mm',
                'Hệ dẫn động' => 'AWD (2 cầu toàn thời gian)',
                'Thời hạn bảo hành' => '10 năm hoặc 200.000 km',
            ],
            'vinfast-vf-8' => [
                'Số chỗ ngồi' => '5 chỗ',
                'Quãng đường di chuyển (WLTP)' => '471 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => '24 phút',
                'Công suất tối đa' => '300 kW (402 hp)',
                'Mô-men xoắn cực đại' => '620 Nm',
                'Dung lượng pin khả dụng' => '87.7 kWh',
                'Dài x Rộng x Cao' => '4.750 x 1.934 x 1.667 mm',
                'Chiều dài cơ sở' => '2.950 mm',
                'Hệ thống trợ lái' => 'ADAS cấp độ 2',
                'Thời hạn bảo hành' => '10 năm hoặc 200.000 km',
            ],
            'vinfast-vf8-all-new' => [
                'Số chỗ ngồi' => '5 chỗ',
                'Quãng đường di chuyển (WLTP)' => '490 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => '22 phút',
                'Công suất tối đa' => '300 kW (402 hp)',
                'Mô-men xoắn cực đại' => '640 Nm',
                'Hệ thống treo' => 'Treo khí nén chủ động nâng hạ gầm',
                'Nội thất' => 'Da Nappa cao cấp sưởi/làm mát ghế',
                'Thời hạn bảo hành' => '10 năm hoặc 200.000 km',
            ],
            'vinfast-vf-9' => [
                'Số chỗ ngồi' => '6 hoặc 7 chỗ (Ghế cơ trưởng)',
                'Quãng đường di chuyển (WLTP)' => '626 km / lần sạc',
                'Thời gian sạc nhanh (10% - 70%)' => '26 phút',
                'Công suất tối đa' => '300 kW (402 hp)',
                'Mô-men xoắn cực đại' => '620 Nm',
                'Dung lượng pin khả dụng' => '123 kWh',
                'Dài x Rộng x Cao' => '5.118 x 2.254 x 1.696 mm',
                'Chiều dài cơ sở' => '3.150 mm',
                'Hệ thống giải trí' => 'Màn hình trung tâm 15.6 inch + Màn hình sau',
                'Thời hạn bảo hành' => '10 năm hoặc 200.000 km',
            ],
            'vinfast-vf-wild' => [
                'Phân khúc' => 'Bán tải điện thông minh cỡ trung',
                'Chiều dài tổng thể' => '5.324 mm',
                'Chiều rộng tổng thể' => '1.990 mm',
                'Tính năng khoang chứa' => 'Mở rộng thùng hàng linh hoạt gập hàng ghế sau',
                'Kính lái' => 'Kính toàn cảnh Panorama kéo dài nóc',
                'Hệ dẫn động' => '2 mô tơ điện AWD',
                'Thời hạn bảo hành' => '10 năm hoặc 200.000 km',
            ],
            'vinfast-vf-mpv-7' => [
                'Số chỗ ngồi' => '7 chỗ rộng rãi cho gia đình và dịch vụ',
                'Quãng đường di chuyển' => '420 km / lần sạc',
                'Thời gian sạc nhanh' => '30 phút',
                'Dài x Rộng x Cao' => '4.720 x 1.830 x 1.700 mm',
                'Cửa trượt' => 'Cửa trượt điện thông minh 2 bên',
                'Thời hạn bảo hành' => '7 năm hoặc 160.000 km',
            ],
            'vinfast-minio-green' => [
                'Phân khúc' => 'Xe đô thị siêu nhỏ gọn thế hệ xanh',
                'Số chỗ ngồi' => '2 - 4 chỗ linh hoạt',
                'Quãng đường di chuyển' => '170 km / lần sạc',
                'Thời gian sạc nhanh' => '25 phút',
                'Tiện ích' => 'Dễ dàng xoay xở trong ngõ nhỏ nội đô',
                'Thời hạn bảo hành' => '5 năm hoặc 100.000 km',
            ],
            'vinfast-herio-green' => [
                'Phân khúc' => 'Xe điện hatchback nhỏ gọn đô thị',
                'Số chỗ ngồi' => '4 chỗ',
                'Quãng đường di chuyển' => '200 km / lần sạc',
                'Động cơ' => 'Thuần điện êm ái, tiết kiệm tối đa chi phí vận hành',
                'Thời hạn bảo hành' => '7 năm hoặc 160.000 km',
            ],
            'vinfast-nerio-green' => [
                'Phân khúc' => 'Crossover đô thị thông minh',
                'Số chỗ ngồi' => '5 chỗ',
                'Quãng đường di chuyển' => '350 km / lần sạc',
                'Trang bị an toàn' => 'Camera lùi, cảm biến va chạm, cân bằng điện tử',
                'Thời hạn bảo hành' => '7 năm hoặc 160.000 km',
            ],
            'vinfast-limo-green' => [
                'Phân khúc' => 'MPV / Limousine điện thương gia hạng sang',
                'Số chỗ ngồi' => '7 chỗ (Ghế cơ trưởng VIP bọc da, massage)',
                'Quãng đường di chuyển' => '500 km / lần sạc',
                'Tiện nghi VIP' => 'Tủ lạnh mini, sạc không dây từng vị trí, rèm che nắng',
                'Thời hạn bảo hành' => '10 năm hoặc 200.000 km',
            ],
            'vinfast-ec-van' => [
                'Phân khúc' => 'Xe tải Van vận chuyển hàng hóa nội đô xanh',
                'Số chỗ ngồi' => '2 chỗ ngồi khoang lái',
                'Tải trọng chở hàng' => '500 kg - 850 kg',
                'Thể tích thùng xe' => 'Hơn 4.5 m3',
                'Quãng đường di chuyển' => '220 km / lần sạc',
                'Ưu thế' => 'Lưu thông 24/7 nội thành không lo giờ cấm tải',
                'Thời hạn bảo hành' => '5 năm hoặc 150.000 km',
            ],
        ];

        Schema::disableForeignKeyConstraints();
        DB::table('product_specifications')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($specsMap as $slug => $specs) {
            if (! isset($cars[$slug])) {
                continue;
            }

            $productId = $cars[$slug];
            $order = 1;

            foreach ($specs as $label => $value) {
                DB::table('product_specifications')->insert([
                    'product_id' => $productId,
                    'group_id' => null,
                    'label' => $label,
                    'value' => $value,
                    'unit' => null,
                    'sort_order' => $order++,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
