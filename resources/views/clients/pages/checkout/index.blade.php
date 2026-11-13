@extends('clients.layouts.app')

@section('title', 'Thanh Toán Đặt Cọc Tiền Mặt | VinFast Hải Phòng')
@section('meta_description', 'Xác nhận thông tin đặt cọc xe ô tô VinFast. Phương thức thanh toán: Tiền mặt trực tiếp tại Showroom VinFast Minh Đạo Hải Phòng.')

@section('content')
<div class="vinfast-autohaiphong_checkout_section" style="padding: 40px 0 60px 0;">
    <div class="vinfast-autohaiphong_layout_container">
        <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 24px;">
            XÁC NHẬN ĐẶT CỌC XE VINFAST (THANH TOÁN TIỀN MẶT)
        </h1>

        <form action="{{ route('client.checkout.store') }}" method="POST">
            @csrf
            <input type="hidden" name="idempotency_key" value="{{ $idempotencyKey }}">

            <div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 36px; align-items: start;">
                {{-- Cột Trái: Thông tin khách hàng & Phương thức thanh toán --}}
                <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                    <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 20px; border-bottom: 1px solid var(--client-color-border); padding-bottom: 8px;">
                        THÔNG TIN KHÁCH HÀNG ĐĂNG KÝ
                    </h2>

                    @if($errors->any())
                        <div style="background-color: #fee2e2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                            Họ và tên của bạn <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" required 
                               placeholder="Ví dụ: Nguyễn Văn A"
                               style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                                Số điện thoại liên hệ <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required 
                                   placeholder="0988 302 882"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                                Email nhận hợp đồng (nếu có)
                            </label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}" 
                                   placeholder="email@example.com"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
                        </div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--client-color-heading); margin-bottom: 6px;">
                            Ghi chú yêu cầu thêm (màu sắc mong muốn, thời gian nhận xe...)
                        </label>
                        <textarea name="customer_note" rows="3" 
                                  placeholder="Ví dụ: Tôi muốn nhận xe trong tuần này tại Showroom Bạch Đằng..."
                                  style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">{{ old('customer_note') }}</textarea>
                    </div>

                    {{-- Phương thức thanh toán cố định --}}
                    <h2 style="font-size: 1.2rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 16px; border-bottom: 1px solid var(--client-color-border); padding-bottom: 8px;">
                        PHƯƠNG THỨC THANH TOÁN
                    </h2>

                    <div style="background: #f8fafc; border: 2px solid var(--client-color-primary); border-radius: 8px; padding: 18px 20px; margin-bottom: 24px;">
                        <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer;">
                            <input type="radio" name="payment_method" value="cash" checked style="margin-top: 4px; accent-color: var(--client-color-primary);">
                            <div>
                                <div style="font-weight: 700; color: var(--client-color-heading); font-size: 1rem;">
                                    💵 Thanh toán tiền mặt trực tiếp tại Showroom (Phương thức duy nhất)
                                </div>
                                <div style="font-size: 0.85rem; color: #475569; margin-top: 4px; line-height: 1.5;">
                                    Quý khách đăng ký thông tin giữ xe online miễn phí. Sau đó chuyên viên bán hàng sẽ liên hệ xác nhận lịch hẹn và quý khách sẽ tiến hành thanh toán tiền mặt trực tiếp tại:
                                    <br><strong>Showroom VinFast Minh Đạo — Số 1 Bạch Đằng, P. Thượng Lý, Q. Hồng Bàng, TP. Hải Phòng</strong>.
                                </div>
                            </div>
                        </label>
                    </div>

                    {{-- Điều khoản đồng thuận --}}
                    <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 6px; padding: 14px 16px;">
                        <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 0.875rem; color: #334155; line-height: 1.5;">
                            <input type="checkbox" name="consent_accepted" value="1" required style="margin-top: 3px; accent-color: var(--client-color-primary);" {{ old('consent_accepted') ? 'checked' : '' }}>
                            <span>
                                Tôi xác nhận các thông tin trên là chính xác và đồng ý với 
                                <a href="{{ url('/chinh-sach-thanh-toan') }}" target="_blank" style="color: var(--client-color-primary); font-weight: 600;">chính sách thanh toán tiền mặt</a> 
                                và bảo mật thông tin của VinFast Hải Phòng.
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Cột Phải: Tóm tắt đơn hàng xe --}}
                <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 16px; border-bottom: 1px solid var(--client-color-border); padding-bottom: 10px;">
                        DANH SÁCH XE ĐẶT HÀNG
                    </h3>

                    <div style="max-height: 280px; overflow-y: auto; margin-bottom: 20px;">
                        @foreach($cart->items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px dashed var(--client-color-border);">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp' }}" 
                                         alt="{{ $item->product_name }}" 
                                         style="width: 50px; height: 32px; object-fit: cover; border-radius: 3px;">
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem; color: var(--client-color-heading);">
                                            {{ $item->product_name }} &times; {{ $item->quantity }}
                                        </div>
                                        @if($item->variant_name)
                                            <div style="font-size: 0.75rem; color: var(--client-color-muted);">{{ $item->variant_name }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div style="font-weight: 700; font-size: 0.9rem; color: var(--client-color-primary);">
                                    {{ number_format($item->line_total, 0, ',', '.') }} đ
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9rem;">
                        <span style="color: var(--client-color-muted);">Tổng giá niêm yết:</span>
                        <span style="font-weight: 600; color: var(--client-color-heading);">{{ number_format($cart->subtotal, 0, ',', '.') }} đ</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 14px; font-size: 0.9rem;">
                        <span style="color: var(--client-color-muted);">Hình thức thanh toán:</span>
                        <span style="font-weight: 700; color: #16a34a;">Tiền mặt tại showroom</span>
                    </div>

                    <div style="border-top: 2px solid var(--client-color-border); padding-top: 14px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="font-weight: 700; font-size: 1.05rem; color: var(--client-color-heading);">Tổng giá trị đơn hàng:</span>
                        <span style="font-weight: 800; font-size: 1.4rem; color: var(--client-color-primary);">
                            {{ number_format($cart->total, 0, ',', '.') }} VNĐ
                        </span>
                    </div>

                    <button type="submit" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="width: 100%; padding: 14px; font-size: 1.05rem;">
                        Xác Nhận Đặt Cọc Tiền Mặt &rarr;
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

