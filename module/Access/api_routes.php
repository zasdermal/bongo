<?php

use Illuminate\Support\Facades\Route;

use Module\Access\Controllers\UserController;

Route::prefix('/user')->group(function () {
    //users
    Route::get('/employees', [UserController::class, 'employees']);
});