<section class="section services" id="services" aria-labelledby="services-title">
    <div class="container">
        <x-section-head index="01" label="Услуги" title-id="services-title">
            <x-slot:title>Цифровые решения под задачи бизнеса</x-slot:title>
            <x-slot:lead>Не просто «делаем сайты» — разбираемся, какую задачу должен решить продукт, и создаём инструмент, который работает на результат.</x-slot:lead>
        </x-section-head>

        @include('partials.service-list', ['services' => config('studio.services')])

        <div class="cta-row" data-reveal>
            <p class="cta-row__text">Не нашли свою задачу? <span>Создадим решение с нуля.</span></p>
            <x-button href="#contact" data-project-type="other">Обсудить проект</x-button>
        </div>
    </div>
</section>
