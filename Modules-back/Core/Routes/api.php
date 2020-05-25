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

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1/person'], function () {
    Route::get('/', 'PersonController@index')->name('person.index')
        ->middleware('permission:person');
    Route::get('/{person}', 'PersonController@show')->name('person.show')
        ->middleware('permission:person show');
    Route::post('/', 'PersonController@store')->name('person.store')
        ->middleware('permission:person store');
    Route::put('/{person}', 'PersonController@update')->name('person.update')
        ->middleware('permission:person update');
    Route::delete('/{person}', 'PersonController@destroy')->name('person.destroy')
        ->middleware('permission:person destroy');
});