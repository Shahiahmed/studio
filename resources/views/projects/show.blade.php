@extends('layouts.app')

@section('title', $project->title.' — '.config('studio.name'))
@section('description', $project->excerpt)
@if ($project->imageUrl())
    @section('og_image', $project->imageUrl())
@endif

@section('content')
    <article class="case">
        <header class="container case__hero">
            <a href="{{ route('home') }}#work" class="case__back">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 3 5 8l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Все работы
            </a>

            <p class="case__meta" data-reveal>
                <span class="tag">{{ $project->category }}</span>
                @if ($project->is_concept)
                    <span class="badge">Концепт</span>
                @endif
            </p>

            <h1 class="case__title" data-reveal>{{ $project->title }}</h1>
            <p class="case__lead" data-reveal>{{ $project->excerpt }}</p>

            @if ($project->url)
                <div data-reveal>
                    <x-button href="{{ $project->url }}" variant="ghost" target="_blank" rel="noopener">Открыть проект</x-button>
                </div>
            @endif
        </header>

        @if ($project->imageUrl())
            <div class="container">
                <figure class="case__cover" data-reveal>
                    <img
                        src="{{ $project->imageUrl() }}"
                        @if ($project->imageSrcset()) srcset="{{ $project->imageSrcset() }}" sizes="100vw" @endif
                        alt="{{ $project->title }}"
                        width="1600" height="1195"
                        fetchpriority="high"
                    >
                </figure>
            </div>
        @endif

        @php
            $blocks = array_filter([
                'Задача' => $project->task,
                'Решение' => $project->solution,
                'Результат' => $project->result,
            ]);
        @endphp

        @if ($blocks || $project->tags)
            <div class="container case__body">
                @foreach ($blocks as $heading => $text)
                    <section class="case__block" data-reveal>
                        <h2>{{ $heading }}</h2>
                        <p>{{ $text }}</p>
                    </section>
                @endforeach

                @if ($project->tags)
                    <section class="case__block" data-reveal>
                        <h2>Что внутри</h2>
                        <div class="tags">
                            @foreach ($project->tags as $tag)
                                <span class="tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        @endif
    </article>

    <section class="section">
        <div class="container">
            <div class="pricing__help" data-reveal>
                <div>
                    <h2>Хотите похожий проект?</h2>
                    <p>Расскажите о задаче — мы предложим решение и сориентируем по стоимости.</p>
                </div>
                <x-button href="{{ route('home') }}#contact">Обсудить проект</x-button>
            </div>

            @if ($more->isNotEmpty())
                <h2 class="case__more-title" data-reveal>Другие работы</h2>
                <div class="work__grid work__grid--compact">
                    @foreach ($more as $item)
                        @include('partials.project-card', ['project' => $item])
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
