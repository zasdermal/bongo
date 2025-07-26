<?php

use Illuminate\Support\Facades\Route;

use Module\Sales\Controllers\CollectionController;
use Module\Sales\Controllers\OrderInvoiceController;

Route::prefix('/order')->name('order.')->group(function () {
    Route::get('/invoices', [OrderInvoiceController::class, 'invoices'])->name('invoices');
    Route::get('/create-invoice', [OrderInvoiceController::class, 'create'])->name('create_invoice');
    Route::post('/store-invoice', [OrderInvoiceController::class, 'store'])->name('store_invoice');
    Route::get('/invoice/{id}', [OrderInvoiceController::class, 'invoice'])->name('invoice');
    Route::put('/update-invoice/{id}', [OrderInvoiceController::class, 'update'])->name('update_invoice');
    
    Route::get('/cancel-invoice/{id}', [OrderInvoiceController::class, 'cancel'])->name('cancel_invoice');
    Route::post('/update-order/{id}', [OrderInvoiceController::class, 'update_order'])->name('update_order');

    Route::get('/accepted-invoices', [OrderInvoiceController::class, 'accepted_invoices'])->name('accepted_invoices');
});

Route::prefix('/collection')->name('collection.')->group(function () {
    Route::get('/dues', [CollectionController::class, 'dues'])->name('dues');
    Route::get('/due/{id}', [CollectionController::class, 'due'])->name('due');
    Route::post('/update-due/{id}', [CollectionController::class, 'update'])->name('update_due');

    //not needed
    // Route::get('/partial-dues', [CollectionController::class, 'partial_dues'])->name('partial_dues');

    // Route::get('/return-order/{id}', [CollectionController::class, 'return_order'])->name('return_order');
    // Route::get('/return-order-and-edit-invoice/{id}', [CollectionController::class, 'return_order_and_edit_invoice'])->name('return_order_and_edit_invoice');
    // Route::post('/return-order-and-update-invoice/{id}', [CollectionController::class, 'return_order_and_update_invoice'])->name('return_order_and_update_invoice');
    // Route::get('/collected-payment', [CollectionController::class, 'collected_payment'])->name('collected_payment');
    // Route::post('/bulk-upload-collections', [CollectionController::class, 'bulk_upload_collections'])->name('bulk_upload_collections');
});