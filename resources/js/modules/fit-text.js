// Scales the font of [data-fit-text] so its single line spans exactly the element's width
export function initFitText() {
    const blocks = document.querySelectorAll('[data-fit-text]');
    if (!blocks.length) return;

    const fit = (block) => {
        const text = block.firstElementChild;
        const available = block.clientWidth;
        if (!text || !available || !text.offsetWidth) return;

        const size = parseFloat(getComputedStyle(block).fontSize);
        block.style.fontSize = `${(size * available) / text.offsetWidth}px`;
    };

    // The block's width doesn't depend on its font size, so resizing it never loops
    const observer = new ResizeObserver((entries) => entries.forEach((entry) => fit(entry.target)));
    blocks.forEach((block) => observer.observe(block));

    // Metrics change once the display font has loaded
    document.fonts?.ready.then(() => blocks.forEach(fit));
}
