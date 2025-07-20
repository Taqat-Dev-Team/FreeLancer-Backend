<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\Auth\AuthController;
use App\Http\Controllers\Back\Auth\SocialAuthController;
use App\Http\Controllers\Back\GeneralController;
use App\Http\Controllers\Back\Auth\ForgotPasswordController;
use App\Http\Controllers\Back\Auth\ResetPasswordController;

Route::middleware('web')->prefix('freelancer')->group(function () {

    // صفحات العرض (GET)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('freelancer.login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('freelancer.register');
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('freelancer.verifyOtp');
    Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('freelancer.forgot');
    Route::get('/profile', [AuthController::class, 'showProfilePage'])->middleware('auth')->name('freelancer.profile');
    Route::get('/check-email', [AuthController::class, 'showCheckEmailPage'])->name('freelancer.check_email');

    // Google Auth (GET)
//    Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('freelancer.login-google');
//    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('freelancer.login-google');
    Route::get('auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('freelancer.auth.social');
    Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

    // Forgot Password (POST)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('freelancer.forgot-password');
    Route::post('/send-reset-email', [ForgotPasswordController::class, 'sendResetEmail'])->name('freelancer.send-reset-email');
    // Reset Password (POST)
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('freelancer.reset-password');

    Route::post('/reset-password', [ResetPasswordController::class, 'resetPasswordSubmit'])->name('freelancer.reset-password-submit');

    // Auth (POST)
    Route::post('/register', [AuthController::class, 'register'])->name('freelancer.register.submit');
    Route::post('/login', [AuthController::class, 'login'])->name('freelancer.login.submit');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('freelancer.verifyOtp.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('freelancer.resendOtp.submit');

    // General Data (GET)
    Route::get('/policies', [GeneralController::class, 'policies']);
    Route::get('/skills', [GeneralController::class, 'skills']);
    Route::get('/skills/{id}', [GeneralController::class, 'categorySkills']);
    Route::get('/categories', [GeneralController::class, 'categories']);
    Route::get('/countries', [GeneralController::class, 'countries']);
    Route::get('/subcategories', [GeneralController::class, 'subcategories']);
    Route::get('/subcategories/{id}', [GeneralController::class, 'CategorySubcategories']);
    Route::get('/education-levels', [GeneralController::class, 'education_levels']);
    Route::get('/social', [GeneralController::class, 'social']);
    Route::get('/languages', [GeneralController::class, 'languages']);
    Route::get('/languages_levels', [GeneralController::class, 'languages_levels']);
    Route::get('/work_type', [GeneralController::class, 'work_type']);
    Route::get('/grade', [GeneralController::class, 'grade']);

});
