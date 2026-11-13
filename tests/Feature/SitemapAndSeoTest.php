<?php

namespace Tests\Feature;

use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialPostsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapAndSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
        $this->seed(InitialPostsSeeder::class);
    }

    public function test_sitemap_xml_returns_valid_response(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<loc>', false);
        $response->assertSee('/xe/vinfast-vf-3', false);
        $response->assertSee('/chuyen-muc/tin-tuc', false);
    }

    public function test_home_page_contains_autodealer_json_ld_schema(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('"@type": "AutoDealer"', false);
        $response->assertSee('Số 1 Bạch Đằng', false);
    }

    public function test_car_detail_page_contains_vehicle_json_ld_schema(): void
    {
        $response = $this->get('/xe/vinfast-vf-3');

        $response->assertStatus(200);
        $response->assertSee('"@type": "Car"', false);
        $response->assertSee('"brand"', false);
        $response->assertSee('"priceCurrency": "VND"', false);
    }
}

