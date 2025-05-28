<?php

use App\Http\Controllers\Front\Auth\AuthController;
use App\Http\Controllers\Front\Auth\SocialAuthController;

use App\Http\Controllers\Front\Auth\ForgotPasswordController;
use App\Http\Controllers\Front\Auth\ResetPasswordController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Google Auth
Route::controller(SocialAuthController::class)->group(function () {
    Route::get('/auth/google', 'redirectToGoogle');
    Route::get('/auth/google/callback', 'handleGoogleCallback');
});


// Forgot Password / Reset Password Routes
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forget-password', 'sendResetLinkEmail');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/reset-password', 'reset'); // لإعادة تعيين كلمة المرور
});

// Auth Routes for non-authenticated users.
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/verify-otp', 'verifyOtp');
    Route::post('/resend-otp', 'resendOtp');

    Route::middleware(['auth:sanctum', 'verified.email'])->group(function () {
        Route::get('/profile', 'profile');
        Route::post('/lang', 'lang');
        Route::post('/logout', 'logout');
    });
});




