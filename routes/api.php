<?php

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('refresh', 'AuthController@refresh')->name('refresh');
        Route::get('current/user', 'AuthController@currentUser')->name('current.user');

        Route::group(['middleware' => 'auth:api'], function(){
            Route::get('logout', 'AuthController@logout')->name('logout');
            Route::post('user', 'AuthController@user')->name('user');
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::prefix('person')->name('person.')->group(function () {
            Route::get('/', 'PersonController@index')->name('index')
                ->middleware('permission:person');
            Route::get('/{person}', 'PersonController@show')->name('show')
                ->middleware('permission:person show');
            Route::post('/', 'PersonController@store')->name('store')
                ->middleware('permission:person store');
            Route::put('/{person}', 'PersonController@update')->name('update')
                ->middleware('permission:person update');
            Route::delete('/{person}', 'PersonController@destroy')->name('destroy')
                ->middleware('permission:person destroy');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', 'UserController@index')->name('index')
                ->middleware('permission:user');
            Route::get('/filters', 'UserController@filters')->name('filters')
                ->middleware('permission:user');
            Route::get('/module-data', 'UserController@moduleData')->name('module-data')
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

        Route::prefix('v1/properties')->name('properties.')->middleware('auth:api')->group(function () {
            Route::get('/', 'PropertyController@index')->name('index')
                ->middleware('permission:property');
            Route::get('/{property}', 'PropertyController@show')->name('show')
                ->middleware('permission:property show');
            Route::post('/', 'PropertyController@store')->name('store')
                ->middleware('permission:property store');
            Route::put('/{property}', 'PropertyController@update')->name('update')
                ->middleware('permission:property update');
            Route::delete('/{property}', 'PropertyController@destroy')->name('destroy')
                ->middleware('permission:property destroy');
        });
    });
});
