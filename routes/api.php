<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::middleware('throttle:5,1')->group(function () {

        Route::post('/login',             [AuthController::class, 'login']);
        Route::post('/register',          [AuthController::class, 'register']);
        Route::post('/forgot-password',   [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password',    [AuthController::class, 'resetPassword']);
        Route::post('/email/verify',      [EmailVerificationController::class, 'verifyEmail']);
    });



    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/user',                                 UserController::class);
        Route::post('/email/verification-notification',     [EmailVerificationController::class, 'sendEmail']);


        Route::delete('/logout',      [AuthController::class, 'logout']);
    });
});
