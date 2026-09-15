import { prefersReducedMotion } from './utils';

export function initReviews() {
    document.querySelectorAll('[data-reviews]').forEach((root) => {
        const track = root.querySelector('[data-reviews-track]');
        const prev = root.querySelector('[data-reviews-prev]');
        const next = root.querySelector('[data-reviews-next]');
        if (!track || !prev || !next) return;

        const scrollByCard = (direction) => {
            const card = track.firstElementChild;
            const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
            track.scrollBy({
                left: direction * ((card?.getBoundingClientRect().width ?? 320) + gap),
                behavior: prefersReducedMotion() ? 'auto' : 'smooth',
            });
        };

        const sync = () => {
            const maxScroll = track.scrollWidth - track.clientWidth;
            root.classList.toggle('is-static', maxScroll <= 4);
            prev.disabled = track.scrollLeft <= 4;
            next.disabled = track.scrollLeft >= maxScroll - 4;
        };

        prev.addEventListener('click', () => scrollByCard(-1));
        next.addEventListener('click', () => scrollByCard(1));
        track.addEventListener('scroll', sync, { passive: true });
        window.addEventListener('resize', sync);
        sync();
    });
}
