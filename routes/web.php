<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\LeadController;
use Illuminate\Support\Facades\Route;

Route::name('client.')->group(function () {
    // 1. Trang chủ
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // 2. Tiếp nhận thông tin báo giá & tư vấn (Leads)
    Route::post('/lead/store', [LeadController::class, 'store'])->name('leads.store');
});
