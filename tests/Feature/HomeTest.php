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

    public function test_homepage_displays_real_vehicle_data_and_safe_quote_controls(): void
    {
        $name = 'VF "Special" & O\'Brien';
        DB::table('products')->where('slug', 'vinfast-vf-3')->update([
            'name' => $name,
            'sale_price' => 123000000,
            'price_on_request' => false,
        ]);
        DB::table('posts')->insert([
            'title' => 'Tin mới từ showroom',
            'slug' => 'tin-moi-tu-showroom',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('client.home'));

        $response->assertOk()
            ->assertSee('Cùng VinFast Hải Phòng tìm chiếc xe phù hợp.')
            ->assertSee('123.000.000 VNĐ')
            ->assertSee('Tin mới từ showroom')
            ->assertSee('id="home-search"', false)
            ->assertSee('id="home-sort"', false);

        $document = new \DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8" ?>'.$response->getContent());
        $xpath = new \DOMXPath($document);
        $headings = $xpath->query('//h1');
        $this->assertCount(1, $headings);
        $this->assertStringContainsString('VinFast Hải Phòng', $headings->item(0)->textContent);
        $buttons = $xpath->query('//button[@data-car-name]');
        $quoteButton = null;
        foreach ($buttons as $button) {
            if ($button->getAttribute('data-car-name') === $name) {
                $quoteButton = $button;
                break;
            }
        }
        $this->assertNotNull($quoteButton);
        $this->assertStringContainsString('this.dataset.carName', $quoteButton->getAttribute('onclick'));
    }

    public function test_homepage_comparison_contains_current_prices_and_product_links(): void
    {
        DB::table('products')->where('slug', 'vinfast-vf-3')->update([
            'sale_price' => 123000000,
            'price_on_request' => false,
        ]);
        DB::table('products')->where('slug', 'vinfast-vf-5')->update([
            'price_on_request' => true,
        ]);

        $response = $this->get(route('client.home'))->assertOk();
        $document = new \DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8" ?>'.$response->getContent());
        $xpath = new \DOMXPath($document);
        foreach ([1, 2] as $number) {
            $options = $xpath->query('//select[@id="home-compare-'.$number.'"]/option[@data-url]');
            $prices = [];
            foreach ($options as $option) {
                $prices[$option->getAttribute('data-url')] = $option->getAttribute('data-price');
            }
            $this->assertSame('123.000.000 VNĐ', $prices[route('client.products.show', 'vinfast-vf-3')]);
            $this->assertSame('Liên hệ báo giá', $prices[route('client.products.show', 'vinfast-vf-5')]);
        }
        $this->assertCount(1, $xpath->query('//noscript[contains(., "JavaScript")]'));
        $this->assertCount(1, $xpath->query('//div[@id="home-comparison"][@aria-live="polite"]'));
    }

    public function test_homepage_has_honest_empty_states_when_no_vehicles_or_posts_exist(): void
    {
        DB::table('products')->update(['status' => 'draft']);
        DB::table('posts')->update(['status' => 'draft']);

        $this->get(route('client.home'))
            ->assertOk()
            ->assertSee('Thông tin dòng xe đang được cập nhật')
            ->assertDontSee('id="home-search"', false)
            ->assertDontSee('Thông tin mới nhất.');
    }
}
