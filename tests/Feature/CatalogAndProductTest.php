<?php

namespace Tests\Feature;

use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    public function test_product_detail_gallery_displays_attached_images_and_navigation(): void
    {
        $product = DB::table('products')->where('slug', 'vinfast-vf-3')->firstOrFail();
        $primaryImageId = DB::table('products')->where('id', $product->id)->value('thumbnail_media_id');
        $additionalImageId = DB::table('media')->insertGetId([
            'uuid' => (string) Str::uuid(),
            'disk' => 'public',
            'path' => 'clients/assets/images/products/vinfast-vf-5.webp',
            'filename' => 'gallery-vf5.webp',
            'original_filename' => 'gallery-vf5.webp',
            'extension' => 'webp',
            'mime_type' => 'image/webp',
            'file_size' => 1200,
            'alt_text' => 'Góc nội thất xe',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('media_usages')->insert([
            [
                'media_id' => $primaryImageId,
                'usable_type' => 'product',
                'usable_id' => $product->id,
                'role' => 'gallery',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'media_id' => $additionalImageId,
                'usable_type' => 'product',
                'usable_id' => $product->id,
                'role' => 'gallery',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/xe/vinfast-vf-3');

        $response->assertOk();
        $response->assertSee('data-vf-product-gallery', false);
        $response->assertSee('data-vf-gallery-next', false);
        $response->assertSee('data-vf-gallery-thumbnail="1"', false);
        $response->assertSee('clients/assets/images/products/vinfast-vf-5.webp');
    }

    /**
     * Kiểm tra truy cập slug xe không tồn tại trả về 404.
     */
    public function test_product_detail_returns_404_when_not_found(): void
    {
        $response = $this->get('/xe/xe-khong-ton-tai-abc');

        $response->assertStatus(404);
    }

    /**
     * Kiểm tra truy cập trang phân trang catalog /o-to-vinfast/page/2 thành công.
     */
    public function test_catalog_pagination_url_displays_successfully(): void
    {
        $response = $this->get('/o-to-vinfast/page/2');

        $response->assertStatus(200);
        $response->assertSee('CÁC DÒNG XE Ô TÔ VINFAST');
    }
}
