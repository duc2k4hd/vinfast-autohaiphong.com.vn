@extends('admin.layouts.app')

@section('title', 'Quản Lý Khách Hàng Tiềm Năng (Leads)')
@section('header_title', 'DANH SÁCH YÊU CẦU BÁO GIÁ LĂN BÁNH & TƯ VẤN')

@section('content')
<div class="vinfast-autohaiphong_admin_card">
    <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <span>DANH SÁCH YÊU CẦU TƯ VẤN TỪ KHÁCH HÀNG</span>
        
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.leads.index') }}" class="vinfast-autohaiphong_admin_btn {{ !$currentStatus ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Tất Cả
            </a>
            <a href="{{ route('admin.leads.index', ['status' => 'new']) }}" class="vinfast-autohaiphong_admin_btn {{ $currentStatus === 'new' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Mới
            </a>
            <a href="{{ route('admin.leads.index', ['status' => 'contacted']) }}" class="vinfast-autohaiphong_admin_btn {{ $currentStatus === 'contacted' ? 'vinfast-autohaiphong_admin_btn_primary' : 'vinfast-autohaiphong_admin_btn_outline' }}" style="padding: 4px 10px; font-size: 0.8rem;">
                Đã Liên Hệ
            </a>
        </div>
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
                            <a href="tel:{{ $lead->phone }}" style="font-weight: 700; color: var(--admin-primary);">
                                📞 {{ $lead->phone }}
                            </a>
                        </td>
                        <td>
                            <span style="font-weight: 600;">{{ $lead->product_name ?? 'Tư vấn chung' }}</span>
                        </td>
                        <td style="font-size: 0.85rem; color: #475569; max-width: 250px;">
                            {{ $lead->note ?: 'Khách gửi yêu cầu báo giá' }}
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

