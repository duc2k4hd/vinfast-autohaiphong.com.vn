<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SyncAssetsCommand extends Command
{
    protected $signature = 'app:sync-assets';

    protected $description = 'Đồng bộ và tổ chức toàn bộ assets vào public/storage/clients/assets đúng loại';

    public function handle(): int
    {
        $baseAssetsPath = public_path('storage/clients/assets');

        $directories = [
            $baseAssetsPath.'/images/business',
            $baseAssetsPath.'/images/banners',
            $baseAssetsPath.'/images/products',
            $baseAssetsPath.'/images/posts',
            $baseAssetsPath.'/images/icons',
            $baseAssetsPath.'/fonts',
            $baseAssetsPath.'/css',
            $baseAssetsPath.'/js',
        ];

        foreach ($directories as $dir) {
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
                $this->info("Đã tạo thư mục: $dir");
            }
        }

        // 1. Sao chép Fonts Open Sans vào public/storage/clients/assets/fonts
        $buildAssets = public_path('build/assets');
        if (File::exists($buildAssets)) {
            $fontFiles = File::glob($buildAssets.'/*.woff*');
            foreach ($fontFiles as $fontFile) {
                $dest = $baseAssetsPath.'/fonts/'.basename($fontFile);
                File::copy($fontFile, $dest);
            }
            $this->info('Đã sao chép các tệp fonts vào public/storage/clients/assets/fonts/');
        }

        // 2. Danh sách ảnh các dòng xe VinFast
        $cars = [
            'vinfast-vf-2' => [
                'name' => 'VinFast VF 2',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp',
                'file' => 'vinfast-vf-2.webp',
            ],
            'vinfast-vf-3' => [
                'name' => 'VinFast VF 3',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2024/05/VF-3-600x338.webp',
                'file' => 'vinfast-vf-3.webp',
            ],
            'vinfast-vf-5' => [
                'name' => 'VinFast VF 5 Plus',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf-5-plus-600x338.webp',
                'file' => 'vinfast-vf-5.webp',
            ],
            'vinfast-vf-6' => [
                'name' => 'VinFast VF 6',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf6-600x338.webp',
                'file' => 'vinfast-vf-6.webp',
            ],
            'vinfast-vf-7' => [
                'name' => 'VinFast VF 7',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf7-600x338.webp',
                'file' => 'vinfast-vf-7.webp',
            ],
            'vinfast-vf-8' => [
                'name' => 'VinFast VF 8',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf-8-600x338.webp',
                'file' => 'vinfast-vf-8.webp',
            ],
            'vinfast-vf8-all-new' => [
                'name' => 'VinFast VF8 All New',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf-8-600x338.webp',
                'file' => 'vinfast-vf8-all-new.webp',
            ],
            'vinfast-vf-9' => [
                'name' => 'VinFast VF 9',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf9-600x338.webp',
                'file' => 'vinfast-vf-9.webp',
            ],
            'vinfast-vf-wild' => [
                'name' => 'VinFast VF Wild',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2024/01/vinfast-vf-wild-600x338.webp',
                'file' => 'vinfast-vf-wild.webp',
            ],
            'vinfast-vf-mpv-7' => [
                'name' => 'VinFast VF MPV 7',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp',
                'file' => 'vinfast-vf-mpv-7.webp',
            ],
            'vinfast-minio-green' => [
                'name' => 'VinFast Minio Green',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp',
                'file' => 'vinfast-minio-green.webp',
            ],
            'vinfast-herio-green' => [
                'name' => 'VinFast Herio Green',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2024/05/VF-3-600x338.webp',
                'file' => 'vinfast-herio-green.webp',
            ],
            'vinfast-nerio-green' => [
                'name' => 'VinFast Nerio Green',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf-5-plus-600x338.webp',
                'file' => 'vinfast-nerio-green.webp',
            ],
            'vinfast-limo-green' => [
                'name' => 'VinFast Limo Green',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf9-600x338.webp',
                'file' => 'vinfast-limo-green.webp',
            ],
            'vinfast-ec-van' => [
                'name' => 'VinFast EC Van',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2026/07/VF2-300x180.webp',
                'file' => 'vinfast-ec-van.webp',
            ],
        ];

        $now = now();

        foreach ($cars as $slug => $item) {
            $destFile = $baseAssetsPath.'/images/products/'.$item['file'];
            $relPath = 'clients/assets/images/products/'.$item['file'];

            if (! File::exists($destFile)) {
                $this->info("Đang tải ảnh xe: {$item['name']}...");
                try {
                    $response = Http::timeout(10)->get($item['url']);
                    if ($response->successful()) {
                        File::put($destFile, $response->body());
                        $this->info(" -> Đã lưu: {$destFile}");
                    } else {
                        // Tạo placeholder ảnh xe nhẹ nếu URL không tải được
                        File::copy($baseAssetsPath.'/images/banners/banner-vf-wild-94utr45.webp', $destFile);
                        $this->warn(" -> Tạo bản sao cục bộ cho {$item['name']}");
                    }
                } catch (\Exception $e) {
                    File::copy($baseAssetsPath.'/images/banners/banner-vf-wild-94utr45.webp', $destFile);
                    $this->warn(' -> Ngoại lệ tải ảnh: '.$e->getMessage());
                }
            }

            // Ghi nhận vào bảng media và liên kết với product
            $mediaId = DB::table('media')->where('path', $relPath)->value('id');
            if (! $mediaId) {
                $mediaId = DB::table('media')->insertGetId([
                    'uuid' => (string) Str::uuid(),
                    'folder_id' => null,
                    'disk' => 'public',
                    'filename' => $item['file'],
                    'original_filename' => $item['file'],
                    'extension' => 'webp',
                    'path' => $relPath,
                    'mime_type' => 'image/webp',
                    'file_size' => File::exists($destFile) ? File::size($destFile) : 1024,
                    'alt_text' => $item['name'].' tại VinFast Hải Phòng',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('products')->where('slug', $slug)->update([
                'thumbnail_media_id' => $mediaId,
                'updated_at' => $now,
            ]);
        }

        // 3. Tải và tổ chức ảnh tin tức bài viết
        $postsImages = [
            'chinh-sach-mien-phi-sac-pin-xe-dien-vinfast-toan-quoc' => [
                'file' => 'chinh-sach-mien-phi-sac-pin.webp',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-banner-54gf5.png',
            ],
            'vinfast-vf-3-xe-dien-do-thi-hai-phong' => [
                'file' => 'vinfast-vf-3-xe-dien-do-thi.webp',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2024/05/VF-3-600x338.webp',
            ],
            'huong-dan-su-dung-tram-sac-vinfast-hai-phong' => [
                'file' => 'huong-dan-su-dung-tram-sac.webp',
                'url' => 'https://vinfast-haiphong.com/wp-content/uploads/2023/11/vinfast-vf6-600x338.webp',
            ],
        ];

        foreach ($postsImages as $slug => $pItem) {
            $destFile = $baseAssetsPath.'/images/posts/'.$pItem['file'];
            $relPath = 'clients/assets/images/posts/'.$pItem['file'];

            if (! File::exists($destFile)) {
                try {
                    $response = Http::timeout(10)->get($pItem['url']);
                    if ($response->successful()) {
                        File::put($destFile, $response->body());
                    } else {
                        File::copy($baseAssetsPath.'/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp', $destFile);
                    }
                } catch (\Exception $e) {
                    File::copy($baseAssetsPath.'/images/banners/banner-vi-tuong-lai-xanh-546ygtr5webp.webp', $destFile);
                }
            }

            $mediaId = DB::table('media')->where('path', $relPath)->value('id');
            if (! $mediaId) {
                $mediaId = DB::table('media')->insertGetId([
                    'uuid' => (string) Str::uuid(),
                    'folder_id' => null,
                    'disk' => 'public',
                    'filename' => $pItem['file'],
                    'original_filename' => $pItem['file'],
                    'extension' => 'webp',
                    'path' => $relPath,
                    'mime_type' => 'image/webp',
                    'file_size' => File::exists($destFile) ? File::size($destFile) : 1024,
                    'alt_text' => 'Tin tức VinFast Hải Phòng',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('posts')->where('slug', $slug)->update([
                'featured_media_id' => $mediaId,
                'updated_at' => $now,
            ]);
        }

        $this->info('Đã hoàn tất đồng bộ toàn bộ assets vào public/storage/clients/assets đúng loại!');

        return Command::SUCCESS;
    }
}
