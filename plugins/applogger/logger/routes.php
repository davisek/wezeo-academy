<?php
use AppUser\User\Http\Middleware\CheckAuth;
use AppLogger\Logger\Http\Controllers\LogController;

Route::group(['prefix' => 'api'], function () {
    Route::post('log', [LogController::class, 'store'])->middleware(CheckAuth::class);
    Route::get('logs', [LogController::class, 'index'])->middleware(CheckAuth::class);

    Route::get('logs/arrival', [LogController::class, 'checkArrival']);
    Route::get('logs/{user}', [LogController::class, 'userLogs']);
});

