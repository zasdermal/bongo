<?php

use Illuminate\Support\Facades\Route;

use Module\Inventory\Controllers\StockController;

Route::get('/stocks', [StockController::class, 'availabel_stocks']);