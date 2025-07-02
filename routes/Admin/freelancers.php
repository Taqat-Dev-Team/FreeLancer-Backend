<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FreeLancer\FreeLancerVerificationRequestsController;
use App\Http\Controllers\Admin\FreeLancer\FreeLancerVerifiedController;


Route::prefix('admin/freelancer/')->name('admin.')->group(function () {


    Route::middleware('admin')->group(function () {


        Route::name('freelancers.')->group(function () {


            Route::name('request.')->prefix('verification-request')->group(function () {
                Route::controller(FreeLancerVerificationRequestsController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/data', 'data')->name('data');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::post('/{id}/{action}', 'handleAction')->name('handleAction');
                });
            });

            Route::name('verified.')->prefix('verified')->group(function () {
                Route::controller(FreeLancerVerifiedController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/data', 'data')->name('data');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::delete('/{id}', 'destroy')->name('delete');
                    Route::post('/status/{id}', 'status')->name('status');
                    Route::post('/admin-active/{id}', 'ActiveByAdmin')->name('ActiveByAdmin');
                    Route::post('/send-message', 'sendMessage')->name('sendMessage');
                });
            });


        });

    });

});
