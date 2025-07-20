<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">
<head>
    <base href="{{ asset('') }}" />
    <title>Bright Gaza - Check Email</title>
    <meta charset="utf-8" />
    <meta name="robots" content="follow, index" />
    <link href="{{ url()->current() }}" rel="canonical" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Check email for password reset, styled with Tailwind CSS" />
    <meta name="twitter:site" content="@keenthemes" />
    <meta name="twitter:creator" content="@keenthemes" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Bright Gaza - Check Email" />
    <meta name="twitter:description" content="Check email for password reset, styled with Tailwind CSS" />
    <meta name="twitter:image" content="{{ asset('freelancer/media/app/og-image.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="@keenthemes" />
    <meta property="og:title" content="Bright Gaza - Check Email" />
    <meta property="og:description" content="Check email for password reset, styled with Tailwind CSS" />
    <meta property="og:image" content="{{ asset('freelancer/media/app/og-image.png') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('freelancer/media/app/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('freelancer/media/app/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('freelancer/media/app/favicon-16x16.png') }}" />
    <link rel="shortcut icon" href="{{ asset('freelancer/media/app/favicon.ico') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/css/styles.css') }}" rel="stylesheet" />

    <style>
        .branded-bg {
            background-image: url('{{ asset('freelancer/media/images/2600x1600/1.png') }}');
        }
        .dark .branded-bg {
            background-image: url('{{ asset('freelancer/media/images/2600x1600/1-dark.png') }}');
        }
    </style>
</head>
<body class="antialiased flex h-full text-base text-foreground bg-background">

{{-- Theme Mode --}}
<script>
    const defaultThemeMode = "light";
    let themeMode;

    if (document.documentElement) {
        if (localStorage.getItem("kt-theme")) {
            themeMode = localStorage.getItem("kt-theme");
        } else if (document.documentElement.hasAttribute("data-kt-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-kt-theme-mode");
        } else {
            themeMode = defaultThemeMode;
        }

        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.classList.add(themeMode);
    }
</script>

{{-- Page Content --}}
<div class="grid lg:grid-cols-2 grow">
    <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
        <div class="kt-card max-w-[440px] w-full">
            <div class="kt-card-content p-10">
                <div class="flex justify-center py-10">
                    <img class="dark:hidden max-h-[130px]" src="{{ asset('freelancer/media/illustrations/30.svg') }}" alt="image" />
                    <img class="light:hidden max-h-[130px]" src="{{ asset('freelancer/media/illustrations/30-dark.svg') }}" alt="image" />
                </div>
                <h3 class="text-lg font-medium text-mono text-center mb-3">Check your email</h3>
                <div class="text-sm text-center text-secondary-foreground mb-7.5">
                    Please click the link sent to your email
                    <a href="#" class="text-sm text-foreground font-medium hover:text-primary">
                        {{ $email ?? 'bob@reui.io' }}
                    </a><br />
                    to reset your password. Thank you
                </div>
                {{-- OTP Code --}}
                @if($otpCode)
                    <div class="text-center mt-6">
                        <p class="text-sm text-secondary-foreground mb-1">Your OTP code is:</p>
                        <div class="text-lg font-semibold text-primary tracking-widest">
                            {{ $otpCode }}
                        </div>
                    </div>
                @endif
                <div class="flex items-center justify-center gap-1.5">
                        <span class="text-2sm text-secondary-foreground">
                            Didn’t receive an email? (37s)
                        </span>
                    <a class="text-2sm kt-link" href="#">
                        Resend
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div class="lg:rounded-xl lg:border lg:border-border lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center bg-cover bg-no-repeat branded-bg hidden lg:block"></div>
</div>

{{-- Scripts --}}
<script src="{{ asset('freelancer/js/core.bundle.js') }}"></script>
<script src="{{ asset('freelancer/vendors/ktui/ktui.min.js') }}"></script>
<script src="{{ asset('freelancer/vendors/apexcharts/apexcharts.min.js') }}"></script>
</body>
</html>
