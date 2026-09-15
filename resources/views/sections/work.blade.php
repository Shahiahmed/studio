<section class="section work" id="work" aria-labelledby="work-title">
    <div class="container">
        <x-section-head index="02" label="Работы" title-id="work-title">
            <x-slot:title>Проекты, в которых видно качество</x-slot:title>
            <x-slot:lead>Показываем, как решаем задачи бизнеса — от интернет-магазинов до внутренних систем.</x-slot:lead>
        </x-section-head>

        @if ($projects->isNotEmpty())
            <div class="work__grid">
                @foreach ($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @else
            <p class="work__empty">Скоро здесь появятся наши проекты.</p>
        @endif

        <div class="cta-row" data-reveal>
            <p class="cta-row__text">Хотите проект такого уровня? <span>Расскажите о задаче.</span></p>
            <x-button href="#contact">Заказать разработку</x-button>
        </div>
    </div>
</section>
