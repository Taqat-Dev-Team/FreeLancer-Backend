<?php

namespace App\Http\Controllers\Admin;
// You might need to adjust your controller's namespace

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Display the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login'); // Ensure the path is correct for your Blade file
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:6'],
            ], [
                'email.required' => 'The email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'password.required' => 'The password is required.',
                'password.min' => 'The password must be at least 6 characters.',
            ]);
        } catch (ValidationException $e) {
            // If the request is AJAX, return validation errors as JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.', // General message
                    'errors' => $e->errors(),
                ], 422); // 422 Unprocessable Entity
            }
            // Otherwise, redirect back with errors (for non-AJAX)
            return redirect()->back()->withErrors($e->errors())->withInput($request->only('email'));
        }

        // 2. Attempt to authenticate the user
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Login successful!',
                    'redirect' => route('admin.dashboard'),
                ], 200);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        // 3. Authentication failed
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
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // Use the appropriate guard
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
