{{-- Thanh điều hướng chuyển tab các trang chính sách --}}
<div class="vf-policy-tabs-wrapper" style="background: #ffffff; border-bottom: 1px solid var(--client-color-border); position: sticky; top: 70px; z-index: 30; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
    <div class="vinfast-autohaiphong_layout_container">
        <div style="display: flex; gap: 8px; overflow-x: auto; padding: 10px 0; scrollbar-width: none; -ms-overflow-style: none;">
            <a href="{{ route('client.pages.policies') }}" 
               class="vf-policy-tab-item {{ ($activeTab ?? '') === 'hub' ? 'active' : '' }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 9999px; font-size: 0.9rem; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.2s ease; border: 1px solid {{ ($activeTab ?? '') === 'hub' ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ ($activeTab ?? '') === 'hub' ? 'var(--client-color-primary)' : '#f8fafc' }}; color: {{ ($activeTab ?? '') === 'hub' ? '#ffffff' : '#334155' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Tổng Quan Chính Sách</span>
            </a>

            <a href="{{ route('client.pages.warranty_policy') }}" 
               class="vf-policy-tab-item {{ ($activeTab ?? '') === 'bao-hanh' ? 'active' : '' }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 9999px; font-size: 0.9rem; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.2s ease; border: 1px solid {{ ($activeTab ?? '') === 'bao-hanh' ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ ($activeTab ?? '') === 'bao-hanh' ? 'var(--client-color-primary)' : '#f8fafc' }}; color: {{ ($activeTab ?? '') === 'bao-hanh' ? '#ffffff' : '#334155' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Bảo Hành & Cứu Hộ 24/7</span>
            </a>

            <a href="{{ route('client.pages.payment_policy') }}" 
               class="vf-policy-tab-item {{ ($activeTab ?? '') === 'thanh-toan' ? 'active' : '' }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 9999px; font-size: 0.9rem; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.2s ease; border: 1px solid {{ ($activeTab ?? '') === 'thanh-toan' ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ ($activeTab ?? '') === 'thanh-toan' ? 'var(--client-color-primary)' : '#f8fafc' }}; color: {{ ($activeTab ?? '') === 'thanh-toan' ? '#ffffff' : '#334155' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                <span>Thanh Toán Tiền Mặt & Nhận Xe</span>
            </a>

            <a href="{{ route('client.pages.privacy_policy') }}" 
               class="vf-policy-tab-item {{ ($activeTab ?? '') === 'bao-mat' ? 'active' : '' }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 9999px; font-size: 0.9rem; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.2s ease; border: 1px solid {{ ($activeTab ?? '') === 'bao-mat' ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ ($activeTab ?? '') === 'bao-mat' ? 'var(--client-color-primary)' : '#f8fafc' }}; color: {{ ($activeTab ?? '') === 'bao-mat' ? '#ffffff' : '#334155' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>Bảo Mật Thông Tin</span>
            </a>

            <a href="{{ route('client.pages.terms') }}" 
               class="vf-policy-tab-item {{ ($activeTab ?? '') === 'dieu-khoan' ? 'active' : '' }}"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 9999px; font-size: 0.9rem; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.2s ease; border: 1px solid {{ ($activeTab ?? '') === 'dieu-khoan' ? 'var(--client-color-primary)' : 'var(--client-color-border)' }}; background: {{ ($activeTab ?? '') === 'dieu-khoan' ? 'var(--client-color-primary)' : '#f8fafc' }}; color: {{ ($activeTab ?? '') === 'dieu-khoan' ? '#ffffff' : '#334155' }};">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span>Điều Khoản Sử Dụng</span>
            </a>
        </div>
    </div>
</div>
