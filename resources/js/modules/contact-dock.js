import { onScrollFrame } from './utils';

/**
 * Floating contact button: opens the messenger links in the corner of the screen.
 * The closed state is handled by CSS (visibility), so the links stay out of the tab order.
 */
export function initContactDock() {
    const dock = document.querySelector('[data-dock]');
    const toggle = dock?.querySelector('[data-dock-toggle]');
    if (!toggle) return;

    const setOpen = (open) => {
        dock.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', String(open));
    };

    // Kept off the first screen, where it would sit on top of the hero visual
    onScrollFrame(() => {
        const visible = window.scrollY > window.innerHeight * 0.6;
        dock.classList.toggle('is-visible', visible);
        if (!visible) setOpen(false);
    });

    toggle.addEventListener('click', () => setOpen(!dock.classList.contains('is-open')));

    // Picking a channel closes the dock, so it is shut when the user comes back to the tab
    dock.addEventListener('click', (event) => {
        if (event.target.closest('a')) setOpen(false);
    });

    document.addEventListener('click', (event) => {
        if (!dock.contains(event.target)) setOpen(false);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape' || !dock.classList.contains('is-open')) return;
        setOpen(false);
        toggle.focus();
    });
}
