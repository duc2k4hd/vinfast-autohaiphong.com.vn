<?php

namespace App\Providers;

use App\Services\Shared\SettingsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class, function () {
            return new SettingsService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('clients.layouts.header', function ($view) {
            $cars = DB::table('products')
                ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
                ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
                ->where('products.status', 'published')
                ->whereNull('products.deleted_at')
                ->where(function ($query) {
                    $query->whereNull('products.published_at')->orWhere('products.published_at', '<=', now());
                })
                ->orderBy('products.sort_order')->orderBy('products.id')
                ->select('products.name', 'products.slug', 'media.path as thumbnail_path', 'product_categories.name as category_name')
                ->get();
            $view->with('menuCars', $cars);
        });

        if (! $this->app->runningInConsole()) {
            View::composer('clients.*', function ($view) {
                $settings = app(SettingsService::class)->getPublicSettings();
                $view->with('siteSettings', $settings);
            });
        }
    }
}
