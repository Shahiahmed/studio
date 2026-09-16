@php
    $sent = session()->has('lead_success');
    // Service pages pre-select their project type
    $selectedType = old('project_type', $projectType ?? null);
@endphp

<section class="section contact" id="contact" aria-labelledby="contact-title">
    <div class="container contact__grid">
        <div class="contact__intro">
            <p class="section-head__label" data-reveal><span>({{ $index ?? '09' }})</span> Заявка</p>
            <h2 class="contact__title" id="contact-title" data-reveal>
                Есть идея? Давайте превратим её в&nbsp;<em>работающий продукт.</em>
            </h2>
            <p class="contact__lead" data-reveal>Расскажите о своей задаче — мы свяжемся с вами и предложим решение.</p>

            <ul class="contact__channels" data-reveal>
                @foreach (config('studio.contacts.channels') as $channel)
                    <li>
                        <a class="channel" href="{{ $channel['url'] }}" target="_blank" rel="noopener">
                            <span>{{ $channel['label'] }}</span>
                            <span class="channel__meta">{{ $channel['meta'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        @include('partials.lead-form', [
            'prefix' => 'lead',
            'sent' => $sent,
            'selectedType' => $selectedType,
            'reveal' => true,
        ])
    </div>
</section>
