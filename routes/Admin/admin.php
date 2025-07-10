<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;


Route::prefix('admin')->name('admin.')->group(function () {

    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->name('login.submit');
    });

    Route::middleware('admin')->group(function () {


        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::controller(AdminAuthController::class)->group(function () {
            Route::post('logout', 'logout')->name('logout');
            Route::view('profile', 'admin.profile')->name('profile');
            Route::post('profile', 'updateProfile')->name('profile.update');
        });


        Route::prefix('contacts')->name('contacts.')->group(function () {

            Route::controller(ContactController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/data', 'getData')->name('data');
                Route::get('/{id}/show', 'show')->name('show');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::post('/reply{id}', 'reply')->name('reply');

            });
        });

        Route::prefix('settings')->name('settings.')->group(function () {

            Route::controller(SettingsController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'update')->name('update');
            });
        });


        Route::prefix('users')->name('users.')->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}/show', 'show')->name('show');
                Route::get('/data', 'data')->name('data');
                Route::delete('/{id}', 'destroy')->name('delete');
                Route::post('/status/{id}', 'status')->name('status');
                Route::post('/send-message', 'sendMessage')->name('sendMessage');


            });
        });

    });


});


require __DIR__ . '/management.php';
require __DIR__ . '/freelancers.php';
