@extends('layouts.app')

@push('head')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => config('studio.name'),
        'description' => config('studio.description'),
        'url' => url('/'),
        'email' => config('studio.contacts.email'),
        'telephone' => config('studio.contacts.phone'),
        'priceRange' => 'от 150 000 ₸',
        'makesOffer' => collect(config('studio.services'))->map(fn ($service) => [
            '@type' => 'Offer',
            'itemOffered' => [
                '@type' => 'Service',
                'name' => $service['h1'],
                'description' => $service['what'],
                'url' => route('services.show', $service['slug']),
            ],
        ])->all(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    @include('sections.hero')
    @include('sections.services')
    @include('sections.work')
    @include('sections.why')
    @include('sections.process')
    @include('sections.pricing')
    @include('sections.about')
    @include('sections.testimonials')
    @include('sections.faq')
    @include('sections.contact')
@endsection
