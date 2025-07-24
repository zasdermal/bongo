<?php

use Illuminate\Support\Facades\Route;

use Module\Market\Controllers\SalePointController;

Route::post('/sale-points-by-territory', [SalePointController::class, 'salePoints_by_territory']);