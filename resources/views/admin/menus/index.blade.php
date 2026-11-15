@extends('admin.layouts.app')

@section('title', 'Quản Lý Menu & Ảnh Hiển Thị')
@section('header_title', 'Quản Lý Menu & Ảnh Hiển Thị')

@section('breadcrumb')
    <span>Hệ thống</span> / <span style="color: var(--admin-primary); font-weight: 600;">Quản lý Menu</span>
@endsection

@section('content')
<div class="vf-menu-admin-wrap" style="display: flex; flex-direction: column; gap: 20px;">

    {{-- Alert thông báo --}}
    @if(session('success'))
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 18px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 1.1rem; cursor: pointer; color: #065f46;">&times;</button>
        </div>
    @endif

    {{-- Header Tabs Navigation --}}
    <div style="background: #ffffff; border: 1px solid var(--admin-border); border-radius: 10px; padding: 6px 10px; display: flex; gap: 8px; align-items: center; justify-content: space-between; flex-wrap: wrap;">
        <div style="display: flex; gap: 8px;">
            <button type="button" class="vf-tab-btn active" id="tab-btn-cars" onclick="switchMenuTab('cars')" style="padding: 10px 18px; border-radius: 7px; border: none; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Menu Xe & Ảnh Hiển Thị (Mega Menu)
                <span style="background: #e0e7ff; color: #3730a3; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem;">{{ $vehicles->count() }} xe</span>
            </button>
            <button type="button" class="vf-tab-btn" id="tab-btn-nav" onclick="switchMenuTab('nav')" style="padding: 10px 18px; border-radius: 7px; border: none; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; background: transparent; color: var(--admin-text);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                Menu Điều Hướng Header
                <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem;">{{ $headerItems->count() }} mục</span>
            </button>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('client.home') }}" target="_blank" class="vinfast-autohaiphong_admin_btn" style="padding: 8px 14px; font-size: 0.84rem; background: #f8fafc; border: 1px solid var(--admin-border); color: var(--admin-text); display: inline-flex; align-items: center; gap: 6px; border-radius: 6px; text-decoration: none;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                Xem Menu Ngoài Web
            </a>
        </div>
    </div>

    {{-- TAB 1: MENU XE & ẢNH HIỂN THỊ (MEGA MENU) --}}
    <div id="tab-content-cars" class="vf-tab-content" style="display: block;">
        <form action="{{ route('admin.menus.vehicles.update') }}" method="POST" id="form-car-menu">
            @csrf

            <div style="background: #ffffff; border: 1px solid var(--admin-border); border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                <div style="padding: 16px 20px; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; background: #fafbfc;">
                    <div>
                        <h2 style="font-size: 1.05rem; font-weight: 700; color: var(--admin-heading); margin: 0 0 4px 0;">Danh Sách Xe Trong Mega Menu "Ô Tô VinFast"</h2>
                        <p style="font-size: 0.8rem; color: var(--admin-muted); margin: 0;">Bấm nút "Đổi ảnh" trên từng dòng xe để chọn ảnh cutout/studio hiển thị trực tiếp trên menu. Bật/tắt hoặc chỉnh số thứ tự để sắp xếp menu.</p>
                    </div>

                    <div style="display: flex; gap: 10px; align-items: center;">
                        <button type="submit" class="vinfast-autohaiphong_admin_btn" style="background: var(--admin-primary); color: #ffffff; padding: 9px 18px; border-radius: 6px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(20,100,244,0.2);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            Lưu Tất Cả Thay Đổi
                        </button>
                    </div>
                </div>

                {{-- Bảng quản lý xe & ảnh menu --}}
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid var(--admin-border); color: var(--admin-heading); font-weight: 700; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 12px 16px; width: 60px; text-align: center;">STT</th>
                                <th style="padding: 12px 16px; width: 180px;">Ảnh Hiển Thị Menu</th>
                                <th style="padding: 12px 16px; min-width: 220px;">Dòng Xe & Đường Dẫn</th>
                                <th style="padding: 12px 16px; width: 170px;">Phân Nhóm</th>
                                <th style="padding: 12px 16px; width: 100px; text-align: center;">Thứ Tự</th>
                                <th style="padding: 12px 16px; width: 140px; text-align: center;">Hiển Thị Menu</th>
                                <th style="padding: 12px 16px; width: 130px; text-align: center;">Thao Tác Nhanh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $index => $car)
                                <tr id="car-row-{{ $car->id }}" style="border-bottom: 1px solid var(--admin-border); transition: background 0.15s;" onmouseover="this.style.background='#fdfefe'" onmouseout="this.style.background='transparent'">
                                    {{-- Cột STT --}}
                                    <td style="padding: 12px 16px; text-align: center; color: var(--admin-muted); font-weight: 600;">
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- Cột Ảnh hiển thị menu --}}
                                    <td style="padding: 12px 16px;">
                                        <div style="display: flex; flex-direction: column; gap: 8px;">
                                            <div id="car-thumb-box-{{ $car->id }}" style="width: 140px; height: 75px; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                                                @if($car->thumbnail_path)
                                                    <img id="car-thumb-img-{{ $car->id }}" src="{{ asset('storage/' . $car->thumbnail_path) }}" alt="{{ $car->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 4px;">
                                                @else
                                                    <span id="car-thumb-empty-{{ $car->id }}" style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">Chưa có ảnh</span>
                                                @endif
                                            </div>

                                            <input type="hidden" name="vehicles[{{ $car->id }}][thumbnail_media_id]" id="car-media-input-{{ $car->id }}" value="{{ $car->thumbnail_media_id }}">

                                            <div style="display: flex; gap: 6px;">
                                                <button type="button" onclick="chooseCarMenuImage({{ $car->id }})" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 10px; font-size: 0.76rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; font-weight: 600; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                                    Đổi ảnh
                                                </button>
                                                @if($car->thumbnail_media_id)
                                                    <button type="button" onclick="removeCarMenuImage({{ $car->id }})" id="car-remove-btn-{{ $car->id }}" style="padding: 5px 8px; font-size: 0.76rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer;">
                                                        ✕
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Cột Tên xe & Đường dẫn --}}
                                    <td style="padding: 12px 16px;">
                                        <div style="font-weight: 700; color: var(--admin-heading); font-size: 0.95rem; margin-bottom: 4px;">
                                            {{ $car->name }}
                                        </div>
                                        <div style="font-size: 0.76rem; color: var(--admin-muted); display: flex; align-items: center; gap: 6px;">
                                            <span>/xe/{{ $car->slug }}</span>
                                            <a href="{{ route('client.products.show', $car->slug) }}" target="_blank" style="color: var(--admin-primary); text-decoration: none;" title="Xem chi tiết xe ngoài web">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                            </a>
                                        </div>
                                        <div style="margin-top: 6px;">
                                            <a href="{{ route('admin.products.edit', $car->id) }}" style="font-size: 0.74rem; color: #475569; text-decoration: underline;">
                                                Chỉnh sửa toàn bộ xe &rarr;
                                            </a>
                                        </div>
                                    </td>

                                    {{-- Cột Phân nhóm --}}
                                    <td style="padding: 12px 16px;">
                                        @if(str_contains(strtolower($car->category_name ?? ''), 'dịch vụ') || str_contains(strtolower($car->category_name ?? ''), 'xanh'))
                                            <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 12px; font-size: 0.76rem; font-weight: 600; display: inline-block;">
                                                🌱 {{ $car->category_name ?: 'Vận Tải Xanh' }}
                                            </span>
                                        @else
                                            <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 4px 10px; border-radius: 12px; font-size: 0.76rem; font-weight: 600; display: inline-block;">
                                                🚗 {{ $car->category_name ?: 'Ô Tô Du Lịch' }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Cột Thứ tự sắp xếp --}}
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <input type="number" name="vehicles[{{ $car->id }}][sort_order]" id="car-sort-{{ $car->id }}" value="{{ $car->sort_order }}" min="0" max="999" style="width: 65px; text-align: center; padding: 6px; border: 1px solid var(--admin-border); border-radius: 5px; font-weight: 700; color: var(--admin-heading);">
                                    </td>

                                    {{-- Cột Bật/Tắt hiển thị menu --}}
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <label style="display: inline-flex; align-items: center; cursor: pointer; gap: 8px;">
                                            <input type="checkbox" name="vehicles[{{ $car->id }}][show_in_menu]" id="car-show-{{ $car->id }}" value="1" {{ $car->show_in_menu ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--admin-primary);">
                                            <span style="font-size: 0.82rem; font-weight: 600; color: {{ $car->show_in_menu ? '#059669' : '#dc2626' }};" id="car-status-text-{{ $car->id }}">
                                                {{ $car->show_in_menu ? 'Hiển thị' : 'Đang ẩn' }}
                                            </span>
                                        </label>
                                    </td>

                                    {{-- Cột Thao tác nhanh (AJAX) --}}
                                    <td style="padding: 12px 16px; text-align: center;">
                                        <button type="button" onclick="saveSingleCar({{ $car->id }})" id="btn-save-car-{{ $car->id }}" class="vinfast-autohaiphong_admin_btn" style="padding: 6px 12px; font-size: 0.78rem; background: #f8fafc; border: 1px solid var(--admin-border); color: var(--admin-heading); font-weight: 600; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            💾 Lưu dòng
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding: 30px; text-align: center; color: var(--admin-muted);">
                                        Chưa có dữ liệu dòng xe trong hệ thống.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer Action Bar --}}
                <div style="padding: 16px 20px; background: #fafbfc; border-top: 1px solid var(--admin-border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div style="font-size: 0.82rem; color: var(--admin-muted);">
                        💡 Mẹo: Sau khi đổi ảnh hoặc thứ tự xe, bấm <strong>"Lưu Tất Cả Thay Đổi"</strong> hoặc bấm <strong>"Lưu dòng"</strong> để hệ thống tự động xóa cache và hiển thị ngay trên web!
                    </div>

                    <button type="submit" class="vinfast-autohaiphong_admin_btn" style="background: var(--admin-primary); color: #ffffff; padding: 10px 22px; border-radius: 6px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Lưu Toàn Bộ Cấu Hình Xe
                    </button>
                </div>
            </div>
        </form>

        {{-- KHUNG XEM TRƯỚC GIAO DIỆN MEGA MENU (LIVE PREVIEW) --}}
        <div style="margin-top: 24px; background: #ffffff; border: 1px solid var(--admin-border); border-radius: 10px; padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid var(--admin-border); padding-bottom: 12px;">
                <div>
                    <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--admin-heading); margin: 0 0 2px 0;">Xem Trước Trực Quan Dropdown "Khám Phá Các Dòng Xe VinFast"</h3>
                    <p style="font-size: 0.78rem; color: var(--admin-muted); margin: 0;">Mô phỏng chính xác khung menu người dùng nhìn thấy khi click vào menu trên trang chủ.</p>
                </div>
                <span style="font-size: 0.76rem; background: #ecfdf5; color: #047857; padding: 3px 10px; border-radius: 20px; font-weight: 600;">Live Preview</span>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                    <span style="font-weight: 700; font-size: 0.95rem; color: #0f172a;">Khám phá các dòng xe VinFast</span>
                    <span style="font-size: 0.8rem; color: var(--admin-primary); font-weight: 600;">Xem tất cả xe &rarr;</span>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 14px;">
                    @foreach($vehicles->where('show_in_menu', 1) as $car)
                        <div style="border: 1px solid #f1f5f9; border-radius: 8px; padding: 12px; text-align: center; background: #fafbfc;">
                            <div style="height: 70px; display: flex; align-items: center; justify-content: center; margin-bottom: 8px;">
                                @if($car->thumbnail_path)
                                    <img src="{{ asset('storage/' . $car->thumbnail_path) }}" alt="{{ $car->name }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                @else
                                    <span style="font-size: 0.7rem; color: #94a3b8;">Chưa có ảnh</span>
                                @endif
                            </div>
                            <div style="font-weight: 700; font-size: 0.82rem; color: #0f172a; margin-bottom: 2px;">{{ $car->name }}</div>
                            <div style="font-size: 0.7rem; color: #64748b;">{{ $car->category_name ?? 'Ô Tô Điện' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- TAB 2: MENU ĐIỀU HƯỚNG HEADER (NAVIGATION) --}}
    <div id="tab-content-nav" class="vf-tab-content" style="display: none;">
        <div style="background: #ffffff; border: 1px solid var(--admin-border); border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; background: #fafbfc;">
                <div>
                    <h2 style="font-size: 1.05rem; font-weight: 700; color: var(--admin-heading); margin: 0 0 4px 0;">Cấu Hình Menu Thanh Điều Hướng (Header Navigation)</h2>
                    <p style="font-size: 0.8rem; color: var(--admin-muted); margin: 0;">Quản lý các đường link cấp 1 xuất hiện trên thanh menu chính của website.</p>
                </div>

                <button type="button" onclick="openCreateMenuItemModal()" class="vinfast-autohaiphong_admin_btn" style="background: var(--admin-primary); color: #ffffff; padding: 8px 16px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Thêm Mục Menu Mới
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid var(--admin-border); color: var(--admin-heading); font-weight: 700; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            <th style="padding: 12px 16px; width: 60px; text-align: center;">Thứ tự</th>
                            <th style="padding: 12px 16px; min-width: 180px;">Tiêu đề hiển thị</th>
                            <th style="padding: 12px 16px; min-width: 220px;">Đường dẫn (URL / Route)</th>
                            <th style="padding: 12px 16px; width: 140px;">Huy hiệu / Ghi chú</th>
                            <th style="padding: 12px 16px; width: 100px; text-align: center;">Mở tab</th>
                            <th style="padding: 12px 16px; width: 120px; text-align: center;">Trạng thái</th>
                            <th style="padding: 12px 16px; width: 140px; text-align: center;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($headerItems as $item)
                            <tr style="border-bottom: 1px solid var(--admin-border); transition: background 0.15s;" onmouseover="this.style.background='#fdfefe'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 12px 16px; text-align: center; font-weight: 700; color: var(--admin-heading);">
                                    {{ $item->sort_order }}
                                </td>
                                <td style="padding: 12px 16px; font-weight: 600; color: var(--admin-heading);">
                                    {{ $item->label }}
                                </td>
                                <td style="padding: 12px 16px; font-size: 0.8rem; color: var(--admin-muted); font-family: monospace;">
                                    @if($item->route_name)
                                        <span style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; color: #0f172a;">route('{{ $item->route_name }}')</span>
                                    @else
                                        <span>{{ $item->url ?: '#' }}</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 16px;">
                                    @if($item->badge)
                                        <span style="background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 10px; font-size: 0.74rem; font-weight: 600;">
                                            {{ $item->badge }}
                                        </span>
                                    @endif
                                    @if($item->description)
                                        <div style="font-size: 0.72rem; color: #94a3b8; margin-top: 2px;">{{ $item->description }}</div>
                                    @endif
                                </td>
                                <td style="padding: 12px 16px; text-align: center; font-size: 0.8rem;">
                                    {{ $item->target === '_blank' ? 'Tab mới' : 'Hiện tại' }}
                                </td>
                                <td style="padding: 12px 16px; text-align: center;">
                                    @if($item->is_active)
                                        <span style="background: #ecfdf5; color: #047857; padding: 3px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600;">Bật</span>
                                    @else
                                        <span style="background: #fef2f2; color: #b91c1c; padding: 3px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600;">Tắt</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 16px; text-align: center;">
                                    <div style="display: flex; gap: 6px; justify-content: center;">
                                        <button type="button" onclick="editMenuItem({{ json_encode($item) }})" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 10px; font-size: 0.76rem; background: #eff6ff; color: #1464f4; border: 1px solid #bfdbfe; border-radius: 4px; cursor: pointer;">
                                            Sửa
                                        </button>
                                        <form action="{{ route('admin.menus.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mục menu này?')" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="vinfast-autohaiphong_admin_btn" style="padding: 5px 8px; font-size: 0.76rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 4px; cursor: pointer;">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 30px; text-align: center; color: var(--admin-muted);">
                                    Chưa có mục menu nào. Bấm nút "Thêm Mục Menu Mới" ở trên để tạo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL THÊM / SỬA MENU ITEM --}}
