@php
    // Форма используется дважды: в секции «Заявка» и в модалке из шапки,
    // поэтому id полей получают префикс, иначе они задвоятся на странице
    $prefix = $prefix ?? 'lead';
    $sent = $sent ?? false;
    $selectedType = $selectedType ?? null;
    $reveal = $reveal ?? false;
    // В модалке действие короче: там и так понятно, о чём речь
    $submitLabel = $submitLabel ?? __('Обсудить проект');
@endphp

<form
    @class(['lead-form', 'is-sent' => $sent])
    method="POST"
    action="{{ locale_route('leads.store') }}"
    data-lead-form
    novalidate
    @if ($reveal) data-reveal @endif
>
    @csrf

    <div class="lead-form__fields">
        <div class="lead-form__row">
            <div @class(['field', 'has-error' => $errors->has('name')]) data-field="name">
                <label class="field__label" for="{{ $prefix }}-name">{{ __('Имя') }}</label>
                <input class="field__input" id="{{ $prefix }}-name" name="name" type="text" autocomplete="name" placeholder="{{ __('Как к вам обращаться') }}" value="{{ old('name') }}" required maxlength="120" aria-describedby="{{ $prefix }}-name-error">
                <p class="field__error" id="{{ $prefix }}-name-error">@error('name'){{ $message }}@enderror</p>
            </div>

            <div @class(['field', 'has-error' => $errors->has('contact')]) data-field="contact">
                <label class="field__label" for="{{ $prefix }}-contact">{{ __('Контакт') }}</label>
                <input class="field__input" id="{{ $prefix }}-contact" name="contact" type="text" autocomplete="tel" placeholder="{{ __('Телефон, Telegram или email') }}" value="{{ old('contact') }}" required maxlength="190" aria-describedby="{{ $prefix }}-contact-error">
                <p class="field__error" id="{{ $prefix }}-contact-error">@error('contact'){{ $message }}@enderror</p>
            </div>
        </div>

        <fieldset @class(['field', 'has-error' => $errors->has('project_type')]) data-field="project_type">
            <legend class="field__label">{{ __('Тип проекта') }}</legend>
            <div class="choice-list">
                @foreach (studio('project_types') as $value => $label)
                    <label class="choice">
                        <input type="radio" name="project_type" value="{{ $value }}" @checked($selectedType === $value)>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            <p class="field__error">@error('project_type'){{ $message }}@enderror</p>
        </fieldset>

        <div @class(['field', 'has-error' => $errors->has('message')]) data-field="message">
            <label class="field__label" for="{{ $prefix }}-message">{{ __('Описание задачи') }}</label>
            <textarea class="field__input" id="{{ $prefix }}-message" name="message" rows="4" maxlength="5000" placeholder="{{ __('Что нужно сделать, какие есть сроки и пожелания') }}" aria-describedby="{{ $prefix }}-message-error">{{ old('message') }}</textarea>
            <p class="field__error" id="{{ $prefix }}-message-error">@error('message'){{ $message }}@enderror</p>
        </div>

        <div class="hp" aria-hidden="true">
            <label>{{ __('Сайт') }} <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>

        <div class="lead-form__footer">
            <x-button variant="accent">{{ $submitLabel }}</x-button>
            <p class="lead-form__legal">{{ __('Нажимая кнопку, вы соглашаетесь на обработку персональных данных.') }}</p>
        </div>

        <p class="lead-form__status" data-form-status role="status" aria-live="polite"></p>
    </div>

    <div class="lead-form__done" data-form-done @unless ($sent) hidden @endunless>
        <span class="lead-form__done-mark" aria-hidden="true">
            <svg width="28" height="28" viewBox="0 0 14 14" fill="none"><path d="m2.5 7.5 3 3 6-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <h3 tabindex="-1" data-form-done-title>{{ __('Заявка отправлена') }}</h3>
        <p>{{ session('lead_success', __('Спасибо! Мы свяжемся с вами и предложим решение.')) }}</p>
        <button type="button" class="text-btn" data-form-again>{{ __('Отправить ещё одну заявку') }}</button>
    </div>
</form>
