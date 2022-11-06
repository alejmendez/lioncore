<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('person')->controller(PersonController::class)->name('people.')->group(function () {
                Route::middleware('permission:person read')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/filters', 'filters')->name('filters');
                    Route::get('/module-data', 'moduleData')->name('module-data');
                    Route::get('/{id}', 'show')->name('show');
                });
                Route::post('/', 'store')->name('store')
                    ->middleware('permission:person create');
                Route::put('/{id}', 'update')->name('update')
                    ->middleware('permission:person update');
                Route::delete('/{id}', 'destroy')->name('destroy')
                    ->middleware('permission:person delete');
            });
        });
    });
