<?php

namespace Tests\Feature;

use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
    }

    /**
     * Kiểm tra trang chủ hiển thị thành công với đầy đủ dữ liệu xe.
     */
    public function test_home_page_displays_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('VINFAST HẢI PHÒNG');
        $response->assertSee('VinFast VF 3');
        $response->assertSee('VinFast VF 5 Plus');
        $response->assertSee('VinFast VF 8 All New');
        $response->assertSee('0966.597.282');
    }

    /**
     * Kiểm tra gửi form báo giá lăn bánh thành công.
     */
    public function test_customer_can_submit_quote_request(): void
    {
        $payload = [
            'type' => 'quote',
            'name' => 'Trần Văn Khách',
            'phone' => '0912345678',
            'registration_area' => 'Hải Phòng',
            'message' => 'Tư vấn xe VinFast VF 3',
        ];

        $response = $this->post(route('client.leads.store'), $payload);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('leads', [
            'name' => 'Trần Văn Khách',
            'phone' => '0912345678',
            'status' => 'new',
        ]);
        $this->assertDatabaseHas('consent_records', [
            'type' => 'data_processing',
        ]);
    }
}
