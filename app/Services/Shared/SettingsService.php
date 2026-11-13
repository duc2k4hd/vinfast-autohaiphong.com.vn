<?php

namespace App\Services\Shared;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SettingsService
{
    /**
     * Cache thời gian sống (TTL) tính bằng giây (24 giờ).
     */
    protected const CACHE_TTL = 86400;

    /**
     * Khóa lưu cache cho autoload settings.
     */
    protected const CACHE_KEY_AUTOLOAD = 'site:settings:autoload';

    /**
     * Khóa lưu cache cho public settings (chia sẻ ra Blade).
     */
    protected const CACHE_KEY_PUBLIC = 'site:settings:public';

    /**
     * Bộ nhớ đệm trong cùng một request (In-memory memoization).
     *
     * @var array<string, mixed>|null
     */
    protected ?array $memoizedSettings = null;

    /**
     * Khởi tạo service và nạp cấu hình.
     */
    public function __construct()
    {
        // Trì hoãn nạp dữ liệu đến khi có lệnh gọi đầu tiên
    }

    /**
     * Lấy giá trị của một khóa cấu hình.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $this->ensureLoaded();

        return $this->memoizedSettings[$key] ?? $default;
    }

    /**
     * Lấy toàn bộ các cấu hình công khai được phép chia sẻ tới Client.
     *
     * @return array<string, mixed>
     */
    public function getPublicSettings(): array
    {
        if (! Schema::hasTable('settings')) {
            return [];
        }

        return Cache::remember(self::CACHE_KEY_PUBLIC, self::CACHE_TTL, function () {
            return DB::table('settings')
                ->where('is_public', true)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    /**
     * Cập nhật hoặc thêm mới một khóa cấu hình.
     */
    public function set(
        string $key,
        mixed $value,
        string $group = 'general',
        bool $isPublic = false,
        string $type = 'string',
        ?string $description = null
    ): bool {
        $stringValue = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string) $value;

        DB::table('settings')->updateOrInsert(
            ['key' => $key],
            [
                'group' => $group,
                'type' => $type,
                'value' => $stringValue,
                'is_public' => $isPublic,
                'autoload' => true,
                'description' => $description,
                'updated_at' => now(),
            ]
        );

        $this->invalidate();

        return true;
    }

    /**
     * Xóa cache để làm mới dữ liệu sau khi Admin cập nhật.
     */
    public function invalidate(): void
    {
        $this->memoizedSettings = null;
        Cache::forget(self::CACHE_KEY_AUTOLOAD);
        Cache::forget(self::CACHE_KEY_PUBLIC);
    }

    /**
     * Đảm bảo cấu hình autoload đã được nạp vào bộ nhớ RAM của request.
     */
    protected function ensureLoaded(): void
    {
        if ($this->memoizedSettings !== null) {
            return;
        }

        if (! Schema::hasTable('settings')) {
            $this->memoizedSettings = [];

            return;
        }

        $this->memoizedSettings = Cache::remember(self::CACHE_KEY_AUTOLOAD, self::CACHE_TTL, function () {
            return DB::table('settings')
                ->where('autoload', true)
                ->pluck('value', 'key')
                ->toArray();
        });
    }
}
