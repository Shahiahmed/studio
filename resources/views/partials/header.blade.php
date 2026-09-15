<header class="site-header" data-header>
    <div class="container site-header__inner">
        <a href="{{ route('home') }}" class="logo" aria-label="{{ config('studio.name') }} — на главную">
            <span class="logo__mark" aria-hidden="true"></span>
            <span class="logo__text">{{ config('studio.name') }}</span>
        </a>

        <nav class="site-nav" aria-label="Основная навигация">
            <ul>
                @foreach (config('studio.nav') as $item)
                    <li><a href="{{ route('home') }}#{{ $item['id'] }}">{{ $item['label'] }}</a></li>
                @endforeach
            </ul>
        </nav>

        <x-button href="{{ route('home') }}#contact" size="sm" class="site-header__cta">Обсудить проект</x-button>

        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
            <span class="sr-only" data-menu-label>Открыть меню</span>
            <span class="menu-toggle__bars" aria-hidden="true"></span>
        </button>
    </div>
</header>

<div class="mobile-menu" id="mobile-menu" data-menu inert>
    <nav aria-label="Мобильная навигация">
        <ul class="mobile-menu__links">
            @foreach (config('studio.nav') as $item)
                <li style="--i: {{ $loop->index }}">
                    <a href="{{ route('home') }}#{{ $item['id'] }}">
                        <span class="mono">{{ sprintf('%02d', $loop->iteration) }}</span>{{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="mobile-menu__footer">
        <x-button href="{{ route('home') }}#contact" variant="accent">Обсудить проект</x-button>
        <ul class="mobile-menu__channels">
            @foreach (config('studio.contacts.channels') as $channel)
                <li><a href="{{ $channel['url'] }}" target="_blank" rel="noopener">{{ $channel['label'] }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
