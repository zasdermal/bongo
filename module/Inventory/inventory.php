<?php

use Illuminate\Support\Facades\Route;

use Module\Inventory\Controllers\StockController;
use Module\Inventory\Controllers\ProductController;
use Module\Inventory\Controllers\CategoryController;
use Module\Inventory\Controllers\SubCategoryController;

Route::prefix('/catalog')->name('catalog.')->group(function () {
    // categories
    Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
    // Route::post('/store-category', [CategoryController::class, 'store'])->name('store_category');

    // sub categories
    Route::get('/sub-categories', [SubCategoryController::class, 'subCategories'])->name('subCategories');
    // Route::post('/store-sub-category', [SubCategoryController::class, 'store'])->name('store_sub_category');

    // products
    Route::get('/products', [ProductController::class, 'products'])->name('products');
    // Route::post('/store-product', [ProductController::class, 'store'])->name('store_product');
});

Route::get('/stocks', [StockController::class, 'stocks'])->name('stocks');
Route::post('/store-stocks', [StockController::class, 'store'])->name('store_stocks');