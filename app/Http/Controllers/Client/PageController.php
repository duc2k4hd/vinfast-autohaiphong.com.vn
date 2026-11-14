<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Shared\SettingsService;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService
    ) {}

    /**
     * Trang Pin & Trạm Sạc VinFast.
     */
    public function chargingStations(): View
    {
        return view('clients.pages.custom.charging-stations', [
            'settings' => $this->settingsService->getPublicSettings(),
        ]);
    }

    /**
     * Trang Trải Nghiệm Khách Hàng.
     */
    public function customerExperience(): View
    {
        return view('clients.pages.custom.customer-experience');
    }

    /**
     * Trang Chính Sách Thanh Toán (Quy định thanh toán tiền mặt tại showroom).
     */
    public function paymentPolicy(): View
    {
        return view('clients.pages.custom.payment-policy');
    }

    /**
     * Trang Chính Sách Bảo Mật.
     */
    public function privacyPolicy(): View
    {
        return view('clients.pages.custom.privacy-policy');
    }

    /**
     * Trang Chính Sách Bảo Hành.
     */
    public function warrantyPolicy(): View
    {
        return view('clients.pages.custom.warranty-policy');
    }

    /**
     * Trang Điều Khoản Sử Dụng.
     */
    public function terms(): View
    {
        return view('clients.pages.custom.terms');
    }
}
