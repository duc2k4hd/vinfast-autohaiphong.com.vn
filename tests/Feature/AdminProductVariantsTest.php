<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialCarsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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

    public function test_specification_groups_and_units_are_preserved_and_can_be_changed(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->firstOrFail();
        $group = DB::table('product_specification_groups')->insertGetId(['name' => 'Test group', 'slug' => 'test-group']);

        $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
            'name' => $product->name,
            'specs_labels' => ['Grouped', 'Ungrouped'],
            'specs_values' => ['100', '200'],
            'specs_groups' => [$group, null],
            'specs_units' => ['km', null],
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'Grouped', 'group_id' => $group, 'unit' => 'km']);
        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'Ungrouped', 'group_id' => null]);
        $this->actingAs($this->admin)->get(route('admin.products.edit', $product->id))
            ->assertOk()->assertSee('Test group')->assertSee('name="specs_groups[]"', false)->assertSee('value="km"', false);

        $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
            'name' => $product->name,
            'specs_labels' => ['Grouped'],
            'specs_values' => ['100'],
            'specs_groups' => [999999],
        ])->assertSessionHasErrors('specs_groups.0');
        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'Grouped', 'group_id' => $group]);

        $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
            'name' => $product->name,
            'specs_present' => 1,
        ])->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('product_specifications', ['product_id' => $product->id, 'label' => 'Grouped']);
    }

    public function test_new_specification_groups_are_created_and_reused_without_changing_existing_names(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->firstOrFail();
        $existing = DB::table('product_specification_groups')->insertGetId(['name' => 'Power Train', 'slug' => 'power-train']);
        $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
            'name' => $product->name,
            'specs_present' => 1,
            'specs_labels' => ['A', 'B', 'C'],
            'specs_values' => ['1', '2', '3'],
            'specs_groups' => ['new:first', 'new:first', 'new:second'],
            'new_spec_groups' => ['first' => 'Battery testing', 'second' => 'Power Train'],
        ])->assertSessionHasNoErrors();
        $group = DB::table('product_specification_groups')->where('name', 'Battery testing')->first();
        $this->assertNotNull($group);
        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'A', 'group_id' => $group->id]);
        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'B', 'group_id' => $group->id]);
        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'C', 'group_id' => $existing]);
        $this->assertDatabaseHas('product_specification_groups', ['id' => $existing, 'name' => 'Power Train']);
    }

    public function test_invalid_new_group_references_are_rejected_without_deleting_specifications(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->firstOrFail();
        $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
            'name' => $product->name,
            'specs_labels' => ['A'], 'specs_values' => ['1'], 'specs_groups' => ['new:missing'],
        ])->assertSessionHasErrors('specs_groups.0');
        $this->assertDatabaseMissing('product_specifications', ['product_id' => $product->id, 'label' => 'A']);
    }

    public function test_guest_cannot_create_specification_groups(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->firstOrFail();
        $this->put(route('admin.products.update', $product->id), [
            'name' => $product->name,
            'specs_labels' => ['A'], 'specs_values' => ['1'], 'specs_groups' => ['new:guest'],
            'new_spec_groups' => ['guest' => 'Guest Group'],
        ])->assertRedirect();
        $this->assertDatabaseMissing('product_specification_groups', ['slug' => 'guest-group']);
    }

    public function test_new_product_can_save_new_group_with_specification(): void
    {
        $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Test Group Car',
            'specs_present' => 1,
            'specs_labels' => ['Range'], 'specs_values' => ['300'], 'specs_groups' => ['new:car'],
            'new_spec_groups' => ['car' => 'Vehicle Range'],
        ])->assertSessionHasNoErrors();
        $product = Product::where('slug', 'test-group-car')->firstOrFail();
        $group = DB::table('product_specification_groups')->where('name', 'Vehicle Range')->first();
        $this->assertNotNull($group);
        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'Range', 'group_id' => $group->id]);
    }

    public function test_similar_group_slugs_do_not_reuse_differently_named_groups(): void
    {
        $product = Product::where('slug', 'vinfast-vf-3')->firstOrFail();
        $existing = DB::table('product_specification_groups')->insertGetId(['name' => 'Battery pack', 'slug' => 'battery-pack']);
        $this->actingAs($this->admin)->put(route('admin.products.update', $product->id), [
            'name' => $product->name, 'specs_labels' => ['Capacity'], 'specs_values' => ['10'],
            'specs_groups' => ['new:different'], 'new_spec_groups' => ['different' => 'Battery-pack'],
        ])->assertSessionHasNoErrors();
        $new = DB::table('product_specification_groups')->where('name', 'Battery-pack')->first();
        $this->assertNotNull($new);
        $this->assertNotEquals($existing, $new->id);
        $this->assertDatabaseHas('product_specifications', ['product_id' => $product->id, 'label' => 'Capacity', 'group_id' => $new->id]);
    }
}
