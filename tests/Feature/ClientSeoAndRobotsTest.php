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
            '/blogs?tracking=2',
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
        $catalogResponse->assertSee('<meta name="robots" content="noindex, follow">', false);
        $catalogResponse->assertSee('<link rel="canonical" href="'.route('client.catalog.index').'">', false);

        // 2. Blog filtered
        $blogResponse = $this->get('/blogs?category=danh-gia-xe');
        $blogResponse->assertOk();
        $blogResponse->assertSee('<meta name="robots" content="noindex, follow">', false);
        $blogResponse->assertSee('<link rel="canonical" href="'.route('client.posts.index').'">', false);

        // 3. Home with tracking
        $homeResponse = $this->get('/?utm_source=google');
        $homeResponse->assertOk();
        $homeResponse->assertSee('<meta name="robots" content="noindex, follow">', false);
        $homeResponse->assertSee('<link rel="canonical" href="'.route('client.home').'/">', false);

        // 4. Product with tracking
        $productResponse = $this->get('/xe/vinfast-vf-3?ref=social');
        $productResponse->assertOk();
        $productResponse->assertSee('<meta name="robots" content="noindex, follow">', false);
        $productResponse->assertSee('<link rel="canonical" href="'.route('client.products.show', 'vinfast-vf-3').'">', false);
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

    public function test_robots_txt_leaves_noindex_pages_crawlable_and_provides_sitemap(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringNotContainsString('Disallow: /admin/', $content);
        $this->assertStringNotContainsString('Disallow: /dat-hang-thanh-cong/', $content);
        $this->assertStringNotContainsString('Disallow: /thanh-toan', $content);
        $this->assertStringNotContainsString('Disallow: /dat-coc-ngay', $content);
        $this->assertStringNotContainsString('Disallow: /gio-hang', $content);
        $this->assertStringContainsString('Disallow: /api/', $content);
        $this->assertStringContainsString('Sitemap: https://vinfast-autohaiphong.com.vn/sitemap.xml', $content);
    }

    public function test_query_parameter_urls_are_noindex_follow_with_clean_canonical_urls(): void
    {
        $this->get('/?utm_source=campaign')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false)
            ->assertSee('<link rel="canonical" href="'.route('client.home').'/">', false)
            ->assertSee('property="og:url" content="'.route('client.home').'/"', false)
            ->assertHeader('X-Robots-Tag', 'noindex, follow');

        $this->get('/o-to-vinfast?sort=price_asc&category=o-to-dien-du-lich')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false)
            ->assertSee('<link rel="canonical" href="'.route('client.catalog.index').'">', false)
            ->assertSee('property="og:url" content="'.route('client.catalog.index').'"', false);

        $this->get('/xe/vinfast-vf-3?ref=tracking')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, follow">', false)
            ->assertSee('<link rel="canonical" href="'.route('client.products.show', 'vinfast-vf-3').'">', false)
            ->assertSee('property="og:url" content="'.route('client.products.show', 'vinfast-vf-3').'"', false);
    }

    public function test_private_and_admin_pages_are_noindex_nofollow(): void
    {
        $this->get('/gio-hang')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');

        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_blog_pagination_uses_clean_indexable_page_urls(): void
    {
        foreach (range(1, 8) as $index) {
            DB::table('posts')->insert([
                'title' => 'Bài viết kiểm tra phân trang '.$index,
                'slug' => 'bai-viet-kiem-tra-phan-trang-'.$index,
                'excerpt' => 'Thông tin cập nhật xe điện tại Hải Phòng.',
                'content_html' => '<p>Nội dung bài viết kiểm tra phân trang.</p>',
                'status' => 'published',
                'published_at' => now()->subMinutes($index),
                'created_at' => now()->subMinutes($index),
                'updated_at' => now()->subMinutes($index),
            ]);
        }

        $this->get('/blogs')
            ->assertOk()
            ->assertSee('/blogs/page/2', false)
            ->assertDontSee('/blogs?page=2', false);

        $response = $this->get('/blogs/page/2');
        $response->assertOk();
        $response->assertSee('<meta name="robots" content="index, follow', false);
        $this->assertStringContainsString('/blogs/page/2', $response->getContent());
    }

    public function test_pagination_urls_beyond_available_pages_return_noindex_404_responses(): void
    {
        $this->get('/o-to-vinfast/page/999')
            ->assertNotFound()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');

        $this->get('/blogs/page/999')
            ->assertNotFound()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_rendered_public_pages_have_titles_descriptions_and_canonical_links(): void
    {
        $urls = [
            '/',
            '/o-to-vinfast',
            '/xe/vinfast-vf-3',
            '/blogs',
            '/blog/vinfast-vf-3-xe-dien-do-thi-hai-phong',
            '/lien-he',
            '/pin-va-tram-sac',
            '/trai-nghiem-khach-hang',
            '/chinh-sach',
            '/chinh-sach-thanh-toan',
            '/chinh-sach-bao-mat',
            '/chinh-sach-bao-hanh',
            '/dieu-khoan-su-dung',
            '/so-do-trang-web',
        ];
        $titles = [];

        foreach ($urls as $url) {
            $response = $this->get($url);
            $response->assertOk();
            $html = $response->getContent();

            $this->assertSame(1, preg_match('/<title>([^<]+)<\/title>/u', $html, $titleMatch), $url.' should have a title.');
            $this->assertNotSame('', trim(html_entity_decode($titleMatch[1])), $url.' should have a non-empty title.');
            $this->assertSame(1, preg_match('/<meta name="description" content="([^"]+)"/u', $html, $descriptionMatch), $url.' should have a description.');
            $this->assertNotSame('', trim(html_entity_decode($descriptionMatch[1])), $url.' should have a non-empty description.');
            $this->assertSame(1, preg_match('/<link rel="canonical" href="([^"]+)"/u', $html, $canonicalMatch), $url.' should have a canonical URL.');
            $this->assertStringStartsWith('http', $canonicalMatch[1]);
            $titles[] = html_entity_decode($titleMatch[1]);
        }

        $this->assertCount(count($titles), array_unique($titles));
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
