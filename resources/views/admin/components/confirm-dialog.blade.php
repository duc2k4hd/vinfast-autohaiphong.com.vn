{{-- Modal Xác Nhận Hành Động (Confirm Dialog Component) - evondevKit & Enterprise Admin Style --}}
<div id="admin-confirm-modal" class="vinfast-autohaiphong_admin_modal_overlay" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(2px); align-items: center; justify-content: center; padding: 16px;">
    <div class="vinfast-autohaiphong_admin_modal_box" style="background: #ffffff; border: 1px solid var(--admin-border); border-radius: 8px; width: 100%; max-width: 440px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); overflow: hidden; animation: adminModalFadeIn 0.15s ease-out;">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; gap: 12px;">
            <div id="admin-confirm-icon-box" style="width: 36px; height: 36px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: #fee2e2; color: #dc2626;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <div>
                <h3 id="admin-confirm-title" style="font-size: 1rem; font-weight: 700; color: var(--admin-heading); margin: 0; line-height: 1.3;">
                    Xác Nhận Hành Động
                </h3>
            </div>
        </div>
        <div style="padding: 20px 24px;">
            <p id="admin-confirm-message" style="font-size: 0.9rem; color: var(--admin-text); line-height: 1.5; margin: 0;">
                Bạn có chắc chắn muốn thực hiện hành động này? Dữ liệu có thể không thể khôi phục sau khi xác nhận.
            </p>
        </div>
        <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end; gap: 10px;">
            <button type="button" id="admin-confirm-cancel-btn" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 7px 16px; font-size: 0.85rem;">
                Hủy Bỏ
            </button>
            <button type="button" id="admin-confirm-ok-btn" class="vinfast-autohaiphong_admin_btn" style="padding: 7px 18px; font-size: 0.85rem; background: #dc2626; color: #ffffff; border: none;">
                Xác Nhận
            </button>
        </div>
    </div>
</div>

<style>
@keyframes adminModalFadeIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}
</style>

<script>
(function() {
    let pendingCallback = null;
    const modal = document.getElementById('admin-confirm-modal');
    const titleEl = document.getElementById('admin-confirm-title');
    const msgEl = document.getElementById('admin-confirm-message');
    const iconBox = document.getElementById('admin-confirm-icon-box');
    const okBtn = document.getElementById('admin-confirm-ok-btn');
    const cancelBtn = document.getElementById('admin-confirm-cancel-btn');

    window.showConfirmDialog = function(options) {
        const {
            title = 'Xác Nhận Hành Động',
            message = 'Bạn có chắc chắn muốn thực hiện thao tác này?',
            confirmText = 'Xác Nhận',
            cancelText = 'Hủy Bỏ',
            type = 'danger', // 'danger' | 'primary' | 'warning'
            onConfirm = null
        } = options;

        titleEl.textContent = title;
        msgEl.textContent = message;
        okBtn.textContent = confirmText;
        cancelBtn.textContent = cancelText;

        if (type === 'danger') {
            iconBox.style.background = '#fee2e2';
            iconBox.style.color = '#dc2626';
            okBtn.style.background = '#dc2626';
        } else if (type === 'primary') {
            iconBox.style.background = '#dbeafe';
            iconBox.style.color = '#1464f4';
            okBtn.style.background = '#1464f4';
        } else {
            iconBox.style.background = '#fef3c7';
            iconBox.style.color = '#d97706';
            okBtn.style.background = '#d97706';
        }

        pendingCallback = onConfirm;
        modal.style.display = 'flex';
    };

    function closeModal() {
        modal.style.display = 'none';
        pendingCallback = null;
    }

    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
    }

    if (okBtn) {
        okBtn.addEventListener('click', function() {
            const cb = pendingCallback;
            closeModal();
            if (typeof cb === 'function') {
                cb();
            }
        });
    }

    // Auto-bind any form or button with data-confirm
    document.addEventListener('submit', function(e) {
        const form = e.target;
        const confirmMsg = form.getAttribute('data-confirm');
        if (confirmMsg && !form.dataset.confirmed) {
            e.preventDefault();
            const confirmTitle = form.getAttribute('data-confirm-title') || 'Xác Nhận Thao Tác';
            const confirmType = form.getAttribute('data-confirm-type') || 'danger';
            const confirmBtnText = form.getAttribute('data-confirm-btn') || 'Đồng Ý';

            window.showConfirmDialog({
                title: confirmTitle,
                message: confirmMsg,
                type: confirmType,
                confirmText: confirmBtnText,
                onConfirm: function() {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        }
    });
})();
</script>

