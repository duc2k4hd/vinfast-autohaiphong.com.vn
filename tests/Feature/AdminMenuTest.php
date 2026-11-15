<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMenuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_cannot_access_admin_menus(): void
    {
        $response = $this->get(route('admin.menus.index'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_access_menu_management(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.menus.index'));

        $response->assertOk();
        $response->assertSee('Quản Lý Menu');
        $response->assertSee('Menu Xe');
        $response->assertSee('Menu Điều Hướng Header');
    }

    public function test_admin_can_update_vehicle_menu_settings_via_ajax(): void
    {
        $user = User::factory()->create();
        $product = Product::first();

        $response = $this->actingAs($user)
            ->patchJson(route('admin.menus.vehicles.update_single', $product->id), [
                'show_in_menu' => 0,
                'sort_order' => 99,
            ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'show_in_menu' => 0,
            'sort_order' => 99,
        ]);
    }

    public function test_admin_can_store_and_delete_menu_item(): void
    {
        $user = User::factory()->create();
        $menu = Menu::firstOrCreate(['slug' => 'header'], [
            'name' => 'Menu Đầu Trang',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->postJson(route('admin.menus.items.store'), [
            'menu_id' => $menu->id,
            'label' => 'Bảng Giá Xe Mới',
            'url' => '/bang-gia-xe',
            'target' => '_self',
            'is_active' => 1,
            'sort_order' => 10,
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);

        $item = MenuItem::where('label', 'Bảng Giá Xe Mới')->first();
        $this->assertNotNull($item);
        $this->assertEquals('/bang-gia-xe', $item->url);

        // Delete menu item
        $deleteResponse = $this->actingAs($user)->deleteJson(route('admin.menus.items.destroy', $item->id));
        $deleteResponse->assertOk();
        $this->assertDatabaseMissing('menu_items', ['id' => $item->id]);
    }
}
