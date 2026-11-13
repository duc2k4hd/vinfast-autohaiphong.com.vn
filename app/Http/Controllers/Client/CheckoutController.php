<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CheckoutRequest;
use App\Services\Client\CartService;
use App\Services\Client\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutService $checkoutService
    ) {}

    /**
     * Mua ngay/đặt cọc trực tiếp một mẫu xe mà không cần qua trang giỏ hàng.
     */
    public function direct(Request $request): RedirectResponse
    {
        $productId = (int) $request->input('product_id');
        $variantId = $request->input('variant_id') ? (int) $request->input('variant_id') : null;

        if ($productId > 0) {
            $this->cartService->setSingleItem($productId, 1, $variantId);
        }

        return redirect()->route('client.checkout.index');
    }

    /**
     * Hiển thị trang thanh toán tiền mặt.
     */
    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCartDetails();

        if ($cart->items->isEmpty()) {
            return redirect()->route('client.catalog.index')
                ->with('warning', 'Danh sách đặt cọc của bạn đang trống. Vui lòng chọn mẫu xe mong muốn.');
        }

        $idempotencyKey = Str::uuid()->toString();

        return view('clients.pages.checkout.index', [
            'cart' => $cart,
            'idempotencyKey' => $idempotencyKey,
        ]);
    }

    /**
     * Xử lý gửi đơn đặt cọc thanh toán tiền mặt duy nhất (cash).
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cart = $this->cartService->getCartDetails();

        if ($cart->items->isEmpty()) {
            return redirect()->route('client.catalog.index')
                ->with('error', 'Đơn hàng không hợp lệ do giỏ hàng đã hết hạn.');
        }

        $order = $this->checkoutService->processCashOrder(
            $request->validated(),
            $cart->items,
            $request->input('idempotency_key')
        );

        // Xóa giỏ hàng sau khi đặt thành công
        $this->cartService->clear();

        return redirect()->route('client.checkout.success', ['order_number' => $order->order_number])
            ->with('success', 'Đơn đặt hàng và lịch hẹn thanh toán tiền mặt đã được tạo thành công!');
    }

    /**
     * Hiển thị trang đặt hàng thành công và hướng dẫn thanh toán tiền mặt tại Showroom.
     */
    public function success(string $order_number): View
    {
        $order = $this->checkoutService->findByOrderNumber($order_number);

        if (! $order) {
            abort(404, 'Không tìm thấy thông tin đơn hàng này.');
        }

        return view('clients.pages.checkout.success', [
            'order' => $order,
        ]);
    }
}
