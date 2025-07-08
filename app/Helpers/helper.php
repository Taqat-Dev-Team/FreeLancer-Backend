<?php

use App\Models\Contact;
use App\Models\IdentityVerification;

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
        ['id' => 0, 'label' => __('messages.beginner')],
        ['id' => 1, 'label' => __('messages.intermediate')],
        ['id' => 2, 'label' => __('messages.advanced')],
        ['id' => 3, 'label' => __('messages.native')],
    ]);
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
        ['id' => 0, 'label' => __('messages.excellent')],
        ['id' => 1, 'label' => __('messages.very_good')],
        ['id' => 2, 'label' => __('messages.good')],
        ['id' => 3, 'label' => __('messages.pass')]

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
