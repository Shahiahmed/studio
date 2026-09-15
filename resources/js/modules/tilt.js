import { hasFinePointer, prefersReducedMotion } from './utils';

export function initTilt() {
    if (!hasFinePointer() || prefersReducedMotion()) return;

    document.querySelectorAll('[data-tilt]').forEach((element) => {
        let pointer = null;
        let frame = 0;

        // One read and one style write per frame, however many pointer events arrive
        const apply = () => {
            frame = 0;
            const rect = element.getBoundingClientRect();
            const width = element.offsetWidth;
            const height = element.offsetHeight;
            const x = (pointer.clientX - rect.left) / rect.width;
            const y = (pointer.clientY - rect.top) / rect.height;

            element.style.setProperty('--ry', `${((x - 0.5) * 5).toFixed(2)}deg`);
            element.style.setProperty('--rx', `${((0.5 - y) * 5).toFixed(2)}deg`);
            // Cursor badge offset from the centre in px: it moves with translate, so no layout per frame
            element.style.setProperty('--cx', `${((x - 0.5) * width).toFixed(1)}px`);
            element.style.setProperty('--cy', `${((y - 0.5) * height).toFixed(1)}px`);
        };

        const track = ({ clientX, clientY }) => {
            pointer = { clientX, clientY };
            frame ||= requestAnimationFrame(apply);
        };

        element.addEventListener('pointerenter', track);
        element.addEventListener('pointermove', track);

        // The badge fades out where the pointer left; only the tilt eases back
        element.addEventListener('pointerleave', () => {
            cancelAnimationFrame(frame);
            frame = 0;
            element.style.setProperty('--rx', '0deg');
            element.style.setProperty('--ry', '0deg');
        });
    });
}
