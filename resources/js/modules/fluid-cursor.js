import { hasFinePointer, prefersReducedMotion } from './utils';

// Brand-toned dye: accent orange plus warm neighbours, so the trail matches the palette
const PALETTE = ['#ff4f1f', '#ff8a4c', '#ffb07a', '#e8431a'];

// The trail is soft smoke, so the canvas gets 3/4 of the CSS size in device pixels, whatever the
// screen density (the library multiplies by devicePixelRatio), and is stretched by CSS
const RENDER_SCALE = 0.75 / (window.devicePixelRatio || 1);

// Dye has fully faded by then, so the render loop can stop
const IDLE_STOP_MS = 3000;

/**
 * Soft fluid "ink" that trails the mouse (WebGL, webgl-fluid-enhanced, MIT).
 * Drawn under the page content, over the page background. Desktop only,
 * skipped for reduced motion or missing WebGL.
 */
export async function initFluidCursor() {
    if (!hasFinePointer() || prefersReducedMotion() || !supportsWebGL()) return;

    // The library restyles the element it receives (position/display), so hand it an inner
    // box and keep the fixed full-screen layer on the outer one
    const layer = document.createElement('div');
    layer.className = 'fluid-cursor';
    layer.setAttribute('aria-hidden', 'true');
    const stage = document.createElement('div');
    layer.append(stage);
    document.body.prepend(layer);

    let canvas;
    let fluid;
    try {
        const { default: WebGLFluidEnhanced } = await import('webgl-fluid-enhanced');
        fluid = new WebGLFluidEnhanced(stage);
        Object.assign(stage.style, {
            width: `${RENDER_SCALE * 100}%`,
            height: `${RENDER_SCALE * 100}%`,
            transform: `scale(${1 / RENDER_SCALE})`,
            transformOrigin: '0 0',
        });
        fluid.setConfig({
            transparent: true,
            hover: true,
            colorPalette: PALETTE,
            colorful: true,
            colorUpdateSpeed: 6,
            brightness: 0.7,
            simResolution: 128,
            dyeResolution: 768,
            densityDissipation: 2.6,
            velocityDissipation: 1.6,
            pressure: 0.6,
            pressureIterations: 10,
            curl: 18,
            splatRadius: 0.1,
            splatForce: 3500,
            shading: false,
            bloom: false,
            sunrays: false,
        });
        fluid.start();
        canvas = stage.querySelector('canvas');
        if (!canvas) throw new Error('Fluid canvas was not created');
    } catch {
        layer.remove();
        return;
    }

    // The layer ignores pointer events so the page stays clickable; forward the mouse to the canvas.
    // The library reads offsetX/offsetY, which are set explicitly in the canvas' own (scaled) pixels.
    const forward = (type, clientX, clientY) => {
        const event = new MouseEvent(type);
        Object.defineProperties(event, {
            offsetX: { value: clientX * RENDER_SCALE },
            offsetY: { value: clientY * RENDER_SCALE },
        });
        canvas.dispatchEvent(event);
    };

    let idleTimer;
    // A fresh pointer sits at 0,0, so its first move would shoot a jet from the corner:
    // anchor it at the cursor with a mousedown before moving
    let needsAnchor = true;

    window.addEventListener(
        'mousemove',
        ({ clientX, clientY }) => {
            fluid.start();
            layer.classList.add('is-active');
            if (needsAnchor) {
                forward('mousedown', clientX, clientY);
                needsAnchor = false;
            }
            forward('mousemove', clientX, clientY);

            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                fluid.stop();
                needsAnchor = true;
            }, IDLE_STOP_MS);
        },
        { passive: true },
    );

    document.documentElement.addEventListener('mouseleave', () => layer.classList.remove('is-active'));
}

function supportsWebGL() {
    try {
        const probe = document.createElement('canvas');
        return Boolean(probe.getContext('webgl2') || probe.getContext('webgl'));
    } catch {
        return false;
    }
}
