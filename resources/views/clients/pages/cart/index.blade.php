@extends('clients.layouts.app')

@section('title', 'Giỏ Hàng / Danh Sách Đặt Cọc Xe | VinFast Hải Phòng')
@section('meta_description', 'Xem lại danh sách các mẫu xe VinFast bạn đang quan tâm hoặc đăng ký đặt cọc tiền mặt tại VinFast Minh Đạo Hải Phòng.')

@section('content')
<div class="vinfast-autohaiphong_cart_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 24px;">
            DANH SÁCH XE ĐĂNG KÝ ĐẶT CỌC
        </h1>

        @if($cart->items->isEmpty())
            <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 48px; text-align: center;">
                <p style="font-size: 1.1rem; color: var(--client-color-muted); margin-bottom: 20px;">
                    Hiện tại bạn chưa chọn mẫu xe nào vào danh sách đặt cọc.
                </p>
                <a href="{{ url('/o-to-vinfast') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 12px 24px; text-decoration: none;">
                    Khám Phá Các Dòng Xe VinFast &rarr;
                </a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px; align-items: start;">
                {{-- Bảng chi tiết giỏ hàng --}}
                <div>
                    <table class="vinfast-autohaiphong_cart_table">
                        <thead>
                            <tr>
                                <th>Mẫu Xe</th>
                                <th>Đơn Giá</th>
                                <th style="text-align: center;">Số Lượng</th>
                                <th style="text-align: right;">Thành Tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 14px;">
                                            <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid var(--client-color-border);">
                                            <div>
                                                <a href="{{ url('/xe/' . $item->product_slug) }}" style="font-weight: 700; color: var(--client-color-heading); text-decoration: none;">
                                                    {{ $item->product_name }}
                                                </a>
                                                @if($item->variant_name)
                                                    <div style="font-size: 0.8rem; color: var(--client-color-muted);">
                                                        Phiên bản: {{ $item->variant_name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600; color: #334155;">
                                            {{ number_format($item->unit_price, 0, ',', '.') }} đ
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('client.cart.update') }}" method="POST" style="display: inline-flex; align-items: center; gap: 4px;">
                                            @csrf
                                            <input type="hidden" name="item_key" value="{{ $item->key }}">
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="10" 
                                                   style="width: 50px; text-align: center; padding: 4px; border: 1px solid var(--client-color-border); border-radius: 4px;"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td style="text-align: right;">
                                        <span style="font-weight: 700; color: var(--client-color-primary);">
                                            {{ number_format($item->line_total, 0, ',', '.') }} đ
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('client.cart.remove') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa xe này?')">
                                            @csrf
                                            <input type="hidden" name="item_key" value="{{ $item->key }}">
                                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.1rem;" title="Xóa">
                                                &times;
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tóm tắt đặt cọc & Nút Checkout --}}
                <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 16px; border-bottom: 1px solid var(--client-color-border); padding-bottom: 10px;">
                        TỔNG HỢP THANH TOÁN
                    </h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem;">
                        <span style="color: var(--client-color-muted);">Tạm tính xe:</span>
                        <span style="font-weight: 600; color: var(--client-color-heading);">{{ number_format($cart->subtotal, 0, ',', '.') }} VNĐ</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 0.95rem;">
                        <span style="color: var(--client-color-muted);">Ưu đãi lệ phí trước bạ:</span>
                        <span style="font-weight: 600; color: #16a34a;">0% (Miễn phí)</span>
                    </div>

                    <div style="border-top: 2px dashed var(--client-color-border); padding-top: 14px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-weight: 700; font-size: 1.1rem; color: var(--client-color-heading);">Tổng giá niêm yết:</span>
                        <span style="font-weight: 800; font-size: 1.35rem; color: var(--client-color-primary);">
                            {{ number_format($cart->total, 0, ',', '.') }} VNĐ
                        </span>
                    </div>

                    <div class="vinfast-autohaiphong_checkout_cash_notice" style="font-size: 0.85rem; line-height: 1.5; margin-bottom: 20px;">
                        <strong>Lưu ý:</strong> Phương thức thanh toán duy nhất áp dụng là <strong>Tiền mặt trực tiếp tại Showroom VinFast Minh Đạo</strong>. Bạn sẽ không bị trừ bất kỳ khoản phí trực tuyến nào khi đặt cọc online.
                    </div>

                    <a href="{{ route('client.checkout.index') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="width: 100%; padding: 13px; font-size: 1rem; text-decoration: none; text-align: center;">
                        Tiến Hành Đặt Cọc Xe (Tiền Mặt) &rarr;
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

