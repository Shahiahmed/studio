<section class="section work" id="work" aria-labelledby="work-title">
    <div class="container">
        <x-section-head index="02" label="{{ __('Наши проекты') }}" title-id="work-title">
            <x-slot:title>{{ __('Проекты, в которых видно качество') }}</x-slot:title>
            <x-slot:lead>{{ __('Показываем, как решаем задачи бизнеса — от интернет-магазинов до внутренних систем.') }}</x-slot:lead>
        </x-section-head>

        @if ($projects->isNotEmpty())
            <div class="work__grid">
                @foreach ($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>
        @else
            <p class="work__empty">{{ __('Скоро здесь появятся наши проекты.') }}</p>
        @endif

        <div class="cta-row" data-reveal>
            <p class="cta-row__text">{{ __('Хотите проект такого уровня?') }} <span>{{ __('Расскажите о задаче.') }}</span></p>
            <x-button href="#contact">{{ __('Заказать разработку') }}</x-button>
        </div>
    </div>
</section>
