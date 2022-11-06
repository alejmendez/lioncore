<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('employees')->controller(EmployeeController::class)->name('employees.')->group(function () {
                Route::middleware('permission:employee read')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/filters', 'filters')->name('filters');
                    Route::get('/module-data', 'moduleData')->name('module-data');
                    Route::get('/{id}', 'show')->name('show');
                });
                Route::post('/', 'store')->name('store')
                    ->middleware('permission:employee create');
                Route::put('/{id}', 'update')->name('update')
                    ->middleware('permission:employee update');
                Route::delete('/{id}', 'destroy')->name('destroy')
                    ->middleware('permission:employee delete');
            });
        });
    });
