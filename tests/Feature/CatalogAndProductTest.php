<?php

namespace Tests\Feature;

use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogAndProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
    }

    /**
     * Kiểm tra truy cập trang danh mục xe thành công.
     */
    public function test_catalog_page_displays_successfully(): void
    {
        $response = $this->get(route('client.catalog.index'));

        $response->assertStatus(200);
        $response->assertSee('CÁC DÒNG XE Ô TÔ VINFAST');
        $response->assertSee('VinFast VF 3');
        $response->assertSee('VinFast VF 5 Plus');
    }

    /**
     * Kiểm tra lọc danh mục theo category slug.
     */
    public function test_catalog_can_filter_by_category(): void
    {
        $response = $this->get(route('client.catalog.index', ['category' => 'o-to-dien-du-lich']));

        $response->assertStatus(200);
        $response->assertSee('VinFast VF 3');
    }

    /**
     * Kiểm tra truy cập trang chi tiết xe ô tô VinFast thành công.
     */
    public function test_product_detail_page_displays_successfully(): void
    {
        $response = $this->get('/xe/vinfast-vf-3');

        $response->assertStatus(200);
        $response->assertSee('VinFast VF 3');
        $response->assertSee('285.000.000 VNĐ');
        $response->assertSee('YÊU CẦU BÁO GIÁ LĂN BÁNH');
        $response->assertSee('BẢNG THÔNG SỐ KỸ THUẬT XE VINFAST VF 3');
    }

    /**
     * Kiểm tra truy cập slug xe không tồn tại trả về 404.
     */
    public function test_product_detail_returns_404_when_not_found(): void
    {
        $response = $this->get('/xe/xe-khong-ton-tai-abc');

        $response->assertStatus(404);
    }
}
