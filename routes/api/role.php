<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('roles')->controller(RoleController::class)->name('roles.')->group(function () {
                Route::middleware('permission:role read')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/filters', 'filters')->name('filters');
                    Route::get('/module-data', 'moduleData')->name('module-data');
                    Route::get('/{id}', 'show')->name('show');
                });
                Route::post('/', 'store')->name('store')
                    ->middleware('permission:role create');
                Route::put('/{id}', 'update')->name('update')
                    ->middleware('permission:role update');
                Route::delete('/{id}', 'destroy')->name('destroy')
                    ->middleware('permission:role delete');
            });
        });
    });
