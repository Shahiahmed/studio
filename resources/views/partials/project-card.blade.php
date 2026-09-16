<article class="work-card" data-reveal>
    <a href="{{ locale_route('projects.show', $project) }}" class="work-card__link">
        <div class="work-card__media" data-tilt>
            @if ($project->imageUrl())
                <img
                    src="{{ $project->imageUrl() }}"
                    @if ($project->imageSrcset()) srcset="{{ $project->imageSrcset() }}" sizes="(max-width: 800px) 100vw, 60vw" @endif
                    alt="{{ $project->title }}"
                    width="1600" height="1195"
                    loading="lazy" decoding="async"
                >
            @endif
            <span class="work-card__cursor" aria-hidden="true">{{ __('Подробнее') }}</span>
        </div>

        <div class="work-card__meta">
            <p class="work-card__category">
                {{ $project->category }}
                @if ($project->is_concept)
                    <span class="badge">{{ __('Концепт') }}</span>
                @endif
            </p>
            <h3 class="work-card__title">{{ $project->title }}</h3>
            <p class="work-card__excerpt">{{ $project->excerpt }}</p>
            <span class="work-card__more">
                {{ __('Подробнее') }}
                <svg width="12" height="12" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2.5 11.5 11.5 2.5M4.5 2.5h7v7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </div>
    </a>
</article>
