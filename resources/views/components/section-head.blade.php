@props(['index', 'label', 'titleId' => null])

<div {{ $attributes->class('section-head') }}>
    <p class="section-head__label" data-reveal><span>({{ $index }})</span> {{ $label }}</p>
    <h2 class="section-head__title" @if ($titleId) id="{{ $titleId }}" @endif data-reveal>{{ $title }}</h2>
    @if (isset($lead) && $lead->isNotEmpty())
        <p class="section-head__lead" data-reveal>{{ $lead }}</p>
    @endif
</div>
