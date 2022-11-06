<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->controller(ChatController::class)->group(function () {
            Route::prefix('chat')->name('chats.')->group(function () {
                Route::post('msg', 'msg')->name('msg')
                    ->middleware('permission:chat read');
                Route::get('contacts', 'contacts')->name('contacts')
                    ->middleware('permission:chat read');
                Route::get('chat-contacts', 'chatContacts')->name('chat-contacts')
                    ->middleware('permission:chat read');
                Route::get('chats', 'chats')->name('chats')
                    ->middleware('permission:chat read');
                Route::post('mark-all-seen', 'markAllSeen')->name('mark-all-seen')
                    ->middleware('permission:chat read');
                Route::post('set-pinned', 'setPinned')->name('set-pinned')
                    ->middleware('permission:chat read');
            });
        });
    });
