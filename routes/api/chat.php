<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::prefix('chat')->name('chats.')->group(function () {
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
        });
    });
