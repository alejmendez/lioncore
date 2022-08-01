<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('employees')->name('employees.')->group(function () {
                Route::middleware('permission:employee read')->group(function () {
                    Route::get('/', [EmployeeController::class, 'index'])->name('index');
                    Route::get('/filters', [EmployeeController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [EmployeeController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [EmployeeController::class, 'show'])->name('show');
                });
                Route::post('/', [EmployeeController::class, 'store'])->name('store')
                    ->middleware('permission:employee create');
                Route::put('/{id}', [EmployeeController::class, 'update'])->name('update')
                    ->middleware('permission:employee update');
                Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:employee delete');
            });
        });
    });
