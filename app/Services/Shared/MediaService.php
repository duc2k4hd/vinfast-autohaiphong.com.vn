<?php

namespace App\Services\Shared;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Tải lên một file media và lưu vào cơ sở dữ liệu.
     *
     * @param  string  $folderPath  Đường dẫn thư mục (ví dụ: 'clients/products/vinfast-vf-3/gallery')
     * @param  string  $disk  Disk lưu trữ ('public')
     * @param  array  $attributes  Thuộc tính bổ sung (alt_text, title, caption, uploaded_by)
     */
    public function upload(
        UploadedFile $file,
        string $folderPath = 'clients/shared',
        string $disk = 'public',
        array $attributes = []
    ): object {
        $uuid = (string) Str::uuid();
        $originalFilename = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getClientMimeType();
        $fileSize = $file->getSize();
        $checksum = hash_file('sha256', $file->getRealPath());

        // Kiểm tra xem file đã tồn tại theo checksum để chống trùng lặp
        $existingMedia = DB::table('media')
            ->where('checksum_sha256', $checksum)
            ->where('disk', $disk)
            ->first();

        if ($existingMedia) {
            return $existingMedia;
        }

        // Đặt tên file chuẩn hóa an toàn
        $safeBasename = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME));
        $filename = "{$safeBasename}-{$uuid}.{$extension}";
        $fullPath = rtrim($folderPath, '/').'/'.$filename;

        // Lưu file vật lý
        Storage::disk($disk)->putFileAs($folderPath, $file, $filename);

        // Lấy kích thước ảnh nếu là định dạng hình ảnh
        $width = null;
        $height = null;
        if (str_starts_with($mimeType, 'image/')) {
            $imageInfo = @getimagesize($file->getRealPath());
            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
            }
        }

        $now = now();
        $mediaId = DB::table('media')->insertGetId([
            'uuid' => $uuid,
            'disk' => $disk,
            'folder_id' => $attributes['folder_id'] ?? null,
            'path' => $fullPath,
            'filename' => $filename,
            'original_filename' => $originalFilename,
            'extension' => $extension,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'width' => $width,
            'height' => $height,
            'checksum_sha256' => $checksum,
            'alt_text' => $attributes['alt_text'] ?? $safeBasename,
            'title' => $attributes['title'] ?? $originalFilename,
            'caption' => $attributes['caption'] ?? null,
            'source_url' => $attributes['source_url'] ?? null,
            'source_license' => $attributes['source_license'] ?? null,
            'status' => 'active',
            'uploaded_by' => $attributes['uploaded_by'] ?? null,
            'metadata' => isset($attributes['metadata']) ? json_encode($attributes['metadata']) : null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return DB::table('media')->where('id', $mediaId)->first();
    }

    /**
     * Gắn liên kết media với một đối tượng sử dụng (sản phẩm, bài viết...).
     *
     * @param  string  $usableType  (ví dụ: 'App\Models\Shared\Product')
     * @param  string  $role  (thumbnail, gallery, hero, banner, content)
     */
    public function attachUsage(
        int $mediaId,
        string $usableType,
        int $usableId,
        string $role = 'gallery',
        int $sortOrder = 0
    ): bool {
        DB::table('media_usages')->updateOrInsert(
            [
                'media_id' => $mediaId,
                'usable_type' => $usableType,
                'usable_id' => $usableId,
                'role' => $role,
            ],
            [
                'sort_order' => $sortOrder,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return true;
    }

    /**
     * Lấy URL công khai của một file media.
     *
     * @param  object|string|null  $media  Đối tượng media hoặc đường dẫn path
     * @param  string  $default  Fallback URL nếu không có ảnh
     */
    public function getUrl(mixed $media, string $default = '/images/placeholder-car.webp'): string
    {
        if (! $media) {
            return asset($default);
        }

        $path = is_object($media) ? $media->path : $media;

        return Storage::disk('public')->url($path);
    }
}
