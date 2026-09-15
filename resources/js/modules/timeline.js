import { clamp, onScrollFrame, prefersReducedMotion } from './utils';

export function initTimeline() {
    const timeline = document.querySelector('[data-timeline]');
    if (!timeline) return;

    const steps = [...timeline.querySelectorAll('[data-step]')];
    const track = timeline.querySelector('.timeline__track');
    const vertical = window.matchMedia('(max-width: 1100px)');

    if (prefersReducedMotion()) {
        timeline.style.setProperty('--progress', '1');
        steps.forEach((step) => step.classList.add('is-active'));
        return;
    }

    onScrollFrame(() => {
        const rect = timeline.getBoundingClientRect();
        const viewport = window.innerHeight;
        const isVertical = vertical.matches;

        // Horizontal: fills while the timeline travels through the lower half of the screen.
        // Vertical: fills as the reading line (60% of the viewport) moves through it.
        const progress = isVertical
            ? clamp((viewport * 0.6 - rect.top) / rect.height)
            : clamp((viewport * 0.85 - rect.top) / (viewport * 0.5));

        timeline.style.setProperty('--progress', progress.toFixed(4));

        const trackRect = track.getBoundingClientRect();
        let current = -1;

        steps.forEach((step, index) => {
            const num = step.querySelector('.step__num').getBoundingClientRect();
            const position = isVertical
                ? (num.top + num.height / 2 - trackRect.top) / trackRect.height
                : (num.left + num.width / 2 - trackRect.left) / trackRect.width;

            const active = progress > 0 && progress >= position;
            step.classList.toggle('is-active', active);
            if (active) current = index;
        });

        steps.forEach((step, index) => step.classList.toggle('is-current', index === current));
    });
}
