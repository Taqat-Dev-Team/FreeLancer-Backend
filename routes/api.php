<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


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
