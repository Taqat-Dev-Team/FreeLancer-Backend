<?php

namespace App\Http\Controllers\Admin;
// You might need to adjust your controller's namespace

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Display the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }


    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = $request->filled('remember');
            if (Auth::guard('admin')->attempt($credentials, $remember)) {
                $request->session()->regenerate();
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Login successful!',
                        'redirect' => route('admin.dashboard'),
                    ], 200);
                }

                return redirect()->intended(route('admin.dashboard'));
            }

            // 2. Authentication failed
            $errorMessage = 'These credentials do not match our records.';
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $errorMessage,
                    'errors' => [
                        'email' => [$errorMessage], // You can return the error for a specific field
                    ],
                ], 401); // 401 Unauthorized
            }

            return redirect()->back()->withErrors([
                'email' => $errorMessage,
            ]);

        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.', // General message
                    'errors' => $e->errors(),
                ], 422); // 422 Unprocessable Entity
            }
            return redirect()->back()->withErrors($e->errors())->withInput($request->only('email'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Use the appropriate guard
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function updateProfile(Request $request)
    {

        try {

            $admin = Auth::guard('admin')->user();

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->hasFile('avatar')) {
                $admin->clearMediaCollection('avatar');

                $admin
                    ->addMediaFromRequest('avatar')
                    ->usingFileName(Str::random(20) . '.' . $request->file('avatar')->getClientOriginalExtension())
                    ->storingConversionsOnDisk('admins')
                    ->toMediaCollection('avatar', 'admins');
            }

            $admin->save();

            return response()->json(['success' => true, 'message' => 'Profile Updated Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Profile update failed.', 'error' => $e->getMessage()], 500);
        }
    }


    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Data validation failed'
            ]);
        }


        if (!Hash::check($request->old_password, $admin->password)) {
            return response()->json(['success' => false, 'message' => 'Old Password Incorrect']);
        }

        $admin->password = bcrypt($request->password);
        $admin->save();

        return response()->json(['success' => true, 'message' => 'Password Updated Successfully']);
    }
}