<div id="modal-menu-item" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: #ffffff; width: 95%; max-width: 500px; border-radius: 10px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; background: #fafbfc;">
            <h3 id="modal-menu-title" style="margin: 0; font-size: 1rem; font-weight: 700; color: var(--admin-heading);">Thêm Mục Menu Mới</h3>
            <button type="button" onclick="closeMenuItemModal()" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--admin-muted);">&times;</button>
        </div>

        <form id="form-menu-item" method="POST" action="{{ route('admin.menus.items.store') }}">
            @csrf
            <input type="hidden" name="_method" id="menu-item-method" value="POST">
            <input type="hidden" name="menu_id" value="{{ $headerMenu->id }}">

            <div style="padding: 20px; display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 4px; color: var(--admin-heading);">Tiêu đề hiển thị (*)</label>
                    <input type="text" name="label" id="item-label" required placeholder="Ví dụ: Bảng Giá Xe" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.88rem;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 4px; color: var(--admin-heading);">Đường dẫn URL</label>
                    <input type="text" name="url" id="item-url" placeholder="Ví dụ: /bang-gia-xe hoặc https://..." style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.88rem;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 4px; color: var(--admin-heading);">Tên Route nội bộ (Nếu dùng Route Laravel)</label>
                    <input type="text" name="route_name" id="item-route" placeholder="Ví dụ: client.home hoặc client.posts.index" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.88rem;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 4px; color: var(--admin-heading);">Huy hiệu (Badge)</label>
                        <input type="text" name="badge" id="item-badge" placeholder="Ví dụ: Mới, Hot" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.88rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 4px; color: var(--admin-heading);">Thứ tự sắp xếp</label>
                        <input type="number" name="sort_order" id="item-sort" value="0" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.88rem;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 4px; color: var(--admin-heading);">Cách mở liên kết</label>
                        <select name="target" id="item-target" style="width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 0.88rem;">
                            <option value="_self">Tại trang hiện tại (_self)</option>
                            <option value="_blank">Mở tab mới (_blank)</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: center; margin-top: 20px;">
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">
                            <input type="checkbox" name="is_active" id="item-active" value="1" checked style="width: 18px; height: 18px;">
                            Bật hiển thị
                        </label>
                    </div>
                </div>
            </div>

            <div style="padding: 14px 20px; background: #fafbfc; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeMenuItemModal()" style="padding: 8px 14px; border: 1px solid var(--admin-border); background: #ffffff; border-radius: 6px; cursor: pointer; font-size: 0.84rem;">Hủy</button>
                <button type="submit" class="vinfast-autohaiphong_admin_btn" style="background: var(--admin-primary); color: #ffffff; padding: 8px 18px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; font-size: 0.84rem;">Lưu Mục Menu</button>
            </div>
        </form>
    </div>
