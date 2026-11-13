@props([
    'name' => 'content',
    'id' => null,
    'value' => '',
    'height' => 450,
    'label' => null,
    'folder' => 'posts',
])

@php
    $editorId = $id ?? $name;
    $tinymceKey = config('services.tinymce.key', 'no-api-key');
@endphp

<div class="vinfast-autohaiphong_admin_editor_wrapper" style="margin-bottom: 20px;">
    @if($label)
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <label for="{{ $editorId }}" style="font-weight: 600; font-size: 0.9rem; color: var(--admin-text);">
                {{ $label }}
            </label>
            <div style="font-size: 0.8rem; color: var(--admin-muted);">
                <span id="{{ $editorId }}-word-count">0 từ</span>
                <span style="margin: 0 4px;">•</span>
                <span id="{{ $editorId }}-read-time">~1 phút đọc</span>
            </div>
        </div>
    @endif

    <textarea id="{{ $editorId }}" name="{{ $name }}" style="width: 100%; visibility: hidden;">{!! old($name, $value) !!}</textarea>
</div>

@once
@push('scripts')
<script src="https://cdn.tiny.cloud/1/{{ $tinymceKey }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const uploadUrl = '{{ route("admin.media.store") }}';

    function initTinyMceEditor(selector, height, folder) {
        if (!window.tinymce) {
            console.warn('TinyMCE chưa sẵn sàng.');
            return;
        }

        tinymce.init({
            selector: selector,
            height: height || 450,
            menubar: false,
            branding: false,
            promotion: false,
            convert_urls: false,
            relative_urls: false,
            paste_data_images: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'searchreplace', 'visualblocks', 'code', 'fullscreen', 'media', 'table', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                     'alignleft aligncenter alignright alignjustify | bullist numlist | ' +
                     'link image media table | removeformat code fullscreen preview',
            block_formats: 'Đoạn văn=p; Tiêu đề lớn (H2)=h2; Tiêu đề vừa (H3)=h3; Tiêu đề nhỏ (H4)=h4; Trích dẫn=blockquote; Khối mã=pre',
            content_style: `
                body {
                    font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                    font-size: 15px;
                    line-height: 1.75;
                    color: #334155;
                    padding: 16px;
                }
                img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 6px;
                }
                h2 { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-top: 24px; margin-bottom: 12px; }
                h3 { font-size: 1.25rem; font-weight: 600; color: #0f172a; margin-top: 20px; margin-bottom: 10px; }
                h4 { font-size: 1.1rem; font-weight: 600; color: #0f172a; margin-top: 16px; margin-bottom: 8px; }
                table { border-collapse: collapse; width: 100%; margin: 16px 0; }
                th, td { border: 1px solid #cbd5e1; padding: 10px 14px; }
                th { background-color: #f8fafc; font-weight: 600; }
                blockquote { border-left: 4px solid #1464f4; padding-left: 16px; color: #64748b; font-style: italic; }
            `,
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function (resolve, reject) {
                    const xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', uploadUrl);
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                    xhr.setRequestHeader('Accept', 'application/json');

                    xhr.upload.onprogress = function (e) {
                        progress(e.loaded / e.total * 100);
                    };

                    xhr.onload = function () {
                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('Tải ảnh thất bại: Mã lỗi HTTP ' + xhr.status);
                            return;
                        }

                        let json;
                        try {
                            json = JSON.parse(xhr.responseText);
                        } catch (err) {
                            reject('Phản hồi từ server không hợp lệ: ' + xhr.responseText);
                            return;
                        }

                        if (!json || typeof json.location !== 'string') {
                            reject('Phản hồi tải ảnh thiếu đường dẫn: ' + xhr.responseText);
                            return;
                        }

                        resolve(json.location);
                    };

                    xhr.onerror = function () {
                        reject('Lỗi kết nối mạng khi tải ảnh lên.');
                    };

                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('folder', folder || 'posts');
                    xhr.send(formData);
                });
            },
            setup: function (editor) {
                function updateStats() {
                    const text = editor.getContent({ format: 'text' }) || '';
                    const words = text.trim() ? text.trim().split(/\s+/).length : 0;
                    const readMinutes = Math.max(1, Math.ceil(words / 250));

                    const wordEl = document.getElementById(editor.id + '-word-count');
                    const readEl = document.getElementById(editor.id + '-read-time');
                    if (wordEl) wordEl.textContent = words + ' từ';
                    if (readEl) readEl.textContent = '~' + readMinutes + ' phút đọc';
                }

                editor.on('init', updateStats);
                editor.on('keyup change', updateStats);
            }
        });
    }

    window.initTinyMceEditor = initTinyMceEditor;
});
</script>
@endpush
@endonce

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.initTinyMceEditor) {
        window.initTinyMceEditor('#{{ $editorId }}', {{ $height }}, '{{ $folder }}');
    }
});
</script>
@endpush
