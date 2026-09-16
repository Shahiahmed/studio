@php($sectionId = $sectionId ?? 'process')

<section class="section section--paper process" id="{{ $sectionId }}" aria-labelledby="{{ $sectionId }}-title">
    <div class="container">
        <x-section-head :index="$index ?? '04'" label="{{ __('Процесс') }}" title-id="{{ $sectionId }}-title">
            <x-slot:title>{{ __('Понятный процесс — от идеи до запуска') }}</x-slot:title>
            <x-slot:lead>{{ __('Шесть этапов, на каждом из которых вы знаете, что происходит и какой будет результат.') }}</x-slot:lead>
        </x-section-head>

        <div class="timeline" data-timeline>
            <div class="timeline__track" aria-hidden="true">
                <span class="timeline__progress"></span>
            </div>

            <ol class="timeline__steps">
                @foreach (studio('process') as $step)
                    <li class="step" data-step>
                        <span class="step__num">{{ sprintf('%02d', $loop->iteration) }}</span>
                        <div class="step__content">
                            <h3 class="step__title">{{ $step['title'] }}</h3>
                            <p class="step__text">{{ $step['text'] }}</p>
                            <p class="step__result"><span>{{ __('Результат') }}</span>{{ $step['result'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
