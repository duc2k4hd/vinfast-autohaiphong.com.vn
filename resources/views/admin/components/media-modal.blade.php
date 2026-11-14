{{-- POPUP XỬ LÝ ẢNH CHUNG TOÀN HỆ THỐNG ADMIN --}}
<div id="vf-global-media-modal" class="vf-media-modal-backdrop" style="display: none;" aria-hidden="true">
    <div class="vf-media-modal-dialog">
        {{-- 1. Header: Tabs & Nút Đóng --}}
        <div class="vf-media-modal-header">
            <div class="vf-media-modal-tabs">
                <button type="button" class="vf-media-tab-btn active" data-tab="library" onclick="switchMediaTab('library')">
                    Thư viện
                </button>
                <button type="button" class="vf-media-tab-btn" data-tab="upload" onclick="switchMediaTab('upload')">
                    Tải lên
                </button>
            </div>
            <button type="button" class="vf-media-close-btn" onclick="closeMediaManager()" aria-label="Đóng popup">
                &times;
            </button>
        </div>

        {{-- 2. Body: Chứa nội dung 2 Tab --}}
        <div class="vf-media-modal-body">
            {{-- TAB 1: THƯ VIỆN ẢNH --}}
            <div id="vf-media-tab-library" class="vf-media-tab-content active">
                {{-- Toolbar: Tìm kiếm, Chọn nhiều, Switch Grid/List --}}
                <div class="vf-media-toolbar">
                    <div class="vf-media-search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" id="vf-media-search-input" placeholder="Tìm kiếm ảnh..." oninput="onMediaSearchInput(this.value)">
                    </div>

                    <div class="vf-media-toolbar-actions">
                        <button type="button" id="vf-media-multi-toggle-btn" class="vf-media-toolbar-btn" onclick="toggleMultiSelectMode()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            <span id="vf-media-multi-btn-label">Chọn nhiều ảnh</span>
                        </button>

                        <div class="vf-media-view-switch">
                            <button type="button" class="vf-media-view-btn active" data-view="grid" onclick="switchMediaView('grid')" title="Dạng lưới ô vuông">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            </button>
                            <button type="button" class="vf-media-view-btn" data-view="list" onclick="switchMediaView('list')" title="Dạng danh sách">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Container Lưới ảnh / Danh sách ảnh --}}
                <div id="vf-media-items-scroll-wrap" class="vf-media-items-wrapper">
                    <div id="vf-media-grid" class="vf-media-grid-view">
                        {{-- JS render các item ảnh vào đây --}}
                    </div>

                    {{-- Trạng thái tải & Tải thêm --}}
                    <div id="vf-media-loading" style="display: none; text-align: center; padding: 24px; color: var(--admin-primary); font-size: 0.9rem;">
                        <span class="vf-spinner"></span> Đang tải thư viện ảnh...
                    </div>

                    <div id="vf-media-empty" style="display: none; text-align: center; padding: 48px 20px; color: var(--admin-muted);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px; display: block; opacity: 0.5;"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        <p style="font-weight: 600; margin-bottom: 4px;">Không tìm thấy hình ảnh nào</p>
                        <p style="font-size: 0.8rem;">Hãy thử tìm từ khóa khác hoặc chuyển sang tab "Tải lên" để thêm ảnh mới.</p>
                    </div>

                    <div id="vf-media-load-more-wrap" style="text-align: center; padding: 16px 0; display: none;">
                        <button type="button" class="vf-media-btn-load-more" onclick="loadNextMediaPage()">
                            Tải thêm ảnh...
                        </button>
                    </div>
                </div>
            </div>

            {{-- TAB 2: TẢI LÊN (UPLOAD BATCH ĐA LUỒNG TRÁNH NGHẼN SERVER) --}}
            <div id="vf-media-tab-upload" class="vf-media-tab-content">
                {{-- Vùng Kéo Thả Upload Lớn --}}
                <div id="vf-media-dropzone" class="vf-media-dropzone" onclick="document.getElementById('vf-media-file-input').click()">
                    <input type="file" id="vf-media-file-input" multiple accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml,image/avif" style="display: none;" onchange="handleMediaFilesSelected(this.files)">
                    <div class="vf-media-dropzone-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div class="vf-media-dropzone-title">Kéo thả ảnh vào đây hoặc click để chọn</div>
                    <div class="vf-media-dropzone-subtitle">Hỗ trợ: JPG, PNG, GIF, WEBP, AVIF, SVG (tối đa 5MB / mỗi ảnh)</div>
                    <div class="vf-media-dropzone-hint">⚡ Hệ thống hỗ trợ tải hàng trăm ảnh cùng lúc với công nghệ chia batch đa luồng tự động</div>
                </div>

                {{-- Tiến trình tải lên Upload Queue --}}
                <div id="vf-media-upload-queue-card" style="display: none; margin-top: 18px; background: #f8fafc; border: 1px solid var(--admin-border); border-radius: 8px; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                            <strong style="font-size: 0.9rem; color: var(--admin-heading);">TIẾN TRÌNH TẢI ẢNH ĐA LUỒNG</strong>
                            <span id="vf-upload-overall-status" style="font-size: 0.8rem; color: var(--admin-muted); margin-left: 8px;">(0/0 file)</span>
                        </div>
                        <span id="vf-upload-percent-text" style="font-size: 0.85rem; font-weight: 700; color: var(--admin-primary);">0%</span>
                    </div>

                    <div class="vf-media-progress-bar-wrap">
                        <div id="vf-upload-progress-fill" class="vf-media-progress-bar-fill" style="width: 0%;"></div>
                    </div>

                    <div id="vf-media-queue-list" class="vf-media-queue-list">
                        {{-- JS render danh sách các file trong queue --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Footer: Nút bấm & Tác vụ --}}
        <div class="vf-media-modal-footer">
            <div class="vf-media-footer-left">
                <button type="button" class="vf-media-btn-outline" onclick="switchMediaTab('upload')">
                    Tải thêm ảnh
                </button>
                <span id="vf-media-selected-count-badge" style="font-size: 0.8rem; font-weight: 600; color: var(--admin-primary); margin-left: 8px; display: none;">
                    Đã chọn: <strong id="vf-media-selected-number">0</strong> ảnh
                </span>
            </div>

            <div class="vf-media-footer-right">
                <button type="button" class="vf-media-btn-icon" onclick="refreshMediaLibrary()" title="Tải lại danh sách">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                    <span>Làm mới</span>
                </button>
                <button type="button" class="vf-media-btn-secondary" onclick="closeMediaManager()">
                    Hủy
                </button>
                <button type="button" id="vf-media-btn-confirm" class="vf-media-btn-primary" onclick="confirmMediaSelection()">
                    Chèn vào editor
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS CHO GLOBAL POPUP MEDIA MANAGER */
.vf-media-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
}
.vf-media-modal-dialog {
    background: #ffffff;
    width: 100%;
    max-width: 1140px;
    height: 88vh;
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: vfMediaFadeIn 0.18s ease-out;
}
@keyframes vfMediaFadeIn {
    from { opacity: 0; transform: scale(0.98); }
    to { opacity: 1; transform: scale(1); }
}

