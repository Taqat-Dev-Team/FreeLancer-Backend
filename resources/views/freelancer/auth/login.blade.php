<!DOCTYPE html>
<html
    class="h-full"
    data-kt-theme="true"
    data-kt-theme-mode="light"
    dir="ltr"
    lang="{{ app()->getLocale() }}"
>
<head>
    <base href="{{ url('/') }}/" />
    <title>Bright Gaza - {{ __('freelancer.sign_in') }}</title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <link href="{{ asset('freelancer/media/app/favicon.ico') }}" rel="shortcut icon" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <link href="{{ asset('freelancer/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/css/styles.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .branded-bg {
            background-image: url("{{ asset('freelancer/media/images/2600x1600/1.png') }}");
        }
        .dark .branded-bg {
            background-image: url("{{ asset('freelancer/media/images/2600x1600/1-dark.png') }}");
        }
        .kt-input {
            position: relative;
        }
        .error-icon {
            position: absolute;
            top: 50%;
            right: 3rem; /* أكثر من 2.5rem لأن زر الرؤية له حوالي 3rem */
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            pointer-events: none;
            color: #f56565; /* لون الأحمر من Tailwind */
        }
        /* تفعيل ظهور البوردر الأحمر بشكل واضح */
        .kt-input.border-red-500 {
            border-color: #f56565 !important;
            box-shadow: 0 0 0 1px #f56565 !important;
            background-color: #fff5f5 !important;
        }
    </style>

    <!-- jQuery & jQuery Validation CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>
<body class="antialiased flex h-full text-base text-foreground bg-background">
<div class="grid lg:grid-cols-2 grow">
    <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
        <div class="kt-card max-w-[370px] w-full">
            <form
                id="sign_in_form"
                method="POST"
                class="kt-card-content flex flex-col gap-5 p-10"
                action="{{ route('freelancer.login') }}"
                novalidate
            >
                @csrf
                <div class="text-center mb-2.5">
                    <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                        {{ __('freelancer.sign_in') }}
                    </h3>
                    <div class="flex items-center justify-center">
                        <span class="text-sm text-secondary-foreground me-1.5">
                            {{ __('freelancer.need_account') }}
                        </span>
                        <a
                            class="text-sm link font-medium"
                            href="{{ route('freelancer.register') }}"
                        >
                            {{ __('freelancer.sign_up') }}
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2.5">
                    <a class="kt-btn kt-btn-outline justify-center" href="{{ route('freelancer.auth.social','google') }}">
                        <img alt="Google Logo" class="size-3.5 shrink-0" src="{{ asset('freelancer/media/brand-logos/google.svg') }}" />
                        {{ __('freelancer.sign_up_with_google') }}
                    </a>
                </div>
                <div class="flex items-center gap-2">
                    <span class="border-t border-border w-full"> </span>
                    <span class="text-xs text-muted-foreground font-medium uppercase">
                        {{ __('freelancer.or') }}
                    </span>
                    <span class="border-t border-border w-full"> </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="email" class="kt-form-label font-normal text-mono">
                        {{ __('freelancer.email') }}
                    </label>
                    <div class="kt-input relative">
                        <input
                            id="email"
                            name="email"
                            class="kt-input pr-10"
                            placeholder="{{ __('freelancer.enter_email') }}"
                            type="email"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>
                    <span id="email_error" class="text-red-500 text-sm mt-1"></span>
                </div>

                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between gap-1">
                        <label for="password" class="kt-form-label font-normal text-mono">
                            {{ __('freelancer.password') }}
                        </label>
                        <a
                            class="text-sm kt-link shrink-0"
                            href="{{ route('freelancer.forgot-password') }}"
                        >
                            {{ __('freelancer.forgot_password') }}
                        </a>
                    </div>
                    <div class="kt-input relative flex items-center" data-kt-toggle-password="true">
                        <input
                            id="password"
                            name="password"
                            placeholder="{{ __('freelancer.enter_password') }}"
                            type="password"
                            required
                            class="flex-grow pr-14"
                        />
                        <!-- أيقونة الخطأ ستُضاف هنا ديناميكياً -->
                        <button
                            class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5 relative z-10"
                            data-kt-toggle-password-trigger="true"
                            type="button"
                            onclick="togglePasswordVisibility()"
                        >
                            <span id="eyeOpen" class="">
                                <i class="ki-filled ki-eye text-muted-foreground"></i>
                            </span>
                            <span id="eyeClose" class="hidden">
                                <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                            </span>
                        </button>
                    </div>
                    <span id="password_error" class="text-red-500 text-sm mt-1"></span>
                </div>
                <label class="kt-label">
                    <input
                        class="kt-checkbox kt-checkbox-sm"
                        name="remember"
                        type="checkbox"
                        value="1"
                    />
                    <span class="kt-checkbox-label"> {{ __('freelancer.remember_me') }} </span>
                </label>
                <button
                    type="submit"
                    class="kt-btn kt-btn-primary flex justify-center grow"
                    id="login_button"
                >
                    {{ __('freelancer.sign_in_button') }}
                </button>
                <div id="form_error" class="text-red-500 text-center mt-2"></div>
                <div id="kt_toast_element" class="toast-container fixed top-5 right-5 z-50"></div>

            </form>
        </div>
    </div>
    <div
        class="lg:rounded-xl lg:border lg:border-border lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center bg-cover bg-no-repeat branded-bg hidden lg:block"
    ></div>
