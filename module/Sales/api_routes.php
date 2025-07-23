<?php

use Illuminate\Support\Facades\Route;

use Module\Sales\Controllers\OrderInvoiceController;

Route::prefix('/order')->group(function () {
    Route::post('/store-invoice', [OrderInvoiceController::class, 'store']);
});