<?php

Route::prefix('v1')
->domain('{tenant}.lioncore.oo')
->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login', 'Auth\AuthController@login')->name('login');
        Route::post('register', 'Auth\AuthController@register')->name('register');
        Route::post('refresh', 'Auth\AuthController@refresh')->name('refresh');
        Route::get('current/user', 'Auth\AuthController@currentUser')->name('current.user');

        Route::group(['middleware' => 'auth:api'], function(){
            Route::get('logout', 'Auth\AuthController@logout')->name('logout');
            Route::post('user', 'Auth\AuthController@user')->name('user');
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::prefix('person')->name('person.')->group(function () {
            Route::get('/', 'PersonController@index')->name('index')
                ->middleware('permission:person list');
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
                ->middleware('permission:user list');
            Route::get('/filters', 'UserController@filters')->name('filters')
                ->middleware('permission:user list');
            Route::get('/module-data', 'UserController@moduleData')->name('module-data')
                ->middleware('permission:user list');
            Route::get('/{user}', 'UserController@show')->name('show')
                ->middleware('permission:user show');
            Route::post('/', 'UserController@store')->name('store')
                ->middleware('permission:user store');
            Route::put('/{user}', 'UserController@update')->name('update')
                ->middleware('permission:user update');
            Route::delete('/{user}', 'UserController@destroy')->name('destroy')
                ->middleware('permission:user destroy');
        });

        Route::prefix('properties')->name('properties.')->group(function () {
            Route::get('/', 'PropertyController@index')->name('index')
                ->middleware('permission:property list');
            Route::get('/filters', 'PropertyController@filters')->name('filters')
                ->middleware('permission:property list');
            Route::get('/module-data', 'PropertyController@moduleData')->name('module-data')
                ->middleware('permission:property list');
            Route::get('/{property}', 'PropertyController@show')->name('show')
                ->middleware('permission:property show');
            Route::post('/', 'PropertyController@store')->name('store')
                ->middleware('permission:property store');
            Route::put('/{property}', 'PropertyController@update')->name('update')
                ->middleware('permission:property update');
            Route::delete('/{property}', 'PropertyController@destroy')->name('destroy')
                ->middleware('permission:property destroy');
        });

        Route::prefix('chat')->name('chat.')->group(function () {
            Route::post('msg', 'ChatController@msg')->name('msg')
                ->middleware('permission:chat view');
            Route::get('contacts', 'ChatController@contacts')->name('contacts')
                ->middleware('permission:chat view');
            Route::get('chat-contacts', 'ChatController@chatContacts')->name('chat-contacts')
                ->middleware('permission:chat view');
            Route::get('chats', 'ChatController@chats')->name('chats')
                ->middleware('permission:chat view');
            Route::post('mark-all-seen', 'ChatController@markAllSeen')->name('mark-all-seen')
                ->middleware('permission:chat view');
            Route::post('set-pinned', 'ChatController@setPinned')->name('set-pinned')
                ->middleware('permission:chat view');
        });

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', 'RoleController@index')->name('index')
                ->middleware('permission:role list');
            Route::get('/filters', 'RoleController@filters')->name('filters')
                ->middleware('permission:role list');
            Route::get('/module-data', 'RoleController@moduleData')->name('module-data')
                ->middleware('permission:role list');
            Route::get('/{role}', 'RoleController@show')->name('show')
                ->middleware('permission:role show');
            Route::post('/', 'RoleController@store')->name('store')
                ->middleware('permission:role store');
            Route::put('/{role}', 'RoleController@update')->name('update')
                ->middleware('permission:role update');
            Route::delete('/{role}', 'RoleController@destroy')->name('destroy')
                ->middleware('permission:role destroy');
        });
        // add router
    });
});
