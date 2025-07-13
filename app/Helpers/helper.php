<?php

use App\Models\Contact;
use App\Models\IdentityVerification;
use App\Models\User;

function otp(): int
{
    $env = env('APP_ENV');

    if ($env === 'production' || $env === 'staging') {
        // في بيئة الإنتاج أو الستيجنق، نستخدم رمز OTP حقيقي
        return rand(100000, 999999);
    }

    // في بيئة التطوير أو غيرها، نستخدم رمز ثابت
    return 111111;
}

function Mobileotp(): int
{
    $env = env('APP_ENV');

    if ($env === 'production' || $env === 'staging') {
        // في بيئة الإنتاج أو الستيجنق، نستخدم رمز OTP حقيقي
        return rand(100000, 999999);
    }

    // في بيئة التطوير أو غيرها، نستخدم رمز ثابت
    return 111111;
}


function languages_levels()
{
    return collect([
        ['id' => 1, 'label' => __('messages.beginner')],
        ['id' => 2, 'label' => __('messages.intermediate')],
        ['id' => 3, 'label' => __('messages.advanced')],
        ['id' => 4, 'label' => __('messages.native')],
    ]);
}

function usersNotTypedCount()
{
    return User::whereDoesntHave('freelancer')
        ->whereDoesntHave('client')->count();
}

function work_type()
{
    return collect([
        ['id' => 'on-site', 'label' => __('messages.on-site')],
        ['id' => 'remote', 'label' => __('messages.remote')],
        ['id' => 'hybrid', 'label' => __('messages.hybrid')],
    ]);
}


function AcademicGrade()
{
    return collect([
        ['id' => 1, 'label' => __('messages.excellent')],
        ['id' => 2, 'label' => __('messages.very_good')],
        ['id' => 3, 'label' => __('messages.good')],
        ['id' => 4, 'label' => __('messages.pass')]

    ]);

}

function ServiceFileFormat()
{
    return collect([
        ['id' => 1, 'label' => 'AI'],
        ['id' => 2, 'label' => 'EPS'],
        ['id' => 3, 'label' => 'PSD'],
        ['id' => 4, 'label' => 'PPT'],
        ['id' => 5, 'label' => 'JPG'],
        ['id' => 6, 'label' => 'PNG'],
        ['id' => 7, 'label' => 'PDF'],
        ['id' => 8, 'label' => 'DOCX'],
        ['id' => 9, 'label' => 'XLSX'],
        ['id' => 10, 'label' => 'ZIP'],

    ]);

}


function unreadContactsCount()
{
    return Contact::where('status', 0)->count();
}

function IdentityRequestsCount()
{
    return IdentityVerification::where('status', '0')->distinct('freelancer_id')->count('freelancer_id');
}

function VerifiedFreeLancersCount()
{
    return IdentityVerification::where('status', '1')->distinct('freelancer_id')->count('freelancer_id');
}

function OthersFreeLancersCount()
{
    return \App\Models\Freelancer::whereDoesntHave('identityVerification')->count();
}


if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        }

        if ($key === null) {
            return $settings; // يرجع كل الإعدادات
        }

        return $settings[$key] ?? $default;
    }
}


if (!function_exists('setting_media')) {
    function setting_media($key)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();

        if ($setting && $setting->hasMedia($key)) {
            return $setting->getFirstMedia($key)->getFullUrl();
        }

        return null;
    }
}
