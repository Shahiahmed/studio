/**
 * The header CTA opens the brief in a dialog instead of scrolling to the section.
 * Its href still points at #contact, so without JS (or <dialog>) the link just works.
 */
export function initLeadModal() {
    const modal = document.querySelector('[data-lead-modal]');
    if (!modal || typeof modal.showModal !== 'function') return;

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-lead-modal-open]');
        if (!trigger || modal.open) return;

        event.preventDefault();
        modal.showModal();
        document.body.classList.add('modal-open');
        // showModal() would focus the close button, which reads as «leave» rather than «fill in»
        modal.querySelector('[name="name"]')?.focus({ preventScroll: true });
    });

    // The dialog itself is only hit outside the panel, so this covers the backdrop
    modal.addEventListener('click', (event) => {
        if (event.target === modal || event.target.closest('[data-lead-modal-close]')) modal.close();
    });

    // Fires on Escape too, so the lock is released whatever closed the dialog
    modal.addEventListener('close', () => document.body.classList.remove('modal-open'));
}
