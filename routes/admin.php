<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['web', 'auth:admin'])->group(function () {
    // Admin routes sẽ được thêm sau
});
