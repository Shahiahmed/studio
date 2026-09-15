export const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

export const hasFinePointer = () => window.matchMedia('(hover: hover) and (pointer: fine)').matches;

export const clamp = (value, min = 0, max = 1) => Math.min(Math.max(value, min), max);

/**
 * Runs `callback` at most once per animation frame on scroll and resize.
 */
export function onScrollFrame(callback) {
    let frame = 0;

    const schedule = () => {
        if (frame) return;
        frame = requestAnimationFrame(() => {
            frame = 0;
            callback();
        });
    };

    window.addEventListener('scroll', schedule, { passive: true });
    window.addEventListener('resize', schedule);
    callback();
}
