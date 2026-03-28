import './bootstrap';

/**
 * Плавное появление блоков при скролле (data-pv-reveal).
 */
function initProstoScrollReveal() {
    const nodes = document.querySelectorAll('[data-pv-reveal]');
    if (!nodes.length) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        nodes.forEach((el) => el.classList.add('is-revealed'));

        return;
    }

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }
                entry.target.classList.add('is-revealed');
                io.unobserve(entry.target);
            });
        },
        { root: null, rootMargin: '0px 0px -7% 0px', threshold: 0.07 }
    );

    nodes.forEach((el) => io.observe(el));
}

/**
 * Превью YouTube: до клика показываем постер (promo.png), iframe без реального src — иначе чёрный прямоугольник.
 */
function initYouTubePoster() {
    document.querySelectorAll('[data-youtube-poster-btn]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const frame = btn.closest('.pv-video-frame');
            if (!frame) {
                return;
            }
            const iframe = frame.querySelector('iframe[data-youtube-src]');
            if (!iframe) {
                return;
            }
            const base = iframe.getAttribute('data-youtube-src');
            if (!base) {
                return;
            }
            const url = base.includes('?') ? `${base}&autoplay=1` : `${base}?autoplay=1`;
            iframe.src = url;
            iframe.classList.remove('hidden');
            btn.remove();
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initProstoScrollReveal();
    initYouTubePoster();
});
