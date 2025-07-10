<?php

use Illuminate\Support\Facades\Route;


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->route('home');
});


Route::get('/link', function () {
    Artisan::call('storage:link');
});



Route::view('/', 'Front.welcome')->name('home');
Route::view('/register', 'Front.register')->name('register');
Route::view('/login', 'Front.login')->name('login');


require __DIR__ . '/Admin/admin.php';

