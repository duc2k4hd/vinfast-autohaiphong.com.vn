<?php

namespace App\Providers;

use App\Services\Shared\SettingsService;
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

        if (! $this->app->runningInConsole()) {
            View::composer('clients.*', function ($view) {
                $settings = app(SettingsService::class)->getPublicSettings();
                $view->with('siteSettings', $settings);
            });
        }
    }
}
