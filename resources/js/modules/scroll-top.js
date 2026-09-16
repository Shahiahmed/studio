import { onScrollFrame } from './utils';

/**
 * Back-to-top button in the corner opposite the contact dock.
 * Appears on the same scroll threshold, so both corners fill at once.
 */
export function initScrollTop() {
    const button = document.querySelector('[data-to-top]');
    if (!button) return;

    onScrollFrame(() => {
        button.classList.toggle('is-visible', window.scrollY > window.innerHeight * 0.6);
    });

    // No explicit behavior: it falls back to scroll-behavior from CSS, which reduced motion turns off
    button.addEventListener('click', () => window.scrollTo({ top: 0 }));
}
