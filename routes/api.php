<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoleController;

Route::pattern('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');


Route::prefix('api/v1')
    //->domain('{tenant}.lioncore.oo')
    ->name('api.v1.')
    ->group(function () {
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('login', [AuthController::class, 'login'])->name('login');
            Route::post('register', [AuthController::class, 'register'])->name('register');
            Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
            Route::get('current/user', [AuthController::class, 'currentUser'])->name('current.user');

            Route::group(['middleware' => 'auth:api'], function () {
                Route::get('logout', [AuthController::class, 'logout'])->name('logout');
                Route::post('user', [AuthController::class, 'user'])->name('user');
            });
        });
    });

Route::middleware(['auth:api', 'throttle:60,1'])->group(function () {
    JsonApi::register('v1')
        ->defaultId('[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}')
        ->routes(function ($api) {
            $api->resource('user')->relationships(function ($relations) {
                $relations->hasOne('person');
            });
            $api->resource('employee')->relationships(function ($relations) {
                $relations->hasOne('person');
            });
            $api->resource('people')->relationships(function ($relations) {
                $relations->hasOne('employee');
                $relations->hasOne('user');
            });
        });
});
