<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SeoController as AdminSeoController;
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
use App\Http\Controllers\Client\SitemapController;
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
    Route::get('/o-to-vinfast/page/{page}', [CatalogController::class, 'index'])->whereNumber('page')->name('catalog.page');

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

    // 7. Tin tức & Blog
    Route::get('/blogs', [PostController::class, 'index'])->name('posts.index');
    Route::get('/blogs/page/{page}', [PostController::class, 'index'])->whereNumber('page')->name('posts.page');
    Route::get('/blog/{slug}', [PostController::class, 'show'])->name('posts.show');

    // 301 Redirects tương thích ngược từ URL cũ
    Route::get('/chuyen-muc/tin-tuc', function () {
        $query = request()->getQueryString();

        return redirect()->to(url('/blogs').($query ? '?'.$query : ''), 301);
    });
    Route::get('/chuyen-muc/tin-tuc/page/{page}', function ($page) {
        return redirect()->to(url('/blogs').'?page='.$page, 301);
    });
    Route::get('/chuyen-muc/tin-tuc/{slug}', function ($slug) {
        return redirect()->to(url('/blog/'.$slug), 301);
    });

    // 8. Liên hệ
    Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

    // 9. Các trang chính sách & hạ tầng
    Route::get('/chinh-sach', [PageController::class, 'policyHub'])->name('pages.policies');
    Route::get('/pin-va-tram-sac', [PageController::class, 'chargingStations'])->name('pages.charging_stations');
    Route::get('/trai-nghiem-khach-hang', [PageController::class, 'customerExperience'])->name('pages.customer_experience');
    Route::get('/chinh-sach-thanh-toan', [PageController::class, 'paymentPolicy'])->name('pages.payment_policy');
    Route::get('/chinh-sach-bao-mat', [PageController::class, 'privacyPolicy'])->name('pages.privacy_policy');
    Route::get('/chinh-sach-bao-hanh', [PageController::class, 'warrantyPolicy'])->name('pages.warranty_policy');
    Route::get('/dieu-khoan-su-dung', [PageController::class, 'terms'])->name('pages.terms');

    // 10. Sitemap XML động, HTML Sitemap & Robots.txt
    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
    Route::get('/so-do-trang-web', [SitemapController::class, 'html'])->name('sitemap.html');
    Route::get('/robots.txt', function () {
        return response(file_get_contents(public_path('robots.txt')), 200, ['Content-Type' => 'text/plain']);
    })->name('robots');
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
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');

        // Quản lý Đơn hàng tiền mặt
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{id}/print', [AdminOrderController::class, 'print'])->name('orders.print');
        Route::patch('/orders/{id}/confirm-cash', [AdminOrderController::class, 'confirmCashPayment'])->name('orders.confirm_cash');

        // Quản lý Báo giá (Leads)
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::patch('/leads/{id}/status', [AdminLeadController::class, 'updateStatus'])->name('leads.update_status');
        Route::delete('/leads/{id}', [AdminLeadController::class, 'destroy'])->name('leads.destroy');

        // Quản lý Tin tức (Posts)
        Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [AdminPostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{id}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{id}', [AdminPostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{id}', [AdminPostController::class, 'destroy'])->name('posts.destroy');

        // Quản lý Thư viện Media
        Route::get('/media', [AdminMediaController::class, 'index'])->name('media.index');
        Route::get('/media/api/list', [AdminMediaController::class, 'apiList'])->name('media.api.list');
        Route::post('/media', [AdminMediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{id}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

        // Quản lý Menu & Ảnh hiển thị
        Route::get('/menus', [AdminMenuController::class, 'index'])->name('menus.index');
        Route::post('/menus/vehicles', [AdminMenuController::class, 'updateVehicleMenu'])->name('menus.vehicles.update');
        Route::patch('/menus/vehicles/{id}', [AdminMenuController::class, 'updateVehicleSingle'])->name('menus.vehicles.update_single');
        Route::post('/menus/items', [AdminMenuController::class, 'storeMenuItem'])->name('menus.items.store');
        Route::put('/menus/items/{id}', [AdminMenuController::class, 'updateMenuItem'])->name('menus.items.update');
        Route::delete('/menus/items/{id}', [AdminMenuController::class, 'destroyMenuItem'])->name('menus.items.destroy');

        // Quản lý Cài đặt
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Công cụ SEO thời gian thực
        Route::post('/seo/analyze', [AdminSeoController::class, 'analyze'])->name('seo.analyze');
    });
});
