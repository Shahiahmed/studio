<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $pageTitle = trim($__env->yieldContent('title')) ?: studio('name').' — '.studio('tagline');
        $pageDescription = trim($__env->yieldContent('description')) ?: studio('description');
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Та же страница на другом языке: поисковик покажет нужную версию --}}
    @foreach (studio_locales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ locale_alternate($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ locale_alternate(studio_default_locale()) }}">
    <meta name="theme-color" content="#eeebe4">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ studio_locales()[app()->getLocale()]['og'] ?? 'ru_RU' }}">
    @foreach (studio_locales() as $code => $locale)
        @if ($code !== app()->getLocale())
            <meta property="og:locale:alternate" content="{{ $locale['og'] }}">
        @endif
    @endforeach
    <meta property="og:site_name" content="{{ studio('name') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ trim($__env->yieldContent('og_image')) ?: asset('media/hero/hero-poster.webp') }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <script>document.documentElement.classList.add('js')</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <a class="skip-link" href="#main">{{ __('Перейти к содержанию') }}</a>

    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.contact-dock')
    @include('partials.scroll-top')
    @include('partials.lead-modal')
</body>
</html>
