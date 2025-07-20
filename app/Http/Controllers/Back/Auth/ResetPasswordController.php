<?php

namespace App\Http\Controllers\Back\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\ApiResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\PasswordReset as PasswordResetEvent;
use App\Models\User;

// تأكد من استيراد نموذج المستخدم الخاص بك

class ResetPasswordController extends Controller
{
    use ApiResponseTrait;

    public function showResetPasswordForm()
    {
        return view('freelancer.auth.reset-password');
    }



    public function resetPasswordSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->user_new_password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => true,
                'message' => __('done_reset_password')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __($status)
            ], 400);
        }
    }

}
