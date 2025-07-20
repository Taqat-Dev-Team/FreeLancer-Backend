<?php

namespace App\Http\Controllers\Back\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('freelancer.auth.login');
    }

    public function showRegisterForm()
    {
        return view('freelancer.auth.register');
    }
    public function showCheckEmailPage(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->firstOrFail();
        $otpCode = $user->otpCodes()->latest()->first()?->code; // Assuming 'code' هو اسم العمود في جدول otp_codes

        return view('freelancer.auth.2fa', [
            'email' => $email,
            'otpCode' => $otpCode,  // نرسل الكود ليظهر في الصفحة
        ]);
    }




    public function showProfilePage()
    {
        return view('freelancer.auth.profile');
    }







    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'terms'    => 'accepted',
        ]);

        // 1️⃣ إنشاء المستخدم
        $user = User::create([
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'email_verified_at' => null,
        ]);

        // 2️⃣ توليد كود التحقق وتخزينه في جدول منفصل
        $otpCode = random_int(100000, 999999);
        $user->otpCodes()->create([
            'code'       => $otpCode,
            'expires_at' => now()->addMinutes(10), // مدة الصلاحية 10 دقائق
        ]);

        // 3️⃣ محاولة إرسال البريد
        try {
            Mail::to($user->email)
                ->queue(new OtpMail($otpCode, app()->getLocale(), $user->email));
        } catch (\Throwable $e) {
            Log::error('OTP email failed to send', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'error'   => $e->getMessage(),
            ]);
        }

        // 4️⃣ تسجيل الدخول (اختياري)
        Auth::login($user);

        // 5️⃣ رد JSON للواجهة الأماميّة
        return response()->json([
            'success'  => true,
            'message'  => __('freelancer.register_success'),
            'redirect' => route('freelancer.check_email', ['email' => $user->email]),
        ]);
    }






    public function login(Request $request)
    {
        // تحقق من صحة البيانات
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => __('freelancer.sign_in'),
                'user' => Auth::user(),
            ]);
        }

        // فشل تسجيل الدخول
        return response()->json([
            'message' => __('freelancer.invalid_credentials'),
        ], 422);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => __('freelancer.logout_success')]);
    }


    public function sendOtp(User $user): string|false
    {
        try {
            // حذف OTP القديم الغير منتهي
            $user->otpCodes()->where('expires_at', '>', Carbon::now())->delete();

            // إنشاء OTP جديد
            $otpCode = otp();
            $expiresAt = Carbon::now()->addMinutes(5);

            OtpCode::create([
                'user_id' => $user->id,
                'code' => $otpCode,
                'expires_at' => $expiresAt,
            ]);

            $userLocale = $user->lang ?? app()->getLocale();

            try {
                Mail::to($user->email)->send(new OtpMail($otpCode, $userLocale, $user->email));
            } catch (Exception $mailException) {
                // لو فشل الإرسال بس سجله ولا توقف التنفيذ
                Log::error('Failed to send OTP email (non-blocking).', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $mailException->getMessage(),
                ]);
            }

            // ترجع true مهما حصل مع الإيميل
            // ترجع الكود الجديد
            return $otpCode;

        } catch (Exception $e) {
            // لو حصل خطأ في حفظ OTP أو غيره يرجع false لأنه خطأ حقيقي يمنع الإكمال
            Log::error('Failed to create OTP.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }


    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('freelancer.user_not_found'),
            ], 404);
        }

        if (!is_null($user->email_verified_at)) {
            return response()->json([
                'success' => false,
                'message' => __('freelancer.email_already_verified'),
            ], 400);
        }

        $otpCode = $this->sendOtp($user);

        if (!$otpCode) {
            Log::error('Failed to send OTP during resendOtp request.', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            return response()->json([
                'success' => false,
                'message' => __('freelancer.failed_to_send_otp_email'),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('freelancer.otp_sent_successfully'),
            'otp_code' => $otpCode,  // إرسال الكود الجديد للعميل
            'retry_after_seconds' => 0,
        ], 200);
    }




    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $latestOtp = $user->otpCodes()->latest()->first();

        if (!$latestOtp || $latestOtp->code !== $request->otp_code) {
            return response()->json(['message' => 'Invalid OTP code.'], 422);
        }


        $user->email_verified_at = now();
        $user->save();


        Auth::login($user);

        return response()->json(['message' => 'OTP verified. Logging in...']);
    }



    public function profile(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => __('freelancer.profile_success'),
            'user' => $user,
        ], 200);
    }



}
