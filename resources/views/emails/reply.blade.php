<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ ($locale ?? 'ar') == 'en' ? 'Reply from Taqat Support Team' : 'رد من فريق دعم طاقات' }}</title>
    <style>
        /* استيراد خط تجوال */
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');

        body {
            font-family: 'Tajawal', 'Helvetica Neue', Helvetica, Arial, sans-serif; /* تطبيق خط تجوال */
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
            background-color: #1279be; /* Primary Color: #1279be */
            padding: 30px 25px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            font-family: 'Tajawal', sans-serif; /* تطبيق خط تجوال على العنوان */
            margin: 0;
            font-size: 28px;
            font-weight: 700; /* تجوال Bold */
        }

        .header .logo {
            width: 230px;
            height: auto;
            /*margin-bottom: 15px;*/
        }

        .content {
            padding: 30px 25px;
            line-height: 1.6;
            color: #555555;
            /* Text alignment and direction will be handled by Blade conditional classes */
        }

        .content p {
            margin-bottom: 15px;
            font-size: 16px;
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
            width: 180px;
            height: auto;
            /*margin-top: 15px;*/
            opacity: 0.7;
        }


    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ url('logos/white.png') }}" alt="Taqat Logo">
    </div>
    <div class="content">
        @if(($locale ?? 'ar') == 'en')
            <p>Hello{{ $userName ? ' ' . $userName : '' }},</p>
            <p>Thank you for contacting Taqat. Our team has reviewed your inquiry and here is our response:</p>
        @else
            <p>مرحبًا{{ $userName ? ' ' . $userName : '' }},</p>
            <p>شكرًا لتواصلك مع طاقات. لقد قمنا بمراجعة رسالتك، وردنا هو:</p>
        @endif

        <div class="reply-box">
            {!!  $replyText !!}
        </div>

        @if(($locale ?? 'ar') == 'en')
            <p>We are always happy to support you. If you have further questions, feel free to contact us again.</p>
            <p>Best regards,<br>Taqat Support Team</p>
        @else
            <p>نحن دائمًا سعداء بدعمك. إذا كانت لديك أي استفسارات إضافية، لا تتردد في التواصل معنا.</p>
            <p>مع أطيب التحيات،<br>فريق دعم طاقات</p>
        @endif
    </div>
    <div class="footer">
        <p>
            &copy; {{ date('Y') }} {{ ($locale ?? 'ar') == 'en' ? 'Taqat. All rights reserved.' : 'طاقات. جميع الحقوق محفوظة.' }}</p>
    </div>
</div>
</body>
</html>
