<html class="h-full light" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en"
      data-kt-theme-swtich-initialized="true" data-kt-theme-switch-mode="light">
<head>
    <base href="../../../../">
    <title>
        Metronic - Tailwind CSS Sign In
    </title>
    <meta charset="utf-8">
    <meta content="follow, index" name="robots">
    <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/authentication/branded/sign-in" rel="canonical">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Sign in page, using Tailwind CSS" name="description">
    <meta content="@keenthemes" name="twitter:site">
    <meta content="@keenthemes" name="twitter:creator">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="Metronic - Tailwind CSS Sign In" name="twitter:title">
    <meta content="Sign in page, using Tailwind CSS" name="twitter:description">
    <meta content="assets/media/app/og-image.png" name="twitter:image">
    <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/authentication/branded/sign-in"
          property="og:url">
    <meta content="en_US" property="og:locale">
    <meta content="website" property="og:type">
    <meta content="@keenthemes" property="og:site_name">
    <meta content="Metronic - Tailwind CSS Sign In" property="og:title">
    <meta content="Sign in page, using Tailwind CSS" property="og:description">
    <meta content="assets/media/app/og-image.png" property="og:image">
    <link href="{{asset('front/assets/media/app/apple-touch-icon.png')}}" rel="apple-touch-icon" sizes="180x180">
    <link href="{{asset('front/assets/media/app/favicon-32x32.png')}}" rel="icon" sizes="32x32" type="image/png">
    <link href="{{asset('front/assets/media/app/favicon-16x16.png')}}" rel="icon" sizes="16x16" type="image/png">
    <link href="{{asset('front/assets/media/app/favicon.ico')}}" rel="shortcut icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="{{asset('front/assets/vendors/apexcharts/apexcharts.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendors/keenicons/styles.bundle.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/css/styles.css')}}" rel="stylesheet">
</head>
<body class="antialiased flex h-full text-base text-foreground bg-background" data-new-gr-c-s-check-loaded="8.931.0"
      data-gr-ext-installed="">
<!-- Theme Mode -->
<script>
    const defaultThemeMode = 'light'; // light|dark|system
    let themeMode;

    if (document.documentElement) {
        if (localStorage.getItem('kt-theme')) {
            themeMode = localStorage.getItem('kt-theme');
        } else if (
            document.documentElement.hasAttribute('data-kt-theme-mode')
        ) {
            themeMode =
                document.documentElement.getAttribute('data-kt-theme-mode');
        } else {
            themeMode = defaultThemeMode;
        }

        if (themeMode === 'system') {
            themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches
                ? 'dark'
                : 'light';
        }

        document.documentElement.classList.add(themeMode);
    }
</script>
<!-- End of Theme Mode -->
<!-- Page -->
<style>
    .branded-bg {
        background-image: url('{{asset('front/assets/media/images/2600x1600/1.png')}}');
    }

    .dark .branded-bg {
        background-image: url('{{asset('front/assets/media/images/2600x1600/1-dark.png')}}');
    }
</style>
<div class="grid lg:grid-cols-2 grow">
    <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
        <div class="kt-card max-w-[370px] w-full">
            <form action="#" class="kt-card-content flex flex-col gap-5 p-10" id="sign_in_form" method="get">
                <div class="text-center mb-2.5">
                    <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                        @lang('Sign in')
                    </h3>
                    <div class="flex items-center justify-center font-medium">
        <span class="text-sm text-secondary-foreground me-1.5">
        @lang('Need an account?')
        </span>
                        <a class="text-sm link" href="{{route('register')}}">
                            @lang('Sign up')
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2.5">
                    <a class="kt-btn kt-btn-outline justify-center" href="#">
                        <img alt="" class="size-3.5 shrink-0"
                             src="{{asset('front/assets/media/brand-logos/google.svg')}}">
                        Use Google
                    </a>

                </div>
                <div class="flex items-center gap-2">
       <span class="border-t border-border w-full">
       </span>
                    <span class="text-xs text-muted-foreground font-medium uppercase">
        @lang('or')
       </span>
                    <span class="border-t border-border w-full">
       </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        @lang('Email')
                    </label>
                    <input class="kt-input" placeholder="email@email.com" type="text" value="">
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1">
                        <label class="kt-form-label font-normal text-mono">
                            @lang('Password')
                        </label>
                        <a class="text-sm kt-link shrink-0"
                           href="html/demo1/authentication/branded/reset-password/enter-email.html">
                            @lang('Forgot Password?')
                        </a>
                    </div>
                    <div class="kt-input active" data-kt-toggle-password="true"
                         data-kt-toggle-password-initialized="true">
                        <input name="user_password" placeholder="Enter Password" type="password" value="">
                        <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                                data-kt-toggle-password-trigger="true" type="button">
         <span class="kt-toggle-password-active:hidden">
          <i class="ki-filled ki-eye text-muted-foreground">
          </i>
         </span>
                            <span class="hidden kt-toggle-password-active:block">
          <i class="ki-filled ki-eye-slash text-muted-foreground">
          </i>
         </span>
                        </button>
                    </div>
                </div>
                <label class="kt-label">
                    <input class="kt-checkbox kt-checkbox-sm" name="check" type="checkbox" value="1">
                    <span class="kt-checkbox-label">
        @lang('Remember me')
       </span>
                </label>
                <button class="kt-btn kt-btn-primary flex justify-center grow">
                    @lang('Sign In')
                </button>
            </form>
        </div>
    </div>
    <div
        class="lg:rounded-xl lg:border lg:border-border lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center xl:bg-cover bg-no-repeat branded-bg">
        <div class="flex flex-col p-8 lg:p-16 gap-4">
            <a href="html/demo1.html">
                <img class="h-[28px] max-w-none" src="assets/media/app/mini-logo.svg">
            </a>
            <div class="flex flex-col gap-3">
                <h3 class="text-2xl font-semibold text-mono">
                    Secure Access Portal
                </h3>
                <div class="text-base font-medium text-secondary-foreground">
                    A robust authentication gateway ensuring
                    <br>
                    secure
                    <span class="text-mono font-semibold">
        efficient user access
       </span>
                    to the Metronic
                    <br>
                    Dashboard interface.
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Page -->
<!-- Scripts -->
<script src="{{asset('front/assets/js/core.bundle.js')}}">
</script>
<script src="{{asset('front/assets/vendors/ktui/ktui.min.js')}}">
</script>

<!-- End of Scripts -->


</body>
</html>