/* Header */
.vf-media-modal-header {
    height: 54px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    background: #ffffff;
    flex-shrink: 0;
}
.vf-media-modal-tabs {
    display: flex;
    height: 100%;
    gap: 24px;
}
.vf-media-tab-btn {
    border: 0;
    background: transparent;
    font-size: 0.95rem;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    height: 100%;
    position: relative;
    padding: 0 4px;
    transition: color 0.15s ease;
}
.vf-media-tab-btn:hover {
    color: #1464f4;
}
.vf-media-tab-btn.active {
    color: #1464f4;
    font-weight: 700;
}
.vf-media-tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background: #1464f4;
    border-radius: 3px 3px 0 0;
}
.vf-media-close-btn {
    border: 0;
    background: transparent;
    font-size: 1.6rem;
    color: #94a3b8;
    cursor: pointer;
    line-height: 1;
    padding: 4px;
    border-radius: 4px;
}
.vf-media-close-btn:hover {
    color: #0f172a;
}

/* Body */
.vf-media-modal-body {
    flex: 1;
    overflow: hidden;
    position: relative;
    background: #ffffff;
}
.vf-media-tab-content {
    display: none;
    height: 100%;
    flex-direction: column;
}
.vf-media-tab-content.active {
    display: flex;
}

/* Toolbar */
.vf-media-toolbar {
    padding: 12px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    background: #ffffff;
    flex-shrink: 0;
}
.vf-media-search-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 6px 12px;
    width: 320px;
    max-width: 100%;
}
.vf-media-search-box svg {
    color: #94a3b8;
    flex-shrink: 0;
}
.vf-media-search-box input {
    border: 0;
    background: transparent;
    outline: none;
    font-size: 0.85rem;
    width: 100%;
    color: #1e293b;
}
.vf-media-toolbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}
.vf-media-toolbar-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #ffffff;
    font-size: 0.82rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s ease;
}
.vf-media-toolbar-btn:hover, .vf-media-toolbar-btn.active {
    background: #eff6ff;
    color: #1464f4;
    border-color: #bfdbfe;
}
.vf-media-view-switch {
    display: inline-flex;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
}
.vf-media-view-btn {
    border: 0;
    background: #ffffff;
    padding: 6px 10px;
    color: #64748b;
    cursor: pointer;
    display: grid;
    place-items: center;
    transition: all 0.15s ease;
}
.vf-media-view-btn:hover {
    background: #f1f5f9;
}
.vf-media-view-btn.active {
    background: #eff6ff;
    color: #1464f4;
}

