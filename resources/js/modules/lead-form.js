export function initLeadForm() {
    const form = document.querySelector('[data-lead-form]');
    if (!form) return;

    const status = form.querySelector('[data-form-status]');
    const submit = form.querySelector('[type="submit"]');
    const done = form.querySelector('[data-form-done]');
    let sending = false;

    const setStatus = (text = '', type = '') => {
        status.textContent = text;
        status.classList.toggle('is-error', type === 'error');
    };

    const clearFieldError = (field) => {
        field.classList.remove('has-error');
        field.querySelector('.field__error').textContent = '';
        field.querySelectorAll('input, textarea').forEach((input) => input.removeAttribute('aria-invalid'));
    };

    const clearErrors = () => form.querySelectorAll('[data-field]').forEach(clearFieldError);

    const showErrors = (errors) => {
        let first = null;

        Object.entries(errors).forEach(([name, messages]) => {
            const field = form.querySelector(`[data-field="${name}"]`);
            if (!field) return;

            field.classList.add('has-error');
            field.querySelector('.field__error').textContent = messages[0];

            const input = field.querySelector('input, textarea');
            input?.setAttribute('aria-invalid', 'true');
            first ??= input;
        });

        first?.focus();
    };

    // Fields and the success panel are two mutually exclusive states of the form
    const setSent = (sent) => {
        form.classList.toggle('is-sent', sent);
        done.hidden = !sent;
    };

    // Drop a field's error as soon as the visitor starts fixing it
    form.addEventListener('input', (event) => {
        const field = event.target.closest('[data-field]');
        if (field?.classList.contains('has-error')) clearFieldError(field);
    });

    // Any CTA with data-project-type reopens the form and pre-selects the matching option
    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-project-type]');
        if (!trigger) return;

        if (form.classList.contains('is-sent')) {
            setSent(false);
            setStatus();
        }

        const option = form.querySelector(`input[name="project_type"][value="${CSS.escape(trigger.dataset.projectType)}"]`);
        if (option) option.checked = true;
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (sending) return;

        sending = true;
        clearErrors();
        setStatus('Отправляем…');
        submit.disabled = true;
        form.setAttribute('aria-busy', 'true');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: new FormData(form),
                // Never leave the form stuck on «Отправляем…» on a dead connection
                signal: 'timeout' in AbortSignal ? AbortSignal.timeout(20000) : undefined,
            });
            const data = await response.json().catch(() => ({}));

            if (response.ok && !response.redirected) {
                form.reset();
                setStatus();
                setSent(true);

                // The panel is shorter than the fields: keep it in view and move focus to it
                if (form.getBoundingClientRect().top < 0) form.scrollIntoView({ block: 'start' });
                done.querySelector('[data-form-done-title]')?.focus({ preventScroll: true });
                return;
            }

            if (response.status === 422 && data.errors) {
                showErrors(data.errors);
                setStatus('Проверьте поля формы.', 'error');
            } else if (response.status === 429) {
                setStatus('Слишком много попыток. Попробуйте через минуту.', 'error');
            } else if (response.status === 419) {
                setStatus('Страница устарела. Обновите её и отправьте заявку снова.', 'error');
            } else {
                throw new Error(`Unexpected status ${response.status}`);
            }
        } catch {
            setStatus('Не удалось отправить заявку. Попробуйте ещё раз или напишите нам в мессенджер.', 'error');
        } finally {
            sending = false;
            submit.disabled = false;
            form.removeAttribute('aria-busy');
        }
    });

    form.querySelector('[data-form-again]')?.addEventListener('click', () => {
        setSent(false);
        setStatus();
        form.querySelector('[name="name"]')?.focus();
    });
}
