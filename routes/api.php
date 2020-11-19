<?php

Route::prefix('v1')
//->domain('{tenant}.lioncore.oo')
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

        Route::prefix('alumnos')->name('alumnos.')->group(function () {
            Route::get('/', 'AlumnoController@index')->name('index')
                ->middleware('permission:alumno list');
            Route::get('/filters', 'AlumnoController@filters')->name('filters')
                ->middleware('permission:alumno list');
            Route::get('/module-data', 'AlumnoController@moduleData')->name('module-data')
                ->middleware('permission:alumno list');
            Route::get('/{alumno}', 'AlumnoController@show')->name('show')
                ->middleware('permission:alumno show');
            Route::post('/', 'AlumnoController@store')->name('store')
                ->middleware('permission:alumno store');
            Route::put('/{alumno}', 'AlumnoController@update')->name('update')
                ->middleware('permission:alumno update');
            Route::delete('/{alumno}', 'AlumnoController@destroy')->name('destroy')
                ->middleware('permission:alumno destroy');
        });

        Route::prefix('registros')->name('registros.')->group(function () {
            Route::get('/', 'RegistroController@index')->name('index')
                ->middleware('permission:registro list');
            Route::get('/filters', 'RegistroController@filters')->name('filters')
                ->middleware('permission:registro list');
            Route::get('/module-data', 'RegistroController@moduleData')->name('module-data')
                ->middleware('permission:registro list');
            Route::get('/{registro}', 'RegistroController@show')->name('show')
                ->middleware('permission:registro show');
            Route::post('/', 'RegistroController@store')->name('store')
                ->middleware('permission:registro store');
            Route::put('/{registro}', 'RegistroController@update')->name('update')
                ->middleware('permission:registro update');
            Route::delete('/{registro}', 'RegistroController@destroy')->name('destroy')
                ->middleware('permission:registro destroy');
        });

        Route::prefix('graficas')->name('graficas.')->group(function () {
            Route::get('/', 'GraficaController@index')->name('index')
                ->middleware('permission:grafica list');
            Route::get('/filters', 'GraficaController@filters')->name('filters')
                ->middleware('permission:grafica list');
            Route::get('/module-data', 'GraficaController@moduleData')->name('module-data')
                ->middleware('permission:grafica list');
            Route::get('/{grafica}', 'GraficaController@show')->name('show')
                ->middleware('permission:grafica show');
            Route::post('/', 'GraficaController@store')->name('store')
                ->middleware('permission:grafica store');
            Route::put('/{grafica}', 'GraficaController@update')->name('update')
                ->middleware('permission:grafica update');
            Route::delete('/{grafica}', 'GraficaController@destroy')->name('destroy')
                ->middleware('permission:grafica destroy');
        });
        // add router
    });
});
