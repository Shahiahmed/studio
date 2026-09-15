import { onScrollFrame } from './utils';

export function initHeader() {
    const header = document.querySelector('[data-header]');
    if (!header) return;

    let lastY = window.scrollY;

    onScrollFrame(() => {
        const y = window.scrollY;
        const delta = y - lastY;

        header.classList.toggle('is-scrolled', y > 8);

        if (Math.abs(delta) > 6) {
            const menuOpen = document.body.classList.contains('menu-open');
            header.classList.toggle('is-hidden', delta > 0 && y > 480 && !menuOpen);
            lastY = y;
        }
    });

    header.addEventListener('focusin', () => header.classList.remove('is-hidden'));

    // Highlight the nav link of the section currently in view
    const links = [...header.querySelectorAll('.site-nav a')];
    const sections = links
        .map((link) => document.getElementById(new URL(link.href).hash.slice(1)))
        .filter(Boolean);

    if (!sections.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                links.forEach((link) => {
                    link.classList.toggle('is-active', new URL(link.href).hash === `#${entry.target.id}`);
                });
            });
        },
        { rootMargin: '-45% 0px -50% 0px' },
    );

    sections.forEach((section) => observer.observe(section));
}
