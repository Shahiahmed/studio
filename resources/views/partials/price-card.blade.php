<article @class(['price-card', 'price-card--featured' => $plan['featured'] ?? false]) data-reveal>
    <div>
        <h3 class="price-card__title">{{ $plan['title'] }}</h3>
        <p class="price-card__note">{{ $plan['note'] }}</p>
    </div>

    @if ($plan['price'])
        <p class="price-card__price">
            <span class="price-card__from">{{ __('от') }}</span>{{ number_format($plan['price'], 0, '', ' ') }}&nbsp;₸
        </p>
    @else
        <p class="price-card__price price-card__price--custom">{{ __('Индивидуальный расчёт') }}</p>
    @endif

    <ul class="price-card__list">
        @foreach ($plan['includes'] as $include)
            <li>{{ $include }}</li>
        @endforeach
    </ul>

    <x-button href="#contact" :variant="($plan['featured'] ?? false) ? 'accent' : 'ghost'" data-project-type="{{ $plan['type'] }}">
        {{ __('Получить расчёт') }}
    </x-button>
</article>
