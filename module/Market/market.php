<?php

use Illuminate\Support\Facades\Route;

use Module\Market\Controllers\ZoneController;
use Module\Market\Controllers\AreaController;
use Module\Market\Controllers\RegionController;
use Module\Market\Controllers\DivisionController;
use Module\Market\Controllers\TerritoryController;
use Module\Market\Controllers\SalePointController;

Route::prefix('/location')->name('location.')->group(function () {
    // zones
    Route::get('/zones', [ZoneController::class, 'zones'])->name('zones');
    Route::post('/store-zone', [ZoneController::class, 'store'])->name('store_zone');
    Route::get('/zone/{id}', [ZoneController::class, 'zone'])->name('zone');
    Route::post('/update-zone/{id}', [ZoneController::class, 'update'])->name('update_zone');
    Route::get('/destroy-zone/{id}', [ZoneController::class, 'destroy'])->name('destroy_zone');

    // division
    Route::get('/divisions', [DivisionController::class, 'divisions'])->name('divisions');
    Route::post('/sub-area', [DivisionController::class, 'store'])->name('store_sub_area');
    Route::post('/update-sub-area/{id}', [DivisionController::class, 'update'])->name('update_sub_area');
    Route::get('/associated-region-zone-area-by-sub_area_{id}', [DivisionController::class, 'associated_region_zone_area_by_sub_area_'])->name('associated_region_zone_area_by_sub_area_');
    Route::get('/associated-sub-areas-for-area_{id}', [DivisionController::class, 'associated_sub_areas_for_'])->name('associated_sub_areas_for_');

    // regions
    Route::get('/regions', [RegionController::class, 'regions'])->name('regions');
    Route::post('/region', [RegionController::class, 'store'])->name('store_region');
    Route::post('/update-region/{id}', [RegionController::class, 'update'])->name('update_region');
    Route::get('/associated-zone-by-region_{id}', [RegionController::class, 'associated_zone_by_region_'])->name('associated_zone_by_region_');

    // areas
    Route::get('/areas', [AreaController::class, 'areas'])->name('areas');
    Route::post('/area', [AreaController::class, 'store'])->name('store_area');
    Route::post('/update-area/{id}', [AreaController::class, 'update'])->name('update_area');
    Route::get('/associated-region-zone-by-area_{id}', [AreaController::class, 'associated_region_zone_by_area_'])->name('associated_region_zone_by_area_');

    // territories
    Route::get('/territories', [TerritoryController::class, 'territories'])->name('territories');
    Route::post('/territory', [TerritoryController::class, 'store'])->name('store_territory');
    Route::post('/update-territory/{id}', [TerritoryController::class, 'update'])->name('update_territory');
    Route::get('/associated-territories-for-sub_area_{id}', [TerritoryController::class, 'associated_territories_for_'])->name('associated_territories_for_');

    // design
    Route::get('/design', [TerritoryController::class, 'design'])->name('design');
});

//sales point
Route::get('/sale-points', [SalePointController::class, 'salePoints'])->name('salePoints');
Route::post('/store-sale-point', [SalePointController::class, 'store'])->name('store_salePoint');
Route::get('/sale-point/{id}', [SalePointController::class, 'salePoint'])->name('salePoint');
Route::post('/update-sale-point/{id}', [SalePointController::class, 'update'])->name('update_salePoint');
Route::get('/destroy-sale-point/{id}', [SalePointController::class, 'destroy'])->name('destroy_salePoint');

Route::post('/bulk-upload-sale-points', [SalePointController::class, 'bulk_upload_salePoints'])->name('bulk_upload_salePoints');
Route::get('/sale-point-by-territory_{id}', [SalePointController::class, 'salePoint_by_territory_'])->name('salePoint_by_territory_'); // it will be salePoints