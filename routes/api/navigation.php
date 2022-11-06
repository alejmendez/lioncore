<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('navigations')->controller(NavigationController::class)->name('navigations.')->group(function () {
                Route::middleware('permission:navigation read')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/filters', 'filters')->name('filters');
                    Route::get('/module-data', 'moduleData')->name('module-data');
                    Route::get('/{id}', 'show')->name('show');

                    Route::get('/getMenu', 'getMenu')->name('getMenu')
                        ->middleware('permission:navigation delete');
                });
                Route::post('/', 'store')->name('store')
                    ->middleware('permission:navigation create');
                Route::put('/{id}', 'update')->name('update')
                    ->middleware('permission:navigation update');
                Route::delete('/{id}', 'destroy')->name('destroy')
                    ->middleware('permission:navigation delete');
            });
        });
    });