</div>

<script>
// =========================================================================
// 1. CHUYỂN TAB GIAO DIỆN
// =========================================================================
function switchMenuTab(tab) {
    const btnCars = document.getElementById('tab-btn-cars');
    const btnNav = document.getElementById('tab-btn-nav');
    const contentCars = document.getElementById('tab-content-cars');
    const contentNav = document.getElementById('tab-content-nav');

    if (tab === 'cars') {
        btnCars.style.background = '#ffffff';
        btnCars.style.color = 'var(--admin-primary)';
        btnCars.style.boxShadow = '0 1px 3px rgba(0,0,0,0.05)';
        btnNav.style.background = 'transparent';
        btnNav.style.color = 'var(--admin-text)';
        btnNav.style.boxShadow = 'none';
        contentCars.style.display = 'block';
        contentNav.style.display = 'none';
    } else {
        btnNav.style.background = '#ffffff';
        btnNav.style.color = 'var(--admin-primary)';
        btnNav.style.boxShadow = '0 1px 3px rgba(0,0,0,0.05)';
        btnCars.style.background = 'transparent';
        btnCars.style.color = 'var(--admin-text)';
        btnCars.style.boxShadow = 'none';
        contentCars.style.display = 'none';
        contentNav.style.display = 'block';
    }
}

