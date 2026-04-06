<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $localeFromQuery = $request->get('lang');

        $locale = $localeFromQuery
            ?? session('locale')
            ?? $request->user()?->preferred_locale
            ?? config('app.locale');

        if (! in_array($locale, ['ar', 'fr'], true)) {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);
        session(['locale' => $locale]);

        if ($localeFromQuery && $request->user() && $request->user()->preferred_locale !== $locale) {
            $request->user()->forceFill(['preferred_locale' => $locale])->save();
        }

        return $next($request);
    }
}