/* Lưới ảnh Grid */
.vf-media-items-wrapper {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
}
.vf-media-grid-view {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 14px;
}
.vf-media-item {
    position: relative;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    background: #ffffff;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
    display: flex;
    flex-direction: column;
}
.vf-media-item:hover {
    border-color: #93c5fd;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}
.vf-media-item.selected {
    border-color: #1464f4;
    background: #eff6ff;
    box-shadow: 0 0 0 1px #1464f4;
}
.vf-media-item-thumb {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.vf-media-item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.2s ease;
}
.vf-media-item:hover .vf-media-item-thumb img {
    transform: scale(1.05);
}
.vf-media-item-name {
    padding: 6px 8px;
    font-size: 0.72rem;
    color: #334155;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border-top: 1px solid #f1f5f9;
    text-align: center;
    background: #ffffff;
}
.vf-media-item.selected .vf-media-item-name {
    background: #eff6ff;
    color: #1464f4;
    font-weight: 600;
}
.vf-media-item-checkbox {
    position: absolute;
    top: 6px;
    left: 6px;
    width: 18px;
    height: 18px;
    border-radius: 4px;
    border: 1.5px solid rgba(0,0,0,0.3);
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    transition: all 0.15s ease;
}
.vf-media-item.selected .vf-media-item-checkbox {
    background: #1464f4;
    border-color: #1464f4;
    color: #ffffff;
}
.vf-media-item-checkbox::after {
    content: '✓';
    font-size: 11px;
    font-weight: bold;
    color: #ffffff;
    display: none;
}
.vf-media-item.selected .vf-media-item-checkbox::after {
    display: block;
}

/* Dạng danh sách List */
.vf-media-list-view {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.vf-media-list-view .vf-media-item {
    flex-direction: row;
    align-items: center;
    height: 56px;
    padding: 6px 12px;
}
.vf-media-list-view .vf-media-item-thumb {
    width: 44px;
    height: 44px;
    border-radius: 4px;
    flex-shrink: 0;
    margin-left: 28px;
}
.vf-media-list-view .vf-media-item-name {
    border-top: 0;
    text-align: left;
    flex: 1;
    font-size: 0.85rem;
    padding-left: 12px;
}
.vf-media-list-view .vf-media-item-checkbox {
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
}

/* Nút Tải thêm */
.vf-media-btn-load-more {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    padding: 8px 24px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.15s ease;
}
.vf-media-btn-load-more:hover {
    background: #1464f4;
    color: #ffffff;
    border-color: #1464f4;
}

/* Tab Tải lên: Dropzone & Progress */
#vf-media-tab-upload {
    padding: 24px;
    overflow-y: auto;
}
.vf-media-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 60px 24px;
    text-align: center;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.2s ease;
}
.vf-media-dropzone:hover, .vf-media-dropzone.dragover {
    border-color: #1464f4;
    background: #f8fbff;
}
.vf-media-dropzone-icon {
    color: #94a3b8;
    margin-bottom: 12px;
    transition: transform 0.2s ease;
}
.vf-media-dropzone:hover .vf-media-dropzone-icon {
    transform: translateY(-4px);
    color: #1464f4;
}
.vf-media-dropzone-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
}
.vf-media-dropzone-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 8px;
}
.vf-media-dropzone-hint {
    font-size: 0.78rem;
    color: #1464f4;
    font-weight: 600;
}

