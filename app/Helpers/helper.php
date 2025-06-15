<?php
function otp(): int
{
    return 111111;
//    rand(100000, 999999); // إنشاء رمز OTP من 6 أرقام

}


function languages_levels()
{
    return (object)[
        'Beginner',
        'Intermediate',
        'Advanced',
        'Native',
    ];

}


function unreadContactsCount()
{
    return \App\Models\Contact::where('status',0)->count();
}
