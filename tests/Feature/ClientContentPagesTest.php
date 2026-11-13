<?php

namespace Tests\Feature;

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
    }

    public function test_can_view_customer_experience_page(): void
    {
        $response = $this->get('/trai-nghiem-khach-hang');
        $response->assertStatus(200);
        $response->assertSee('TRẢI NGHIỆM KHÁCH HÀNG');
    }

    public function test_can_view_posts_and_single_post(): void
    {
        $response = $this->get('/chuyen-muc/tin-tuc');
        $response->assertStatus(200);
        $response->assertSee('TIN TỨC');
        $response->assertSee('SỰ KIỆN VINFAST');

        $singleResponse = $this->get('/chuyen-muc/tin-tuc/vinfast-vf-3-xe-dien-do-thi-hai-phong');
        $singleResponse->assertStatus(200);
        $singleResponse->assertSee('VinFast VF 3 — Mẫu Xe Điện Đô Thị Gây Sốt');
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
