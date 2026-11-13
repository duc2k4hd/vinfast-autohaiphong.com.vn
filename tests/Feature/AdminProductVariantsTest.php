<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialCarsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductVariantsTest extends TestCase
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

    public function test_admin_can_view_product_edit_page_with_variants(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->first();
        $this->assertNotNull($product);

        $response = $this->actingAs($this->admin)->get(route('admin.products.edit', $product->id));

        $response->assertStatus(200);
        $response->assertSee('PHIÊN BẢN');
        $response->assertSee('THÔNG SỐ KỸ THUẬT KEY - VALUE');
    }

    public function test_admin_can_update_product_variants_and_specifications(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->first();
        $this->assertNotNull($product);

        $payload = [
            'name' => 'VinFast VF 3 Nâng Cấp V2',
            'regular_price' => 250000000,
            'sale_price' => 240000000,
            'short_description' => 'Mẫu xe điện mini thông minh đô thị phong cách.',
            'description_html' => '<p>Nội dung mô tả chi tiết VF 3 V2.</p>',
            'specs_labels' => [
                'Số chỗ ngồi',
                'Quãng đường di chuyển',
            ],
            'specs_values' => [
                '4 chỗ',
                '215 km / lần sạc',
            ],
            'variant_names' => [
                'Bản Tiêu Chuẩn Thuê Pin',
                'Bản Cao Cấp Kèm Pin',
            ],
            'variant_skus' => [
                'VF3-TEST-BAT',
                'VF3-TEST-INC',
            ],
            'variant_regular_prices' => [
                240000000,
                322000000,
            ],
            'variant_sale_prices' => [
                235000000,
                315000000,
            ],
            'variant_color_names' => [
                'Vàng Nóc Trắng',
                'Xanh Bộ Đội Nóc Trắng',
            ],
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), $payload);

        $response->assertRedirect(route('admin.products.edit', $product->id));
        $response->assertSessionHas('success');

        // Kiểm tra cơ sở dữ liệu đã lưu
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'VinFast VF 3 Nâng Cấp V2',
            'regular_price' => 250000000,
        ]);

        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'name' => 'Bản Tiêu Chuẩn Thuê Pin',
            'sku' => 'VF3-TEST-BAT',
            'sale_price' => 235000000,
        ]);

        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product->id,
            'name' => 'Bản Cao Cấp Kèm Pin',
            'sku' => 'VF3-TEST-INC',
            'sale_price' => 315000000,
        ]);

        $this->assertDatabaseHas('product_specifications', [
            'product_id' => $product->id,
            'label' => 'Quãng đường di chuyển',
            'value' => '215 km / lần sạc',
        ]);
    }
}
