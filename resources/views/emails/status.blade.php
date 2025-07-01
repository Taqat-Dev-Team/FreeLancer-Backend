<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(($locale ?? 'ar') == 'en')
            {{ $status == 'active' ? 'Account Activated' : 'Account Deactivated' }}
        @else
            {{ $status == 'active' ? 'تم تفعيل حسابك' : 'تم تعطيل حسابك' }}
        @endif
    </title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');

        body {
            font-family: 'Tajawal', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333333;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #1279be;
            padding: 30px 25px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .header .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
        }

        .content {
            padding: 30px 25px;
            line-height: 1.6;
            color: #555555;
        }

        .content p {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .reason-box {
            background-color: #ffe6e6;
            color: #cc0000;
            font-size: 16px;
            font-weight: bold;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 6px;
        }

        .footer {
            background-color: #f4f7f6;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            color: #777777;
            border-top: 1px solid #eeeeee;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer .logo-footer {
            max-width: 100px;
            height: auto;
            margin-top: 15px;
            opacity: 0.7;
        }

        .rtl {
            text-align: right;
            direction: rtl;
        }

        .ltr {
            text-align: left;
            direction: ltr;
        }
    </style>
</head>
<body>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" class="container">
                <tr>
                    <td class="header">
                        <img src="{{ url('logos/white.png') }}" alt="Taqat Logo" class="logo">
                    </td>
                </tr>
                <tr>
                    <td class="content @if(($locale ?? 'ar') == 'en') ltr @else rtl @endif">
                        @if(($locale ?? 'ar') == 'en')
                            @if($status == 'active')
                                <p>Hello {{ $user->name }},</p>
                                <p>Your account on <strong>Taqat Platform</strong> has been <strong>activated</strong> successfully.</p>
                                <p>You can now log in and use all available services.</p>
                            @else
                                <p>Hello {{ $user->name }},</p>
                                <p>Your account on <strong>Taqat Platform</strong> has been <strong>deactivated</strong>.</p>
                                @if(!empty($reason))
                                    <div class="reason-box">
                                        Reason: {{ $reason }}
                                    </div>
                                @endif
                                <p>If you have any questions, feel free to contact support.</p>
                            @endif
                        @else
                            @if($status == 'active')
                                <p>مرحبًا {{ $user->name }},</p>
                                <p>تم <strong>تفعيل</strong> حسابك في <strong>منصة طاقات</strong> بنجاح.</p>
                                <p>يمكنك الآن تسجيل الدخول واستخدام جميع الخدمات المتاحة.</p>
                            @else
                                <p>مرحبًا {{ $user->name }},</p>
                                <p>تم <strong>تعطيل</strong> حسابك في <strong>منصة طاقات</strong>.</p>
                                @if(!empty($reason))
                                    <div class="reason-box">
                                        السبب: {{ $reason }}
                                    </div>
                                @endif
                                <p>إذا كانت لديك أي استفسارات، يرجى التواصل مع الدعم الفني.</p>
                            @endif
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="footer @if(($locale ?? 'ar') == 'en') ltr @else rtl @endif">
                        <p>
                            @if(($locale ?? 'ar') == 'en')
                                &copy; {{ date('Y') }} Taqat. All rights reserved.
                            @else
                                &copy; {{ date('Y') }} طاقات. جميع الحقوق محفوظة.
                            @endif
                        </p>
                        <img src="{{ asset('logos/logo.png') }}" alt="Taqat Logo" class="logo-footer">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
