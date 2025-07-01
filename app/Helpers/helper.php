<?php
function otp(): int
{
    return rand(100000, 999999); // إنشاء رمز OTP من 6 أرقام

}

function Mobileotp(): int
{
    return rand(100000, 999999); // إنشاء رمز OTP من 6 أرقام

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
    return \App\Models\Contact::where('status', 0)->count();
}

function IdentityRequestsCount()
{
    return \App\Models\IdentityVerification::where('status', '0')->count();
}

function VerifiedFreeLancersCount()
{
    return \App\Models\IdentityVerification::where('status', '1')->count();
}
