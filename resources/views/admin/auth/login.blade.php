<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{url('/')}}"/>
    <title>Login</title>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('logos/favicon.png') }}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link href="{{ url('admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
<div class="d-flex flex-column flex-root" id="kt_app_root">

    <!-- Google Fonts: Tajawal -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">


    <style>
        body {
            background-image: url({{ url('admin//media/auth/bg10.jpeg') }});
        }

        [data-bs-theme="dark"]
        body {
            background-image: url({{url('admin/media/auth/bg9-dark.jpeg')}});
        }


        body {
            /*font-family: 'Tajawal', sans-serif;*/
            /*background-color: #f8f9fa;*/
        }


    </style>


    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <a href="{{ url('/') }}" class=" justify-content-center text-center">
                    <img alt="Logo" src="{{url('/logos/logo.png')}}" class="h-125px theme-light-show"/>
                    <img alt="Logo" src="{{url('/logos/white.png')}}" class="h-80px theme-dark-show"/>


                </a>

                <div class="d-flex flex-center flex-column align-items-stretch h-50 w-md-400px ">
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
                        <form class="form w-100" novalidate="novalidate" id="login_form" method="post"
                              action="{{ route('admin.login.submit') }}">
                            @csrf
                            <div class="text-center mb-11">
                                <h1 class="text-gray-700 fw-bolder mb-3">👋 Welcome Back</h1>
                                <p class="text-muted">Sign in to your account</p>

                            </div>
                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Email" name="email" autocomplete="off"
                                       class="form-control bg-transparent"/>
                                {{-- Container for email field error message --}}
                                <div class="fv-plugins-message-container invalid-feedback mt-2"
                                     data-field-error="email"></div>
                            </div>
                            <div class="fv-row mb-3">
                                <input type="password" placeholder="Password" name="password" autocomplete="off"
                                       class="form-control bg-transparent"/>
                                {{-- Container for password field error message --}}
                                <div class="fv-plugins-message-container invalid-feedback mt-2"
                                     data-field-error="password"></div>
                            </div>
                            <div class="d-grid mb-10">
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
    </div>
</div>
<script>var hostUrl = "{{ url('assets/') }}/";</script>
<script src="{{ url('admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ url('admin/js/scripts.bundle.js') }}"></script>
<script src="{{ url('admin/js/custom/login.js') }}"></script>



</body>

</html>
