<?php

use App\Http\Controllers\Front\FreeLancer\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ProfileController::class)->group(function () {
    Route::middleware(['auth:sanctum', 'verified.email','freelancer'])->prefix('freelancer')->group(function () {
        Route::post('/save-data', 'saveData');
    });

});

