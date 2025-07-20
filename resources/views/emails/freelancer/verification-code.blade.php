<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verification Code</title>
</head>
<body>
<h2>Hello {{ $user->email }},</h2>
<p>Your verification code is:</p>
<h1>{{ $user->verification_code }}</h1>
<p>Use this code to verify your account.</p>
</body>
</html>
