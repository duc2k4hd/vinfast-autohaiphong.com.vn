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
        $response->assertSee('/blogs', false);
        $response->assertSee('/blog/', false);
    }

    public function test_home_page_contains_autodealer_json_ld_schema(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('"@type": "AutoDealer"', false);
        $response->assertSee('Lê Hồng Phong', false);
        $response->assertSee('<meta property="og:locale" content="vi_VN">', false);
        $response->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
    }

    public function test_autodealer_schema_uses_visible_settings_and_safely_encodes_script_content(): void
    {
        $settings = [
            'site_name' => '</script><script>alert("name")</script>',
            'site_phone' => '0123 456 789',
            'site_address' => '42 Test Street & "Showroom"',
        ];
        view()->share('siteSettings', $settings);

        $response = $this->get('/');

        $response->assertOk();
        $html = $response->getContent();
        $this->assertStringNotContainsString($settings['site_name'], $html);
        $this->assertSame(1, preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches));
        $schema = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('AutoDealer', $schema['@type']);
        $this->assertSame($settings['site_name'], $schema['name']);
        $this->assertSame($settings['site_phone'], $schema['telephone']);
        $this->assertSame('PostalAddress', $schema['address']['@type']);
        $this->assertSame($settings['site_address'], $schema['address']['streetAddress']);
        $this->assertArrayNotHasKey('priceRange', $schema);
        $this->assertArrayNotHasKey('paymentAccepted', $schema);
        $response->assertSee($settings['site_address']);
        $response->assertSee($settings['site_phone']);
    }

    public function test_car_detail_page_contains_vehicle_json_ld_schema(): void
    {
        $response = $this->get('/xe/vinfast-vf-3');

        $response->assertStatus(200);
        $response->assertSee('"@type": "Car"', false);
        $response->assertSee('"brand"', false);
        $response->assertSee('"priceCurrency": "VND"', false);
    }

    public function test_robots_txt_allows_crawlers_to_read_private_page_noindex_directives(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertDontSee('Disallow: /admin/');
        $response->assertDontSee('Disallow: /dat-hang-thanh-cong/');
        $response->assertSee('Disallow: /api/');
        $response->assertSee('Sitemap: https://vinfast-autohaiphong.com.vn/sitemap.xml');
    }
}