// Kiểm tra query param tab
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('tab') === 'navigation') {
    switchMenuTab('nav');
}

// =========================================================================
// 2. CHỌN ẢNH CHO TỪNG DÒNG XE QUA MEDIA LIBRARY MODAL
// =========================================================================
function chooseCarMenuImage(carId) {
    if (typeof window.openMediaManager !== 'function') {
        alert('Trình quản lý Media chưa sẵn sàng. Vui lòng thử lại!');
        return;
    }

    window.openMediaManager({
        mode: 'single',
        confirmText: 'Chọn làm ảnh Menu',
        onSelect: function(media) {
            const input = document.getElementById('car-media-input-' + carId);
            const box = document.getElementById('car-thumb-box-' + carId);

            if (input) input.value = media.id;
            if (box) {
                box.innerHTML = `<img id="car-thumb-img-${carId}" src="/storage/${media.path}" alt="${media.title || 'Xe'}" style="max-width: 100%; max-height: 100%; object-fit: contain; padding: 4px;">`;
            }

            // Tự động lưu nhanh qua AJAX
            saveSingleCar(carId);
        }
    });
}

function removeCarMenuImage(carId) {
    if (!confirm('Xóa ảnh hiển thị của xe này khỏi menu?')) return;
    const input = document.getElementById('car-media-input-' + carId);
    const box = document.getElementById('car-thumb-box-' + carId);
    if (input) input.value = '';
    if (box) {
        box.innerHTML = `<span style="font-size: 0.72rem; color: #94a3b8; font-weight: 500;">Chưa có ảnh</span>`;
    }
    saveSingleCar(carId);
}

