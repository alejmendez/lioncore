<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('navigations')->name('navigations.')->group(function () {
                Route::middleware('permission:navigation read')->group(function () {
                    Route::get('/', [NavigationController::class, 'index'])->name('index');
                    Route::get('/filters', [NavigationController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [NavigationController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [NavigationController::class, 'show'])->name('show');

                    Route::get('/getMenu', [NavigationController::class, 'getMenu'])->name('getMenu')
                        ->middleware('permission:navigation delete');
                });
                Route::post('/', [NavigationController::class, 'store'])->name('store')
                    ->middleware('permission:navigation create');
                Route::put('/{id}', [NavigationController::class, 'update'])->name('update')
                    ->middleware('permission:navigation update');
                Route::delete('/{id}', [NavigationController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:navigation delete');
            });
        });
    });
