{{-- Открывается кнопкой «Обсудить проект» в шапке. Остальные кнопки по-прежнему ведут к форме внизу --}}
<dialog class="modal" data-lead-modal aria-labelledby="lead-modal-title">
    <div class="modal__panel">
        <button class="modal__close" type="button" aria-label="Закрыть" data-lead-modal-close>
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                <path d="m7 7 10 10M17 7 7 17"/>
            </svg>
        </button>

        <p class="modal__label">Заявка</p>
        <h2 class="modal__title" id="lead-modal-title">Расскажите о проекте</h2>
        <p class="modal__lead">Свяжемся с вами и предложим решение.</p>

        @include('partials.lead-form', ['prefix' => 'modal', 'submitLabel' => 'Отправить'])
    </div>
</dialog>
