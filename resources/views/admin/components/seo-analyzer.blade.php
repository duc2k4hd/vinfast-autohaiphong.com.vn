<div class="vinfast-autohaiphong_admin_card">
    <div class="vinfast-autohaiphong_admin_card_title" style="display: flex; justify-content: space-between; align-items: center;">
        <span>TỐI ƯU HÓA SEO (GOOGLE SNIPPET)</span>
        <button type="button" id="btn-run-seo-audit" class="vinfast-autohaiphong_admin_btn vinfast-autohaiphong_admin_btn_outline" style="padding: 3px 8px; font-size: 0.78rem;">
            Chấm Điểm SEO
        </button>
    </div>

    {{-- Focus Keyword --}}
    <div style="margin-bottom: 12px;">
        <label style="display: block; font-weight: 600; font-size: 0.82rem; margin-bottom: 4px; color: var(--admin-heading);">
            Từ Khóa Trọng Tâm (Focus Keyword)
        </label>
        <input type="text" id="seo_focus_keyword" name="focus_keyword" value="{{ old('focus_keyword') }}" placeholder="VD: VinFast VF 3 Hải Phòng" 
               style="width: 100%; padding: 7px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
    </div>

    {{-- Meta Title --}}
    <div style="margin-bottom: 12px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
            <label style="font-weight: 600; font-size: 0.82rem; color: var(--admin-heading);">Meta Title (Tiêu Đề SEO)</label>
            <span id="meta-title-counter" style="font-size: 0.75rem; color: var(--admin-muted);">0 / 60 ký tự</span>
        </div>
        <input type="text" id="seo_meta_title" name="meta_title" value="{{ old('meta_title', $metaTitle ?? '') }}" placeholder="Tiêu đề hiển thị kết quả tìm kiếm..." 
               style="width: 100%; padding: 7px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">
    </div>

    {{-- Meta Description --}}
    <div style="margin-bottom: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
            <label style="font-weight: 600; font-size: 0.82rem; color: var(--admin-heading);">Meta Description (Mô Tả SEO)</label>
            <span id="meta-desc-counter" style="font-size: 0.75rem; color: var(--admin-muted);">0 / 160 ký tự</span>
        </div>
        <textarea id="seo_meta_description" name="meta_description" rows="3" placeholder="Mô tả tóm tắt thu hút người tìm kiếm click vào bài viết..." 
                  style="width: 100%; padding: 7px 10px; border: 1px solid var(--admin-border); border-radius: 4px; font-size: 0.85rem;">{{ old('meta_description', $metaDescription ?? '') }}</textarea>
    </div>

    {{-- Bảng Kết Quả Đánh Giá Điểm SEO --}}
    <div id="seo-score-box" style="background: var(--admin-bg); border: 1px solid var(--admin-border); border-radius: 6px; padding: 12px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.82rem; font-weight: 600; color: var(--admin-heading);">Điểm chất lượng SEO:</span>
            <span id="seo-score-badge" style="font-size: 0.85rem; font-weight: 700; color: var(--admin-primary);">-- / 100</span>
        </div>

        {{-- Progress Bar --}}
        <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden; margin-bottom: 10px;">
            <div id="seo-score-bar" style="width: 0%; height: 100%; background: var(--admin-primary); transition: width 0.3s ease;"></div>
        </div>

        <div id="seo-metrics" style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--admin-muted); margin-bottom: 8px;">
            <span>Số từ: <strong id="seo-metric-words">0</strong></span>
            <span>Thời gian đọc: <strong id="seo-metric-reading">~1 phút</strong></span>
            <span>Mật độ từ khóa: <strong id="seo-metric-density">0%</strong></span>
        </div>

        <div id="seo-feedback-list" style="font-size: 0.78rem; line-height: 1.5; color: var(--admin-text); max-height: 140px; overflow-y: auto;">
            <p style="color: var(--admin-muted); font-style: italic;">Bấm "Chấm Điểm SEO" để phân tích chi tiết.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.querySelector('input[name="title"]');
    const metaTitleInput = document.getElementById('seo_meta_title');
    const metaDescInput = document.getElementById('seo_meta_description');
    const focusKeywordInput = document.getElementById('seo_focus_keyword');
    const btnAudit = document.getElementById('btn-run-seo-audit');

    const metaTitleCounter = document.getElementById('meta-title-counter');
    const metaDescCounter = document.getElementById('meta-desc-counter');
    const scoreBadge = document.getElementById('seo-score-badge');
    const scoreBar = document.getElementById('seo-score-bar');
    const metricWords = document.getElementById('seo-metric-words');
    const metricReading = document.getElementById('seo-metric-reading');
    const metricDensity = document.getElementById('seo-metric-density');
    const feedbackList = document.getElementById('seo-feedback-list');

    function updateCounters() {
        if (metaTitleInput && metaTitleCounter) {
            metaTitleCounter.textContent = `${metaTitleInput.value.length} / 60 ký tự`;
            metaTitleCounter.style.color = (metaTitleInput.value.length >= 40 && metaTitleInput.value.length <= 65) ? '#16a34a' : 'var(--admin-muted)';
        }
        if (metaDescInput && metaDescCounter) {
            metaDescCounter.textContent = `${metaDescInput.value.length} / 160 ký tự`;
            metaDescCounter.style.color = (metaDescInput.value.length >= 120 && metaDescInput.value.length <= 165) ? '#16a34a' : 'var(--admin-muted)';
        }
    }

    if (metaTitleInput) metaTitleInput.addEventListener('input', updateCounters);
    if (metaDescInput) metaDescInput.addEventListener('input', updateCounters);
    updateCounters();

    async function analyzeSeo() {
        let contentHtml = '';
        if (window.tinymce && window.tinymce.get('content_html')) {
            contentHtml = window.tinymce.get('content_html').getContent();
        } else {
            const ta = document.getElementById('content_html');
            if (ta) contentHtml = ta.value;
        }

        const payload = {
            title: titleInput ? titleInput.value : '',
            meta_title: metaTitleInput ? metaTitleInput.value : '',
            meta_description: metaDescInput ? metaDescInput.value : '',
            focus_keyword: focusKeywordInput ? focusKeywordInput.value : '',
            content: contentHtml
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        try {
            scoreBadge.textContent = 'Đang tính...';
            const res = await fetch('{{ route('admin.seo.analyze') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            const json = await res.json();
            if (json.success && json.data) {
                const d = json.data;
                scoreBadge.textContent = `${d.score} / 100 (${d.status})`;
                scoreBar.style.width = `${d.score}%`;

                if (d.score >= 80) {
                    scoreBar.style.background = '#16a34a';
                    scoreBadge.style.color = '#16a34a';
                } else if (d.score >= 50) {
                    scoreBar.style.background = '#d97706';
                    scoreBadge.style.color = '#d97706';
                } else {
                    scoreBar.style.background = '#dc2626';
                    scoreBadge.style.color = '#dc2626';
                }

                metricWords.textContent = d.word_count;
                metricReading.textContent = `~${d.reading_time} phút`;
                metricDensity.textContent = `${d.keyword_density}%`;

                let html = '';
                if (d.issues && d.issues.length > 0) {
                    d.issues.forEach(iss => {
                        html += `<div style="color: #b91c1c; margin-bottom: 3px;">&bull; ${iss}</div>`;
                    });
                }
                if (d.good_points && d.good_points.length > 0) {
                    d.good_points.forEach(gp => {
                        html += `<div style="color: #15803d; margin-bottom: 3px;">&check; ${gp}</div>`;
                    });
                }
                feedbackList.innerHTML = html || '<div style="color: #16a34a;">Nội dung bài viết đạt chuẩn SEO tối đa!</div>';
            }
        } catch (err) {
            scoreBadge.textContent = 'Lỗi kết nối';
            console.error('Lỗi phân tích SEO:', err);
        }
    }

    if (btnAudit) {
        btnAudit.addEventListener('click', analyzeSeo);
    }
});
</script>
@endpush

