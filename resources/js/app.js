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

/**
 * Заставка главной: SVG «прорисовка» → логотип → плавный уход.
 */
function initSplashIntro() {
    const splash = document.getElementById('pv-splash');
    if (!splash) {
        return;
    }

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) {
        splash.remove();
        return;
    }

    document.body.classList.add('overflow-hidden');

    const strokes = splash.querySelectorAll('[data-splash-draw]');
    const wordmark = splash.querySelector('.pv-splash__wordmark');

    const anims = [];
    strokes.forEach((el, i) => {
        try {
            const len = el.getTotalLength();
            el.style.strokeDasharray = String(len);
            el.style.strokeDashoffset = String(len);
            const dur = 720 + i * 55;
            const delay = i * 85;
            const a = el.animate([{ strokeDashoffset: len }, { strokeDashoffset: 0 }], {
                duration: dur,
                delay,
                easing: 'cubic-bezier(0.4, 0, 0.2, 1)',
                fill: 'forwards',
            });
            anims.push(a.finished);
        } catch {
            /* старые движки без getTotalLength на части узлов */
        }
    });

    const finishDraw = () => {
        if (wordmark) {
            wordmark.animate([{ opacity: 0, transform: 'translateY(6px)' }, { opacity: 1, transform: 'translateY(0)' }], {
                duration: 680,
                easing: 'cubic-bezier(0.33, 1, 0.68, 1)',
                fill: 'forwards',
            });
        }
        window.setTimeout(() => {
            splash.classList.add('pv-splash--out');
        }, 1180);
    };

    if (anims.length) {
        Promise.all(anims).then(finishDraw);
    } else {
        finishDraw();
    }

    let splashCleaned = false;
    const removeSplash = () => {
        if (splashCleaned) {
            return;
        }
        splashCleaned = true;
        splash.remove();
        document.body.classList.remove('overflow-hidden');
    };

    splash.addEventListener('transitionend', (e) => {
        if (!splash.classList.contains('pv-splash--out')) {
            return;
        }
        if (e.propertyName !== 'opacity' && e.propertyName !== 'transform') {
            return;
        }
        removeSplash();
    });

    window.setTimeout(() => {
        if (splash.parentNode && splash.classList.contains('pv-splash--out')) {
            removeSplash();
        }
    }, 5200);
}

/**
 * Кабинет: бургер, выезд сайдбара, закрытие по фону и Escape.
 */
function initCabinetMobileNav() {
    const burger = document.getElementById('pv-cabinet-burger');
    const aside = document.getElementById('pv-cabinet-aside');
    const backdrop = document.getElementById('pv-cabinet-backdrop');
    if (!burger || !aside || !backdrop) {
        return;
    }

    const open = () => {
        aside.classList.remove('-translate-x-full');
        aside.classList.add('translate-x-0');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100');
        burger.setAttribute('aria-expanded', 'true');
        burger.setAttribute('aria-label', 'Закрыть меню');
        document.body.classList.add('overflow-hidden');
    };

    const close = () => {
        aside.classList.add('-translate-x-full');
        aside.classList.remove('translate-x-0');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100');
        burger.setAttribute('aria-expanded', 'false');
        burger.setAttribute('aria-label', 'Открыть меню');
        document.body.classList.remove('overflow-hidden');
    };

    burger.addEventListener('click', () => {
        const isOpen = burger.getAttribute('aria-expanded') === 'true';
        if (isOpen) {
            close();
        } else {
            open();
        }
    });

    backdrop.addEventListener('click', close);

    aside.querySelectorAll('a').forEach((a) => {
        a.addEventListener('click', () => {
            if (window.matchMedia('(max-width: 767px)').matches) {
                close();
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && burger.getAttribute('aria-expanded') === 'true') {
            close();
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initSplashIntro();
    initCabinetMobileNav();
    initProstoScrollReveal();
    initYouTubePoster();
});
