<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('roles')->name('roles.')->group(function () {
                Route::middleware('permission:role read')->group(function () {
                    Route::get('/', [RoleController::class, 'index'])->name('index');
                    Route::get('/filters', [RoleController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [RoleController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [RoleController::class, 'show'])->name('show');
                });
                Route::post('/', [RoleController::class, 'store'])->name('store')
                    ->middleware('permission:role create');
                Route::put('/{id}', [RoleController::class, 'update'])->name('update')
                    ->middleware('permission:role update');
                Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:role delete');
            });
        });
    });
