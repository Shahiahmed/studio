<footer class="site-footer">
    <div class="container">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                <a href="{{ locale_route('home') }}" class="logo logo--night">
                    <span class="logo__mark" aria-hidden="true"></span>
                    <span class="logo__text">{{ studio('name') }}</span>
                </a>
                <p>{{ studio('description') }}</p>
            </div>

            <nav class="site-footer__col" aria-label="{{ __('Услуги') }}">
                <h2 class="site-footer__heading"><a href="{{ locale_route('services.index') }}">{{ __('Услуги') }}</a></h2>
                <ul>
                    @foreach (studio('services') as $service)
                        <li><a href="{{ locale_route('services.show', $service['slug']) }}">{{ $service['h1'] }}</a></li>
                    @endforeach
                </ul>
            </nav>

            <nav class="site-footer__col" aria-label="{{ __('Навигация в подвале') }}">
                <h2 class="site-footer__heading">{{ __('Разделы') }}</h2>
                <ul>
                    @foreach (studio('nav') as $item)
                        <li><a href="{{ locale_route('home') }}#{{ $item['id'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>

            <div class="site-footer__col">
                <h2 class="site-footer__heading">{{ __('Связаться') }}</h2>
                <ul>
                    @foreach (studio('contacts.channels') as $channel)
                        <li><a href="{{ $channel['url'] }}" target="_blank" rel="noopener">{{ $channel['label'] }}</a></li>
                    @endforeach
                    <li><a href="tel:{{ preg_replace('/[^\d+]/', '', studio('contacts.phone')) }}">{{ studio('contacts.phone') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>© {{ date('Y') }} {{ studio('name') }}</span>
            <span>{{ __('Сайты · Веб-приложения · Telegram-боты · Автоматизация') }}</span>
        </div>

        <div class="site-footer__wordmark" aria-hidden="true" data-fit-text>
            <span>{{ studio('name') }}</span>
        </div>
    </div>
</footer>
