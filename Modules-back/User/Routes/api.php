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


Route::prefix('v1/users')->name('users.')->middleware('auth:api')->group(function () {
    Route::get('/', 'UserController@index')->name('index')
        ->middleware('permission:user');
    Route::get('/{user}', 'UserController@show')->name('show')
        ->middleware('permission:user show');
    Route::post('/', 'UserController@store')->name('store')
        ->middleware('permission:user store');
    Route::put('/{user}', 'UserController@update')->name('update')
        ->middleware('permission:user update');
    Route::delete('/{user}', 'UserController@destroy')->name('destroy')
        ->middleware('permission:user destroy');
});
