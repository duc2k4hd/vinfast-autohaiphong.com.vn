<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialPostsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientContentPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialPostsSeeder::class);
    }

    public function test_can_view_charging_stations_page(): void
    {
        $response = $this->get('/pin-va-tram-sac');
        $response->assertStatus(200);
        $response->assertSee('HẠ TẦNG TRẠM SẠC VINFAST HẢI PHÒNG');
        $response->assertSee('Ước tính chi phí');
        $response->assertSee('battery-capacity');
        $response->assertSee('https://vgreen.net/');
        $response->assertSee('Chưa tính hao hụt');
        $response->assertSee('Showroom VinFast Hải Phòng');
        $response->assertSee('vinfastauto.com/vn/phu-kien-va-dich-vu-khac/he-thong-showroom-va-tram-sac');
        $response->assertSee('FAQPage');
        $response->assertSee('BreadcrumbList');
    }

    public function test_admin_can_update_charging_page_settings_and_client_reflects(): void
    {
        $this->seed(InitialAdminUserSeeder::class);
        $admin = User::where('email', 'admin@vinfast-autohaiphong.com.vn')->firstOrFail();

        $updatePayload = [
            'charging_hero_title' => 'TRẠM SẠC CHÍNH HÃNG HẢI PHÒNG 2026',
            'charging_hero_banner' => 'clients/assets/images/banners/banner-custom-hero.webp',
            'charging_hero_desc' => 'Mạng lưới sạc xe điện thông minh hàng đầu tại Hải Phòng.',
            'charging_img_station_minhdao' => 'clients/assets/images/stations/minh-dao-custom.webp',
        ];

        $this->actingAs($admin)
            ->put(route('admin.settings.update'), $updatePayload)
            ->assertRedirect();

        $clientResponse = $this->get('/pin-va-tram-sac');
        $clientResponse->assertStatus(200);
        $clientResponse->assertSee('TRẠM SẠC CHÍNH HÃNG HẢI PHÒNG 2026');
        $clientResponse->assertSee('banner-custom-hero.webp');
        $clientResponse->assertSee('Mạng lưới sạc xe điện thông minh hàng đầu tại Hải Phòng.');
        $clientResponse->assertSee('minh-dao-custom.webp');
    }

    public function test_can_view_customer_experience_page(): void
    {
        $response = $this->get('/trai-nghiem-khach-hang');
        $response->assertStatus(200);
        $response->assertSee('TRẢI NGHIỆM KHÁCH HÀNG');
    }

    public function test_can_view_posts_and_single_post(): void
    {
        // 1. Trang danh sách tin tức /blogs
        $response = $this->get('/blogs');
        $response->assertStatus(200);
        $response->assertSee('TIN TỨC & BÀI VIẾT VINFAST');
        $response->assertSee('Tất cả bài viết');

        // 2. Trang chi tiết bài viết /blog/{slug}
        $singleResponse = $this->get('/blog/vinfast-vf-3-xe-dien-do-thi-hai-phong');
        $singleResponse->assertStatus(200);
        $singleResponse->assertSee('VinFast VF 3 — Mẫu Xe Điện Đô Thị Gây Sốt');

        // 3. Lọc bài viết theo danh mục qua query param /blogs?category=
        $catResponse = $this->get('/blogs?category=danh-gia-xe');
        $catResponse->assertStatus(200);
        $catResponse->assertSee('VinFast VF 3 — Mẫu Xe Điện Đô Thị Gây Sốt');

        // 4. Redirect 301 từ đường dẫn cũ sang slug mới
        $legacyIndex = $this->get('/chuyen-muc/tin-tuc');
        $legacyIndex->assertStatus(301);
        $legacyIndex->assertRedirect('/blogs');

        $legacyShow = $this->get('/chuyen-muc/tin-tuc/vinfast-vf-3-xe-dien-do-thi-hai-phong');
        $legacyShow->assertStatus(301);
        $legacyShow->assertRedirect('/blog/vinfast-vf-3-xe-dien-do-thi-hai-phong');
    }

    public function test_can_view_contact_and_submit_message(): void
    {
        $response = $this->get('/lien-he');
        $response->assertStatus(200);
        $response->assertSee('0988 302 882');
        $response->assertSee('0915 286 506');

        $postResponse = $this->post('/lien-he', [
            'name' => 'Khách Hàng Test',
            'phone' => '0988302882',
            'email' => 'test@example.com',
            'subject' => 'Tư vấn VF 6',
            'message' => 'Tôi muốn hỏi thủ tục lái thử VF 6 tại nhà',
        ]);

        $postResponse->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Khách Hàng Test',
            'phone' => '0988302882',
        ]);
    }

    public function test_can_view_policy_pages(): void
    {
        $this->get('/chinh-sach-thanh-toan')->assertStatus(200)->assertSee('CHÍNH SÁCH THANH TOÁN');
        $this->get('/chinh-sach-bao-mat')->assertStatus(200)->assertSee('CHÍNH SÁCH BẢO MẬT THÔNG TIN');
        $this->get('/chinh-sach-bao-hanh')->assertStatus(200)->assertSee('CHÍNH SÁCH BẢO HÀNH CHÍNH HÃNG');
        $this->get('/dieu-khoan-su-dung')->assertStatus(200)->assertSee('ĐIỀU KHOẢN SỬ DỤNG WEBSITE');
    }
}
