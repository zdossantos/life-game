<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectLocale
{
    /** Supported locales in order of priority. */
    private const SUPPORTED = ['en', 'fr'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolveLocale($request);
        app()->setLocale($locale);

        return $next($request);
    }

    private function resolveLocale(Request $request): string
    {
        // 1. Query-string override: ?lang=fr  (useful for testing / bots)
        $query = $request->query('lang');
        if ($query && in_array($query, self::SUPPORTED, true)) {
            return $query;
        }

        // 2. Accept-Language header (used by browsers and Googlebot)
        $acceptLanguage = $request->header('Accept-Language', '');
        foreach (explode(',', $acceptLanguage) as $part) {
            $tag = strtolower(trim(explode(';', $part)[0]));       // e.g. "fr-FR" → "fr-fr"
            $primary = explode('-', $tag)[0];                       // e.g. "fr-fr" → "fr"
            if (in_array($primary, self::SUPPORTED, true)) {
                return $primary;
            }
        }

        // 3. Fallback to app default, but only if it is supported
        $defaultLocale = config('app.locale', 'en');

        return in_array($defaultLocale, self::SUPPORTED, true) ? $defaultLocale : 'en';
    }
}

