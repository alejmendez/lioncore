<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->name('auth.')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('refresh', 'AuthController@refresh')->name('refresh');
        Route::get('current/user', 'AuthController@currentUser')->name('current.user');

        Route::group(['middleware' => 'auth:api'], function(){
            Route::get('logout', 'AuthController@logout')->name('logout');
            Route::post('user', 'AuthController@user')->name('user');
        });
    });
});
