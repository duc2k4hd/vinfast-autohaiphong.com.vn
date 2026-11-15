<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialPostsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ClientSeoAndRobotsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
        $this->seed(InitialPostsSeeder::class);
    }

    public function test_clean_urls_have_index_follow_robots_meta(): void
    {
        $urls = [
            '/',
            '/o-to-vinfast',
            '/xe/vinfast-vf-3',
            '/blogs',
            '/blog/vinfast-vf-3-xe-dien-do-thi-hai-phong',
            '/lien-he',
            '/chinh-sach',
            '/chinh-sach-bao-hanh',
            '/chinh-sach-thanh-toan',
            '/chinh-sach-bao-mat',
            '/dieu-khoan-su-dung',
            '/pin-va-tram-sac',
            '/trai-nghiem-khach-hang',
            '/so-do-trang-web',
        ];

        foreach ($urls as $url) {
            $response = $this->get($url);
            $response->assertOk();
            $response->assertSee('<meta name="robots" content="index, follow', false);
        }
    }

    public function test_urls_with_query_parameters_have_noindex_follow_robots_meta(): void
    {
        $queryUrls = [
            '/blogs?category=danh-gia-xe',
            '/blogs?page=2',
            '/o-to-vinfast?sort=price_asc',
            '/o-to-vinfast?category=suv&sort=price_desc',
            '/?utm_source=facebook&utm_medium=cpc',
            '/lien-he?ref=google',
            '/pin-va-tram-sac?tab=map',
        ];

        foreach ($queryUrls as $url) {
            $response = $this->get($url);
            $response->assertOk();
            $response->assertSee('<meta name="robots" content="noindex, follow">', false);
            $response->assertDontSee('<meta name="robots" content="index, follow', false);
        }
    }

    public function test_canonical_urls_strip_query_parameters_to_prevent_duplicate_crawling(): void
    {
        // 1. Catalog filtered
        $catalogResponse = $this->get('/o-to-vinfast?sort=price_asc&category=suv');
        $catalogResponse->assertOk();
        $catalogResponse->assertSee('<link rel="canonical" href="'.route('client.catalog.index').'">', false);

        // 2. Blog filtered
        $blogResponse = $this->get('/blogs?category=danh-gia-xe');
        $blogResponse->assertOk();
        $blogResponse->assertSee('<link rel="canonical" href="'.url('/blogs').'">', false);

        // 3. Home with tracking
        $homeResponse = $this->get('/?utm_source=google');
        $homeResponse->assertOk();
        $homeResponse->assertSee('<link rel="canonical" href="'.route('client.home').'">', false);

        // 4. Product with tracking
        $productResponse = $this->get('/xe/vinfast-vf-3?ref=social');
        $productResponse->assertOk();
        $productResponse->assertSee('<link rel="canonical" href="'.url('/xe/vinfast-vf-3').'">', false);
    }

    public function test_private_checkout_and_cart_pages_have_noindex_nofollow(): void
    {
        $this->get('/gio-hang')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);

        $product = Product::first();
        $this->post('/gio-hang/them', ['product_id' => $product->id]);

        $this->get('/thanh-toan')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);

        DB::table('orders')->insert([
            'order_number' => 'TEST-SEO-12345',
            'customer_name' => 'Nguyễn Văn Test',
            'customer_phone' => '0988302882',
            'customer_email' => 'test@example.com',
            'subtotal' => 50000000,
            'discount_total' => 0,
            'total' => 50000000,
            'currency' => 'VND',
            'payment_method' => 'cash_at_showroom',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->get('/dat-hang-thanh-cong/TEST-SEO-12345')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);
    }

    public function test_robots_txt_disallows_private_routes_and_provides_sitemap(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('Disallow: /admin/', $content);
        $this->assertStringContainsString('Disallow: /dat-hang-thanh-cong/', $content);
        $this->assertStringContainsString('Disallow: /thanh-toan', $content);
        $this->assertStringContainsString('Disallow: /dat-coc-ngay', $content);
        $this->assertStringContainsString('Disallow: /gio-hang', $content);
        $this->assertStringContainsString('Sitemap: https://vinfast-autohaiphong.com.vn/sitemap.xml', $content);
    }

    public function test_all_pages_have_schema_structured_data(): void
    {
        // 1. AutoDealer schema on global layout
        $this->get('/')
            ->assertOk()
            ->assertSee('"@type": "AutoDealer"', false)
            ->assertSee('"@type": "WebSite"', false);

        // 2. Catalog
        $this->get('/o-to-vinfast')
            ->assertOk()
            ->assertSee('"@type": "ItemList"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 3. Product detail
        $this->get('/xe/vinfast-vf-3')
            ->assertOk()
            ->assertSee('"@type": "Car"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 4. Blogs
        $this->get('/blogs')
            ->assertOk()
            ->assertSee('"@type": "Blog"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 5. Blog detail
        $this->get('/blog/vinfast-vf-3-xe-dien-do-thi-hai-phong')
            ->assertOk()
            ->assertSee('"@type": "NewsArticle"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 6. Contact
        $this->get('/lien-he')
            ->assertOk()
            ->assertSee('"@type": "ContactPage"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 7. Policy Hub
        $this->get('/chinh-sach')
            ->assertOk()
            ->assertSee('"@type": "FAQPage"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 8. Warranty policy
        $this->get('/chinh-sach-bao-hanh')
            ->assertOk()
            ->assertSee('"@type": "FAQPage"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 9. Payment policy
        $this->get('/chinh-sach-thanh-toan')
            ->assertOk()
            ->assertSee('"@type": "WebPage"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 10. Privacy policy
        $this->get('/chinh-sach-bao-mat')
            ->assertOk()
            ->assertSee('"@type": "WebPage"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 11. Terms
        $this->get('/dieu-khoan-su-dung')
            ->assertOk()
            ->assertSee('"@type": "WebPage"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 12. Charging stations
        $this->get('/pin-va-tram-sac')
            ->assertOk()
            ->assertSee('"@type": "FAQPage"', false)
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 13. Customer experience
        $this->get('/trai-nghiem-khach-hang')
            ->assertOk()
            ->assertSee('"@type": "BreadcrumbList"', false);

        // 14. HTML sitemap
        $this->get('/so-do-trang-web')
            ->assertOk()
            ->assertSee('"@type": "BreadcrumbList"', false);
    }
}
