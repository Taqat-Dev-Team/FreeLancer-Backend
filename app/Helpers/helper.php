<?php
function otp(): int
{
    return 111111;
//    rand(100000, 999999); // إنشاء رمز OTP من 6 أرقام

}


function languages_levels()
{
    return collect([
        ['key' => 0, 'label' => __('messages.beginner')],
        ['key' => 1, 'label' => __('messages.intermediate')],
        ['key' => 2, 'label' => __('messages.advanced')],
        ['key' => 3, 'label' => __('messages.native')],
    ]);
}

function work_type()
{
    return collect([
        ['label' => __('messages.on-site')],
        ['label' => __('messages.remote')],
        ['label' => __('messages.hybrid')],
    ]);
}

function AcademicGrade()
{
    return collect([
        ['label' => __('messages.excellent')],
        ['label' => __('messages.very_good')],
        ['label' => __('messages.good')],
        ['label' => __('messages.pass')],

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
