<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
                Route::middleware('permission:user read')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/filters', 'filters')->name('filters');
                    Route::get('/module-data', 'moduleData')->name('module-data');
                    Route::get('/{id}', 'show')->name('show');
                });
                Route::post('/', 'store')->name('store')
                    ->middleware('permission:user create');
                Route::put('/{id}', 'update')->name('update')
                    ->middleware('permission:user update');
                Route::delete('/{id}', 'destroy')->name('destroy')
                    ->middleware('permission:user delete');
            });
        });
    });
