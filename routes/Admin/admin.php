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
            Route::controller(CategoryController::class)->group(function () {
                Route::get('categories', 'index')->name('categories.index');
                Route::get('categories/data', 'getData')->name('categories.data');
                Route::post('categories', 'store')->name('categories.store');
                Route::get('categories/{id}/show', 'show')->name('categories.show');
                Route::put('categories/{id}', 'update')->name('categories.update');
                Route::delete('categories/{id}', 'destroy')->name('categories.destroy');
            });

            Route::controller(SubCategoryController::class)->group(function () {
                Route::get('subcategories', 'index')->name('subcategories.index');
                Route::get('subcategories/data', 'getData')->name('subcategories.data');
                Route::post('subcategories', 'store')->name('subcategories.store');
                Route::get('subcategories/{id}/show', 'show')->name('subcategories.show');
                Route::put('subcategories/{id}', 'update')->name('subcategories.update');
                Route::delete('subcategories/{id}', 'destroy')->name('subcategories.destroy');
            });


        });
    });


});
