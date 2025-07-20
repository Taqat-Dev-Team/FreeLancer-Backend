<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="{{ app()->getLocale() }}">
<head>
    <base href="{{ url('/') }}/" />
    <title>Bright Gaza - {{ __('freelancer.sign_up') }}</title>
    <meta charset="utf-8" />
    <meta name="robots" content="follow, index" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ asset('freelancer/media/app/favicon.ico') }}" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/css/styles.css') }}" rel="stylesheet" />

    <style>
        .branded-bg {
            background-image: url("{{ asset('freelancer/media/images/2600x1600/1.png') }}");
        }
        .dark .branded-bg {
            background-image: url("{{ asset('freelancer/media/images/2600x1600/1-dark.png') }}");
        }
    </style>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="antialiased flex h-full text-base text-foreground bg-background">
<div class="grid lg:grid-cols-2 grow">
    <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
        <div class="kt-card max-w-[370px] w-full">
            <form  action="{{ route('freelancer.register.submit') }}" class="kt-card-content flex flex-col gap-5 p-10" id="sign_up_form">
                @csrf
                <div class="text-center mb-2.5">
                    <h3 class="text-lg font-medium text-mono leading-none mb-2.5">
                        {{ __('freelancer.sign_up') }}
                    </h3>
                    <div class="flex items-center justify-center">
                            <span class="text-sm text-secondary-foreground me-1.5">
                                {{ __('freelancer.already_have_account') }}
                            </span>
                        <a class="text-sm link font-medium" href="{{ route('freelancer.login') }}">
                            {{ __('freelancer.sign_in') }}
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2.5">
                    <a class="kt-btn kt-btn-outline justify-center" href="#">
                        <img alt="Google Logo" class="size-3.5 shrink-0" src="{{ asset('freelancer/media/brand-logos/google.svg') }}" />
                        {{ __('freelancer.sign_up_with_google') }}
                    </a>
                </div>

                <div class=" flex items-center gap-2">
                    <span class="border-t border-border w-full"></span>
                    <span class="text-xs text-secondary-foreground uppercase">{{ __('freelancer.or') }}</span>
                    <span class="border-t border-border w-full"></span>
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
                            placeholder="{{ __('freelancer.email') }}"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('freelancer.enter_email') }}"
                            required
                        />
                    </div>
                    <span id="email_error" class="text-red-500 text-sm mt-1"></span>
                </div>

                <div class="flex flex-col gap-1">

                    <div class="kt-input relative flex items-center" data-kt-toggle-password="true">
                        <input
                            id="password"
                            name="password"
                            placeholder="{{ __('freelancer.enter_password') }}"
                            type="password"
                            required
                            class="flex-grow pr-14"
                        />
                         <button
                            class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                            data-kt-toggle-password-trigger="true"
                            type="button"
                        >
                  <span class="kt-toggle-password-active:hidden">
                    <i class="ki-filled ki-eye text-muted-foreground"> </i>
                  </span>
                            <span class="hidden kt-toggle-password-active:block">
                    <i class="ki-filled ki-eye-slash text-muted-foreground">
                    </i>
                  </span>
                        </button>
                    </div>
                    <span id="password_error" class="text-red-500 text-sm mt-1"></span>
                </div>
                <div class="flex flex-col gap-1">

                    <div class="kt-input relative flex items-center" data-kt-toggle-password="true">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="{{ __('freelancer.confirm_password') }}"
                            type="password"
                            required
                            class="flex-grow pr-14"
                        />
                         <button
                            class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                            data-kt-toggle-password-trigger="true"
                            type="button"
                        >
                  <span class="kt-toggle-password-active:hidden">
                    <i class="ki-filled ki-eye text-muted-foreground"> </i>
                  </span>
                            <span class="hidden kt-toggle-password-active:block">
                    <i class="ki-filled ki-eye-slash text-muted-foreground">
                    </i>
                  </span>
                        </button>
                    </div>
                    <span id="password_confirmation_error" class="text-red-500 text-sm mt-1"></span>
                </div>

                <label class="kt-checkbox-group flex items-center gap-2">

                    <input class="kt-checkbox kt-checkbox-sm" name="terms" type="checkbox" value="1" required />
                    <span class="kt-checkbox-label text-sm">
                            {{ __('freelancer.agree') }}
                            <a class="font-medium link text-primary" href="#">{{ __('freelancer.privacy_policy') }}</a>
                        </span>
                </label>

                <button type="submit" class="kt-btn kt-btn-primary flex justify-center grow">
                    {{ __('freelancer.sign_up_button') }}
                </button>
            </form>
        </div>
    </div>

    <div class="lg:rounded-xl lg:border lg:border-border lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center bg-cover bg-no-repeat branded-bg hidden lg:block"></div>
</div>



<script src="{{ asset('freelancer/js/core.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '[data-kt-toggle-password="true"] button', function (event) {
        event.preventDefault(); // 🛑 يمنع إرسال الفورم
        const $input = $(this).siblings('input');
        const $eyeOpen = $(this).find('.kt-toggle-password-active\\:hidden');
        const $eyeClose = $(this).find('.kt-toggle-password-active\\:block');

        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $eyeOpen.addClass('hidden');
            $eyeClose.removeClass('hidden');
        } else {
            $input.attr('type', 'password');
            $eyeOpen.removeClass('hidden');
            $eyeClose.addClass('hidden');
        }
    });
</script>


<script>
    $(document).ready(function () {
        $('#sign_up_form').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: '[name="password"]'
                },
                terms: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "{{ __('freelancer.email_error_required') }}",
                    email: "{{ __('freelancer.email_error_invalid') }}"
                },
                password: {
                    required: "{{ __('freelancer.password_error_required') }}",
                    minlength: "{{ __('freelancer.password_error_min') }}"
                },
                password_confirmation: {
                    required: "{{ __('freelancer.password_confirmation_required') }}",
                    equalTo: "{{ __('freelancer.password_confirmation_mismatch') }}"
                },
                terms: {
                    required: "{{ __('freelancer.must_agree_terms') }}"
                }
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

            submitHandler: function (form, event) {
                event.preventDefault(); // ✅ هذا هو المهم
                const submitBtn = $(form).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html(`
                    <svg class="animate-spin h-5 w-5 mr-2 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    {{ __('freelancer.signing_up') }}
                `);
                let formData = new FormData(form);

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("freelancer.register_success") }}',
                            text: '{{ __("freelancer.redirecting_to_dashboard") }}',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 2000);
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                const errorMsg = errors[field][0];
                                const input = $(`[name="${field}"]`);
                                input.addClass('border-red-500');
                                input.after(`<span class="text-red-500 text-sm">${errorMsg}</span>`);
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("freelancer.register_failed") }}',
                                text: xhr.responseJSON?.message || '{{ __("freelancer.register_failed_unknown") }}',
                            });
                        }
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).text(`{{ __('freelancer.sign_up_button') }}`);
                    }
                });
            }
        });
    });
</script>

</body>
</html>
