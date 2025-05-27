<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = LaravelLocalization::getSupportedLanguagesKeys();
        $defaultLocale = config('app.locale', 'en');
        $locale = $defaultLocale;

        if ($request->user()) {
            $userPreferredLocale = $request->user()->lang;
            if (in_array($userPreferredLocale, $supportedLocales)) {
                $locale = $userPreferredLocale;
            }
        }

        // Set the locale for both Laravel and LaravelLocalization
        app()->setLocale($locale);
        LaravelLocalization::setLocale($locale);

        return $next($request);
    }

}
