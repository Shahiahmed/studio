@props([
    'href' => null,
    'variant' => 'primary',
    'size' => null,
    'arrow' => true,
])

@php
    $classes = collect(['btn', 'btn--'.$variant, $size ? 'btn--'.$size : null])->filter()->implode(' ');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
@else
    <button {{ $attributes->class($classes)->merge(['type' => 'submit']) }}>
@endif
        <span class="btn__label">{{ $slot }}</span>
        @if ($arrow)
            <span class="btn__icon" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.5 11.5 11.5 2.5M4.5 2.5h7v7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        @endif
@if ($href)
    </a>
@else
    </button>
@endif
