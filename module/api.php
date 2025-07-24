<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Module\Access\Controllers\AuthController;

Route::get('health-check', function (Request $request){
    return response()->json([
        'status' => 'SUCCESS',
        'message' => 'Bongo Health is ok'
    ], 200);
});

Route::post('sign-in', [AuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Access Route
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/Access/api_routes.php';

    /*
    |--------------------------------------------------------------------------
    | Inventory Route
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/Inventory/api_routes.php';

    /*
    |--------------------------------------------------------------------------
    | MArket Route
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/Market/api_routes.php';

    /*
    |--------------------------------------------------------------------------
    | Sales Route
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/Sales/api_routes.php';

    /*
    |--------------------------------------------------------------------------
    | Sales Route
    |--------------------------------------------------------------------------
    */
    // require __DIR__ . '/Report/report.php';

    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});