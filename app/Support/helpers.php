<?php

/*
|--------------------------------------------------------------------------
| Языки сайта
|--------------------------------------------------------------------------
| Русский — основной язык: он живёт на «голых» адресах и хранит весь контент
| в config/studio.php. Остальные языки получают префикс в адресе (/kz/...),
| а переводы кладутся в lang/{код}/studio.php по тем же ключам.
| Чего нет в переводе — показывается по-русски.
*/

if (! function_exists('studio_locales')) {
    function studio_locales(): array
    {
        return config('studio.locales', ['ru' => ['label' => 'Рус', 'segment' => null]]);
    }
}

if (! function_exists('studio_default_locale')) {
    function studio_default_locale(): string
    {
        return (string) array_key_first(studio_locales());
    }
}

if (! function_exists('studio_merge')) {
    /** Перевод накладывается поверх русского: можно перевести только часть ключей. */
    function studio_merge(array $base, array $over): array
    {
        foreach ($over as $key => $value) {
            $base[$key] = is_array($value) && isset($base[$key]) && is_array($base[$key])
                ? studio_merge($base[$key], $value)
                : $value;
        }

        return $base;
    }
}

if (! function_exists('studio')) {
    /** Контент сайта с учётом текущего языка. Замена config('studio.X') во фронте. */
    function studio(string $key, mixed $default = null): mixed
    {
        $base = config('studio.'.$key, $default);

        if (app()->getLocale() === studio_default_locale()) {
            return $base;
        }

        $line = trans('studio.'.$key);

        if ($line === 'studio.'.$key) {
            return $base;
        }

        return is_array($base) && is_array($line) ? studio_merge($base, $line) : $line;
    }
}

if (! function_exists('locale_route')) {
    /** Ссылка на маршрут в нужном языке: home → /, kk.home → /kz. */
    function locale_route(string $name, mixed $parameters = [], ?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $prefix = $locale === studio_default_locale() ? '' : $locale.'.';

        return route($prefix.$name, $parameters);
    }
}

if (! function_exists('locale_base_route')) {
    /** Имя текущего маршрута без языкового префикса: kk.services.show → services.show. */
    function locale_base_route(): ?string
    {
        $name = request()->route()?->getName();

        if (! $name) {
            return null;
        }

        foreach (array_keys(studio_locales()) as $code) {
            if (str_starts_with($name, $code.'.')) {
                return substr($name, strlen($code) + 1);
            }
        }

        return $name;
    }
}

if (! function_exists('locale_alternate')) {
    /** Текущая страница на другом языке (для переключателя и hreflang). */
    function locale_alternate(string $locale): string
    {
        $name = locale_base_route();
        $parameters = request()->route()?->parameters() ?? [];

        try {
            $url = $name ? locale_route($name, $parameters, $locale) : locale_route('home', [], $locale);
        } catch (Throwable) {
            $url = locale_route('home', [], $locale);
        }

        $query = request()->getQueryString();

        return $query ? $url.'?'.$query : $url;
    }
}
