@extends('admin.layouts.app')

@section('title', 'Quản Lý Danh Sách Dòng Xe')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" style="color: var(--admin-muted);">Tổng quan</a> &rsaquo; 
    <span>Dòng xe</span>
@endsection
@section('header_title', 'DANH SÁCH 15 DÒNG XE Ô TÔ VINFAST')

@section('content')
<div class="vinfast-autohaiphong_admin_card">
    <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
        <span>DANH SÁCH DÒNG XE TRÊN HỆ THỐNG</span>
    </div>

    <table class="vinfast-autohaiphong_admin_table">
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Hình Ảnh</th>
                <th>Tên Dòng Xe</th>
                <th>Phân Loại</th>
                <th>Giá Niêm Yết</th>
                <th>Trạng Thái</th>
                <th style="text-align: right;">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $prod)
                <tr>
                    <td>{{ $prod->id }}</td>
                    <td>
                        <img src="{{ $prod->thumbnail_path ? asset('storage/' . $prod->thumbnail_path) : asset('storage/clients/assets/images/business/vinfast-haiphong.png') }}" 
                             alt="{{ $prod->name }}" 
                             class="vinfast-autohaiphong_admin_product_thumb">
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--admin-heading);">{{ $prod->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--admin-muted);">Slug: {{ $prod->slug }} | SKU: {{ $prod->sku }}</div>
                    </td>
                    <td>{{ $prod->category_name ?? 'Ô tô điện' }}</td>
                    <td style="font-weight: 700; color: var(--admin-primary);">
                        @if($prod->sale_price || $prod->regular_price)
                            {{ number_format($prod->sale_price ?: $prod->regular_price, 0, ',', '.') }} đ
                        @else
                            Liên hệ
                        @endif
                    </td>
                    <td>
                        <span class="vinfast-autohaiphong_admin_badge vinfast-autohaiphong_admin_badge_success">
                            {{ $prod->status }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.products.edit', $prod->id) }}" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 6px 12px; font-size: 0.8rem;">
                            Sửa Xe & Specs Key-Value
                        </a>
                        <a href="{{ url('/xe/' . $prod->slug) }}" target="_blank" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 6px 10px; font-size: 0.8rem; display: inline-flex; align-items: center;" title="Xem thực tế ngoài website">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $products->links() }}
    </div>
</div>
@endsection

