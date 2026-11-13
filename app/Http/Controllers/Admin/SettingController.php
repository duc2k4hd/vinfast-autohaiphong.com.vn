<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Shared\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService
    ) {}

    /**
     * Giao diện cấu hình cài đặt website.
     */
    public function index(): View
    {
        $settings = $this->settingsService->getAll();

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Cập nhật cài đặt hệ thống.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->except(['_token']);
        $now = now();

        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => (string) $value,
                    'group' => 'general',
                    'is_public' => true,
                    'updated_at' => $now,
                ]
            );
        }

        // Xóa cache để toàn bộ site cập nhật ngay lập tức
        $this->settingsService->invalidate();

        return back()->with('success', 'Đã lưu cấu hình cài đặt website thành công và xóa sạch cache cấu hình.');
    }
}

