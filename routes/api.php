<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoleController;

Route::pattern('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');


Route::prefix('v1')
    //->domain('{tenant}.lioncore.oo')
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

        Route::middleware('auth:api')->group(function () {
            Route::prefix('person')->name('person.')->group(function () {
                Route::middleware('permission:person read')->group(function () {
                    Route::get('/', [PersonController::class, 'index'])->name('index');
                    Route::get('/filters', [PersonController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [PersonController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [PersonController::class, 'show'])->name('show');
                });
                Route::post('/', [PersonController::class, 'store'])->name('store')
                    ->middleware('permission:person create');
                Route::put('/{id}', [PersonController::class, 'update'])->name('update')
                    ->middleware('permission:person update');
                Route::delete('/{id}', [PersonController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:person delete');
            });

            Route::prefix('users')->name('users.')->group(function () {
                Route::middleware('permission:user read')->group(function () {
                    Route::get('/', [UserController::class, 'index'])->name('index');
                    Route::get('/filters', [UserController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [UserController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [UserController::class, 'show'])->name('show');
                });
                Route::post('/', [UserController::class, 'store'])->name('store')
                    ->middleware('permission:user create');
                Route::put('/{id}', [UserController::class, 'update'])->name('update')
                    ->middleware('permission:user update');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:user delete');
            });

            Route::prefix('properties')->name('properties.')->group(function () {
                Route::middleware('permission:property read')->group(function () {
                    Route::get('/', [PropertyController::class, 'index'])->name('index');
                    Route::get('/filters', [PropertyController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [PropertyController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [PropertyController::class, 'show'])->name('show');
                });
                Route::post('/', [PropertyController::class, 'store'])->name('store')
                    ->middleware('permission:property create');
                Route::put('/{id}', [PropertyController::class, 'update'])->name('update')
                    ->middleware('permission:property update');
                Route::delete('/{id}', [PropertyController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:property delete');
            });

            Route::prefix('chat')->name('chat.')->group(function () {
                Route::post('msg', [ChatController::class, 'msg'])->name('msg')
                    ->middleware('permission:chat read');
                Route::get('contacts', [ChatController::class, 'contacts'])->name('contacts')
                    ->middleware('permission:chat read');
                Route::get('chat-contacts', [ChatController::class, 'chatContacts'])->name('chat-contacts')
                    ->middleware('permission:chat read');
                Route::get('chats', [ChatController::class, 'chats'])->name('chats')
                    ->middleware('permission:chat read');
                Route::post('mark-all-seen', [ChatController::class, 'markAllSeen'])->name('mark-all-seen')
                    ->middleware('permission:chat read');
                Route::post('set-pinned', [ChatController::class, 'setPinned'])->name('set-pinned')
                    ->middleware('permission:chat read');
            });

            Route::prefix('roles')->name('roles.')->group(function () {
                Route::middleware('permission:role read')->group(function () {
                    Route::get('/', [RoleController::class, 'index'])->name('index');
                    Route::get('/filters', [RoleController::class, 'filters'])->name('filters');
                    Route::get('/module-data', [RoleController::class, 'moduleData'])->name('module-data');
                    Route::get('/{id}', [RoleController::class, 'show'])->name('show');
                });
                Route::post('/', [RoleController::class, 'store'])->name('store')
                    ->middleware('permission:role create');
                Route::put('/{id}', [RoleController::class, 'update'])->name('update')
                    ->middleware('permission:role update');
                Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:role delete');
            });

            // add router
        });
    });
