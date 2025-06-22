<?php

use App\Http\Controllers\Front\FreeLancer\ProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(ProfileController::class)->group(function () {

    Route::middleware(['auth:sanctum', 'verified.email','freelancer'])->prefix('freelancer')->group(function () {

        Route::post('/save-data', 'saveData');
        Route::post('/about', 'updateAbout');
        Route::post('/skills', 'updateSkills');
        Route::post('/languages', 'updateLanguages');
        Route::post('/socials', 'updateSocials');
        Route::post('/summary', 'updateSummary');
        Route::get('/summary', 'summary');
        Route::delete('/summary/image/{id}', 'deleteImageSummary');
        Route::get('/profile-complete', 'profileComplete');
    });

});