// =========================================================================
// 3. LƯU NHANH TỪNG XE QUA AJAX
// =========================================================================
function saveSingleCar(carId) {
    const btn = document.getElementById('btn-save-car-' + carId);
    const mediaInput = document.getElementById('car-media-input-' + carId);
    const sortInput = document.getElementById('car-sort-' + carId);
    const showCheckbox = document.getElementById('car-show-' + carId);
    const statusText = document.getElementById('car-status-text-' + carId);

    const oldBtnText = btn ? btn.innerHTML : '';
    if (btn) {
        btn.innerHTML = '⏳ Đang lưu...';
        btn.disabled = true;
    }

    const payload = {
        _token: '{{ csrf_token() }}',
        thumbnail_media_id: mediaInput ? mediaInput.value : null,
        sort_order: sortInput ? parseInt(sortInput.value, 10) : 0,
        show_in_menu: showCheckbox && showCheckbox.checked ? 1 : 0
    };

    fetch('/admin/menus/vehicles/' + carId, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (btn) {
            btn.innerHTML = '✅ Đã lưu';
            btn.style.background = '#ecfdf5';
            btn.style.color = '#047857';
            btn.style.borderColor = '#a7f3d0';
            setTimeout(() => {
                btn.innerHTML = '💾 Lưu dòng';
                btn.style.background = '#f8fafc';
                btn.style.color = 'var(--admin-heading)';
                btn.style.borderColor = 'var(--admin-border)';
                btn.disabled = false;
            }, 2000);
        }
        if (statusText && showCheckbox) {
            statusText.textContent = showCheckbox.checked ? 'Hiển thị' : 'Đang ẩn';
            statusText.style.color = showCheckbox.checked ? '#059669' : '#dc2626';
        }
    })
    .catch(err => {
        console.error(err);
        if (btn) {
            btn.innerHTML = '❌ Lỗi';
            btn.disabled = false;
        }
    });
}

