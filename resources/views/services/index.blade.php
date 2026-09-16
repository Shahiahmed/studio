@extends('layouts.app')

@section('title', __('Услуги: разработка сайтов, веб-приложений и Telegram-ботов').' — '.studio('name'))
@section('description', __('Разработка сайтов и интернет-магазинов, веб-приложений и CRM, Telegram-ботов, автоматизация бизнес-процессов и индивидуальные IT-решения. Состав работ, цены и этапы.'))

@php
    $crumbs = [
        ['label' => __('Главная'), 'url' => locale_route('home')],
        ['label' => __('Услуги')],
    ];
@endphp

@section('content')
    <section class="service-hero" aria-labelledby="services-page-title">
        <div class="container">
            @include('partials.breadcrumbs', ['items' => $crumbs])

            <p class="eyebrow service-hero__eyebrow" data-reveal>
                <span class="eyebrow__dot" aria-hidden="true"></span>
                {{ __('Услуги') }}
            </p>
            <h1 class="service-hero__title" id="services-page-title" data-reveal>{{ __('Услуги по разработке цифровых продуктов') }}</h1>

            <div class="service-hero__bottom">
                <p class="service-hero__lead" data-reveal>{{ __('Разрабатываем сайты, интернет-магазины, веб-приложения, Telegram-ботов и автоматизацию для бизнеса. Выберите направление — расскажем, что входит в работу, сколько это стоит и как проходит процесс.') }}</p>
            </div>
        </div>
    </section>

    <section class="section section--flush-top" aria-labelledby="services-page-title">
        <div class="container">
            @include('partials.service-list', ['services' => $services, 'tag' => 'h2'])
        </div>
    </section>

    @include('sections.contact', ['index' => '01'])
@endsection
