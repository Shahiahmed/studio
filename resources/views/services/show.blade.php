@extends('layouts.app')

@section('title', $service['seo_title'].' — '.studio('name'))
@section('description', $service['seo_description'])

@php
    $minPrice = $plans->pluck('price')->filter()->min();
    $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG;

    $crumbs = [
        ['label' => __('Главная'), 'url' => locale_route('home')],
        ['label' => __('Услуги'), 'url' => locale_route('services.index')],
        ['label' => $service['title']],
    ];

    // Section labels are numbered in page order, skipping blocks that are not rendered.
    // A lookup (not a counter) because component attributes may be evaluated more than once.
    $sections = array_keys(array_filter([
        'includes' => true,
        'audience' => true,
        'result' => true,
        'process' => true,
        'pricing' => $plans->isNotEmpty(),
        'work' => $projects->isNotEmpty(),
        'faq' => true,
        'others' => true,
        'contact' => true,
    ]));
    $num = fn (string $key) => sprintf('%02d', array_search($key, $sections) + 1);
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service['h1'],
        'serviceType' => $service['title'],
        'description' => $service['seo_description'],
        'url' => locale_route('services.show', $service['slug']),
        'areaServed' => studio('area_served'),
        'provider' => [
            '@type' => 'ProfessionalService',
            'name' => studio('name'),
            'url' => locale_route('home'),
        ],
        'offers' => $minPrice ? [
            '@type' => 'Offer',
            'url' => locale_route('services.show', $service['slug']),
            'priceSpecification' => [
                '@type' => 'PriceSpecification',
                'minPrice' => $minPrice,
                'priceCurrency' => 'KZT',
            ],
        ] : null,
    ]), $jsonFlags) !!}</script>
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($service['faq'])->map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
        ])->all(),
    ], $jsonFlags) !!}</script>
@endpush

@section('content')
    <section class="service-hero" aria-labelledby="service-title">
        <div class="container">
            @include('partials.breadcrumbs', ['items' => $crumbs])

            <p class="eyebrow service-hero__eyebrow" data-reveal>
                <span class="eyebrow__dot" aria-hidden="true"></span>
                {{ __('Услуга') }}
            </p>
            <h1 class="service-hero__title" id="service-title" data-reveal>{{ $service['h1'] }}</h1>

            <div class="service-hero__bottom">
                <p class="service-hero__lead" data-reveal>{{ $service['intro'] }}</p>

                <div class="service-hero__aside" data-reveal>
                    <p class="service-hero__price">
                        <span>{{ __('Стоимость') }}</span>
                        @if ($minPrice)
                            {{ __('от') }} {{ number_format($minPrice, 0, '', ' ') }}&nbsp;₸
                        @else
                            {{ __('Рассчитаем под задачу') }}
                        @endif
                    </p>

                    <div class="service-hero__actions">
                        <x-button href="#contact" variant="accent" data-project-type="{{ $service['type'] }}">{{ __('Обсудить проект') }}</x-button>
                        @if ($plans->isNotEmpty())
                            <x-button href="#service-pricing" variant="ghost" :arrow="false">{{ __('Смотреть цены') }}</x-button>
                        @endif
                    </div>

                    <div class="tags">
                        @foreach ($service['tags'] as $item)
                            <span class="tag">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section--flush-top" aria-labelledby="service-includes-title">
        <div class="container">
            <x-section-head :index="$num('includes')" label="{{ __('Состав работ') }}" title-id="service-includes-title">
                <x-slot:title>{{ __('Что входит в :subject', ['subject' => $service['subject']]) }}</x-slot:title>
            </x-section-head>

            <ol class="service-features">
                @foreach ($service['includes'] as $item)
                    <li class="service-feature" data-reveal>
                        <span class="service-feature__num">{{ sprintf('%02d', $loop->iteration) }}</span>
                        <h3 class="service-feature__title">{{ $item['title'] }}</h3>
                        <p class="service-feature__text">{{ $item['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="section section--paper" aria-labelledby="service-audience-title">
        <div class="container">
            <x-section-head :index="$num('audience')" label="{{ __('Кому подходит') }}" title-id="service-audience-title">
                <x-slot:title>{{ __('Кому это подходит') }}</x-slot:title>
            </x-section-head>

            <ul class="service-audience">
                @foreach ($service['audience'] as $item)
                    <li class="service-audience__item" data-reveal>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['text'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="section service-result" aria-labelledby="service-result-title">
        <div class="container service-result__grid">
            <div class="service-result__head">
                <p class="section-head__label" data-reveal><span>({{ $num('result') }})</span> {{ __('Результат') }}</p>
                <h2 class="service-result__title" id="service-result-title" data-reveal>{{ __('Что вы получаете') }}</h2>
                <p class="service-result__why" data-reveal>{{ $service['why'] }}</p>
            </div>

            <ul class="service-result__list">
                @foreach ($service['benefits'] as $benefit)
                    <li data-reveal>{{ $benefit }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('sections.process', ['index' => $num('process'), 'sectionId' => 'service-process'])

    @if ($plans->isNotEmpty())
        <section class="section pricing" id="service-pricing" aria-labelledby="service-pricing-title">
            <div class="container">
                <x-section-head :index="$num('pricing')" label="{{ __('Цены') }}" title-id="service-pricing-title">
                    <x-slot:title>{{ __('Стоимость') }}</x-slot:title>
                    <x-slot:lead>{{ __('Итоговая цена зависит от объёма и задач — назовём её после короткого обсуждения проекта.') }}</x-slot:lead>
                </x-section-head>

                <div class="pricing__grid pricing__grid--compact">
                    @foreach ($plans as $plan)
                        @include('partials.price-card', ['plan' => $plan])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($projects->isNotEmpty())
        <section class="section section--flush-top" aria-labelledby="service-work-title">
            <div class="container">
                <x-section-head :index="$num('work')" label="{{ __('Работы') }}" title-id="service-work-title">
                    <x-slot:title>{{ __('Примеры работ') }}</x-slot:title>
                </x-section-head>

                <div class="work__grid work__grid--compact">
                    @foreach ($projects as $project)
                        @include('partials.project-card', ['project' => $project])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section faq" aria-labelledby="service-faq-title">
        <div class="container faq__grid">
            <div class="faq__aside">
                <x-section-head :index="$num('faq')" label="FAQ" title-id="service-faq-title" class="section-head--stack">
                    <x-slot:title>{{ __('Частые вопросы') }}</x-slot:title>
                    <x-slot:lead>{{ __('Не нашли ответ? Напишите нам — ответим и подскажем, с чего начать.') }}</x-slot:lead>
                </x-section-head>
            </div>

            @include('partials.faq-list', ['items' => $service['faq']])
        </div>
    </section>

    <section class="section section--flush-top" aria-labelledby="service-others-title">
        <div class="container">
            <x-section-head :index="$num('others')" label="{{ __('Услуги') }}" title-id="service-others-title">
                <x-slot:title>{{ __('Другие услуги') }}</x-slot:title>
            </x-section-head>

            @include('partials.service-list', ['services' => $others])
        </div>
    </section>

    @include('sections.contact', ['index' => $num('contact'), 'projectType' => $service['type']])
@endsection
