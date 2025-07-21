<?php

namespace App\Http\Controllers\Back\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\ApiResponseTrait;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class SocialAuthController extends Controller
{


    // توجيه المستخدم لصفحة مصادقة جوجل
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the respective social provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $finduser = User::where($provider . '_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('freelancer/dashboard');
            } else {
                // Save user data including profile photo URL
                $newUser = User::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        $provider . '_id' => $user->id,
                        'photo' => $user->avatar, // Profile photo URL
                        'password' => encrypt('123456dummy'),
                        'email_verified_at' => Carbon::now(),
                         'email'             => $user->email,
                         'provider'          => 'google',

                    ]
                );

                Auth::login($newUser);
                return redirect()->intended('freelancer/dashboard');
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }





}


