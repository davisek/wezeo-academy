<?php
use AppSlack\Slack\Http\Controllers\ChatController;
use AppSlack\Slack\Http\Controllers\EmojiController;
use AppSlack\Slack\Http\Controllers\MessageController;
use AppSlack\Slack\Http\Controllers\ReactionController;
use AppUser\User\Http\Middleware\CheckAuth;

Route::group(['prefix' => 'api/v2'], function () {
    Route::group(['middleware' => CheckAuth::class], function () {

        Route::get('chats', [ChatController::class, 'index']);
        Route::post('chat/new', [ChatController::class, 'store']);

        Route::get('messages/{chat}', [MessageController::class, 'index']);
        Route::post('message/new', [MessageController::class, 'store']);


        Route::post('reaction/new', [ReactionController::class, 'store']);
    });

    Route::get('emojis', [EmojiController::class, 'index']);
});


