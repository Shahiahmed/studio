import { prefersReducedMotion } from './utils';

export function initReveal() {
    const items = [...document.querySelectorAll('[data-reveal]')];

    if (!('IntersectionObserver' in window) || prefersReducedMotion()) {
        items.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 },
    );

    items.forEach((item) => {
        // Small stagger between sibling elements that enter together
        const siblings = [...(item.parentElement?.children ?? [])].filter((el) => el.hasAttribute('data-reveal'));
        const index = siblings.indexOf(item);
        if (index > 0) item.style.setProperty('--delay', `${Math.min(index, 4) * 70}ms`);

        observer.observe(item);
    });
}