</div>

<script src="{{ asset('freelancer/js/core.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function togglePasswordVisibility() {
        const passInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClose = document.getElementById('eyeClose');

        if (passInput.type === 'password') {
            passInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClose.classList.remove('hidden');
        } else {
            passInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClose.classList.add('hidden');
        }
    }

    $(document).ready(function() {
        $('#sign_in_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "{{ __('freelancer.email_error_required') }}",
                    email: "{{ __('freelancer.email_error_invalid') }}",
                },
                password: {
                    required: "{{ __('freelancer.password_error_required') }}",
                },
            },
            errorPlacement: function(error, element) {
                const id = element.attr('id') + '_error';
                $('#' + id).text(error.text());

                element.parent().addClass('border-red-500 ');

                // إزالة أيقونة الخطأ السابقة لو موجودة
                element.siblings('.error-icon').remove();

                if(element.attr('id') === 'password') {
                    element.parent().append(`
                        <svg class="error-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                        </svg>
                    `);
                } else {
                    element.after(`
                        <svg class="error-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                        </svg>
                    `);
                }
            },
            success: function(label, element) {
                const id = $(element).attr('id') + '_error';
                $('#' + id).text('');
                $(element).parent().removeClass('border-red-500 ');
                $(element).siblings('.error-icon').remove();
            },
            highlight: function(element) {
                $(element).parent('.kt-input').addClass('border-red-500');
            },
            unhighlight: function(element) {
                const parent = $(element).parent('.kt-input');
                parent.removeClass('border-red-500');
                parent.find('.error-icon').remove();
            },

            submitHandler: function(form) {
                const loginBtn = $('#login_button');

                loginBtn.prop('disabled', true).html(`
        <svg class="animate-spin h-5 w-5 mr-2 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        {{ __('freelancer.signing_in') }}
                `);

                $('#form_error').text('');

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: $(form).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                    },
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم تسجيل الدخول بنجاح',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            setTimeout(() => {
                                window.location.href = "{{ route('freelancer.profile') }}";
                            }, 1600);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ',
                                text: data.message || '{{ __("freelancer.login_failed") }}',
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            if (xhr.responseJSON.errors.email) {
                                $('#email_error').text(xhr.responseJSON.errors.email[0]);
                                $('#email').addClass('border-red-500');
                            }
                            if (xhr.responseJSON.errors.password) {
                                $('#password_error').text(xhr.responseJSON.errors.password[0]);
                                $('#password').addClass('border-red-500');
                            }
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ',
                                text: xhr.responseJSON.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ غير متوقع',
                                text: '{{ __("freelancer.login_failed_unknown") }}',
                            });
                        }
                    },
                    complete: function() {
                        loginBtn.prop('disabled', false).text('{{ __("freelancer.sign_in_button") }}');
                    }
                });
            }


        });
    });
</script>
</body>
</html>
