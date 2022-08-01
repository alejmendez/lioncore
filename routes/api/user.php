<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('users')->name('users.')->group(function () {
                Route::middleware('permission:user read')->group(function () {
                    Route::get('/', [UserController::class, 'index'])->name('index');
                    Route::get('/filters', [UserController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [UserController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [UserController::class, 'show'])->name('show');
                });
                Route::post('/', [UserController::class, 'store'])->name('store')
                    ->middleware('permission:user create');
                Route::put('/{id}', [UserController::class, 'update'])->name('update')
                    ->middleware('permission:user update');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:user delete');
            });
        });
    });
