<?php

namespace App\Services\Client;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CheckoutService
{
    /**
     * Xử lý tạo đơn hàng với phương thức thanh toán tiền mặt duy nhất (cash).
     */
    public function processCashOrder(array $customerData, Collection $items, ?string $idempotencyKey = null): object
    {
        if ($items->isEmpty()) {
            throw new InvalidArgumentException('Không có sản phẩm nào trong đơn hàng để thanh toán.');
        }

        // 1. Chống gửi trùng lặp bằng Idempotency Key
        if ($idempotencyKey) {
            $existingOrder = DB::table('orders')->where('idempotency_key', $idempotencyKey)->first();
            if ($existingOrder) {
                return $existingOrder;
            }
        }

        return DB::transaction(function () use ($customerData, $items, $idempotencyKey) {
            $todayStr = Carbon::now()->format('Ymd');

            // Đếm số đơn trong ngày để sinh số thứ tự
            $dailyCount = DB::table('orders')
                ->whereDate('created_at', Carbon::today())
                ->count();

            $orderNumber = sprintf('VFHP-%s-%04d', $todayStr, $dailyCount + 1);

            $subtotal = $items->sum('line_total');
            $discountTotal = 0;
            $total = max(0, $subtotal - $discountTotal);
            $now = Carbon::now();

            // Lưu bản ghi đồng thuận (Consent Record)
            $consentId = null;
            if (! empty($customerData['consent_accepted'])) {
                $consentId = DB::table('consent_records')->insertGetId([
                    'type' => 'checkout',
                    'ip_address' => request()->ip() ?? '127.0.0.1',
                    'user_agent' => substr(request()->userAgent() ?? '', 0, 500),
                    'source_url' => request()->fullUrl(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // Tạo Order
            $orderId = DB::table('orders')->insertGetId([
                'order_number' => $orderNumber,
                'customer_name' => $customerData['customer_name'],
                'customer_phone' => $customerData['customer_phone'],
                'customer_email' => $customerData['customer_email'] ?? null,
                'customer_note' => $customerData['customer_note'] ?? null,
                'subtotal' => $subtotal,
                'discount_total' => $discountTotal,
                'total' => $total,
                'currency' => 'VND',
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'idempotency_key' => $idempotencyKey,
                'consent_id' => $consentId,
                'utm_source' => request()->get('utm_source'),
                'utm_medium' => request()->get('utm_medium'),
                'utm_campaign' => request()->get('utm_campaign'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Tạo các Order Items
            foreach ($items as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product_name,
                    'product_sku' => $item->product_sku ?? 'VF-AUTO',
                    'variant_name' => $item->variant_name,
                    'color_name' => $item->color_name,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'line_total' => $item->line_total,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // Tạo bản ghi theo dõi thanh toán tiền mặt (Payment Record)
            DB::table('payment_records')->insert([
                'order_id' => $orderId,
                'amount' => $total,
                'method' => 'cash',
                'status' => 'pending',
                'note' => 'Đăng ký đặt cọc/thanh toán tiền mặt trực tiếp tại Showroom VinFast Minh Đạo Hải Phòng (Số 1 Bạch Đằng).',
                'confirmed_by' => null,
                'received_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return (object) [
                'id' => $orderId,
                'order_number' => $orderNumber,
                'customer_name' => $customerData['customer_name'],
                'customer_phone' => $customerData['customer_phone'],
                'total' => $total,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'created_at' => $now,
            ];
        });
    }

    /**
     * Tìm kiếm đơn hàng theo mã để hiển thị trang Đặt hàng thành công.
     */
    public function findByOrderNumber(string $orderNumber): ?object
    {
        $order = DB::table('orders')->where('order_number', $orderNumber)->first();
        if (! $order) {
            return null;
        }

        $order->items = DB::table('order_items')
            ->where('order_id', $order->id)
            ->get();

        return $order;
    }
}