/* Progress bar */
.vf-media-progress-bar-wrap {
    height: 8px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 14px;
}
.vf-media-progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #1464f4, #38bdf8);
    transition: width 0.2s ease;
}
.vf-media-queue-list {
    max-height: 220px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.vf-media-queue-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.8rem;
}
.vf-media-queue-name {
    font-weight: 500;
    color: #334155;
    max-width: 60%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.vf-media-queue-status {
    font-weight: 600;
}
.vf-media-queue-status.pending { color: #94a3b8; }
.vf-media-queue-status.uploading { color: #1464f4; }
.vf-media-queue-status.success { color: #166534; }
.vf-media-queue-status.error { color: #ef4444; }

/* Footer */
.vf-media-modal-footer {
    height: 64px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    background: #ffffff;
    flex-shrink: 0;
}
.vf-media-footer-left, .vf-media-footer-right {
    display: flex;
    align-items: center;
    gap: 10px;
}
.vf-media-btn-outline {
    border: 1px solid #3b82f6;
    background: #ffffff;
    color: #3b82f6;
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.vf-media-btn-outline:hover {
    background: #eff6ff;
}
.vf-media-btn-icon {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.vf-media-btn-icon:hover {
    background: #f1f5f9;
}
.vf-media-btn-secondary {
    border: 1px solid #64748b;
    background: #64748b;
    color: #ffffff;
    padding: 7px 18px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.vf-media-btn-secondary:hover {
    background: #475569;
}
.vf-media-btn-primary {
    border: 0;
    background: #3b82f6;
    color: #ffffff;
    padding: 7px 20px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
    box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
}
.vf-media-btn-primary:hover {
    background: #2563eb;
}
.vf-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(20, 100, 244, 0.2);
    border-top-color: #1464f4;
    border-radius: 50%;
    animation: vfSpin 0.6s linear infinite;
    vertical-align: middle;
    margin-right: 6px;
}
@keyframes vfSpin {
    to { transform: rotate(360deg); }
}
</style>

<script>
/**
 * JAVASCRIPT XỬ LÝ MEDIA MANAGER CORE
 * - Phân trang siêu tốc API (hỗ trợ hàng triệu ảnh).
 * - Đa luồng chia batch Client-side Queue (tránh quá tải server).
 * - Tương thích mọi trang trong Admin.
 */
(function() {
    let currentOptions = {
        mode: 'single', // 'single' hoặc 'multiple'
        confirmText: 'Chèn vào editor',
        onSelect: null
    };

    let currentPage = 1;
    let hasMorePages = true;
    let isLoading = false;
    let currentSearchTerm = '';
    let currentViewMode = 'grid'; // 'grid' hoặc 'list'
    let isMultiSelectActive = false;
    let mediaItemsMap = new Map(); // id -> item object
    let selectedMediaIds = new Set();
    let searchDebounceTimer = null;

    // Hàng đợi upload đa luồng (Upload Queue Concurrency Pool)
    let uploadQueue = [];
    let isUploading = false;
    let activeUploadsCount = 0;
    const MAX_CONCURRENT_UPLOADS = 3; // Tối đa 3 upload đồng thời để bảo vệ PHP-FPM / Server
    let totalFilesCount = 0;
    let finishedFilesCount = 0;

    // Mở popup Media Manager
    window.openMediaManager = function(options = {}) {
        currentOptions = Object.assign({
            mode: 'single',
            confirmText: 'Xác nhận chọn',
            onSelect: null
        }, options);

        isMultiSelectActive = (currentOptions.mode === 'multiple');
        const toggleBtn = document.getElementById('vf-media-multi-toggle-btn');
        if (toggleBtn) {
            toggleBtn.classList.toggle('active', isMultiSelectActive);
        }

        const confirmBtn = document.getElementById('vf-media-btn-confirm');
        if (confirmBtn) {
            confirmBtn.textContent = currentOptions.confirmText;
        }

        selectedMediaIds.clear();
        updateSelectedBadge();

        const modal = document.getElementById('vf-global-media-modal');
        if (modal) {
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        switchMediaTab('library');
        if (mediaItemsMap.size === 0) {
            refreshMediaLibrary();
        }
    };

    // Đóng popup Media Manager
    window.closeMediaManager = function() {
        const modal = document.getElementById('vf-global-media-modal');
        if (modal) {
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    };

    // Chuyển đổi tab
    window.switchMediaTab = function(tabName) {
        document.querySelectorAll('.vf-media-tab-btn').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-tab') === tabName);
        });
        document.getElementById('vf-media-tab-library')?.classList.toggle('active', tabName === 'library');
        document.getElementById('vf-media-tab-upload')?.classList.toggle('active', tabName === 'upload');
    };

    // Chuyển đổi Grid / List
    window.switchMediaView = function(view) {
        currentViewMode = view;
        document.querySelectorAll('.vf-media-view-btn').forEach(btn => {
            btn.classList.toggle('active', btn.getAttribute('data-view') === view);
        });
        const grid = document.getElementById('vf-media-grid');
        if (grid) {
            grid.className = (view === 'grid') ? 'vf-media-grid-view' : 'vf-media-list-view';
        }
    };

    // Bật/tắt chế độ chọn nhiều ảnh
    window.toggleMultiSelectMode = function() {
        isMultiSelectActive = !isMultiSelectActive;
        const toggleBtn = document.getElementById('vf-media-multi-toggle-btn');
        if (toggleBtn) {
            toggleBtn.classList.toggle('active', isMultiSelectActive);
        }
        if (!isMultiSelectActive && selectedMediaIds.size > 1) {
            const firstId = Array.from(selectedMediaIds)[0];
            selectedMediaIds.clear();
            selectedMediaIds.add(firstId);
            reRenderSelectedItems();
        }
        updateSelectedBadge();
    };

    // Tải lại thư viện ảnh từ đầu
    window.refreshMediaLibrary = function() {
        currentPage = 1;
        hasMorePages = true;
        mediaItemsMap.clear();
        selectedMediaIds.clear();
        updateSelectedBadge();

        const grid = document.getElementById('vf-media-grid');
        if (grid) grid.innerHTML = '';

        fetchMediaPage(1);
    };

    // Tải trang ảnh tiếp theo
    window.loadNextMediaPage = function() {
        if (!hasMorePages || isLoading) return;
        fetchMediaPage(currentPage + 1);
    };

    // Gọi API phân trang lấy dữ liệu JSON
    function fetchMediaPage(page) {
        if (isLoading) return;
        isLoading = true;

        const loadingEl = document.getElementById('vf-media-loading');
        const emptyEl = document.getElementById('vf-media-empty');
        const loadMoreWrap = document.getElementById('vf-media-load-more-wrap');

        if (loadingEl) loadingEl.style.display = 'block';
        if (emptyEl) emptyEl.style.display = 'none';
        if (loadMoreWrap) loadMoreWrap.style.display = 'none';

        const params = new URLSearchParams({
            page: page,
            per_page: 36,
            search: currentSearchTerm
        });

        fetch(`/admin/media/api/list?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            isLoading = false;
            if (loadingEl) loadingEl.style.display = 'none';

            currentPage = data.current_page;
            hasMorePages = data.has_more;

            if (data.items && data.items.length > 0) {
                renderMediaItems(data.items);
                if (loadMoreWrap) {
                    loadMoreWrap.style.display = hasMorePages ? 'block' : 'none';
                }
            } else if (page === 1) {
                if (emptyEl) emptyEl.style.display = 'block';
            }
        })
        .catch(err => {
            isLoading = false;
            if (loadingEl) loadingEl.style.display = 'none';
            console.error('Lỗi khi tải thư viện media:', err);
        });
    }

    // Render danh sách item ảnh vào Grid / List
    function renderMediaItems(items) {
        const grid = document.getElementById('vf-media-grid');
        if (!grid) return;

        items.forEach(item => {
            mediaItemsMap.set(item.id, item);

            const div = document.createElement('div');
            div.className = 'vf-media-item' + (selectedMediaIds.has(item.id) ? ' selected' : '');
            div.setAttribute('data-id', item.id);
            div.title = `${item.filename} (${item.file_size || ''})`;

            div.innerHTML = `
                <div class="vf-media-item-checkbox"></div>
                <div class="vf-media-item-thumb">
                    <img src="${item.url}" alt="${item.alt_text || item.filename}" loading="lazy">
                </div>
                <div class="vf-media-item-name">${item.original_filename || item.filename}</div>
            `;

            div.addEventListener('click', (e) => {
                e.preventDefault();
                onItemClicked(item.id);
            });

            grid.appendChild(div);
        });
    }

    // Xử lý khi click vào 1 ảnh
    function onItemClicked(id) {
        if (isMultiSelectActive) {
            if (selectedMediaIds.has(id)) {
                selectedMediaIds.delete(id);
            } else {
                selectedMediaIds.add(id);
            }
        } else {
            selectedMediaIds.clear();
            selectedMediaIds.add(id);
        }

        reRenderSelectedItems();
        updateSelectedBadge();
    }

    // Cập nhật trạng thái selected của các DOM elements
    function reRenderSelectedItems() {
        document.querySelectorAll('#vf-media-grid .vf-media-item').forEach(el => {
            const id = parseInt(el.getAttribute('data-id'), 10);
            el.classList.toggle('selected', selectedMediaIds.has(id));
        });
    }

    // Cập nhật số lượng ảnh đã chọn ở footer
    function updateSelectedBadge() {
        const badge = document.getElementById('vf-media-selected-count-badge');
        const num = document.getElementById('vf-media-selected-number');
        if (badge && num) {
            const count = selectedMediaIds.size;
            num.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    // Debounce tìm kiếm ảnh thời gian thực
    window.onMediaSearchInput = function(val) {
        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => {
            currentSearchTerm = val.trim();
            refreshMediaLibrary();
        }, 300);
    };

    // Xác nhận chọn ảnh và trả về cho callback
    window.confirmMediaSelection = function() {
        if (selectedMediaIds.size === 0) {
            alert('Vui lòng chọn ít nhất một hình ảnh.');
            return;
        }

        const selectedList = [];
        selectedMediaIds.forEach(id => {
            const item = mediaItemsMap.get(id);
            if (item) selectedList.push(item);
        });

        if (typeof currentOptions.onSelect === 'function') {
            currentOptions.onSelect(currentOptions.mode === 'single' ? selectedList[0] : selectedList);
        }

        closeMediaManager();
    };

    // =========================================================================
    // XỬ LÝ UPLOAD ĐA LUỒNG CHIA BATCH (CONCURRENCY QUEUE POOL)
    // =========================================================================
    const dropzone = document.getElementById('vf-media-dropzone');
    if (dropzone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });
        dropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer?.files;
            if (files && files.length > 0) {
                handleMediaFilesSelected(files);
            }
        });
    }

    // Xử lý khi có danh sách file được chọn
    window.handleMediaFilesSelected = function(files) {
        if (!files || files.length === 0) return;

        const queueCard = document.getElementById('vf-media-upload-queue-card');
        const queueList = document.getElementById('vf-media-queue-list');
        if (queueCard) queueCard.style.display = 'block';

        const fileArray = Array.from(files);
        totalFilesCount = fileArray.length;
        finishedFilesCount = 0;
        updateOverallProgress();

        if (queueList) queueList.innerHTML = '';

        fileArray.forEach((file, idx) => {
            const queueItem = {
                id: 'queue-file-' + idx + '-' + Date.now(),
                file: file,
                status: 'pending' // pending, uploading, success, error
            };
            uploadQueue.push(queueItem);

            // Render dòng hàng đợi
            if (queueList) {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'vf-media-queue-item';
                itemDiv.id = queueItem.id;
                itemDiv.innerHTML = `
                    <span class="vf-media-queue-name">${file.name} (${Math.round(file.size / 1024)} KB)</span>
                    <span class="vf-media-queue-status pending">Chờ tải...</span>
                `;
                queueList.appendChild(itemDiv);
            }
        });

        // Bắt đầu chu trình upload đa luồng chia batch
        processUploadQueue();
    };

    // Điều phối hàng đợi đa luồng
    function processUploadQueue() {
        while (activeUploadsCount < MAX_CONCURRENT_UPLOADS && uploadQueue.length > 0) {
            const nextItem = uploadQueue.shift();
            if (nextItem) {
                activeUploadsCount++;
                uploadSingleFile(nextItem);
            }
        }
    }

    // Upload 1 file đơn lẻ
    function uploadSingleFile(queueItem) {
        const itemEl = document.getElementById(queueItem.id);
        const statusEl = itemEl ? itemEl.querySelector('.vf-media-queue-status') : null;

        if (statusEl) {
            statusEl.className = 'vf-media-queue-status uploading';
            statusEl.innerHTML = '<span class="vf-spinner"></span> Đang tải...';
        }

        const formData = new FormData();
        formData.append('file', queueItem.file);
        formData.append('folder', 'products');

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('/admin/media', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw new Error('Upload thất bại: ' + res.statusText);
            return res.json();
        })
        .then(result => {
            activeUploadsCount--;
            finishedFilesCount++;
            updateOverallProgress();

            if (statusEl) {
                statusEl.className = 'vf-media-queue-status success';
                statusEl.textContent = '✓ Thành công';
            }

            // Tiếp tục điều phối các file còn lại trong queue
            processUploadQueue();
            checkAllUploadsComplete();
        })
        .catch(err => {
            activeUploadsCount--;
            finishedFilesCount++;
            updateOverallProgress();

            if (statusEl) {
                statusEl.className = 'vf-media-queue-status error';
                statusEl.textContent = '✕ Lỗi tải lên';
            }

            processUploadQueue();
            checkAllUploadsComplete();
        });
    }

    // Cập nhật thanh tiến trình tổng
    function updateOverallProgress() {
        const percent = totalFilesCount > 0 ? Math.round((finishedFilesCount / totalFilesCount) * 100) : 0;
        const fillEl = document.getElementById('vf-upload-progress-fill');
        const textEl = document.getElementById('vf-upload-percent-text');
        const statusEl = document.getElementById('vf-upload-overall-status');

        if (fillEl) fillEl.style.width = percent + '%';
        if (textEl) textEl.textContent = percent + '%';
        if (statusEl) statusEl.textContent = `(${finishedFilesCount}/${totalFilesCount} file)`;
    }

    // Kiểm tra khi tất cả file đã tải xong
    function checkAllUploadsComplete() {
        if (uploadQueue.length === 0 && activeUploadsCount === 0 && finishedFilesCount > 0) {
            setTimeout(() => {
                // Tự động làm mới và chuyển về Tab Thư viện
                switchMediaTab('library');
                refreshMediaLibrary();
            }, 600);
        }
    }
})();
</script>

