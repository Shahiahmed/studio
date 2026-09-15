<section class="section faq" aria-labelledby="faq-title">
    <div class="container faq__grid">
        <div class="faq__aside">
            <x-section-head index="08" label="FAQ" title-id="faq-title" class="section-head--stack">
                <x-slot:title>Частые вопросы</x-slot:title>
                <x-slot:lead>Не нашли ответ? Напишите нам — ответим и подскажем, с чего начать.</x-slot:lead>
            </x-section-head>
        </div>

        @include('partials.faq-list', ['items' => config('studio.faq')])
    </div>
</section>
