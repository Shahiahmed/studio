{{-- Переключатель языка. Ведёт на ту же страницу в другом языке, якорь секции добавляет JS --}}
@php($currentLocale = app()->getLocale())

<div class="lang {{ $class ?? '' }}" role="group" aria-label="{{ __('Язык сайта') }}">
    @foreach (studio_locales() as $code => $locale)
        <a
            class="lang__item{{ $code === $currentLocale ? ' is-active' : '' }}"
            href="{{ locale_alternate($code) }}"
            hreflang="{{ $code }}"
            lang="{{ $code }}"
            title="{{ $locale['name'] }}"
            @if ($code === $currentLocale) aria-current="true" @endif
            data-lang-link
        >{{ $locale['label'] }}</a>
    @endforeach
</div>
