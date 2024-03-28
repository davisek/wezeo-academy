<?php


use AppAuth\Auth\Http\Controllers\AuthController;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['middleware' => ['web']], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

