<?php
use AppUser\User\Http\Middleware\CheckAuth;

Route::prefix('api')->group(function () {
    Route::post('/log', 'AppLogger\Logger\Controllers\LogController@store')->middleware(CheckAuth::class);
    Route::get('/logs', 'AppLogger\Logger\Controllers\LogController@index')->middleware(CheckAuth::class);

    Route::get('/logs/arrival', 'AppLogger\Logger\Controllers\LogController@checkArrival');
    Route::get('/logs/{user}', 'AppLogger\Logger\Controllers\LogController@userLogs');
});