// Bắt sự kiện đổi checkbox show_in_menu
document.querySelectorAll('input[type="checkbox"][id^="car-show-"]').forEach(cb => {
    cb.addEventListener('change', function() {
        const carId = this.id.replace('car-show-', '');
        const statusText = document.getElementById('car-status-text-' + carId);
        if (statusText) {
            statusText.textContent = this.checked ? 'Hiển thị' : 'Đang ẩn';
            statusText.style.color = this.checked ? '#059669' : '#dc2626';
        }
    });
});

// =========================================================================
// 4. MODAL THÊM / SỬA MENU ITEM (HEADER NAVIGATION)
// =========================================================================
function openCreateMenuItemModal() {
    document.getElementById('modal-menu-title').textContent = 'Thêm Mục Menu Mới';
    const form = document.getElementById('form-menu-item');
    form.action = '{{ route("admin.menus.items.store") }}';
    document.getElementById('menu-item-method').value = 'POST';
    document.getElementById('item-label').value = '';
    document.getElementById('item-url').value = '';
    document.getElementById('item-route').value = '';
    document.getElementById('item-badge').value = '';
    document.getElementById('item-sort').value = '0';
    document.getElementById('item-target').value = '_self';
    document.getElementById('item-active').checked = true;
    document.getElementById('modal-menu-item').style.display = 'flex';
}

function editMenuItem(item) {
    document.getElementById('modal-menu-title').textContent = 'Chỉnh Sửa Mục Menu: ' + item.label;
    const form = document.getElementById('form-menu-item');
    form.action = '/admin/menus/items/' + item.id;
    document.getElementById('menu-item-method').value = 'PUT';
    document.getElementById('item-label').value = item.label || '';
    document.getElementById('item-url').value = item.url || '';
    document.getElementById('item-route').value = item.route_name || '';
    document.getElementById('item-badge').value = item.badge || '';
    document.getElementById('item-sort').value = item.sort_order || 0;
    document.getElementById('item-target').value = item.target || '_self';
    document.getElementById('item-active').checked = !!item.is_active;
    document.getElementById('modal-menu-item').style.display = 'flex';
}

function closeMenuItemModal() {
    document.getElementById('modal-menu-item').style.display = 'none';
}
</script>
@endsection
