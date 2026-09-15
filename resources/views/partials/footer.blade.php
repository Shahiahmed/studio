<footer class="site-footer">
    <div class="container">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                <a href="{{ route('home') }}" class="logo logo--night">
                    <span class="logo__mark" aria-hidden="true"></span>
                    <span class="logo__text">{{ config('studio.name') }}</span>
                </a>
                <p>{{ config('studio.description') }}</p>
            </div>

            <nav class="site-footer__col" aria-label="Навигация в подвале">
                <h2 class="site-footer__heading">Разделы</h2>
                <ul>
                    @foreach (config('studio.nav') as $item)
                        <li><a href="{{ route('home') }}#{{ $item['id'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>

            <div class="site-footer__col">
                <h2 class="site-footer__heading">Связаться</h2>
                <ul>
                    @foreach (config('studio.contacts.channels') as $channel)
                        <li><a href="{{ $channel['url'] }}" target="_blank" rel="noopener">{{ $channel['label'] }}</a></li>
                    @endforeach
                    <li><a href="tel:{{ preg_replace('/[^\d+]/', '', config('studio.contacts.phone')) }}">{{ config('studio.contacts.phone') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="site-footer__bottom">
            <span>© {{ date('Y') }} {{ config('studio.name') }}</span>
            <span>Сайты · Веб-приложения · Telegram-боты · Автоматизация</span>
        </div>
    </div>

    <p class="site-footer__wordmark" aria-hidden="true">{{ config('studio.name') }}</p>
</footer>
