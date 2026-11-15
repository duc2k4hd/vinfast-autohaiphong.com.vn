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
        $response->assertSee('Các dòng xe ô tô VinFast');
        $response->assertSee('VinFast VF 3');
        $response->assertSee('VinFast VF 5 Plus');
        $response->assertSee('"@context": "https://schema.org"', false);
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
        $response->assertSee('Các dòng xe ô tô VinFast');
    }

    public function test_catalog_legacy_pagination_shows_second_page_and_normalized_links(): void
    {
        $first = $this->get('/o-to-vinfast');
        $second = $this->get('/o-to-vinfast/page/2?sort=default');

        $first->assertViewHas('cars', fn ($cars) => $cars->currentPage() === 1 && $cars->total() > 9);
        $second->assertOk()->assertViewHas('cars', fn ($cars) => $cars->currentPage() === 2 && $cars->first()->id !== $first->viewData('cars')->first()->id);
        $second->assertSee(route('client.catalog.page', ['page' => 2]), false);
        $second->assertDontSee('/page/2?page=', false);
    }

    public function test_catalog_sorts_displayed_prices_and_excludes_deleted_products(): void
    {
        DB::table('products')->update(['status' => 'inactive']);
        DB::table('products')->where('slug', 'vinfast-vf-2')->update(['status' => 'active', 'regular_price' => 300, 'sale_price' => null, 'price_on_request' => false]);
        DB::table('products')->where('slug', 'vinfast-vf-3')->update(['status' => 'active', 'regular_price' => 500, 'sale_price' => 100, 'price_on_request' => false]);
        DB::table('products')->where('slug', 'vinfast-vf-5')->update(['status' => 'active', 'regular_price' => 1, 'sale_price' => null, 'price_on_request' => true]);
        DB::table('products')->where('slug', 'vinfast-vf-6')->update(['status' => 'active', 'deleted_at' => now()]);

        $ascending = $this->get('/o-to-vinfast?sort=price_asc');
        $ascending->assertOk()->assertViewHas('cars', fn ($cars) => $cars->pluck('slug')->all() === ['vinfast-vf-3', 'vinfast-vf-2', 'vinfast-vf-5']);
        $this->get('/o-to-vinfast?sort=price_desc')->assertOk()->assertViewHas('cars', fn ($cars) => $cars->pluck('slug')->all() === ['vinfast-vf-2', 'vinfast-vf-3', 'vinfast-vf-5']);
    }

    public function test_catalog_handles_invalid_filter_arrays_and_empty_category(): void
    {
        $this->get('/o-to-vinfast?category[]=invalid&sort[]=invalid')->assertOk();
        $this->get('/o-to-vinfast?category=unknown')->assertOk()->assertSee('Không tìm thấy dòng xe nào phù hợp');
    }

    public function test_product_detail_accessible_with_active_or_coming_soon_status(): void
    {
        DB::table('products')->where('slug', 'vinfast-vf-3')->update(['status' => 'active']);
        $this->get('/xe/vinfast-vf-3')->assertStatus(200);

        DB::table('products')->where('slug', 'vinfast-vf-3')->update(['status' => 'coming_soon']);
        $this->get('/xe/vinfast-vf-3')->assertStatus(200);

        DB::table('products')->where('slug', 'vinfast-vf-3')->update(['status' => 'inactive']);
        $this->get('/xe/vinfast-vf-3')->assertStatus(404);
    }

    public function test_product_detail_displays_video_section_when_configured(): void
    {
        DB::table('products')->where('slug', 'vinfast-vf-3')->update([
            'video_path' => 'clients/assets/videos/products/test-video.mp4',
            'video_title' => 'Video Thử Nghiệm VF 3',
        ]);

        $response = $this->get('/xe/vinfast-vf-3');
        $response->assertStatus(200);
        $response->assertSee('id="vf3-video"', false);
        $response->assertSee('data-vf-lazy-video', false);
        $response->assertSee('test-video.mp4');
        $response->assertSee('VideoObject');
    }

    public function test_product_detail_displays_multiple_videos_seamlessly(): void
    {
        $productId = DB::table('products')->where('slug', 'vinfast-vf-3')->value('id');

        DB::table('product_videos')->insert([
            [
                'product_id' => $productId,
                'video_path' => 'clients/assets/videos/products/vf3-part1.mp4',
                'title' => 'Video Ngoại Thất VF 3',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'video_path' => 'clients/assets/videos/products/vf3-part2.mp4',
                'title' => 'Video Nội Thất VF 3',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/xe/vinfast-vf-3');
        $response->assertStatus(200);
        $response->assertSee('vf3-part1.mp4');
        $response->assertSee('vf3-part2.mp4');
        $response->assertSee('vinfast-autohaiphong_product_video_stack', false);
    }

    /**
     * Kiểm tra nội dung chi tiết bài viết và hình ảnh nội bộ cho dòng xe VinFast VF 2.
     */
    public function test_vf2_detail_page_renders_rich_content_and_local_images(): void
    {
        $response = $this->get('/xe/vinfast-vf-2');

        $response->assertStatus(200);

        // 1. Kiểm tra các section nội dung chính của VF 2
        $response->assertSee('id="vf2-gioi-thieu"', false);
        $response->assertSee('VinFast VF 2 tại Hải Phòng: ô tô điện nhỏ gọn, vừa nhu cầu đi phố');
        $response->assertSee('id="vf2-gia-ban"', false);
        $response->assertSee('Giá VinFast VF 2: 188 triệu đồng đã bao gồm pin');
        $response->assertSee('id="vf2-thiet-ke"', false);
        $response->assertSee('id="vf2-noi-that"', false);
        $response->assertSee('id="vf2-pin-sac"', false);
        $response->assertSee('id="vf2-van-hanh"', false);
        $response->assertSee('id="vf2-an-toan"', false);
        $response->assertSee('id="vf2-mau-sac"', false);
        $response->assertSee('id="vf2-thong-so"', false);
        $response->assertSee('id="vf2-phu-hop"', false);
        $response->assertSee('id="vf2-faq"', false);
        $response->assertSee('id="vf2-tu-van"', false);

        // 2. Kiểm tra đường dẫn ảnh đã map chuẩn nội bộ dự án, không còn link ảnh ngoài
        $response->assertSee('/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-hero-banner-new-desktop.webp', false);
        $response->assertSee('/storage/clients/assets/images/products/vf2/vinfast-vf2-ngoai-that-mau-vang-be-goc-truoc-3-4-desktop.webp', false);
        $response->assertDontSee('static-cms-prod.vinfastauto.com', false);

        // 3. Kiểm tra link ngoài đã được loại bỏ, chỉ giữ tên thương hiệu
        $response->assertDontSee('https://vinfastauto.com', false);
        $response->assertSee('Nguồn đối chiếu: Trang thông tin chính thức và thông báo bán hàng của VinFast');

        // 4. Kiểm tra hotline và showroom VinFast Hải Phòng
        $response->assertSee('0988 302 882');
        $response->assertSee('Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng');
    }
}
