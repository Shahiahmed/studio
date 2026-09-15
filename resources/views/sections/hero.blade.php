<section class="hero" aria-labelledby="hero-title">
    <div class="container">
        <p class="eyebrow" data-reveal>
            <span class="eyebrow__dot" aria-hidden="true"></span>
            Digital product studio
        </p>

        <h1 class="hero__title" id="hero-title">
            <span class="line"><span style="--i: 0">Создаём цифровые</span></span>
            <span class="line"><span style="--i: 1">продукты<span class="hero__orb" aria-hidden="true"></span></span></span>
            <span class="line"><span style="--i: 2">для&nbsp;бизнеса</span></span>
        </h1>

        <div class="hero__bottom">
            <p class="hero__lead" data-reveal>
                Сайты, веб-приложения, Telegram-боты и&nbsp;автоматизация — от идеи до готового продукта.
            </p>

            <div class="hero__actions" data-reveal>
                <x-button href="#contact">Обсудить проект</x-button>
                <x-button href="#work" variant="ghost" :arrow="false">Посмотреть работы</x-button>
            </div>

            <ul class="hero__points" data-reveal>
                @foreach (config('studio.hero_points') as $point)
                    <li>{{ $point }}</li>
                @endforeach
            </ul>
        </div>

        <div class="hero__stage" data-hero-stage>
            <div class="hero__frame" data-hero-frame>
                <video class="hero__video" data-hero-video muted loop playsinline preload="none" poster="{{ asset('media/hero/hero-poster.webp') }}" aria-hidden="true" tabindex="-1">
                    <source data-src="{{ asset('media/hero/hero.mp4') }}" type="video/mp4">
                </video>
            </div>

            <div class="chip chip--lead" aria-hidden="true">
                <span class="chip__icon">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="m2.5 7.5 3 3 6-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <span class="chip__text">
                    <strong>Новая заявка</strong>
                    <small>Интернет-магазин · только что</small>
                </span>
            </div>

            <div class="chip chip--chart" aria-hidden="true">
                <span class="chip__text">
                    <small>Заявки за неделю</small>
                    <svg class="sparkline" viewBox="0 0 120 40" fill="none">
                        <path d="M2 34 20 28l16 3 18-11 18 3 18-11 28-6" />
                    </svg>
                </span>
            </div>

            <div class="chip chip--bot" aria-hidden="true">
                <span class="pulse"></span>
                <span class="chip__text">
                    <strong>Telegram-бот</strong>
                    <small>онлайн · отвечает клиентам</small>
                </span>
            </div>

            <div class="chip chip--deploy" aria-hidden="true">
                <span class="chip__prompt">$</span> deploy → production <span class="chip__ok">✓</span>
            </div>
        </div>
    </div>

    <div class="marquee" aria-label="Направления работы">
        <div class="marquee__track">
            @foreach ([false, true] as $duplicate)
                <ul class="marquee__group" @if ($duplicate) aria-hidden="true" @endif>
                    @foreach (config('studio.marquee') as $item)
                        <li class="marquee__item">{{ $item }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    </div>
</section>
