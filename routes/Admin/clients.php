<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Client\ClientController;


Route::prefix('admin/clients')->name('admin.clients.')->middleware('admin')->group(function () {


    Route::controller(ClientController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}/show', 'show')->name('show');
        Route::get('/data', 'data')->name('data');
        Route::delete('/{id}', 'destroy')->name('delete');
        Route::post('/status/{id}', 'status')->name('status');
        Route::post('/send-message', 'sendMessage')->name('sendMessage');


    });

});
