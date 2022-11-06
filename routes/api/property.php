<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('properties')->controller(PropertyController::class)->name('properties.')->group(function () {
                Route::middleware('permission:property read')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/filters', 'filters')->name('filters');
                    Route::get('/module-data', 'moduleData')->name('module-data');
                    Route::get('/{id}', 'show')->name('show');
                });
                Route::post('/', 'store')->name('store')
                    ->middleware('permission:property create');
                Route::put('/{id}', 'update')->name('update')
                    ->middleware('permission:property update');
                Route::delete('/{id}', 'destroy')->name('destroy')
                    ->middleware('permission:property delete');
            });
        });
    });
