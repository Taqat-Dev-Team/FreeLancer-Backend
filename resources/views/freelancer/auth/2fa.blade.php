<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">
<head>
    <base href="../" />
    <title>Bright Gaza - 2FA</title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <link href="{{ url()->current() }}" rel="canonical" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="Two-factor authentication page, styled with Tailwind CSS" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="Bright Gaza - 2FA" name="twitter:title" />
    <meta content="Two-factor authentication page, styled with Tailwind CSS" name="twitter:description" />
    <meta content="{{ asset('freelancer/media/app/og-image.png') }}" name="twitter:image" />
    <meta content="{{ url()->current() }}" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="Bright Gaza - 2FA" property="og:title" />
    <meta content="Two-factor authentication page, styled with Tailwind CSS" property="og:description" />
    <meta content="{{ asset('freelancer/media/app/og-image.png') }}" property="og:image" />

    <link href="{{ asset('freelancer/media/app/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180" />
    <link href="{{ asset('freelancer/media/app/favicon-32x32.png') }}" rel="icon" sizes="32x32" type="image/png" />
    <link href="{{ asset('freelancer/media/app/favicon-16x16.png') }}" rel="icon" sizes="16x16" type="image/png" />
    <link href="{{ asset('freelancer/media/app/favicon.ico') }}" rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link href="{{ asset('freelancer/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
    <link href="{{ asset('freelancer/css/styles.css') }}" rel="stylesheet" />
</head>
<body class="antialiased flex h-full text-base text-foreground bg-background">
<!-- Theme Mode -->
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
<!-- End Theme Mode -->

<style>
    .branded-bg {
        background-image: url("{{ asset('freelancer/media/images/2600x1600/1.png') }}");
    }
    .dark .branded-bg {
        background-image: url("{{ asset('freelancer/media/images/2600x1600/1-dark.png') }}");
    }
</style>

<div class="grid lg:grid-cols-2 grow">
    <div class="flex justify-center items-center p-8 lg:p-10 order-2 lg:order-1">
        <div class="kt-card max-w-[380px] w-full" id="2fa_form">
            <form id="otpForm" class="kt-card-content flex flex-col gap-5 p-10" method="post" action="{{ route('freelancer.verifyOtp') }}">
                @csrf
                <img alt="image" class="dark:hidden h-20 mb-2" src="{{ asset('freelancer/media/illustrations/28.svg') }}" />
                <img alt="image" class="light:hidden h-20 mb-2" src="{{ asset('freelancer/media/illustrations/28-dark.svg') }}" />
                <div class="text-center mb-2">
                    <h3 class="text-lg font-medium text-mono mb-5">Verify your email</h3>
                    <div class="flex flex-col">
                        <span class="text-sm text-secondary-foreground mb-1.5">Enter the verification code we sent to</span>
                        <a class="text-sm font-medium text-mono" href="#">{{ $email }}</a>

                    </div>
                    @if($otpCode)
                        <div id="otpDisplay" class="text-center text-green-600 font-mono mt-2">
                            OTP: {{ $otpCode }}
                        </div>
                    @endif

                </div>
                <input type="hidden" name="email" value="{{ $email }}" />

                <div class="flex flex-wrap justify-center gap-2.5">
                    <div class="flex flex-wrap justify-center gap-2.5">
                        @for($i = 0; $i < 6; $i++)
                            <input class="kt-input focus:border-primary/10 focus:ring-3 focus:ring-primary/10 size-10 shrink-0 px-0 text-center"
                                   maxlength="1"
                                   name="code_{{ $i }}"
                                   type="text"
                                   value=""
                            />
                        @endfor
                    </div>
                </div>
                <div class="flex items-center justify-center gap-1.5 mb-2">
                    <span class="text-2sm text-secondary-foreground">Didn’t receive a code?</span>
                    <button id="resendOtpBtn" type="button" class="text-2sm kt-link underline cursor-pointer bg-transparent border-none p-0">
                        Resend
                    </button>
                    <span id="resendCountdown" class="text-2sm text-secondary-foreground ml-2">(37s)</span>
                </div>
                <button type="submit" class="kt-btn kt-btn-primary flex justify-center grow">Continue</button>
            </form>
        </div>
    </div>
    <div class="lg:rounded-xl lg:border lg:border-border lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center bg-cover bg-no-repeat branded-bg hidden lg:block"></div>
</div>

