<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('auth/google', [AppAuth\Google\Http\Controllers\AuthController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [AppAuth\Google\Http\Controllers\AuthController::class, 'handleGoogleCallback']);
});
