@extends('clients.layouts.app')

@section('title', 'Đặt Hàng Thành Công — Mã: ' . $order->order_number . ' | VinFast Hải Phòng')
@section('meta_description', 'Đăng ký đặt cọc xe VinFast thành công. Vui lòng xem hướng dẫn hoàn tất thanh toán tiền mặt tại Showroom VinFast Minh Đạo Hải Phòng.')

@section('content')
<div class="vinfast-autohaiphong_checkout_success_section" style="padding: 50px 0 70px 0; background: #f8fafc;">
    <div class="vinfast-autohaiphong_layout_container" style="max-width: 860px;">
        <div style="background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 12px; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); text-align: center;">
            
            {{-- Icon Thành Công --}}
            <div style="width: 72px; height: 72px; background: #dcfce7; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>

            <h1 style="font-size: 1.85rem; font-weight: 800; color: var(--client-color-heading); margin-bottom: 8px;">
                ĐẶT HÀNG THÀNH CÔNG!
            </h1>
            <p style="font-size: 1rem; color: #475569; margin-bottom: 24px;">
                Cảm ơn Quý khách <strong>{{ $order->customer_name }}</strong> đã tin tưởng đăng ký đặt cọc xe tại VinFast Hải Phòng.
            </p>

            {{-- Thông tin mã đơn hàng --}}
            <div style="background: #eff6ff; border: 1px dashed var(--client-color-primary); border-radius: 8px; padding: 18px 24px; margin-bottom: 32px; display: inline-block; min-width: 320px;">
                <div style="font-size: 0.85rem; color: #1e40af; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">
                    MÃ ĐƠN HÀNG CỦA BẠN
                </div>
                <div style="font-size: 1.75rem; font-weight: 800; color: var(--client-color-primary); margin-top: 4px;">
                    {{ $order->order_number }}
                </div>
                <div style="font-size: 0.85rem; color: #475569; margin-top: 4px;">
                    Trạng thái: <strong style="color: #d97706;">Chờ nộp tiền mặt tại Showroom</strong>
                </div>
            </div>

            {{-- Hướng dẫn thanh toán tiền mặt --}}
            <div style="text-align: left; background: #ffffff; border: 1px solid var(--client-color-border); border-radius: 8px; padding: 24px 28px; margin-bottom: 32px; line-height: 1.7;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 12px; border-bottom: 2px solid var(--client-color-primary); padding-bottom: 6px; display: inline-block;">
                    HƯỚNG DẪN HOÀN TẤT THANH TOÁN TIỀN MẶT
                </h2>
                
                <p style="color: #334155; margin-bottom: 12px;">
                    Để hoàn tất thủ tục ký hợp đồng mua bán và nhận biên lai bàn giao xe, Quý khách vui lòng đến trực tiếp showroom theo thông tin sau:
                </p>

                <ul style="list-style: none; padding-left: 0; color: #1e293b;">
                    <li style="margin-bottom: 8px;">
                        📍 <strong>Địa chỉ Showroom:</strong> {{ $siteSettings['site_address'] ?? 'Số 1 Bạch Đằng, Phường Thượng Lý, Quận Hồng Bàng, TP. Hải Phòng' }}
                    </li>
                    <li style="margin-bottom: 8px;">
                        🕒 <strong>Giờ làm việc:</strong> {{ $siteSettings['site_hours'] ?? 'T2–T7: Kinh doanh 7h30–18h00 | CN: 7h00–18h00' }}
                    </li>
                    <li style="margin-bottom: 8px;">
                        💵 <strong>Số tiền thanh toán:</strong> <strong style="color: var(--client-color-primary); font-size: 1.15rem;">{{ number_format($order->total, 0, ',', '.') }} VNĐ</strong>
                    </li>
                    <li style="margin-bottom: 8px;">
                        📄 <strong>Giấy tờ cần mang theo:</strong> Căn cước công dân (CCCD) và mã đơn hàng <strong>{{ $order->order_number }}</strong>.
                    </li>
                </ul>

                <div style="background: #f8fafc; border-left: 4px solid var(--client-color-primary); padding: 12px 16px; margin-top: 16px; font-size: 0.9rem; color: #475569;">
                    Chuyên viên bán hàng VinFast sẽ liên hệ qua số điện thoại <strong>{{ $order->customer_phone }}</strong> trong vòng 15 phút để hỗ trợ Quý khách chi tiết nhất.
                </div>
            </div>

            {{-- Chi tiết sản phẩm trong đơn hàng --}}
            <div style="text-align: left; margin-bottom: 36px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--client-color-heading); margin-bottom: 14px;">
                    DANH SÁCH XE TRONG ĐƠN HÀNG
                </h3>
                <div style="border: 1px solid var(--client-color-border); border-radius: 8px; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid var(--client-color-border);">
                                <th style="padding: 10px 16px; text-align: left;">Tên Mẫu Xe</th>
                                <th style="padding: 10px 16px; text-align: center;">Số lượng</th>
                                <th style="padding: 10px 16px; text-align: right;">Đơn giá</th>
                                <th style="padding: 10px 16px; text-align: right;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr style="border-bottom: 1px solid var(--client-color-border);">
                                    <td style="padding: 12px 16px; font-weight: 600; color: var(--client-color-heading);">
                                        {{ $item->product_name }}
                                        @if($item->variant_name)
                                            <div style="font-size: 0.8rem; color: var(--client-color-muted); font-weight: normal;">
                                                Phiên bản: {{ $item->variant_name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 12px 16px; text-align: center;">{{ $item->quantity }}</td>
                                    <td style="padding: 12px 16px; text-align: right;">{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                                    <td style="padding: 12px 16px; text-align: right; font-weight: 700; color: var(--client-color-primary);">
                                        {{ number_format($item->line_total, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Các nút hành động --}}
            <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
                <a href="{{ route('client.home') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="padding: 12px 28px; text-decoration: none; font-size: 0.95rem;">
                    Trở Về Trang Chủ
                </a>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '0988302882') }}" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_outline" style="padding: 12px 24px; text-decoration: none; font-size: 0.95rem;">
                    Gọi Hotline Bán Hàng: {{ $siteSettings['site_phone'] ?? '0988 302 882' }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