<!-- Scripts -->
<script src="{{ asset('freelancer/js/core.bundle.js') }}"></script>
<script src="{{ asset('freelancer/vendors/ktui/ktui.min.js') }}"></script>
<script src="{{ asset('freelancer/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('input[name^="code_"]');

        inputs.forEach((input, index) => {
            // عند كتابة رقم ينتقل للخانة التالية
            input.addEventListener('input', function(e) {
                const value = this.value;
                if (value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                // اجعل القيمة رقم فقط
                this.value = value.replace(/[^0-9]/g, '');
            });

            // عند لصق الكود كله
            input.addEventListener('paste', function(e) {
                e.preventDefault();

                const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                const digits = pasteData.replace(/\D/g, '').slice(0, inputs.length);

                digits.split('').forEach((digit, i) => {
                    if (inputs[i]) {
                        inputs[i].value = digit;
                    }
                });

                // فوكس على آخر خانة تم تعبئتها أو على الأخيرة
                const lastIndex = Math.min(digits.length, inputs.length) - 1;
                if (inputs[lastIndex]) {
                    inputs[lastIndex].focus();
                }
            });

            // عند الضغط على backspace في خانة فارغة ترجع للخانة السابقة
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#otpForm').on('submit', function (event) {
            event.preventDefault();

            const form = this;

            // التحقق إذا كل الخانات معبّاة
            let otpCode = '';
            let hasEmptyField = false;

            $(form).find('input[name^="code_"]').each(function () {
                const val = $(this).val();
                if (!val) {
                    hasEmptyField = true;
                    $(this).addClass('border-red-500');
                } else {
                    $(this).removeClass('border-red-500');
                }
                otpCode += val;
            });

            if (hasEmptyField) {
                alert('الرجاء تعبئة جميع خانات الكود.');
                return; // إيقاف التنفيذ
            }

            const submitBtn = $(form).find('button[type="submit"]');
            submitBtn.prop('disabled', true).html(`
                <svg class="animate-spin h-5 w-5 mr-2 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                Verifying...
            `);

            let formData = new FormData(form);
            formData.set('otp_code', otpCode);

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
                        title: 'Success',
                        text: response.message || 'OTP verified successfully.',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    setTimeout(() => {
                        window.location.href = "{{ url('/freelancer/dashboard') }}";
                    }, 2000);
                },
                error: function (xhr) {
                    submitBtn.prop('disabled', false).text('Continue');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        for (const field in xhr.responseJSON.errors) {
                            const errorMsg = xhr.responseJSON.errors[field][0];
                            const input = $(`[name="${field}"]`);
                            input.addClass('border-red-500');
                            input.after(`<span class="text-red-500 text-sm">${errorMsg}</span>`);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Verification failed.',
                        });
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {

        function startResendCountdown(seconds) {
            let timeLeft = seconds;
            const countdownEl = $('#resendCountdown');
            const resendBtn = $('#resendOtpBtn');

            resendBtn.prop('disabled', true);
            countdownEl.text(`(${timeLeft}s)`);

            const interval = setInterval(() => {
                timeLeft--;
                countdownEl.text(`(${timeLeft}s)`);

                if (timeLeft <= 0) {
                    clearInterval(interval);
                    countdownEl.text('');
                    resendBtn.prop('disabled', false);
                }
            }, 1000);
        }

        $('#resendOtpBtn').click(function () {
            const resendBtn = $(this);
            resendBtn.prop('disabled', true).text('Sending...');

            $.ajax({
                url: "{{ route('freelancer.resendOtp.submit') }}", // تأكد أن هذا اسم الراوت الصحيح
                method: 'POST',
                data: {
                    email: "{{ $email }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Sent',
                        text: response.message || 'A new OTP has been sent to your email.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // تحديث عرض OTP الجديد في الصفحة
                    if(response.otp_code) {
                        $('#otpDisplay').text('OTP: ' + response.otp_code).show();
                    }

                    // تبدأ عداد العد التنازلي (مثلاً 37 ثانية)
                    startResendCountdown(37);

                    resendBtn.text('Resend');
                },

                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to resend OTP.',
                    });
                    resendBtn.prop('disabled', false).text('Resend');
                }
            });
        });

        // في البداية تعطل الزر وابدأ العد التنازلي إذا تحتاج (مثلاً لو الصفحة فتحت للتو)
        startResendCountdown(37);
    });
</script>


</body>
</html>
