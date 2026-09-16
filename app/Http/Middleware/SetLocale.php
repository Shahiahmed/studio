<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Язык берётся из адреса страницы (/ — русский, /kz/... — казахский).
 * Кука нужна только для того, чтобы запомнить выбор посетителя.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next, string $locale): Response
    {
        if (! array_key_exists($locale, studio_locales())) {
            $locale = studio_default_locale();
        }

        app()->setLocale($locale);
        Cookie::queue(Cookie::forever('studio_locale', $locale));

        return $next($request);
    }
}
