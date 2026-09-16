@if ($testimonials->isNotEmpty())
    <section class="section reviews" aria-labelledby="reviews-title" data-reviews>
        <div class="container">
            <div class="reviews__head">
                <x-section-head index="07" label="{{ __('Отзывы') }}" title-id="reviews-title">
                    <x-slot:title>{{ __('Что говорят клиенты') }}</x-slot:title>
                </x-section-head>

                <div class="reviews__controls">
                    <button type="button" class="round-btn" data-reviews-prev aria-label="{{ __('Предыдущий отзыв') }}">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 3 5 8l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" class="round-btn" data-reviews-next aria-label="{{ __('Следующий отзыв') }}">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m6 3 5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>

            <div class="reviews__track" data-reviews-track tabindex="0" aria-label="{{ __('Отзывы клиентов') }}">
                @foreach ($testimonials as $testimonial)
                    <figure @class(['review', 'review--placeholder' => $testimonial->is_placeholder])>
                        @if ($testimonial->is_placeholder)
                            <span class="tag">{{ __('Место для отзыва') }}</span>
                        @endif

                        <blockquote class="review__body">
                            <p>{{ $testimonial->body }}</p>
                        </blockquote>

                        <figcaption class="review__footer">
                            <span class="review__person">
                                <span class="review__avatar" aria-hidden="true">{{ mb_substr($testimonial->author, 0, 1) }}</span>
                                <span>
                                    <span class="review__name">{{ $testimonial->author }}</span>
                                    @if ($testimonial->role())
                                        <span class="review__role">{{ $testimonial->role() }}</span>
                                    @endif
                                </span>
                            </span>
                            @if ($testimonial->project)
                                <span class="review__project">{{ __('Проект: :name', ['name' => $testimonial->project]) }}</span>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif
