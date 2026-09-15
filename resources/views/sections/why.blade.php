<section class="section why" aria-labelledby="why-title">
    <div class="container why__grid">
        <div class="why__aside">
            <x-section-head index="03" label="Почему мы" title-id="why-title" class="section-head--stack">
                <x-slot:title>Почему с нами спокойно запускать проекты</x-slot:title>
                <x-slot:lead>Мы отвечаем не только за код и дизайн, но и за то, чтобы продукт решал задачу бизнеса.</x-slot:lead>
            </x-section-head>
            <div data-reveal>
                <x-button href="#contact" variant="ghost">Обсудить задачу</x-button>
            </div>
        </div>

        <ul class="why__list">
            @foreach (config('studio.why') as $item)
                <li class="why-item" data-reveal>
                    <span class="why-item__shape why-item__shape--{{ $item['shape'] }}" aria-hidden="true"></span>
                    <div>
                        <h3 class="why-item__title">{{ $item['title'] }}</h3>
                        <p class="why-item__text">{{ $item['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
