<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\ApiResponseTrait;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    use ApiResponseTrait;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => __('messages.email_not_registered'),
        ]);

        if ($validator->fails()) {
            Log::warning('Password reset link request failed due to validation errors.', ['errors' => $validator->errors()->all()]);
            return $this->apiResponse([], $validator->errors()->first(), false, 422);
        }

        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            // لمنع Enumeration Attack، نرجع رسالة عامة حتى لو الإيميل مش موجود
            Log::info('Password reset link requested for non-existent email, but general success message returned.', ['email' => $request->email]);
            return $this->apiResponse([], __('messages.password_reset_link_sent'), true, 200);
        }

        // احصل على اللغة المفضلة للمستخدم لإرسال البريد
        $userLocale = $user->lang ?? app()->getLocale();
        app()->setLocale($userLocale); // لضمان ترجمة الرسائل التي قد تستخدمها Mail::send لاحقاً

        // Laravel Password Broker بيولد التوكن ويرسله عبر Mailable
        $status = Password::broker()->sendResetLink(
            $request->only('email'),
            function ($user, $token) use ($userLocale) {
                // نرسل الـ Mailable المخصص بتاعنا
                try {
                    Mail::to($user->email)->send(new ResetPasswordMail($token, $user->email, $userLocale));
                } catch (\Exception $e) {
                    Log::error('Failed to send password reset link email.', [
                        'email' => $user->email,
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]);
                    // لو فشل الإرسال، ممكن ترمي استثناء يخلي Laravel يعتبر العملية فاشلة
                    // أو ترجع استجابة خطأ
                    throw $e; // نختار رمي الاستثناء ليتم التعامل معه في الـ try-catch الخارجي
                }
            }
        );

        if ($status == Password::RESET_LINK_SENT) {
            return $this->apiResponse([], __('messages.password_reset_link_sent'), true, 200);
        }

        // في حالة فشل غير متوقع (مثلاً، UserProvider مش موجود أو غيره)
        Log::error('Failed to send password reset link due to unexpected status.', ['email' => $request->email, 'status' => $status]);
        return $this->apiResponse([], __('messages.password_reset_link_failed'), false, 500);
    }
}
