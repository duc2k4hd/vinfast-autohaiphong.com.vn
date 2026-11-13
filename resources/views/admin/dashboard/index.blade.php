@extends('admin.layouts.app')

@section('title', 'Bảng Điều Khiển Tổng Quan')
@section('header_title', 'TỔNG QUAN HỆ THỐNG VINFAST HẢI PHÒNG')

@section('content')
{{-- Thẻ số liệu thống kê nhanh --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
    <div class="vinfast-autohaiphong_admin_card" style="margin-bottom: 0;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">DÒNG XE KINH DOANH</div>
        <div style="font-size: 2rem; font-weight: 800; color: var(--admin-heading); margin-top: 6px;">{{ $totalCars }}</div>
        <div style="font-size: 0.8rem; color: #16a34a; margin-top: 4px;">15 mẫu xe điện chuẩn hóa</div>
    </div>

    <div class="vinfast-autohaiphong_admin_card" style="margin-bottom: 0;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">YÊU CẦU BÁO GIÁ</div>
        <div style="font-size: 2rem; font-weight: 800; color: var(--admin-primary); margin-top: 6px;">{{ $totalLeads }}</div>
        <div style="font-size: 0.8rem; color: #d97706; margin-top: 4px;">{{ $newLeads }} yêu cầu mới chờ xử lý</div>
    </div>

    <div class="vinfast-autohaiphong_admin_card" style="margin-bottom: 0;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">ĐƠN CỌC TIỀN MẶT</div>
        <div style="font-size: 2rem; font-weight: 800; color: #d97706; margin-top: 6px;">{{ $totalOrders }}</div>
        <div style="font-size: 0.8rem; color: #475569; margin-top: 4px;">{{ $pendingCashOrders }} đơn chờ nộp tiền showroom</div>
    </div>

    <div class="vinfast-autohaiphong_admin_card" style="margin-bottom: 0;">
        <div style="font-size: 0.8rem; font-weight: 700; color: var(--admin-muted); text-transform: uppercase;">TỔNG GIÁ TRỊ ĐƠN HÀNG</div>
        <div style="font-size: 1.6rem; font-weight: 800; color: #16a34a; margin-top: 6px;">
            {{ number_format($totalOrderValue, 0, ',', '.') }} đ
        </div>
        <div style="font-size: 0.8rem; color: var(--admin-muted); margin-top: 4px;">Duy nhất thanh toán tiền mặt</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 24px;">
    {{-- Đơn đặt cọc mới nhất --}}
    <div class="vinfast-autohaiphong_admin_card">
        <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
            <span>ĐƠN ĐẶT CỌC MỚI NHẤT</span>
            <a href="{{ route('admin.orders.index') }}" style="font-size: 0.8rem; color: var(--admin-primary); font-weight: 600;">Xem tất cả &rarr;</a>
        </div>
        @if($recentOrders->isEmpty())
            <p style="color: var(--admin-muted); padding: 16px 0;">Chưa có đơn đặt hàng nào phát sinh.</p>
        @else
            <table class="vinfast-autohaiphong_admin_table">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Thanh Toán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $ord)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $ord->id) }}" style="font-weight: 700; color: var(--admin-primary);">
                                    {{ $ord->order_number }}
                                </a>
                            </td>
                            <td>
                                <div>{{ $ord->customer_name }}</div>
                                <div style="font-size: 0.8rem; color: var(--admin-muted);">{{ $ord->customer_phone }}</div>
                            </td>
                            <td style="font-weight: 600;">{{ number_format($ord->total, 0, ',', '.') }} đ</td>
                            <td>
                                @if($ord->payment_status === 'paid')
                                    <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">Đã thu tiền</span>
                                @else
                                    <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_warning">Chờ tiền mặt</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Khách hàng yêu cầu tư vấn mới nhất --}}
    <div class="vinfast-autohaiphong_admin_card">
        <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
            <span>YÊU CẦU BÁO GIÁ MỚI</span>
            <a href="{{ route('admin.leads.index') }}" style="font-size: 0.8rem; color: var(--admin-primary); font-weight: 600;">Xem tất cả &rarr;</a>
        </div>
        @if($recentLeads->isEmpty())
            <p style="color: var(--admin-muted); padding: 16px 0;">Chưa có yêu cầu tư vấn nào.</p>
        @else
            <table class="vinfast-autohaiphong_admin_table">
                <thead>
                    <tr>
                        <th>Khách Hàng</th>
                        <th>Xe Quan Tâm</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentLeads as $lead)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $lead->name }}</div>
                                <div style="font-size: 0.8rem; color: var(--admin-muted);">{{ $lead->phone }}</div>
                            </td>
                            <td style="font-size: 0.85rem;">{{ $lead->product_name ?? 'Chưa chọn xe' }}</td>
                            <td>
                                @if($lead->status === 'new')
                                    <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_warning">Mới</span>
                                @elseif($lead->status === 'contacted')
                                    <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">Đã gọi</span>
                                @else
                                    <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_danger">{{ $lead->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

