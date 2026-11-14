<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Giới hạn dung lượng tải ảnh (Kilobytes)
    |--------------------------------------------------------------------------
    | Admin: Tối đa 10MB (10240 KB) cho mọi thao tác tải ảnh trong trang quản trị.
    | Client: Tối đa 3MB (3072 KB) cho người dùng/khách hàng ngoài trang web.
    */
    'max_upload_size_kb' => [
        'admin' => (int) env('ADMIN_MEDIA_MAX_UPLOAD_KB', 10240),
        'client' => (int) env('CLIENT_MEDIA_MAX_UPLOAD_KB', 3072),
    ],

    /*
    |--------------------------------------------------------------------------
    | Định dạng file ảnh được phép tải lên
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
];

