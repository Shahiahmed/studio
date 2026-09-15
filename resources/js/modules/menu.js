export function initMenu() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-menu]');
    if (!toggle || !menu) return;

    const label = toggle.querySelector('[data-menu-label]');

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        label.textContent = open ? 'Закрыть меню' : 'Открыть меню';
        menu.classList.toggle('is-open', open);
        menu.inert = !open;
        document.body.classList.toggle('menu-open', open);
    };

    toggle.addEventListener('click', () => {
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    menu.addEventListener('click', (event) => {
        if (event.target.closest('a')) setOpen(false);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu.classList.contains('is-open')) {
            setOpen(false);
            toggle.focus();
        }
    });

    window.matchMedia('(min-width: 961px)').addEventListener('change', (event) => {
        if (event.matches) setOpen(false);
    });
}
