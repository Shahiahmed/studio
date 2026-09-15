<div class="faq__list">
    @foreach ($items as $item)
        <details class="faq-item" data-reveal>
            <summary>
                {{ $item['q'] }}
                <span class="faq-item__icon" aria-hidden="true"></span>
            </summary>
            <p class="faq-item__answer">{{ $item['a'] }}</p>
        </details>
    @endforeach
</div>
