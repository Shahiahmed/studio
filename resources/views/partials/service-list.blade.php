{{-- $services: list of services from config('studio.services'); $tag: heading level for titles --}}
@php($tag = $tag ?? 'h3')

<ol class="services__list">
    @foreach ($services as $service)
        <li class="service" data-reveal>
            <a href="{{ route('services.show', $service['slug']) }}" class="service__link">
                <span class="service__index">{{ sprintf('%02d', $loop->iteration) }}</span>
                <{{ $tag }} class="service__title">{{ $service['title'] }}</{{ $tag }}>
                <span class="service__body">
                    <span class="service__what">{{ $service['what'] }}</span>
                    <span class="service__why">{{ $service['why'] }}</span>
                    <span class="tags">
                        @foreach ($service['tags'] as $item)
                            <span class="tag">{{ $item }}</span>
                        @endforeach
                    </span>
                </span>
                <span class="service__arrow" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 14 14" fill="none"><path d="M2.5 11.5 11.5 2.5M4.5 2.5h7v7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
            </a>
        </li>
    @endforeach
</ol>
