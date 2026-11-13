<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Hiển thị giỏ hàng / danh sách xe dự kiến đặt cọc.
     */
    public function index(): View
    {
        $cart = $this->cartService->getCartDetails();

        return view('clients.pages.cart.index', [
            'cart' => $cart,
        ]);
    }

    /**
     * Thêm xe vào giỏ hàng.
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'variant_id' => ['nullable', 'integer', 'exists:product_variants,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $this->cartService->add(
            (int) $request->input('product_id'),
            (int) ($request->input('quantity', 1)),
            $request->input('variant_id') ? (int) $request->input('variant_id') : null
        );

        return redirect()->route('client.cart.index')->with('success', 'Đã thêm dòng xe vào danh sách đặt cọc thành công!');
    }

    /**
     * Cập nhật số lượng xe trong giỏ hàng.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'item_key' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $this->cartService->update(
            $request->input('item_key'),
            (int) $request->input('quantity')
        );

        return redirect()->route('client.cart.index')->with('success', 'Đã cập nhật số lượng xe thành công.');
    }

    /**
     * Xóa dòng xe khỏi giỏ hàng.
     */
    public function remove(Request $request): RedirectResponse
    {
        $request->validate([
            'item_key' => ['required', 'string'],
        ]);

        $this->cartService->remove($request->input('item_key'));

        return redirect()->route('client.cart.index')->with('success', 'Đã xóa xe khỏi danh sách đặt cọc.');
    }
}
