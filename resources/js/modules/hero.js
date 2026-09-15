import { clamp, hasFinePointer, onScrollFrame, prefersReducedMotion } from './utils';

export function initHero() {
    requestAnimationFrame(() => document.documentElement.classList.add('is-loaded'));

    const stage = document.querySelector('[data-hero-stage]');
    if (!stage) return;

    const reducedMotion = prefersReducedMotion();

    // Load the background video only when motion is welcome and data is not constrained
    const video = stage.querySelector('[data-hero-video]');
    const source = video?.querySelector('source[data-src]');

    if (video && source && !reducedMotion && !navigator.connection?.saveData) {
        source.src = source.dataset.src;
        video.load();
        video.addEventListener('playing', () => video.classList.add('is-playing'), { once: true });

        new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        }).observe(video);
    }

    if (reducedMotion) return;

    // Frame gently scales up as it scrolls into view
    const frame = stage.querySelector('[data-hero-frame]');
    onScrollFrame(() => {
        const rect = stage.getBoundingClientRect();
        const progress = clamp((window.innerHeight - rect.top) / (window.innerHeight * 0.9));
        frame.style.setProperty('--frame-scale', (0.93 + progress * 0.07).toFixed(4));
    });

    // Floating UI chips follow the pointer with different depth
    if (!hasFinePointer()) return;

    stage.addEventListener('pointermove', (event) => {
        const rect = stage.getBoundingClientRect();
        stage.style.setProperty('--px', ((event.clientX - rect.left) / rect.width - 0.5).toFixed(3));
        stage.style.setProperty('--py', ((event.clientY - rect.top) / rect.height - 0.5).toFixed(3));
    });

    stage.addEventListener('pointerleave', () => {
        stage.style.setProperty('--px', '0');
        stage.style.setProperty('--py', '0');
    });
}
