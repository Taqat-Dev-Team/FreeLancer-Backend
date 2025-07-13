<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8"/>
    @php
        $settings = setting();
       $white = setting_media('white_logo');

       $favicon = setting_media('favicon');
       $dark = setting_media('logo');
           $keywords_en_raw = $settings['meta_keywords_en'] ?? '[]';
           $keywords_en_array = is_string($keywords_en_raw) ? json_decode($keywords_en_raw, true) : [];
           $keywords_en = collect($keywords_en_array)->pluck('value')->implode(', ');
    @endphp
    <base href="{{url('/')}}"/>
    <title>{{$settings['name_en']}} - Login</title>


    <!-- SEO Meta -->
    <meta name="description" content="{{ $settings['meta_description_en'] ?? 'Default site description here' }}"/>
    <meta name="keywords" content="{{ $keywords_en }}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Open Graph -->
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title"
          content="{{ $settings['social_title_en'] ?? ($settings['meta_title_en'] ?? 'Default Site Title') }}"/>
    <meta property="og:description"
          content="{{ $settings['social_description_en'] ?? $settings['meta_description_en'] ?? 'Default social description' }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:site_name"
          content="{{ $settings['social_title_en'] ?? ($settings['meta_title_en'] ?? config('app.name')) }}"/>

    <!-- Canonical -->
    <link rel="canonical" href="{{ url()->current() }}"/>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $favicon }}"/>
    <link rel="icon" type="image/png" href="{{ $favicon }}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link href="{{ url('admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
<div class="d-flex flex-column flex-root" id="kt_app_root">

    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-image: url({{ url('admin//media/auth/bg10.jpeg') }});
        }

        [data-bs-theme="dark"]
        body {
            background-image: url({{url('admin/media/auth/1920x1080.png')}});
        }


    </style>


    <div
        class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center align-items-center min-h-screen p-20 p-md-20">
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-100 p-20 p-md-20"
             style="max-width: 600px;"> {{-- Ziadat al-padding al-dakhili huna --}}

            <a href="{{ url('/') }}"
               class="d-flex justify-content-center text-center mb-8"> {{-- Ziadat al-margin asfal al-logo --}}
                <img alt="Logo" src="{{ $dark }}"
                     class="h-70px h-md-90px theme-light-show"/> {{-- Ziadat ارتفاعat al-suwar --}}
                <img alt="Logo" src="{{$white }}"
                     class="h-60px h-md-80px theme-dark-show"/> {{-- Ziadat ارتفاعat al-suwar --}}
            </a>
            <div class="d-flex flex-center flex-column align-items-stretch w-100" style="max-width: 400px;">
                <div
                    class="d-flex flex-center flex-column flex-column-fluid pb-20 pb-lg-25"> {{-- Ziadat al-padding asfal al-form --}}
                    <form class="form w-100" novalidate="novalidate" id="login_form" method="post"
                          action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="text-center mb-10"> {{-- Ziadat al-margin --}}
                            <h1 class="text-gray-700 fw-bolder mb-3">👋 Welcome Back</h1> {{-- Ziadat al-margin --}}
                            <p class="text-muted">Sign in to your account</p>
                        </div>

                        <div class="fv-row mb-7"> {{-- Ziadat al-margin --}}
                            <input type="text" placeholder="Email" name="email" autocomplete="off"
                                   class="form-control bg-transparent"/>
                            <div class="fv-plugins-message-container invalid-feedback mt-2"
                                 data-field-error="email"></div>
                        </div>

                        <div class="fv-row mb-5"> {{-- Ziadat al-margin --}}
                            <input type="password" placeholder="Password" name="password" autocomplete="off"
                                   class="form-control bg-transparent"/>
                            <div class="fv-plugins-message-container invalid-feedback mt-2"
                                 data-field-error="password"></div>
                        </div>

                        <div class="fv-row mt-6 mb-7"> {{-- Ziadat al-spacing --}}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="remember"
                                       id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-10"> {{-- Ziadat al-margin --}}
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">Sign In</span>
                                <span class="indicator-progress">Please wait...
                              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>var hostUrl = "{{ url('assets/') }}/";</script>
    <script src="{{ url('admin/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ url('admin/js/scripts.bundle.js') }}"></script>
    <script src="{{ url('admin/js/custom/login.js') }}"></script>


</body>

</html>
