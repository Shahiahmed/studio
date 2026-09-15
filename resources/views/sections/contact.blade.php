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

        <form
            @class(['lead-form', 'is-sent' => $sent])
            method="POST"
            action="{{ route('leads.store') }}"
            data-lead-form
            novalidate
            data-reveal
        >
            @csrf

            <div class="lead-form__fields">
                <div class="lead-form__row">
                    <div @class(['field', 'has-error' => $errors->has('name')]) data-field="name">
                        <label class="field__label" for="lead-name">Имя</label>
                        <input class="field__input" id="lead-name" name="name" type="text" autocomplete="name" placeholder="Как к вам обращаться" value="{{ old('name') }}" required maxlength="120" aria-describedby="lead-name-error">
                        <p class="field__error" id="lead-name-error">@error('name'){{ $message }}@enderror</p>
                    </div>

                    <div @class(['field', 'has-error' => $errors->has('contact')]) data-field="contact">
                        <label class="field__label" for="lead-contact">Контакт</label>
                        <input class="field__input" id="lead-contact" name="contact" type="text" autocomplete="tel" placeholder="Телефон, Telegram или email" value="{{ old('contact') }}" required maxlength="190" aria-describedby="lead-contact-error">
                        <p class="field__error" id="lead-contact-error">@error('contact'){{ $message }}@enderror</p>
                    </div>
                </div>

                <fieldset @class(['field', 'has-error' => $errors->has('project_type')]) data-field="project_type">
                    <legend class="field__label">Тип проекта</legend>
                    <div class="choice-list">
                        @foreach (config('studio.project_types') as $value => $label)
                            <label class="choice">
                                <input type="radio" name="project_type" value="{{ $value }}" @checked($selectedType === $value)>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="field__error">@error('project_type'){{ $message }}@enderror</p>
                </fieldset>

                <div @class(['field', 'has-error' => $errors->has('message')]) data-field="message">
                    <label class="field__label" for="lead-message">Описание задачи</label>
                    <textarea class="field__input" id="lead-message" name="message" rows="4" maxlength="5000" placeholder="Что нужно сделать, какие есть сроки и пожелания" aria-describedby="lead-message-error">{{ old('message') }}</textarea>
                    <p class="field__error" id="lead-message-error">@error('message'){{ $message }}@enderror</p>
                </div>

                <div class="hp" aria-hidden="true">
                    <label>Сайт <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <div class="lead-form__footer">
                    <x-button variant="accent">Обсудить проект</x-button>
                    <p class="lead-form__legal">Нажимая кнопку, вы соглашаетесь на обработку персональных данных.</p>
                </div>

                <p class="lead-form__status" data-form-status role="status" aria-live="polite"></p>
            </div>

            <div class="lead-form__done" data-form-done @unless ($sent) hidden @endunless>
                <span class="lead-form__done-mark" aria-hidden="true">
                    <svg width="28" height="28" viewBox="0 0 14 14" fill="none"><path d="m2.5 7.5 3 3 6-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <h3 tabindex="-1" data-form-done-title>Заявка отправлена</h3>
                <p>{{ session('lead_success', 'Спасибо! Мы свяжемся с вами и предложим решение.') }}</p>
                <button type="button" class="text-btn" data-form-again>Отправить ещё одну заявку</button>
            </div>
        </form>
    </div>
</section>
