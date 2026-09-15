<section class="section pricing" id="pricing" aria-labelledby="pricing-title">
    <div class="container">
        <x-section-head index="05" label="Цены" title-id="pricing-title">
            <x-slot:title>Ориентиры по стоимости</x-slot:title>
            <x-slot:lead>Итоговая цена зависит от объёма и задач — назовём её после короткого обсуждения проекта.</x-slot:lead>
        </x-section-head>

        <div class="pricing__grid">
            @foreach (config('studio.pricing') as $plan)
                @include('partials.price-card', ['plan' => $plan])
            @endforeach
        </div>

        <div class="pricing__help" data-reveal>
            <div>
                <h3>Не знаете, какой вариант нужен?</h3>
                <p>Расскажите о задаче — мы предложим оптимальное решение.</p>
            </div>
            <x-button href="#contact">Получить расчёт</x-button>
        </div>
    </div>
</section>
