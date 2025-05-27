<?php

namespace App\Http\Controllers\Front;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.register_success'),
            true,
            201
        );
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->apiResponse([], __('messages.invalid_credentials'), false, 401);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.login_success'),
            true,
            200
        );
    }

    public function profile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return $this->apiResponse([], __('messages.not_authenticated'), false, 401);
        }

        $token = $this->extractBearerToken($request);

        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.profile_success'),
            true,
            200
        );
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return $this->apiResponse([], __('messages.not_authenticated'), false, 401);
        }

        $user->tokens()->delete();

        return $this->apiResponse([], __('messages.logout_success'), true, 200);
    }

    public function lang(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:en,ar',
        ]);

        $user = Auth::user();
        $token = $this->extractBearerToken($request);

        $user->lang = $request->lang;
        $user->save();

        app()->setLocale($user->lang);

        return $this->apiResponse(
            new UserResource($user, $token),
            __('messages.language_updated'),
            true,
            200
        );
    }

    private function extractBearerToken(Request $request): ?string
    {
        $authHeader = $request->header('Authorization');

        return $authHeader && str_starts_with($authHeader, 'Bearer ')
            ? substr($authHeader, 7)
            : null;
    }
}
