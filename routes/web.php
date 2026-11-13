<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CatalogController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\LeadController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\ProductController;
use Illuminate\Support\Facades\Route;

// Route đăng nhập chung hệ thống
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

/*
|--------------------------------------------------------------------------
| CLIENT ROUTES (Giao diện người dùng)
|--------------------------------------------------------------------------
*/
Route::name('client.')->group(function () {
    // 1. Trang chủ
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // 2. Danh mục các dòng xe ô tô VinFast
    Route::get('/o-to-vinfast', [CatalogController::class, 'index'])->name('catalog.index');

    // 3. Chi tiết dòng xe ô tô VinFast
    Route::get('/xe/{slug}', [ProductController::class, 'show'])->name('products.show');

    // 4. Tiếp nhận thông tin báo giá & tư vấn (Leads)
    Route::post('/lead/store', [LeadController::class, 'store'])->name('leads.store');

    // 5. Giỏ hàng / Danh sách xe đăng ký
    Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
    Route::post('/gio-hang/cap-nhat', [CartController::class, 'update'])->name('cart.update');
    Route::post('/gio-hang/xoa', [CartController::class, 'remove'])->name('cart.remove');

    // 6. Quy trình Checkout / Đặt cọc tiền mặt duy nhất
    Route::get('/dat-coc-ngay', [CheckoutController::class, 'direct'])->name('checkout.direct');
    Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/dat-hang-thanh-cong/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

    // 7. Tin tức & Hoạt động
    Route::get('/chuyen-muc/tin-tuc', [PostController::class, 'index'])->name('posts.index');
    Route::get('/chuyen-muc/tin-tuc/{slug}', [PostController::class, 'show'])->name('posts.show');

    // 8. Liên hệ
    Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

    // 9. Các trang chính sách & hạ tầng
    Route::get('/pin-va-tram-sac', [PageController::class, 'chargingStations'])->name('pages.charging_stations');
    Route::get('/trai-nghiem-khach-hang', [PageController::class, 'customerExperience'])->name('pages.customer_experience');
    Route::get('/chinh-sach-thanh-toan', [PageController::class, 'paymentPolicy'])->name('pages.payment_policy');
    Route::get('/chinh-sach-bao-mat', [PageController::class, 'privacyPolicy'])->name('pages.privacy_policy');
    Route::get('/chinh-sach-bao-hanh', [PageController::class, 'warrantyPolicy'])->name('pages.warranty_policy');
    Route::get('/dieu-khoan-su-dung', [PageController::class, 'terms'])->name('pages.terms');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Hệ thống quản trị)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Auth
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Authenticated Admin
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index']);

        // Quản lý Dòng xe & Specs Key-Value
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');

        // Quản lý Đơn hàng tiền mặt
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/confirm-cash', [AdminOrderController::class, 'confirmCashPayment'])->name('orders.confirm_cash');

        // Quản lý Báo giá (Leads)
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::patch('/leads/{id}/status', [AdminLeadController::class, 'updateStatus'])->name('leads.update_status');

        // Quản lý Cài đặt
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
