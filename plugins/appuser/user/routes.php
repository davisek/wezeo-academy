<?php

use AppUser\User\Http\Controllers\UsersController;
use AppUser\User\Http\Controllers\AuthController;
use AppUser\User\Http\Middleware\CheckAuth;

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['middleware' => CheckAuth::class], function () {
        Route::get('users', [UsersController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('user/store', [UsersController::class, 'store']);
        Route::post('users/{id}/change-password', [UsersController::class, 'changePassword']);
    });

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

