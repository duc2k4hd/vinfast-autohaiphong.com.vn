@extends('admin.layouts.app')

@section('title', 'Chi Tiết Đơn Hàng ' . $order->order_number)
@section('header_title', 'CHI TIẾT ĐƠN HÀNG ' . $order->order_number)

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.orders.index') }}" style="color: var(--admin-primary); font-weight: 600;">
        &larr; Quay lại danh sách đơn hàng
    </a>
</div>

<div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 24px; align-items: start;">
    {{-- Cột Trái: Thông tin xe & Chi tiết thanh toán --}}
    <div>
        <div class="vinfast-autohaiphong_admin_card">
            <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
                <span>DANH SÁCH MẪU XE ĐẶT CỌC</span>
                <span class="vinfast-autohaiphong_admin_badge {{ $order->payment_status === 'paid' ? 'vinfast-autohaiphong_admin_badge_success' : 'vinfast-autohaiphong_admin_badge_warning' }}" style="font-size: 0.85rem; padding: 4px 10px;">
                    {{ $order->payment_status === 'paid' ? 'ĐÃ THU TIỀN MẶT' : 'CHỜ NỘP TIỀN TẠI SHOWROOM' }}
                </span>
            </div>

            <table class="vinfast-autohaiphong_admin_table" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th>Tên Mẫu Xe</th>
                        <th style="text-align: center;">Số Lượng</th>
                        <th style="text-align: right;">Đơn Giá</th>
                        <th style="text-align: right;">Thành Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $it)
                        <tr>
                            <td>
                                <div style="font-weight: 700;">{{ $it->product_name }}</div>
                                @if($it->variant_name)
                                    <div style="font-size: 0.8rem; color: var(--admin-muted);">Phiên bản: {{ $it->variant_name }}</div>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $it->quantity }}</td>
                            <td style="text-align: right;">{{ number_format($it->unit_price, 0, ',', '.') }} đ</td>
                            <td style="text-align: right; font-weight: 700; color: var(--admin-primary);">
                                {{ number_format($it->line_total, 0, ',', '.') }} đ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align: right; font-size: 1.1rem; border-top: 2px solid var(--admin-border); padding-top: 14px;">
                Tổng giá trị đơn hàng: <strong style="color: var(--admin-primary); font-size: 1.4rem;">{{ number_format($order->total, 0, ',', '.') }} VNĐ</strong>
            </div>
        </div>

        {{-- Lịch sử ghi nhận thanh toán tiền mặt (Payment Records) --}}
        <div class="vinfast-autohaiphong_admin_card">
            <div class="vinfast-autohaiphong_admin_card_title">LỊCH SỬ THU TIỀN MẶT (SHOWROOM)</div>

            @if($payments->isEmpty())
                <p style="color: var(--admin-muted);">Chưa có bản ghi thanh toán.</p>
            @else
                <table class="vinfast-autohaiphong_admin_table">
                    <thead>
                        <tr>
                            <th>Số Tiền</th>
                            <th>Phương Thức</th>
                            <th>Trạng Thái</th>
                            <th>Thời Gian Nhận</th>
                            <th>Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $pay)
                            <tr>
                                <td style="font-weight: 700;">{{ number_format($pay->amount, 0, ',', '.') }} đ</td>
                                <td>💵 Tiền mặt</td>
                                <td>
                                    @if($pay->status === 'confirmed')
                                        <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">Đã xác nhận thu</span>
                                    @else
                                        <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_warning">Chờ thu tiền</span>
                                    @endif
                                </td>
                                <td>{{ $pay->received_at ? date('d/m/Y H:i', strtotime($pay->received_at)) : 'Chưa thu' }}</td>
                                <td style="font-size: 0.8rem; color: #64748b;">{{ $pay->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Cột Phải: Thông tin khách hàng & Nút Xác nhận thu tiền --}}
    <div>
        <div class="vinfast-autohaiphong_admin_card">
            <div class="vinfast-autohaiphong_admin_card_title">THÔNG TIN KHÁCH HÀNG</div>

            <div style="margin-bottom: 12px;">
                <span style="color: var(--admin-muted); display: block; font-size: 0.8rem;">Họ và tên:</span>
                <strong style="font-size: 1.05rem; color: var(--admin-heading);">{{ $order->customer_name }}</strong>
            </div>

            <div style="margin-bottom: 12px;">
                <span style="color: var(--admin-muted); display: block; font-size: 0.8rem;">Số điện thoại:</span>
                <a href="tel:{{ $order->customer_phone }}" style="font-weight: 700; color: var(--admin-primary); font-size: 1.05rem;">
                    📞 {{ $order->customer_phone }}
                </a>
            </div>

            @if($order->customer_email)
                <div style="margin-bottom: 12px;">
                    <span style="color: var(--admin-muted); display: block; font-size: 0.8rem;">Email:</span>
                    <span>{{ $order->customer_email }}</span>
                </div>
            @endif

            @if($order->customer_note)
                <div style="margin-bottom: 16px;">
                    <span style="color: var(--admin-muted); display: block; font-size: 0.8rem;">Ghi chú của khách:</span>
                    <div style="background: #f8fafc; padding: 10px; border-radius: 4px; font-size: 0.85rem; border: 1px solid var(--admin-border);">
                        {{ $order->customer_note }}
                    </div>
                </div>
            @endif

            <div style="border-top: 1px solid var(--admin-border); padding-top: 16px; margin-top: 16px;">
                <div style="font-size: 0.8rem; color: var(--admin-muted); margin-bottom: 4px;">Thời gian tạo đơn:</div>
                <div style="font-weight: 600;">{{ date('d/m/Y H:i:s', strtotime($order->created_at)) }}</div>
            </div>

            {{-- Nút xác nhận thu tiền mặt --}}
            <div style="margin-top: 24px;">
                @if($order->payment_status !== 'paid')
                    <form action="{{ route('admin.orders.confirm_cash', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn xác nhận đã kiểm đếm và thu đủ tiền mặt tại Showroom?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_primary" style="width: 100%; padding: 12px; font-size: 0.95rem;">
                            💵 Xác Nhận Đã Thu Tiền Mặt Tại Showroom
                        </button>
                    </form>
                @else
                    <div style="background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 12px; border-radius: 6px; text-align: center; font-weight: 700;">
                        ✓ Đã hoàn tất thu tiền mặt tại Showroom
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

