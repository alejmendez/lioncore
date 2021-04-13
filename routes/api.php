<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoleController;

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
                Route::get('/', [PersonController::class, 'index'])->name('index')
                    ->middleware('permission:person list');
                Route::get('/{person}', [PersonController::class, 'show'])->name('show')
                    ->middleware('permission:person show');
                Route::post('/', [PersonController::class, 'store'])->name('store')
                    ->middleware('permission:person store');
                Route::put('/{person}', [PersonController::class, 'update'])->name('update')
                    ->middleware('permission:person update');
                Route::delete('/{person}', [PersonController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:person destroy');
            });

            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index')
                    ->middleware('permission:user list');
                Route::get('/filters', [UserController::class, 'filters'])->name('filters')
                    ->middleware('permission:user list');
                Route::get('/module-data', [UserController::class, 'moduleData'])->name('module-data')
                    ->middleware('permission:user list');
                Route::get('/{user}', [UserController::class, 'show'])->name('show')
                    ->middleware('permission:user show');
                Route::post('/', [UserController::class, 'store'])->name('store')
                    ->middleware('permission:user store');
                Route::put('/{user}', [UserController::class, 'update'])->name('update')
                    ->middleware('permission:user update');
                Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:user destroy');
            });

            Route::prefix('properties')->name('properties.')->group(function () {
                Route::get('/', [PropertyController::class, 'index'])->name('index')
                    ->middleware('permission:property list');
                Route::get('/filters', [PropertyController::class, 'filters'])->name('filters')
                    ->middleware('permission:property list');
                Route::get('/module-data', [PropertyController::class, 'moduleData'])->name('module-data')
                    ->middleware('permission:property list');
                Route::get('/{property}', [PropertyController::class, 'show'])->name('show')
                    ->middleware('permission:property show');
                Route::post('/', [PropertyController::class, 'store'])->name('store')
                    ->middleware('permission:property store');
                Route::put('/{property}', [PropertyController::class, 'update'])->name('update')
                    ->middleware('permission:property update');
                Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:property destroy');
            });

            Route::prefix('chat')->name('chat.')->group(function () {
                Route::post('msg', [ChatController::class, 'msg'])->name('msg')
                    ->middleware('permission:chat view');
                Route::get('contacts', [ChatController::class, 'contacts'])->name('contacts')
                    ->middleware('permission:chat view');
                Route::get('chat-contacts', [ChatController::class, 'chatContacts'])->name('chat-contacts')
                    ->middleware('permission:chat view');
                Route::get('chats', [ChatController::class, 'chats'])->name('chats')
                    ->middleware('permission:chat view');
                Route::post('mark-all-seen', [ChatController::class, 'markAllSeen'])->name('mark-all-seen')
                    ->middleware('permission:chat view');
                Route::post('set-pinned', [ChatController::class, 'setPinned'])->name('set-pinned')
                    ->middleware('permission:chat view');
            });

            Route::prefix('roles')->name('roles.')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('index')
                    ->middleware('permission:role list');
                Route::get('/filters', [RoleController::class, 'filters'])->name('filters')
                    ->middleware('permission:role list');
                Route::get('/module-data', [RoleController::class, 'moduleData'])->name('module-data')
                    ->middleware('permission:role list');
                Route::get('/{role}', [RoleController::class, 'show'])->name('show')
                    ->middleware('permission:role show');
                Route::post('/', [RoleController::class, 'store'])->name('store')
                    ->middleware('permission:role store');
                Route::put('/{role}', [RoleController::class, 'update'])->name('update')
                    ->middleware('permission:role update');
                Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')
                    ->middleware('permission:role destroy');
            });

            // add router
        });
    });
