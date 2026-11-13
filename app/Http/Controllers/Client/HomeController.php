<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\HomeService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Khởi tạo Controller với HomeService.
     */
    public function __construct(
        protected HomeService $homeService
    ) {}

    /**
     * Hiển thị trang chủ website VinFast Hải Phòng.
     */
    public function index(): View
    {
        $cars = $this->homeService->getFeaturedCars();
        $latestPosts = $this->homeService->getLatestPosts(3);
        $banners = $this->homeService->getHomeBanners();

        return view('clients.pages.home.index', [
            'cars' => $cars,
            'latestPosts' => $latestPosts,
            'banners' => $banners,
        ]);
    }
}
