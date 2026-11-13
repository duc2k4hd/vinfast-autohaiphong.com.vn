<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
        $this->seed(InitialAdminUserSeeder::class);
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_view_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@vinfast-autohaiphong.com.vn',
            'password' => 'VinfastHaiPhong@2026',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $dashboardResponse = $this->get('/admin/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('TỔNG QUAN HỆ THỐNG VINFAST HẢI PHÒNG');
    }

    public function test_admin_can_update_product_and_key_value_specifications(): void
    {
        $admin = DB::table('users')->where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
        $car = DB::table('products')->where('slug', 'vinfast-vf-3')->first();

        $response = $this->actingAs(User::find($admin->id))->put('/admin/products/'.$car->id, [
            'name' => 'VinFast VF 3 Cập Nhật',
            'regular_price' => 245000000,
            'sale_price' => 240000000,
            'short_description' => 'Mô tả mới của VF 3',
            'specs_labels' => ['Số chỗ ngồi', 'Dung lượng pin'],
            'specs_values' => ['4 chỗ', '18.64 kWh'],
        ]);

        $response->assertRedirect('/admin/products/'.$car->id.'/edit');

        // Kiểm tra database
        $this->assertDatabaseHas('products', [
            'id' => $car->id,
            'name' => 'VinFast VF 3 Cập Nhật',
        ]);

        $this->assertDatabaseHas('product_specifications', [
            'product_id' => $car->id,
            'label' => 'Số chỗ ngồi',
            'value' => '4 chỗ',
        ]);
    }

    public function test_admin_can_confirm_cash_payment_for_order(): void
    {
        $admin = DB::table('users')->where('email', 'admin@vinfast-autohaiphong.com.vn')->first();

        $orderId = DB::table('orders')->insertGetId([
            'order_number' => 'VFHP-20261113-0001',
            'customer_name' => 'Trần Văn B',
            'customer_phone' => '0988302882',
            'subtotal' => 240000000,
            'total' => 240000000,
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
            'order_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('payment_records')->insert([
            'order_id' => $orderId,
            'amount' => 240000000,
            'method' => 'cash',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $confirmResponse = $this->actingAs(User::find($admin->id))
            ->patch('/admin/orders/'.$orderId.'/confirm-cash');

        $confirmResponse->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $orderId,
            'payment_status' => 'paid',
            'order_status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('payment_records', [
            'order_id' => $orderId,
            'method' => 'cash',
            'status' => 'confirmed',
        ]);
    }

    public function test_admin_can_update_product_thumbnail_media_id(): void
    {
        $admin = DB::table('users')->where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
        $car = DB::table('products')->where('slug', 'vinfast-vf-3')->first();

        $mediaId = DB::table('media')->insertGetId([
            'uuid' => (string) Str::uuid(),
            'disk' => 'public',
            'filename' => 'new-vf3-thumb.webp',
            'original_filename' => 'new-vf3-thumb.webp',
            'extension' => 'webp',
            'path' => 'clients/assets/images/products/new-vf3-thumb.webp',
            'mime_type' => 'image/webp',
            'file_size' => 15000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs(User::find($admin->id))->put('/admin/products/'.$car->id, [
            'name' => 'VinFast VF 3 Cập Nhật Ảnh',
            'thumbnail_media_id' => $mediaId,
        ]);

        $response->assertRedirect('/admin/products/'.$car->id.'/edit');

        $this->assertDatabaseHas('products', [
            'id' => $car->id,
            'thumbnail_media_id' => $mediaId,
        ]);
    }

    public function test_admin_can_filter_leads_by_product_and_status(): void
    {
        $admin = DB::table('users')->where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
        $vf3 = DB::table('products')->where('slug', 'vinfast-vf-3')->first();
        $vf5 = DB::table('products')->where('slug', 'vinfast-vf-5')->first();

        DB::table('leads')->insert([
            'name' => 'Khách Hàng VF 3',
            'phone' => '0988000111',
            'product_id' => $vf3->id,
            'status' => 'new',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('leads')->insert([
            'name' => 'Khách Hàng VF 5',
            'phone' => '0988000222',
            'product_id' => $vf5->id,
            'status' => 'contacted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Lọc theo product_id VF 3
        $response = $this->actingAs(User::find($admin->id))->get('/admin/leads?product_id='.$vf3->id);
        $response->assertStatus(200);
        $response->assertSee('Khách Hàng VF 3');
        $response->assertDontSee('Khách Hàng VF 5');

        // Lọc theo status contacted
        $response2 = $this->actingAs(User::find($admin->id))->get('/admin/leads?status=contacted');
        $response2->assertStatus(200);
        $response2->assertSee('Khách Hàng VF 5');
        $response2->assertDontSee('Khách Hàng VF 3');
    }

    public function test_admin_can_view_products_index(): void
    {
        $admin = DB::table('users')->where('email', 'admin@vinfast-autohaiphong.com.vn')->first();

        $response = $this->actingAs(User::find($admin->id))->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('Quản Lý Danh Sách Dòng Xe');
        $response->assertSee('VinFast VF 3');
    }
}
