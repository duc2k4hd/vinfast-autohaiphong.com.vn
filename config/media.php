<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Giới hạn dung lượng tải tệp (Kilobytes)
    |--------------------------------------------------------------------------
    | Admin Video: Tối đa 50MB (51200 KB) cho video trong trang quản trị.
    | Admin Ảnh: Tối đa 10MB (10240 KB) cho ảnh trong trang quản trị.
    | Client: Tối đa 3MB (3072 KB) cho người dùng/khách hàng ngoài trang web.
    */
    'max_upload_size_kb' => [
        'admin' => (int) env('ADMIN_MEDIA_MAX_UPLOAD_KB', 51200),
        'admin_video' => (int) env('ADMIN_VIDEO_MAX_UPLOAD_KB', 51200),
        'admin_image' => (int) env('ADMIN_IMAGE_MAX_UPLOAD_KB', 10240),
        'client' => (int) env('CLIENT_MEDIA_MAX_UPLOAD_KB', 3072),
    ],

    /*
    |--------------------------------------------------------------------------
    | Định dạng file được phép tải lên
    |--------------------------------------------------------------------------
    */
    'allowed_image_mimes' => [
        'webp',
        'png',
        'jpg',
        'jpeg',
        'svg',
        'gif',
        'avif',
    ],

    'allowed_video_mimes' => [
        'mp4',
        'webm',
        'ogg',
        'mov',
        'm4v',
        'avi',
    ],
];
