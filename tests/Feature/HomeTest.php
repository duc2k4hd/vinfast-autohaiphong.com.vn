<?php

namespace Tests\Feature;

use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
        $response->assertSee('VinFast Hải Phòng');
        $response->assertSee('VinFast VF 3');
        $response->assertSee('VinFast VF 5 Plus');
        $response->assertSee('VinFast VF 8 All New');
        $response->assertSee('0988 302 882');
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

    public function test_vehicle_menu_shows_only_available_cars_with_images(): void
    {
        DB::table('products')->where('slug', 'vinfast-vf-3')->update(['status' => 'draft']);
        DB::table('products')->where('slug', 'vinfast-vf-6')->update(['published_at' => now()->addDay()]);
        DB::table('products')->where('slug', 'vinfast-vf-7')->update(['deleted_at' => now()]);

        $response = $this->get(route('client.home'));

        $response->assertOk();
        $response->assertSee('data-vf-cars-toggle', false);
        $response->assertSee('clients/assets/images/products/vinfast-vf-5.webp');
        $html = $response->getContent();
        $menu = substr($html, strpos($html, 'id="vf-cars-dropdown"'));
        $menu = substr($menu, 0, strpos($menu, '</li>'));
        $this->assertStringContainsString('/xe/vinfast-vf-5', $menu);
        $this->assertStringNotContainsString('/xe/vinfast-vf-3', $menu);
        $this->assertStringNotContainsString('/xe/vinfast-vf-6', $menu);
        $this->assertStringNotContainsString('/xe/vinfast-vf-7', $menu);
    }
}
