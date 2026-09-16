<section class="section services" id="services" aria-labelledby="services-title">
    <div class="container">
        <x-section-head index="01" label="{{ __('Услуги') }}" title-id="services-title">
            <x-slot:title>{{ __('Цифровые решения под задачи бизнеса') }}</x-slot:title>
            <x-slot:lead>{{ __('Не просто «делаем сайты» — разбираемся, какую задачу должен решить продукт, и создаём инструмент, который работает на результат.') }}</x-slot:lead>
        </x-section-head>

        @include('partials.service-list', ['services' => studio('services')])

        <div class="cta-row" data-reveal>
            <p class="cta-row__text">{{ __('Не нашли свою задачу?') }} <span>{{ __('Создадим решение с нуля.') }}</span></p>
            <x-button href="#contact" data-project-type="other">{{ __('Обсудить проект') }}</x-button>
        </div>
    </div>
</section>
