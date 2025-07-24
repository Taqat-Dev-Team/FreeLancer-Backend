<?php

use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Route;


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return redirect()->route('home');
});

Route::get('/test', function () {
    $data = [
        'title' => 'طلب تأكيد هوية جديد',
        'message' => 'تم تقديم طلب جديد لتأكيد الهوية من قبل أحد المستقلين.',
        'url' => '/admin/freelancer/verification-request',
        'freelancer_id' => 1];

    $admins = \App\Models\Admin::all();
    Notification::send($admins, new \App\Notifications\Admin\NewIDRequestNotification($data));
    return 'Notifications sent successfully!';
});







Route::get('/link', function () {
    Artisan::call('storage:link');
});


Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->name('home');


require __DIR__ . '/Admin/admin.php';


