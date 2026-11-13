<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialProductVariantsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientSitemapAndVariantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialAdminUserSeeder::class);
        $this->seed(InitialCarsSeeder::class);
        $this->seed(InitialProductVariantsSeeder::class);
    }

    public function test_client_can_access_html_sitemap(): void
    {
        $response = $this->get(route('client.sitemap.html'));

        $response->assertStatus(200);
        $response->assertSee('SƠ ĐỒ TRANG WEB (HTML SITEMAP)');
        $response->assertSee('DÒNG XE Ô TÔ VINFAST');
        $response->assertSee('VinFast VF 3');
    }

    public function test_client_can_view_product_detail_with_interactive_variants(): void
    {
        $car = Product::where('slug', 'vinfast-vf-3')->first();
        $this->assertNotNull($car);

        $response = $this->get(route('client.products.show', $car->slug));

        $response->assertStatus(200);
        $response->assertSee('Chọn Phiên Bản');
        $response->assertSee('Bản Thuê Pin');
        $response->assertSee('Bản Kèm Pin');
        $response->assertSee('vf-selected-variant-label');
        $response->assertSee('vf-car-price-display');
    }
}
