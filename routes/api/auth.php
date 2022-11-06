<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::prefix('auth')->controller(AuthController::class)->name('auth.')->group(function () {
            Route::post('login', 'login')->name('login');
            Route::post('register', 'register')->name('register');
            Route::post('refresh-access-token', 'refresh')->name('refresh');
            Route::get('current/user', 'currentUser')->name('current.user');

            Route::group(['middleware' => 'auth:api'], function () {
                Route::get('logout', 'logout')->name('logout');
                Route::post('user', 'user')->name('user');
            });
        });
    });
