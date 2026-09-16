<section class="section section--paper about" id="about" aria-labelledby="about-title">
    <div class="container">
        <x-section-head index="06" label="{{ __('О студии') }}" title-id="about-title">
            <x-slot:title>{{ __('Технологии, дизайн и внимание к деталям') }}</x-slot:title>
        </x-section-head>

        <div class="about__grid">
            <p class="about__text" data-reveal>{{ studio('about.text') }}</p>

            <dl class="stats">
                @foreach (studio('about.stats') as $stat)
                    <div class="stat" data-reveal>
                        <dt class="stat__label">{{ $stat['label'] }}</dt>
                        <dd class="stat__value">{{ $stat['value'] }}</dd>
                    </div>
                @endforeach
            </dl>

            <div class="tech">
                <p class="tech__label" data-reveal>{{ __('Технологии') }}</p>
                <ul class="tech__list" data-reveal>
                    @foreach (studio('about.tech') as $tech)
                        <li class="tech__item">{{ $tech }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
