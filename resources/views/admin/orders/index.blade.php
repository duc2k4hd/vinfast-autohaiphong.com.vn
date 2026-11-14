@extends('admin.layouts.app')

@section('title', 'Quản Lý Đơn Đặt Cọc Tiền Mặt')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <span>Đơn đặt cọc tiền mặt</span>
@endsection
@section('header_title', 'DANH SÁCH ĐƠN HÀNG THANH TOÁN TIỀN MẶT')

@section('content')
<div class="vinfast-autohaiphong_admin_card">
    <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <span>DANH SÁCH ĐƠN ĐẶT CỌC XE</span>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <form action="{{ route('admin.orders.index') }}" method="GET" style="display: flex; gap: 6px;">
                @if($currentStatus)
                    <input type="hidden" name="payment_status" value="{{ $currentStatus }}">
                @endif
                <input type="text" name="search" value="{{ $currentSearch ?? '' }}" placeholder="Tìm mã đơn, tên, SĐT..." 
                       style="padding: 5px 10px; border: 1px solid var(--admin-border); border-radius: 5px; font-size: 0.8rem; width: 190px;">
                <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 10px; font-size: 0.8rem;">
                    Tìm
                </button>
            </form>

            <div style="display: flex; gap: 6px;">
                <a href="{{ route('admin.orders.index', array_filter(['search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ !$currentStatus ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Tất Cả
                </a>
                <a href="{{ route('admin.orders.index', array_filter(['payment_status' => 'unpaid', 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentStatus === 'unpaid' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Chờ Tiền Mặt
                </a>
                <a href="{{ route('admin.orders.index', array_filter(['payment_status' => 'paid', 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentStatus === 'paid' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Đã Thu Tiền
                </a>
            </div>
        </div>
    </div>

    @if($orders->isEmpty())
        <p style="color: var(--admin-muted); padding: 24px 0; text-align: center;">Chưa có đơn hàng nào.</p>
    @else
        <table class="vinfast-autohaiphong_admin_table">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Ngày Đăng Ký</th>
                    <th>Khách Hàng</th>
                    <th>Số Điện Thoại</th>
                    <th>Tổng Giá Trị</th>
                    <th>Phương Thức</th>
                    <th>Thanh Toán</th>
                    <th style="text-align: right;">Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" style="font-weight: 700; color: var(--admin-primary);">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td style="font-size: 0.8rem; color: var(--admin-muted);">
                            {{ date('d/m/Y H:i', strtotime($order->created_at)) }}
                        </td>
                        <td style="font-weight: 600;">{{ $order->customer_name }}</td>
                        <td>
                            <a href="tel:{{ $order->customer_phone }}" style="color: var(--admin-text);">
                                {{ $order->customer_phone }}
                            </a>
                        </td>
                        <td style="font-weight: 700; color: var(--admin-heading);">
                            {{ number_format($order->total, 0, ',', '.') }} đ
                        </td>
                        <td>
                            <span class="vinfast-autohaiphong_admin_badge" style="background: #eff6ff; color: #1e40af; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                                Tiền mặt
                            </span>
                        </td>
                        <td>
                            @if($order->payment_status === 'paid')
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">Đã thu tiền mặt</span>
                            @else
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_warning">Chờ nộp tiền</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 12px; font-size: 0.8rem;">
                                Xem Đơn &rarr;
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

