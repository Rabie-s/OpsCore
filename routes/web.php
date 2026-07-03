<?php

use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Index');
})->name('home');


Route::prefix('admin')->group(function () {

    Route::get('/auth/login', [AuthController::class, 'loginPage'])->name('admin.auth.loginPage');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('admin.auth.login');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:admin')->name('admin.auth.logout');



    Route::middleware('auth:admin')->group(function () {
        Route::get('/warehouse/{id}', [WarehouseController::class, 'show'])->name('admin.warehouse');
        Route::post('/warehouse/withdraw', [WarehouseController::class, 'withdraw'])->name('admin.warehouse.withdraw');
    });


});


