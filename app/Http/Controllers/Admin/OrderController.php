<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Shared\CurrencyHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Danh sách đơn đặt cọc xe thanh toán tiền mặt kèm bộ lọc tìm kiếm.
     */
    public function index(Request $request): View
    {
        $status = $request->query('payment_status');
        $search = $request->query('search');

        $query = DB::table('orders');

        if ($status && in_array($status, ['unpaid', 'paid', 'refunded'])) {
            $query->where('payment_status', $status);
        }

        if (! empty($search)) {
            $cleanSearch = trim($search);
            $query->where(function ($q) use ($cleanSearch) {
                $q->where('order_number', 'like', "%{$cleanSearch}%")
                    ->orWhere('customer_name', 'like', "%{$cleanSearch}%")
                    ->orWhere('customer_phone', 'like', "%{$cleanSearch}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'currentStatus' => $status,
            'currentSearch' => $search,
        ]);
    }

    /**
     * Chi tiết đơn hàng và các khoản tiền mặt ghi nhận.
     */
    public function show(int $id): View
    {
        $order = DB::table('orders')->where('id', $id)->first();
        if (! $order) {
            abort(404, 'Không tìm thấy đơn hàng này.');
        }

        $items = DB::table('order_items')->where('order_id', $id)->get();
        $payments = DB::table('payment_records')->where('order_id', $id)->orderBy('created_at', 'asc')->get();

        return view('admin.orders.show', [
            'order' => $order,
            'items' => $items,
            'payments' => $payments,
        ]);
    }

    /**
     * Xem & in Phiếu Thu Tiền Mặt / Đặt Cọc Xe tại Showroom.
     */
    public function print(int $id): View
    {
        $order = DB::table('orders')->where('id', $id)->first();
        if (! $order) {
            abort(404, 'Không tìm thấy đơn hàng này.');
        }

        $items = DB::table('order_items')->where('order_id', $id)->get();
        $payments = DB::table('payment_records')->where('order_id', $id)->orderBy('created_at', 'asc')->get();
        $totalInWords = CurrencyHelper::toVietnameseWords($order->total);

        return view('admin.orders.print', [
            'order' => $order,
            'items' => $items,
            'payments' => $payments,
            'totalInWords' => $totalInWords,
        ]);
    }

    /**
     * Xác nhận đã thu tiền mặt tại Showroom VinFast Minh Đạo.
     */
    public function confirmCashPayment(Request $request, int $id): RedirectResponse
    {
        $order = DB::table('orders')->where('id', $id)->first();
        if (! $order) {
            abort(404);
        }

        $now = now();
        $userId = Auth::id();

        DB::transaction(function () use ($id, $now, $userId) {
            // Cập nhật trạng thái đơn hàng
            DB::table('orders')->where('id', $id)->update([
                'payment_status' => 'paid',
                'order_status' => 'confirmed',
                'confirmed_at' => $now,
                'updated_at' => $now,
            ]);

            // Cập nhật hoặc thêm payment record
            DB::table('payment_records')
                ->where('order_id', $id)
                ->where('method', 'cash')
                ->update([
                    'status' => 'confirmed',
                    'confirmed_by' => $userId,
                    'received_at' => $now,
                    'note' => 'Đã hoàn tất kiểm đếm và thu tiền mặt trực tiếp tại Showroom VinFast Minh Đạo (Số 1 Bạch Đằng).',
                    'updated_at' => $now,
                ]);
        });

        return back()->with('success', 'Đã xác nhận thu tiền mặt thành công cho đơn hàng '.$order->order_number.'. Trạng thái chuyển thành ĐÃ THANH TOÁN.');
    }
}
