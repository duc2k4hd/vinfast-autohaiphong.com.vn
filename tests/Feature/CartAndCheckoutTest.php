<?php

namespace Tests\Feature;

use Database\Seeders\InitialCarsSeeder;
use Database\Seeders\InitialSettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialSettingsSeeder::class);
        $this->seed(InitialCarsSeeder::class);
    }

    public function test_can_view_cart_page(): void
    {
        $response = $this->get('/gio-hang');
        $response->assertStatus(200);
        $response->assertSee('DANH SÁCH XE ĐĂNG KÝ ĐẶT CỌC');
    }

    public function test_can_add_car_to_cart_and_update(): void
    {
        $car = DB::table('products')->where('slug', 'vinfast-vf-3')->first();

        // 1. Thêm xe vào giỏ hàng
        $response = $this->post('/gio-hang/them', [
            'product_id' => $car->id,
            'quantity' => 1,
        ]);
        $response->assertRedirect('/gio-hang');

        // 2. Kiểm tra hiển thị trong giỏ hàng
        $cartResponse = $this->get('/gio-hang');
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee($car->name);

        // 3. Cập nhật số lượng
        $itemKey = "{$car->id}_0";
        $updateResponse = $this->post('/gio-hang/cap-nhat', [
            'item_key' => $itemKey,
            'quantity' => 2,
        ]);
        $updateResponse->assertRedirect('/gio-hang');
    }

    public function test_checkout_cash_only_flow_creates_order_and_payment_record(): void
    {
        $car = DB::table('products')->where('slug', 'vinfast-vf-3')->first();

        // Thêm vào giỏ
        $this->post('/gio-hang/them', [
            'product_id' => $car->id,
            'quantity' => 1,
        ]);

        // Mở trang thanh toán
        $checkoutPage = $this->get('/thanh-toan');
        $checkoutPage->assertStatus(200);
        $checkoutPage->assertSee('Thanh toán tiền mặt trực tiếp tại Showroom');

        // Gửi đơn thanh toán tiền mặt duy nhất
        $submitResponse = $this->post('/thanh-toan', [
            'customer_name' => 'Nguyễn Văn Minh',
            'customer_phone' => '0988302882',
            'customer_email' => 'minh.nguyen@example.com',
            'customer_note' => 'Tôi muốn nhận xe tại showroom Bạch Đằng vào sáng thứ 7',
            'consent_accepted' => '1',
            'idempotency_key' => 'test-idemp-key-12345',
        ]);

        // Đơn hàng được tạo trong DB
        $order = DB::table('orders')->where('customer_phone', '0988302882')->first();
        $this->assertNotNull($order);
        $this->assertStringStartsWith('VFHP-', $order->order_number);
        $this->assertEquals('cash', $order->payment_method);
        $this->assertEquals('unpaid', $order->payment_status);

        // Bản ghi order_items
        $item = DB::table('order_items')->where('order_id', $order->id)->first();
        $this->assertNotNull($item);
        $this->assertEquals($car->name, $item->product_name);

        // Bản ghi payment_records (tiền mặt chờ thu)
        $payment = DB::table('payment_records')->where('order_id', $order->id)->first();
        $this->assertNotNull($payment);
        $this->assertEquals('cash', $payment->method);
        $this->assertEquals('pending', $payment->status);

        // Chuyển hướng sang trang thành công
        $submitResponse->assertRedirect('/dat-hang-thanh-cong/'.$order->order_number);

        // Trang thành công hiển thị rõ hướng dẫn tiền mặt
        $successPage = $this->get('/dat-hang-thanh-cong/'.$order->order_number);
        $successPage->assertStatus(200);
        $successPage->assertSee($order->order_number);
        $successPage->assertSee('HƯỚNG DẪN HOÀN TẤT THANH TOÁN TIỀN MẶT');
        $successPage->assertSee('Số 1 Bạch Đằng');
    }
}
