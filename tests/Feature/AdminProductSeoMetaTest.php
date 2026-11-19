<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialCarsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductSeoMetaTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialAdminUserSeeder::class);
        $this->seed(InitialCarsSeeder::class);

        $this->admin = User::where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
    }

    public function test_admin_can_view_product_create_and_edit_page_with_seo_meta_fields(): void
    {
        // Kiểm tra trang Thêm mới xe
        $createResponse = $this->actingAs($this->admin)->get(route('admin.products.create'));
        $createResponse->assertStatus(200);
        $createResponse->assertSee('THÔNG TIN XE CƠ BẢN');
        $createResponse->assertSee('name="meta_title"', false);
        $createResponse->assertSee('name="meta_description"', false);
        $createResponse->assertSee('name="meta_keywords"', false);
        $createResponse->assertSee('name="canonical_url"', false);
        $createResponse->assertSee('Mô Phỏng Hiển Thị Trên Google Tìm Kiếm (SERP Preview)');

        // Kiểm tra trang Chỉnh sửa xe
        $product = Product::where('slug', 'vinfast-vf-3')->first();
        $this->assertNotNull($product);

        $editResponse = $this->actingAs($this->admin)->get(route('admin.products.edit', $product->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('THÔNG TIN XE CƠ BẢN');
        $editResponse->assertSee('name="meta_title"', false);
        $editResponse->assertSee('name="meta_description"', false);
        $editResponse->assertSee('name="meta_keywords"', false);
        $editResponse->assertSee('name="canonical_url"', false);
        $editResponse->assertSee('product-meta-title-counter', false);
        $editResponse->assertSee('product-meta-desc-counter', false);
    }

    public function test_admin_can_store_product_with_seo_meta_data(): void
    {
        $payload = [
            'name' => 'VinFast VF Wild Concept',
            'slug' => 'vinfast-vf-wild-concept',
            'sku' => 'VFWILD-HP',
            'regular_price' => 990000000,
            'sale_price' => 950000000,
            'short_description' => 'Mẫu xe bán tải điện thể thao ý tưởng VinFast VF Wild ra mắt ấn tượng.',
            'meta_title' => 'Xe Bán Tải Điện VinFast VF Wild Hải Phòng - Giá Tốt Nhất',
            'meta_description' => 'Đánh giá VinFast VF Wild tại Hải Phòng. Bán tải thuần điện công nghệ đỉnh cao, phạm vi di chuyển vượt trội, bảo hành pin chính hãng 10 năm.',
            'meta_keywords' => 'vinfast vf wild, ban tai dien vinfast, gia xe vf wild hai phong',
            'canonical_url' => 'https://vinfast-autohaiphong.com.vn/xe/vinfast-vf-wild-concept',
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), $payload);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('products', [
            'slug' => 'vinfast-vf-wild-concept',
            'meta_title' => 'Xe Bán Tải Điện VinFast VF Wild Hải Phòng - Giá Tốt Nhất',
            'meta_description' => 'Đánh giá VinFast VF Wild tại Hải Phòng. Bán tải thuần điện công nghệ đỉnh cao, phạm vi di chuyển vượt trội, bảo hành pin chính hãng 10 năm.',
            'meta_keywords' => 'vinfast vf wild, ban tai dien vinfast, gia xe vf wild hai phong',
            'canonical_url' => 'https://vinfast-autohaiphong.com.vn/xe/vinfast-vf-wild-concept',
        ]);
    }

    public function test_admin_can_update_product_seo_meta_data(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->first();
        $this->assertNotNull($product);

        $payload = [
            'name' => 'VinFast VF 3',
            'slug' => 'vinfast-vf-3',
            'regular_price' => 322000000,
            'sale_price' => 240000000,
            'short_description' => 'Mẫu xe điện mini hot nhất thị trường hiện nay.',
            'meta_title' => 'VinFast VF 3 Hải Phòng - Giá Lăn Bánh & Khuyến Mãi 2026',
            'meta_description' => 'Bảng giá lăn bánh VinFast VF 3 tại Hải Phòng tháng này. Trả thẳng tiền mặt, ưu đãi thuế trước bạ 0%, miễn phí sạc pin cùng quà tặng hấp dẫn.',
            'meta_keywords' => 'gia xe vf 3 hai phong, dat coc vinfast vf 3, vinfast vf 3 mini',
            'canonical_url' => 'https://vinfast-autohaiphong.com.vn/xe/vinfast-vf-3',
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), $payload);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'meta_title' => 'VinFast VF 3 Hải Phòng - Giá Lăn Bánh & Khuyến Mãi 2026',
            'meta_description' => 'Bảng giá lăn bánh VinFast VF 3 tại Hải Phòng tháng này. Trả thẳng tiền mặt, ưu đãi thuế trước bạ 0%, miễn phí sạc pin cùng quà tặng hấp dẫn.',
            'meta_keywords' => 'gia xe vf 3 hai phong, dat coc vinfast vf 3, vinfast vf 3 mini',
            'canonical_url' => 'https://vinfast-autohaiphong.com.vn/xe/vinfast-vf-3',
        ]);
    }

    public function test_client_product_detail_page_renders_custom_seo_meta_and_opengraph(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->first();
        $product->update([
            'meta_title' => 'VinFast VF 3 Hải Phòng - Giá Lăn Bánh Mới Nhất 2026',
            'meta_description' => 'Mua xe VinFast VF 3 tại Hải Phòng: Bảng giá ưu đãi, trả góp hoặc tiền mặt, sạc pin miễn phí tại showroom.',
            'meta_keywords' => 'vinfast vf 3 hai phong, mua xe vf 3',
            'canonical_url' => 'https://vinfast-autohaiphong.com.vn/xe/vinfast-vf-3',
        ]);

        $response = $this->get('https://vinfast-autohaiphong.com.vn/xe/vinfast-vf-3');

        $response->assertStatus(200);
        $response->assertSee('<title>VinFast VF 3 Hải Phòng - Giá Lăn Bánh Mới Nhất 2026</title>', false);
        $response->assertSee('content="Mua xe VinFast VF 3 tại Hải Phòng: Bảng giá ưu đãi, trả góp hoặc tiền mặt, sạc pin miễn phí tại showroom."', false);
        $response->assertDontSee('name="keywords"', false);
        $response->assertSee('rel="canonical" href="https://vinfast-autohaiphong.com.vn/xe/vinfast-vf-3"', false);
        $response->assertSee('property="og:title" content="VinFast VF 3 Hải Phòng - Giá Lăn Bánh Mới Nhất 2026"', false);
        $response->assertSee('property="og:description" content="Mua xe VinFast VF 3 tại Hải Phòng: Bảng giá ưu đãi, trả góp hoặc tiền mặt, sạc pin miễn phí tại showroom."', false);
    }
}
