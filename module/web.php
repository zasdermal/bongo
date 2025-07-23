<?php

use Illuminate\Support\Facades\Route;

use Module\Access\Controllers\AuthController;

Route::middleware('web')->group(function () {
    Route::get('/', [AuthController::class, 'login_form'])->name('login_form');
    Route::post('/', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Access Route
        |--------------------------------------------------------------------------
        */
        require __DIR__ . '/Access/web_routes.php';

        /*
        |--------------------------------------------------------------------------
        | Inventory Route
        |--------------------------------------------------------------------------
        */
        require __DIR__ . '/Inventory/inventory.php';

        /*
        |--------------------------------------------------------------------------
        | MArket Route
        |--------------------------------------------------------------------------
        */
        require __DIR__ . '/Market/market.php';

        /*
        |--------------------------------------------------------------------------
        | Sales Route
        |--------------------------------------------------------------------------
        */
        require __DIR__ . '/Sales/web_routes.php';

        /*
        |--------------------------------------------------------------------------
        | Sales Route
        |--------------------------------------------------------------------------
        */
        require __DIR__ . '/Report/report.php';

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});