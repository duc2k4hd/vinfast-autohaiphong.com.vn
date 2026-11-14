<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Services\Shared\CurrencyHelper;
use Database\Seeders\InitialAdminUserSeeder;
use Database\Seeders\InitialCarsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminOrderPrintAndSearchTest extends TestCase
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

    public function test_currency_helper_converts_number_to_vietnamese_words(): void
    {
        $words = CurrencyHelper::toVietnameseWords(240000000);
        $this->assertStringContainsString('Hai trăm bốn mươi triệu', $words);
        $this->assertStringContainsString('đồng chẵn', $words);

        $words500k = CurrencyHelper::toVietnameseWords(500000);
        $this->assertStringContainsString('Năm trăm nghìn đồng chẵn', $words500k);
    }

    public function test_admin_can_search_orders_by_number_or_customer_name(): void
    {
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => 'VFHP-20261114-9999',
            'customer_name' => 'Trần Văn Kiểm Thử',
            'customer_phone' => '0988999888',
            'customer_email' => 'test@vinfast.vn',
            'subtotal' => 240000000,
            'total' => 240000000,
            'payment_status' => 'unpaid',
            'order_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.orders.index', ['search' => 'VFHP-20261114-9999']));
        $response->assertStatus(200);
        $response->assertSee('Trần Văn Kiểm Thử');
        $response->assertSee('VFHP-20261114-9999');

        $responsePhone = $this->actingAs($this->admin)->get(route('admin.orders.index', ['search' => '0988999888']));
        $responsePhone->assertStatus(200);
        $responsePhone->assertSee('Trần Văn Kiểm Thử');
    }

    public function test_admin_can_view_and_print_order_deposit_receipt(): void
    {
        $orderId = DB::table('orders')->insertGetId([
            'order_number' => 'VFHP-20261114-8888',
            'customer_name' => 'Nguyễn Minh Đạo',
            'customer_phone' => '0912345678',
            'customer_email' => 'minhdao@vinfast.vn',
            'subtotal' => 322000000,
            'total' => 322000000,
            'payment_status' => 'paid',
            'order_status' => 'confirmed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $car = Product::first();

        DB::table('order_items')->insert([
            'order_id' => $orderId,
            'product_id' => $car ? $car->id : 1,
            'product_name' => 'VinFast VF 3',
            'variant_name' => 'Bản Kèm Pin (Mua đứt pin)',
            'unit_price' => 322000000,
            'quantity' => 1,
            'line_total' => 322000000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.orders.print', $orderId));
        $response->assertStatus(200);
        $response->assertSee('PHIẾU ĐẶT CỌC XE');
        $response->assertSee('VFHP-20261114-8888');
        $response->assertSee('Nguyễn Minh Đạo');
        $response->assertSee('322.000.000 VNĐ');
        $response->assertSee('Bằng chữ:');
        $response->assertSee('Khách Hàng Đặt Cọc');
        $response->assertSee('Thủ Quỹ Thu Tiền');
    }
}
