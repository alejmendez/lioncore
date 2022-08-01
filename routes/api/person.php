<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('person')->name('people.')->group(function () {
                Route::middleware('permission:person read')->group(function () {
                    Route::get('/', [PersonController::class, 'index'])->name('index');
                    Route::get('/filters', [PersonController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [PersonController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [PersonController::class, 'show'])->name('show');
                });
                Route::post('/', [PersonController::class, 'store'])->name('store')
                    ->middleware('permission:person create');
                Route::put('/{id}', [PersonController::class, 'update'])->name('update')
                    ->middleware('permission:person update');
                Route::delete('/{id}', [PersonController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:person delete');
            });
        });
    });
