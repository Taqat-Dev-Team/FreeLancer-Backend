<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $locale === 'en' ? 'Message from Taqat Admin' : 'رسالة من إدارة طاقات' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');

        body {
            font-family: 'Tajawal', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333333;
        }

        .container {
            max-width: 620px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .header {
            background-color: #1279be;
            padding: 20px 30px;
            text-align: center;
        }

        .header img {
            width: 200px;
            height: auto;
        }

        .content {
            padding: 30px 25px;
            font-size: 16px;
            line-height: 1.8;
            direction: {{ $locale === 'en' ? 'ltr' : 'rtl' }};
            text-align: {{ $locale === 'en' ? 'left' : 'right' }};
        }

        .content p {
            margin-bottom: 15px;
        }

        .reply-box {
            background-color: #f0f4f8;
            border-left: 5px solid #1279be;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
            color: #333;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px 25px;
            text-align: center;
            font-size: 13px;
            color: #999;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{ url('logos/white.png') }}" alt="Taqat Logo">
    </div>

    <div class="content">
        @if($locale === 'en')
            <p>Hello{{ $userName ? ' ' . $userName : '' }},</p>
            <p>This message was sent to you by <strong>Taqat Admin</strong>:</p>
        @else
            <p>مرحبًا{{ $userName ? ' ' . $userName : '' }}،</p>
            <p>تم إرسال هذه الرسالة من قبل <strong>إدارة طاقات</strong>:</p>
        @endif

        <div class="reply-box">
            {!! $replyText !!}
        </div>

        @if($locale === 'en')
            <p>If you need further assistance, don’t hesitate to contact us again.</p>
            <p>Best regards,<br><strong>Taqat Support Team</strong></p>
        @else
            <p>إذا كنت بحاجة إلى أي مساعدة إضافية، لا تتردد في التواصل معنا مجددًا.</p>
            <p>مع خالص التحية،<br><strong>فريق دعم طاقات</strong></p>
        @endif
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ $locale === 'en' ? 'Taqat. All rights reserved.' : 'طاقات. جميع الحقوق محفوظة.' }}</p>
    </div>
</div>

</body>
</html>
