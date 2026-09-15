import { hasFinePointer, prefersReducedMotion } from './utils';

export function initTilt() {
    if (!hasFinePointer() || prefersReducedMotion()) return;

    document.querySelectorAll('[data-tilt]').forEach((element) => {
        element.addEventListener('pointermove', (event) => {
            const rect = element.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width;
            const y = (event.clientY - rect.top) / rect.height;

            element.style.setProperty('--ry', `${((x - 0.5) * 5).toFixed(2)}deg`);
            element.style.setProperty('--rx', `${((0.5 - y) * 5).toFixed(2)}deg`);
            element.style.setProperty('--mx', `${(x * 100).toFixed(1)}%`);
            element.style.setProperty('--my', `${(y * 100).toFixed(1)}%`);
        });

        element.addEventListener('pointerleave', () => {
            element.style.setProperty('--rx', '0deg');
            element.style.setProperty('--ry', '0deg');
            element.style.setProperty('--mx', '50%');
            element.style.setProperty('--my', '50%');
        });
    });
}
