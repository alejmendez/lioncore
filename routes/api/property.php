<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('properties')->name('properties.')->group(function () {
                Route::middleware('permission:property read')->group(function () {
                    Route::get('/', [PropertyController::class, 'index'])->name('index');
                    Route::get('/filters', [PropertyController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [PropertyController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [PropertyController::class, 'show'])->name('show');
                });
                Route::post('/', [PropertyController::class, 'store'])->name('store')
                    ->middleware('permission:property create');
                Route::put('/{id}', [PropertyController::class, 'update'])->name('update')
                    ->middleware('permission:property update');
                Route::delete('/{id}', [PropertyController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:property delete');
            });
        });
    });
