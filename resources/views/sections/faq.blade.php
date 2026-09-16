<section class="section faq" aria-labelledby="faq-title">
    <div class="container faq__grid">
        <div class="faq__aside">
            <x-section-head index="08" label="FAQ" title-id="faq-title" class="section-head--stack">
                <x-slot:title>{{ __('Частые вопросы') }}</x-slot:title>
                <x-slot:lead>{{ __('Не нашли ответ? Напишите нам — ответим и подскажем, с чего начать.') }}</x-slot:lead>
            </x-section-head>
        </div>

        @include('partials.faq-list', ['items' => studio('faq')])
    </div>
</section>
