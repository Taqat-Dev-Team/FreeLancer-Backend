<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;


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


        Route::name('management.')->group(function () {
            Route::resource('categories', CategoryController::class)->except('show');
            Route::get('/categories/data', [CategoryController::class, 'getData'])->name('categories.data');
            Route::get('/categories/show/{id}', [CategoryController::class, 'show'])->name('categories.show');

            Route::resource('subcategories', SubCategoryController::class);
        });
    });


});
