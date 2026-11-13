<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Cấu hình chung & Liên hệ (Công khai ra Client)
            [
                'key' => 'site_name',
                'group' => 'general',
                'type' => 'string',
                'value' => 'VinFast Hải Phòng',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Tên thương hiệu website',
            ],
            [
                'key' => 'site_phone',
                'group' => 'contact',
                'type' => 'string',
                'value' => '0966.597.282',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Hotline bán hàng & tư vấn',
            ],
            [
                'key' => 'site_email',
                'group' => 'contact',
                'type' => 'string',
                'value' => 'kinhdoanh@vinfast-haiphong.com',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Email liên hệ kinh doanh',
            ],
            [
                'key' => 'site_address',
                'group' => 'contact',
                'type' => 'string',
                'value' => 'Số 1 Bạch Đằng, Phường Thượng Lý, Quận Hồng Bàng, TP. Hải Phòng',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Địa chỉ showroom chính',
            ],
            [
                'key' => 'company_name',
                'group' => 'company',
                'type' => 'string',
                'value' => 'VinFast Minh Đạo Hải Phòng — Đại lý ủy quyền VinFast Việt Nam',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Tên pháp nhân công ty',
            ],
            [
                'key' => 'site_hours',
                'group' => 'contact',
                'type' => 'string',
                'value' => '08:00 - 18:00 (Thứ 2 - Chủ Nhật)',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Giờ mở cửa đón khách',
            ],
            [
                'key' => 'site_zalo',
                'group' => 'contact',
                'type' => 'string',
                'value' => 'https://zalo.me/0966597282',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Đường dẫn chat Zalo',
            ],
            [
                'key' => 'currency',
                'group' => 'commerce',
                'type' => 'string',
                'value' => 'VND',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Đơn vị tiền tệ chính',
            ],
            [
                'key' => 'cash_enabled',
                'group' => 'commerce',
                'type' => 'boolean',
                'value' => '1',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Thanh toán tiền mặt duy nhất',
            ],
            [
                'key' => 'seo_title',
                'group' => 'seo',
                'type' => 'string',
                'value' => 'VinFast Hải Phòng - Đại lý ủy quyền của VinFast Việt Nam',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Tiêu đề SEO trang chủ mặc định',
            ],
            [
                'key' => 'seo_description',
                'group' => 'seo',
                'type' => 'text',
                'value' => 'VinFast Hải Phòng chuyên cung cấp các dòng xe ô tô điện VinFast: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9... Giá tốt nhất, hỗ trợ trả góp 80%, lái thử tận nơi tại Hải Phòng.',
                'is_public' => true,
                'autoload' => true,
                'description' => 'Mô tả SEO trang chủ',
            ],
        ];

        $now = now();
        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }
}
