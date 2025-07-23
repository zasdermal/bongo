<?php

use Illuminate\Support\Facades\Route;

use Module\Access\Controllers\UserController;
use Module\Access\Controllers\RoleController;
use Module\Access\Controllers\PermissionController;

Route::prefix('/user-management')->name('user_management.')->group(function () {
    //permissions
    Route::get('/permissions', [PermissionController::class, 'permissions'])->name('permissions');
    Route::post('/store-permission', [PermissionController::class, 'store'])->name('store_permission');
    Route::get('/permission/{id}', [PermissionController::class, 'permission'])->name('permission');
    Route::post('/update-permission/{id}', [PermissionController::class, 'update'])->name('update_permission');
    Route::get('/destroy-permission/{id}', [PermissionController::class, 'destroy'])->name('destroy_permission');

    //roles
    Route::get('/roles', [RoleController::class, 'roles'])->name('roles');
    Route::post('/store-role', [RoleController::class, 'store'])->name('store_role');
    Route::get('/role/{id}', [RoleController::class, 'role'])->name('role');
    Route::post('/update-role/{id}', [RoleController::class, 'update'])->name('update_role');
    Route::get('/destroy-role/{id}', [RoleController::class, 'destroy'])->name('destroy_role');
    //assign role permissions
    Route::post('/assign-role-permissions/{id}', [RoleController::class,'assign_role_permissions'])->name('assign_role_permissions');
    
    //users
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/store-user', [UserController::class,'store'])->name('store_user');
    Route::get('/user/{id}', [UserController::class, 'user'])->name('user');
    Route::post('/update-user/{id}', [UserController::class, 'update'])->name('update_user');
    Route::get('/destroy-user/{id}', [UserController::class, 'destroy'])->name('destroy_user');
});