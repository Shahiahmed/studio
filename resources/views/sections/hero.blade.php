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
                {{-- Интерфейс собран вёрсткой, а не видео: чёткий на любом экране и ничего не весит --}}
                <div class="mock" aria-hidden="true">
                    <div class="mock__bar">
                        <span class="mock__dots"><i></i><i></i><i></i></span>
                        <span class="mock__tab">Заявки</span>
                        <span class="mock__live"><span class="pulse"></span>онлайн</span>
                    </div>

                    <div class="mock__body">
                        <ul class="mock__list">
                            <li class="mock__row is-new" style="--i: 0">
                                <span class="mock__badge">new</span>
                                <span class="mock__name">Интернет-магазин</span>
                                <span class="mock__time">только что</span>
                            </li>
                            <li class="mock__row" style="--i: 1">
                                <span class="mock__dot"></span>
                                <span class="mock__name">Telegram-бот для записи</span>
                                <span class="mock__time">12 мин</span>
                            </li>
                            <li class="mock__row" style="--i: 2">
                                <span class="mock__dot"></span>
                                <span class="mock__name">Личный кабинет клиента</span>
                                <span class="mock__time">40 мин</span>
                            </li>
                            <li class="mock__row" style="--i: 3">
                                <span class="mock__dot"></span>
                                <span class="mock__name">Лендинг под запуск</span>
                                <span class="mock__time">2 ч</span>
                            </li>
                        </ul>

                        <div class="mock__panel">
                            <p class="mock__label">Заявки за неделю</p>
                            <p class="mock__value">+38<span>%</span></p>
                            <svg class="sparkline" viewBox="0 0 120 40" fill="none" preserveAspectRatio="none">
                                <path d="M2 34 20 28l16 3 18-11 18 3 18-11 28-6" />
                            </svg>
                            <ul class="mock__legend">
                                <li><span>Сайты</span><span>12</span></li>
                                <li><span>Боты</span><span>7</span></li>
                                <li><span>Автоматизация</span><span>5</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
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
