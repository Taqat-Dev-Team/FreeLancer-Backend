<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">
<head>
    <title>Bright Gaza - Reset Password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('freelancer/media/app/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/css/styles.css') }}" rel="stylesheet" />
</head>
<body class="antialiased flex h-full text-base text-foreground bg-background">

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

<div class="grid lg:grid-cols-2 grow">
    <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
        <div class="kt-card max-w-[370px] w-full">
            <form id="changePasswordForm" method="post" class="kt-card-content flex flex-col gap-5 p-10" action="{{ route('freelancer.reset-password-submit') }}">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <input type="hidden" name="email" value="{{ request()->get('email') }}">

                <div class="text-center">
                    <h3 class="text-lg font-medium text-mono">{{ __('freelancer.reset_password_title') }}</h3>
                    <span class="text-sm text-secondary-foreground">{{ __('freelancer.reset_password_description') }}</span>
                </div>


                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        {{ __('freelancer.password_label') }}
                    </label>
                    <label class="kt-input" data-kt-toggle-password="true">
                        <input
                            name="password"
                            id="password"
                            placeholder="{{ __('freelancer.password_placeholder') }}"
                            type="password"
                            value=""
                            required
                        />
                        <div
                            class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                            data-kt-toggle-password-trigger="true"
                        >
                  <span class="kt-toggle-password-active:hidden">
                    <i class="ki-filled ki-eye text-muted-foreground"> </i>
                  </span>
                            <span class="hidden kt-toggle-password-active:block">
                    <i class="ki-filled ki-eye-slash text-muted-foreground">
                    </i>
                  </span>
                        </div>
                    </label>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="kt-form-label font-normal text-mono">
                        {{ __('freelancer.password_confirmation_label') }}
                    </label>
                    <label class="kt-input" data-kt-toggle-password="true">
                        <input
                            name="password_confirmation"
                            placeholder="{{ __('freelancer.password_confirmation_placeholder') }}"
                            type="password"
                            value=""
                            required
                        />
                        <div
                            class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5"
                            data-kt-toggle-password-trigger="true"
                        >
                  <span class="kt-toggle-password-active:hidden">
                    <i class="ki-filled ki-eye text-muted-foreground"> </i>
                  </span>
                            <span class="hidden kt-toggle-password-active:block">
                    <i class="ki-filled ki-eye-slash text-muted-foreground">
                    </i>
                  </span>
                        </div>
                    </label>
                </div>
                <button type="submit" class="kt-btn kt-btn-primary w-full" id="submitBtn">
                    {{ __('freelancer.submit_button') }}
                </button>

                <div class="flex items-center justify-center">
                    <span class="text-sm text-secondary-foreground me-1.5">{{ __('freelancer.remember_password') }}</span>
                    <a class="text-sm link font-medium" href="{{ route('freelancer.login') }}">{{ __('freelancer.sign_in') }}</a>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:rounded-xl lg:border lg:border-border lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center bg-cover bg-no-repeat branded-bg hidden lg:block"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    $(document).on('click', '[data-kt-toggle-password-trigger="true"]', function (event) {
        event.preventDefault(); // لمنع أي حدث افتراضي (لو كان)
        const $container = $(this).closest('[data-kt-toggle-password="true"]'); // العنصر الأب الذي يحمل data-kt-toggle-password=true
        const $input = $container.find('input');

        // تبديل نوع الإدخال بين password و text
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $(this).find('.kt-toggle-password-active\\:hidden').addClass('hidden');
            $(this).find('.kt-toggle-password-active\\:block').removeClass('hidden');
        } else {
            $input.attr('type', 'password');
            $(this).find('.kt-toggle-password-active\\:hidden').removeClass('hidden');
            $(this).find('.kt-toggle-password-active\\:block').addClass('hidden');
        }
    });

</script>
<script>
    $(document).ready(function () {
        function displayValidationErrors(errors) {
            $('.kt-input').removeClass('border-red-500');
            $('.error-icon').remove();
            $('.text-red-500').text('');

            for (const field in errors) {
                const msg = errors[field][0];
                $('#' + field + '_error').text(msg);
                const input = $('#' + field);
                input.parent().addClass('border-red-500');
                input.parent().after(`
                    <svg class="error-icon inline w-5 h-5 text-red-600 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                    </svg>
                `);
            }
        }

        $('#changePasswordForm').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    required: "{{ __('freelancer.password_error_required') }}",
                    minlength: "{{ __('freelancer.password_error_min') }}"
                },
                password_confirmation: {
                    required: "{{ __('freelancer.password_confirmation_required') }}",
                    equalTo: "{{ __('freelancer.password_confirmation_mismatch') }}"
                }
            },
            errorPlacement: function(error, element) {
                const id = element.attr('id') + '_error';
                $('#' + id).text(error.text());

                element.parent().addClass('border-red-500');

                // Remove previous error icons
                element.siblings('.error-icon').remove();

                // Append error icon after the input
                element.after(`
                <svg class="error-icon inline w-5 h-5 text-red-600 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                </svg>
            `);
            },
            success: function(label, element) {
                const id = $(element).attr('id') + '_error';
                $('#' + id).text('');
                $(element).parent().removeClass('border-red-500');
                $(element).parent().siblings('.error-icon').remove();
            },
            highlight: function(element) {
                $(element).parent().addClass('border-red-500');
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('border-red-500');
                $(element).siblings('.error-icon').remove();
            },
            submitHandler: function (form) {
                const submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true).html(`
                    <svg class="animate-spin h-5 w-5 mr-2 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    {{ __('freelancer.submit_button') }}
                `);

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: $(form).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function (data) {
                        if (data.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message || '{{ __("freelancer.success_message") }}',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
                                window.location.href = "{{ route('freelancer.login') }}";
                            }, 3000);
                        } else if (data.errors) {
                            displayValidationErrors(data.errors);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || '{{ __("freelancer.unexpected_error") }}',
                            });
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON?.errors) {
                            displayValidationErrors(xhr.responseJSON.errors);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message || '{{ __("freelancer.unexpected_error") }}',
                            });
                        }
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).text('{{ __("freelancer.submit_button") }}');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
