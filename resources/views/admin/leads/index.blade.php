@extends('admin.layouts.app')

@section('title', 'Quản Lý Khách Hàng Tiềm Năng (Leads)')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <span>Yêu cầu báo giá</span>
@endsection
@section('header_title', 'DANH SÁCH YÊU CẦU BÁO GIÁ LĂN BÁNH & TƯ VẤN')

@section('content')
<div class="vinfast-autohaiphong_admin_card">
    <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <span>DANH SÁCH YÊU CẦU TƯ VẤN TỪ KHÁCH HÀNG</span>
        
        <form action="{{ route('admin.leads.index') }}" method="GET" style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <input type="text" name="search" value="{{ $currentSearch ?? '' }}" placeholder="Tìm theo tên, SĐT..." 
                   style="padding: 5px 10px; border: 1px solid var(--admin-border); border-radius: 5px; font-size: 0.8rem; width: 170px;">

            <select name="product_id" onchange="this.form.submit()" style="padding: 5px 10px; border: 1px solid var(--admin-border); border-radius: 5px; font-size: 0.8rem; background: #ffffff;">
                <option value="">-- Tất cả dòng xe --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ ($currentProductId ?? '') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 5px 10px; font-size: 0.8rem;">
                Lọc
            </button>

            <div style="display: flex; gap: 6px;">
                <a href="{{ route('admin.leads.index', array_filter(['product_id' => $currentProductId, 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ !$currentStatus ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Tất Cả
                </a>
                <a href="{{ route('admin.leads.index', array_filter(['status' => 'new', 'product_id' => $currentProductId, 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentStatus === 'new' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Mới
                </a>
                <a href="{{ route('admin.leads.index', array_filter(['status' => 'contacted', 'product_id' => $currentProductId, 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentStatus === 'contacted' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Đã Gọi
                </a>
                <a href="{{ route('admin.leads.index', array_filter(['status' => 'converted', 'product_id' => $currentProductId, 'search' => $currentSearch])) }}" class="vinfast-autohaiphong_admin_btn {{ $currentStatus === 'converted' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                    Đã Chốt
                </a>
            </div>
        </form>
    </div>

    @if($leads->isEmpty())
        <p style="color: var(--admin-muted); padding: 24px 0; text-align: center;">Chưa có dữ liệu yêu cầu nào.</p>
    @else
        <table class="vinfast-autohaiphong_admin_table">
            <thead>
                <tr>
                    <th>Thời Gian</th>
                    <th>Khách Hàng</th>
                    <th>Số Điện Thoại</th>
                    <th>Xe Quan Tâm</th>
                    <th>Ghi Chú</th>
                    <th>Trạng Thái</th>
                    <th style="text-align: right;">Cập Nhật</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                    <tr>
                        <td style="font-size: 0.8rem; color: var(--admin-muted);">
                            {{ date('d/m/Y H:i', strtotime($lead->created_at)) }}
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--admin-heading);">{{ $lead->name }}</div>
                            @if($lead->email)
                                <div style="font-size: 0.8rem; color: var(--admin-muted);">{{ $lead->email }}</div>
                            @endif
                        </td>
                        <td>
                            <a href="tel:{{ $lead->phone }}" style="font-weight: 700; color: var(--admin-primary); display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                {{ $lead->phone }}
                            </a>
                        </td>
                        <td>
                            <span style="font-weight: 600;">{{ $lead->product_name ?? 'Tư vấn chung' }}</span>
                        </td>
                        <td style="font-size: 0.85rem; color: #475569; max-width: 250px;">
                            {{ $lead->message ?? 'Khách gửi yêu cầu báo giá' }}
                        </td>
                        <td>
                            @if($lead->status === 'new')
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_warning">Mới nhận</span>
                            @elseif($lead->status === 'contacted')
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">Đã gọi điện</span>
                            @elseif($lead->status === 'converted')
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">Đã chốt cọc</span>
                            @else
                                <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_danger">Từ chối</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <form action="{{ route('admin.leads.update_status', $lead->id) }}" method="POST" style="display: inline-flex; gap: 4px;">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" style="padding: 4px 8px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.8rem;">
                                    <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>Mới</option>
                                    <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>Đã gọi</option>
                                    <option value="converted" {{ $lead->status === 'converted' ? 'selected' : '' }}>Đã chốt cọc</option>
                                    <option value="rejected" {{ $lead->status === 'rejected' ? 'selected' : '' }}>Hủy bỏ</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $leads->links() }}
        </div>
    @endif
</div>
@endsection

