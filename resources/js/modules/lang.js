/**
 * Language switcher: the server never sees the hash, so the current section
 * anchor is copied onto the link right before navigating.
 */
export function initLangSwitch() {
    document.querySelectorAll('[data-lang-link]').forEach((link) => {
        link.addEventListener('click', () => {
            const { hash } = window.location;
            if (hash && !link.hash) link.hash = hash;
        });
    });
}
