<section class="section pricing" id="pricing" aria-labelledby="pricing-title">
    <div class="container">
        <x-section-head index="05" label="{{ __('Цены') }}" title-id="pricing-title">
            <x-slot:title>{{ __('Ориентиры по стоимости') }}</x-slot:title>
            <x-slot:lead>{{ __('Итоговая цена зависит от объёма и задач — назовём её после короткого обсуждения проекта.') }}</x-slot:lead>
        </x-section-head>

        <div class="pricing__grid">
            @foreach (studio('pricing') as $plan)
                @include('partials.price-card', ['plan' => $plan])
            @endforeach
        </div>

        <div class="pricing__help" data-reveal>
            <div>
                <h3>{{ __('Не знаете, какой вариант нужен?') }}</h3>
                <p>{{ __('Расскажите о задаче — мы предложим оптимальное решение.') }}</p>
            </div>
            <x-button href="#contact">{{ __('Получить расчёт') }}</x-button>
        </div>
    </div>
</section>
