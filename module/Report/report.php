<?php

use Illuminate\Support\Facades\Route;

use Module\Report\Controllers\ReportController;

Route::prefix('/report')->name('report.')->group(function () {
    Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
    // Route::get('/brand-wise-sales', [SalesReportController::class, 'brand_wise_sales'])->name('brand_wise_sales');

    // Route::get('/delivery-top-sheet', [SalesReportController::class, 'delivery_top_sheet'])->name('delivery_top_sheet');
    // Route::get('/delivery-top-sheet-products/{id}', [SalesReportController::class, 'delivery_top_sheet_products'])->name('delivery_top_sheet_products');
    // Route::get('/delivery-top-sheet-pharmacy/{id}', [SalesReportController::class, 'delivery_top_sheet_pharmacy'])->name('delivery_top_sheet_pharmacy');

    // Route::get('/collections', [SalesReportController::class, 'collections'])->name('collections');
    // Route::get('/dues', [SalesReportController::class, 'dues'])->name('dues');
    // Route::get('/returns', [SalesReportController::class, 'returns'])->name('returns');
    // Route::get('/pre-returns', [SalesReportController::class, 'pre_returns'])->name('pre_returns');
    // Route::get('/national-sales', [SalesReportController::class, 'national_sales'])->name('national_sales');


    
    // // this route should be transfer to the collection file
    // Route::get('/money-receipts', [SalesReportController::class, 'money_receipts'])->name('money_receipts');
    // Route::post('/store-money-receipt', [MoneyReceiptController::class, 'store'])->name('store_money_receipt');
    // Route::get('/receipt/{id}', [SalesReportController::class, 'receipt'])->name('receipt');
});