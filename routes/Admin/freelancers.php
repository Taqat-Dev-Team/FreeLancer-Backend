<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FreeLancer\FreeLancerVerificationRequestsController;
use App\Http\Controllers\Admin\FreeLancer\FreeLancerVerifiedController;
use App\Http\Controllers\Admin\FreeLancer\OtheFreeLancerController;
use App\Http\Controllers\Admin\FreeLancer\GeneralFreeLancerController;


Route::prefix('admin/freelancer/')->name('admin.')->group(function () {


    Route::middleware('admin')->group(function () {


        Route::name('freelancers.')->group(function () {


            Route::name('request.')->prefix('verification-request')->group(function () {
                Route::controller(FreeLancerVerificationRequestsController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/{id}/show', 'show')->name('show');
                    Route::get('/data', 'data')->name('data');
                    Route::post('/{id}/{action}', 'handleAction')->name('handleAction');


                });
            });

            Route::name('verified.')->prefix('verified')->group(function () {
                Route::controller(FreeLancerVerifiedController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/data', 'data')->name('data');
                    Route::delete('/{id}', 'destroy')->name('delete');


                });
            });

            Route::name('other.')->prefix('other')->group(function () {
                Route::controller(OtheFreeLancerController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/data', 'data')->name('data');
                });
            });


            Route::controller(GeneralFreeLancerController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::delete('/{id}', 'destroy')->name('delete');
                Route::get('/{id}/show', 'show')->name('show');
                Route::post('/status/{id}', 'status')->name('status');
                Route::post('/admin-active/{id}', 'ActiveByAdmin')->name('ActiveByAdmin');
                Route::post('/admin-deactivate/{id}', 'deactivateByAdmin')->name('deactivateByAdmin');
                Route::post('/send-message', 'sendMessage')->name('sendMessage');
                Route::delete('badges/delete/{freelancerId}/{badgeId}', 'deleteBadge')->name('deleteBadge');
                Route::post('/badges/assign', 'assignBadge')->name('badges.assign');


            });

        });

    });

});
