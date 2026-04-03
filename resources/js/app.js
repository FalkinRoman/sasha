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

/**
 * Админка: бургер, выезд сайдбара, закрытие по фону и Escape.
 */
function initAdminMobileNav() {
    const burger = document.getElementById('pv-admin-burger');
    const aside = document.getElementById('pv-admin-aside');
    const backdrop = document.getElementById('pv-admin-backdrop');
    if (!burger || !aside || !backdrop) {
        return;
    }

    const open = () => {
        aside.classList.add('pv-admin-mobile-nav-open');
        backdrop.classList.add('pv-admin-mobile-nav-open');
        burger.setAttribute('aria-expanded', 'true');
        burger.setAttribute('aria-label', 'Закрыть меню');
        document.body.classList.add('overflow-hidden');
    };

    const close = () => {
        aside.classList.remove('pv-admin-mobile-nav-open');
        backdrop.classList.remove('pv-admin-mobile-nav-open');
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

/**
 * Лендинг: бургер-меню на мобиле (header marketing).
 */
/**
 * Полоса предпродажи (md+): длинный текст, пока одна строка (и flex-ряд не ломается); иначе — короткая версия.
 */
function initPresaleBarResponsiveMessage() {
    const root = document.querySelector('[data-pv-presale-bar]');
    if (!root) {
        return;
    }
    const row = root.querySelector('[data-presale-bar-row]');
    const longEl = root.querySelector('[data-presale-msg-long]');
    const shortEl = root.querySelector('[data-presale-msg-short]');
    if (!row || !longEl || !shortEl) {
        return;
    }

    const mq = window.matchMedia('(min-width: 768px)');
    let debounceTimer;

    function apply() {
        if (!mq.matches) {
            root.removeAttribute('data-presale-mode');
            root.removeAttribute('data-presale-ready');
            return;
        }

        root.removeAttribute('data-presale-ready');

        const runMeasure = () => {
            root.setAttribute('data-presale-mode', 'long');
            void row.offsetHeight;
            void longEl.offsetHeight;

            const visibleKids = [...row.children].filter((el) => el.offsetParent !== null);
            const tops = visibleKids.map((el) => el.offsetTop);
            const minTop = tops.length ? Math.min(...tops) : 0;
            const flexWrapped = tops.some((t) => t > minTop + 4);

            const lineRects = longEl.getClientRects();
            const textWrapped = lineRects.length > 1;

            root.setAttribute('data-presale-mode', flexWrapped || textWrapped ? 'short' : 'long');
            root.setAttribute('data-presale-ready', '1');
        };

        window.requestAnimationFrame(() => {
            window.requestAnimationFrame(runMeasure);
        });
    }

    function schedule() {
        window.clearTimeout(debounceTimer);
        debounceTimer = window.setTimeout(() => {
            window.requestAnimationFrame(apply);
        }, 45);
    }

    mq.addEventListener('change', schedule);
    window.addEventListener('resize', schedule);
    const ro = new ResizeObserver(() => schedule());
    ro.observe(row);

    if (document.fonts?.ready) {
        void document.fonts.ready.then(schedule);
    }

    schedule();
}

/**
 * Лендинг «Результаты»: на md+ одинаковая высота трёх карточек (как у самой высокой), без гигантского min-height в CSS.
 */
function initResults30EqualHeight() {
    const wrap = document.querySelector('[data-pv-results-eq]');
    if (!wrap) {
        return;
    }

    const mq = window.matchMedia('(min-width: 768px)');
    let debounceTimer;

    const getArticles = () => [...wrap.querySelectorAll(':scope > article')];

    function apply() {
        const list = getArticles();
        if (!list.length) {
            return;
        }
        list.forEach((a) => {
            a.style.minHeight = '';
        });
        if (!mq.matches) {
            return;
        }
        window.requestAnimationFrame(() => {
            let max = 0;
            list.forEach((a) => {
                max = Math.max(max, a.offsetHeight);
            });
            if (max > 0) {
                list.forEach((a) => {
                    a.style.minHeight = `${max}px`;
                });
            }
        });
    }

    function schedule() {
        window.clearTimeout(debounceTimer);
        debounceTimer = window.setTimeout(apply, 70);
    }

    apply();
    mq.addEventListener('change', apply);
    window.addEventListener('resize', schedule);

    const ro = new ResizeObserver(() => schedule());
    getArticles().forEach((a) => ro.observe(a));

    wrap.querySelectorAll('img').forEach((img) => {
        if (!img.complete) {
            img.addEventListener('load', schedule, { once: true });
        }
    });

    if (document.fonts?.ready) {
        void document.fonts.ready.then(schedule);
    }
}

function initMarketingMobileNav() {
    const burger = document.getElementById('pv-marketing-burger');
    const closeBtn = document.getElementById('pv-marketing-menu-close');
    const menu = document.getElementById('pv-marketing-menu');
    const backdrop = document.getElementById('pv-marketing-menu-backdrop');
    if (!burger || !menu || !backdrop) {
        return;
    }

    const open = () => {
        menu.classList.remove('translate-x-full');
        menu.classList.add('translate-x-0');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100');
        menu.setAttribute('aria-hidden', 'false');
        burger.setAttribute('aria-expanded', 'true');
        document.body.classList.add('overflow-hidden');
    };

    const close = () => {
        menu.classList.add('translate-x-full');
        menu.classList.remove('translate-x-0');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        backdrop.classList.remove('opacity-100');
        menu.setAttribute('aria-hidden', 'true');
        burger.setAttribute('aria-expanded', 'false');
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

    closeBtn?.addEventListener('click', close);
    backdrop.addEventListener('click', close);

    menu.querySelectorAll('a').forEach((a) => {
        a.addEventListener('click', () => {
            close();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && burger.getAttribute('aria-expanded') === 'true') {
            close();
        }
    });
}

/**
 * Герой: счётчик «уже N / мест M» с тиком.
 */
function initHeroCounter() {
    const elIn = document.getElementById('pv-count-in');
    const elLeft = document.getElementById('pv-count-left');
    if (!elIn || !elLeft) {
        return;
    }

    const targetIn = 128;
    const targetLeft = 47;
    const duration = 2600;
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) {
        elIn.textContent = String(targetIn);
        elLeft.textContent = String(targetLeft);

        return;
    }

    const easeOut = (t) => 1 - (1 - t) ** 3;
    const t0 = performance.now();

    function tick(now) {
        const p = Math.min(1, (now - t0) / duration);
        const e = easeOut(p);
        elIn.textContent = String(Math.round(targetIn * e));
        elLeft.textContent = String(Math.round(targetLeft * e));
        if (p < 1) {
            requestAnimationFrame(tick);
        }
    }

    requestAnimationFrame(tick);
}

/**
 * Квиз PROSTO: q2 === both → PROSTO.TOP, иначе PROSTO.Yoga (community).
 */
function initProstoQuiz() {
    const root = document.getElementById('pv-quiz');
    if (!root) {
        return;
    }

    const panel = document.getElementById('pv-quiz-panel');
    const resultEl = document.getElementById('pv-quiz-result');
    const titleEl = document.getElementById('pv-quiz-result-title');
    const textEl = document.getElementById('pv-quiz-result-text');
    const cta = document.getElementById('pv-quiz-cta');
    if (!panel || !resultEl || !titleEl || !textEl || !cta) {
        return;
    }

    const promo = root.dataset.promo || 'QUIZ5';
    const auth = root.dataset.auth === '1';
    const registerUrl = root.dataset.registerUrl || '/register';
    const urlMid = root.dataset.checkoutMid || '#tariffs';
    const urlTop = root.dataset.checkoutTop || '#tariffs';

    function go(next) {
        root.querySelectorAll('.pv-quiz-step').forEach((s) => s.classList.add('hidden'));
        root.querySelector(`[data-quiz-step="${next}"]`)?.classList.remove('hidden');
    }

    root.querySelectorAll('.pv-quiz-opt').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (btn.hasAttribute('data-q1')) {
                go(2);

                return;
            }
            if (btn.hasAttribute('data-q2')) {
                root.setAttribute('data-q2-last', btn.getAttribute('data-q2') || '');
                go(3);

                return;
            }
            if (btn.hasAttribute('data-q3')) {
                const q2 = root.getAttribute('data-q2-last') || '';
                const useTop = q2 === 'both';
                titleEl.textContent = useTop ? 'PROSTO.TOP' : 'PROSTO.Yoga';
                textEl.textContent = useTop
                    ? 'Тебе откликается максимум поддержки: личный чат, разбор ДЗ и сессия 1:1. Забирай скидку 5% на оплату.'
                    : 'Тебе подходит формат с чатом, ведением и практикой без перегруза. Скидка 5% ждёт на шаге оплаты.';
                const sep = (auth ? urlMid : registerUrl).includes('?') ? '&' : '?';
                cta.href = auth
                    ? `${useTop ? urlTop : urlMid}${sep}promocode=${encodeURIComponent(promo)}`
                    : registerUrl;
                panel.classList.add('hidden');
                resultEl.classList.remove('hidden');
            }
        });
    });
}

const PV_VALIDATION_FIELD_IDS = {
    name: 'name',
    email: 'email',
    phone: 'phone',
    password: 'password',
    password_confirmation: 'password_confirmation',
    promocode: 'promocode',
    policy_accept: 'policy_accept',
    newsletter_opt_in: 'newsletter_opt_in',
    remember: 'remember',
    code: 'code',
    telegram_username: 'telegram_username',
};

function ensurePvToastHost() {
    let host = document.getElementById('pv-toast-host');
    if (!host) {
        host = document.createElement('div');
        host.id = 'pv-toast-host';
        host.setAttribute('aria-live', 'polite');
        document.body.appendChild(host);
    }

    return host;
}

/**
 * @param {string} message
 * @param {'error'|'success'} [variant]
 * @param {number} [duration]
 */
function pvToast(message, variant = 'error', duration = 5200) {
    if (!message) {
        return;
    }
    const host = ensurePvToastHost();
    const el = document.createElement('div');
    el.className = `pv-toast pv-toast--${variant}`;
    el.setAttribute('role', 'alert');
    el.textContent = message;
    host.appendChild(el);
    requestAnimationFrame(() => {
        el.classList.add('is-visible');
    });
    window.setTimeout(() => {
        el.classList.remove('is-visible');
        window.setTimeout(() => el.remove(), 320);
    }, duration);
}

function pvMarkFieldErrorKey(fieldKey) {
    const id = PV_VALIDATION_FIELD_IDS[fieldKey] || fieldKey;
    let el = document.getElementById(id);
    if (!el) {
        const safe = typeof CSS !== 'undefined' && typeof CSS.escape === 'function' ? CSS.escape(fieldKey) : fieldKey;
        el = document.querySelector(`[name="${safe}"]`);
    }
    if (!el) {
        return;
    }
    el.classList.add('pv-input-error');
    el.setAttribute('aria-invalid', 'true');
    if (fieldKey === 'promocode') {
        el.closest('details')?.classList.add('pv-details-error');
    }
}

function pvClearInputError(el) {
    if (!el?.classList?.contains('pv-input-error')) {
        return;
    }
    el.classList.remove('pv-input-error');
    el.removeAttribute('aria-invalid');
    el.closest('details')?.classList.remove('pv-details-error');
}

function initPvPageValidationFeedback() {
    const scriptEl = document.getElementById('pv-page-errors');
    if (!scriptEl) {
        return;
    }
    let data;
    try {
        data = JSON.parse(scriptEl.textContent || '{}');
    } catch {
        return;
    }
    scriptEl.remove();
    if (!data || typeof data !== 'object') {
        return;
    }
    const keys = Object.keys(data);
    keys.forEach((key) => pvMarkFieldErrorKey(key));
    const loginForm = document.querySelector('.pv-auth-form[action*="login"]');
    if (keys.length === 1 && keys[0] === 'email' && loginForm && document.getElementById('password')) {
        pvMarkFieldErrorKey('password');
    }
    let delay = 0;
    keys.forEach((k) => {
        const arr = data[k];
        if (!Array.isArray(arr)) {
            return;
        }
        arr.forEach((msg) => {
            window.setTimeout(() => pvToast(msg, 'error'), delay);
            delay += 140;
        });
    });
}

function initPvInputErrorAutoClear() {
    document.addEventListener(
        'input',
        (e) => {
            const t = e.target;
            if (t?.classList?.contains('pv-input-error')) {
                pvClearInputError(t);
            }
        },
        true
    );
    document.addEventListener(
        'change',
        (e) => {
            const t = e.target;
            if ((t?.type === 'checkbox' || t?.type === 'radio') && t?.classList?.contains('pv-input-error')) {
                pvClearInputError(t);
            }
        },
        true
    );
}

/**
 * Регистрация: проверка email, два шага, пароль (сила, генерировать, копировать).
 */
function initRegisterWizard() {
    const root = document.getElementById('pv-register-wizard');
    if (!root) {
        return;
    }

    const checkUrl = root.dataset.checkEmailUrl;
    const csrf = root.dataset.csrf || '';
    const serverError = root.dataset.serverError === '1';

    const step1 = document.getElementById('pv-reg-step1');
    const step2 = document.getElementById('pv-reg-step2');
    const nextBtn = document.getElementById('pv-reg-next');
    const backBtn = document.getElementById('pv-reg-back');
    const form = document.getElementById('pv-register-form');
    const emailInput = document.getElementById('email');
    const emailHint = document.getElementById('email-hint');
    const nameInput = document.getElementById('name');
    const phoneInput = document.getElementById('phone');
    const phoneHint = document.getElementById('phone-hint');
    const pwInput = document.getElementById('password');
    const strengthEl = document.getElementById('pv-reg-strength');
    const genBtn = document.getElementById('pv-reg-gen');
    const togglePwBtn = document.getElementById('pv-reg-toggle-pw');
    const copyBtn = document.getElementById('pv-reg-copy');
    const policyAccept = document.getElementById('policy_accept');
    const policyAcceptHint = document.getElementById('policy-accept-hint');

    if (!step1 || !step2 || !nextBtn || !form || !emailInput || !pwInput) {
        return;
    }

    const digitsOnly = (v) => String(v || '').replace(/\D/g, '');

    function passwordStrength(pw) {
        if (pw.length < 8) {
            return { key: 'weak', text: 'Минимум 8 символов', className: 'text-[#a67c52]' };
        }
        let score = 0;
        if (pw.length >= 10) {
            score += 1;
        }
        if (/\d/.test(pw)) {
            score += 1;
        }
        if (/[a-z]/.test(pw) && /[A-Z]/.test(pw)) {
            score += 1;
        }
        if (/[^a-zA-Z0-9]/.test(pw)) {
            score += 1;
        }
        if (score <= 1) {
            return { key: 'weak', text: 'Пароль можно усилить', className: 'text-[#a67c52]' };
        }
        if (score <= 2) {
            return { key: 'medium', text: 'Нормальный пароль', className: 'text-[#6d8a4a]' };
        }

        return { key: 'strong', text: 'Надёжный пароль', className: 'text-[#4a7c23]' };
    }

    function updateStrength() {
        if (!strengthEl) {
            return;
        }
        const s = passwordStrength(pwInput.value);
        strengthEl.textContent = s.text;
        strengthEl.className = `min-h-[1.25rem] text-xs font-medium ${s.className}`;
        if (!pwInput.classList.contains('pv-input-error')) {
            pwInput.classList.remove('pv-reg-pw--weak', 'pv-reg-pw--medium', 'pv-reg-pw--strong');
            const v = pwInput.value;
            if (v.length > 0) {
                if (v.length < 8 || s.key === 'weak') {
                    pwInput.classList.add('pv-reg-pw--weak');
                } else if (s.key === 'medium') {
                    pwInput.classList.add('pv-reg-pw--medium');
                } else {
                    pwInput.classList.add('pv-reg-pw--strong');
                }
            }
        }
    }

    function generatePassword() {
        const lower = 'abcdefghjkmnpqrstuvwxyz';
        const upper = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        const num = '23456789';
        const sym = '!@#$%&*';
        const len = 14;
        const buf = new Uint8Array(len);
        crypto.getRandomValues(buf);
        let out = '';
        out += lower[buf[0] % lower.length];
        out += upper[buf[1] % upper.length];
        out += num[buf[2] % num.length];
        out += sym[buf[3] % sym.length];
        const all = lower + upper + num + sym;
        for (let i = 4; i < len; i += 1) {
            out += all[buf[i] % all.length];
        }
        const arr = out.split('');
        for (let i = arr.length - 1; i > 0; i -= 1) {
            const j = buf[i % buf.length] % (i + 1);
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
        pwInput.value = arr.join('');
        updateStrength();
    }

    let emailCheckTimer;
    let lastEmailOk = null;

    async function checkEmailNow(showHint = true) {
        const email = emailInput.value.trim().toLowerCase();
        if (!email || !email.includes('@')) {
            lastEmailOk = null;
            if (emailHint && showHint) {
                emailHint.textContent = '';
                emailHint.className = 'min-h-[1.25rem] text-xs text-[#7a837a]';
            }

            return false;
        }
        if (!checkUrl) {
            return true;
        }
        try {
            const res = await fetch(checkUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ email }),
            });
            const data = await res.json().catch(() => ({}));
            const available = Boolean(data.available);
            lastEmailOk = available;
            if (emailHint && showHint) {
                emailHint.textContent = data.message || (available ? 'Email свободен' : 'Этот email уже занят');
                emailHint.className = available
                    ? 'min-h-[1.25rem] text-xs text-[#4a7c23]'
                    : 'min-h-[1.25rem] text-xs text-red-600';
            }
            if (!available && showHint) {
                emailInput.classList.add('pv-input-error');
                emailInput.setAttribute('aria-invalid', 'true');
            } else if (available) {
                emailInput.classList.remove('pv-input-error');
                emailInput.removeAttribute('aria-invalid');
            }

            return available;
        } catch {
            lastEmailOk = null;
            if (emailHint && showHint) {
                emailHint.textContent = 'Не удалось проверить. Повтори через секунду.';
                emailHint.className = 'min-h-[1.25rem] text-xs text-red-600';
            }
            emailInput.classList.add('pv-input-error');
            emailInput.setAttribute('aria-invalid', 'true');

            return false;
        }
    }

    phoneInput?.addEventListener('input', () => {
        if (phoneHint) {
            phoneHint.textContent = '';
            phoneHint.className = 'min-h-[1.25rem] text-xs';
        }
    });

    emailInput.addEventListener('input', () => {
        lastEmailOk = null;
        if (emailHint) {
            emailHint.textContent = '';
            emailHint.className = 'min-h-[1.25rem] text-xs text-[#7a837a]';
        }
        window.clearTimeout(emailCheckTimer);
        emailCheckTimer = window.setTimeout(() => {
            void checkEmailNow(true);
        }, 450);
    });

    emailInput.addEventListener('blur', () => {
        void checkEmailNow(true);
    });

    policyAccept?.addEventListener('change', () => {
        if (policyAccept.checked && policyAcceptHint) {
            policyAcceptHint.textContent = '';
            policyAcceptHint.classList.add('hidden');
        }
    });

    function goStep2() {
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
        nextBtn.classList.add('hidden');
        backBtn?.classList.remove('hidden');
        pwVisible = false;
        pwInput.type = 'password';
        const eo = togglePwBtn?.querySelector('[data-pv-pw-eye]');
        const ec = togglePwBtn?.querySelector('[data-pv-pw-eye-off]');
        eo?.classList.remove('hidden');
        ec?.classList.add('hidden');
        togglePwBtn?.setAttribute('aria-label', 'Показать пароль');
        pwInput.focus();
    }

    function goStep1() {
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        nextBtn.classList.remove('hidden');
        backBtn?.classList.add('hidden');
    }

    nextBtn.addEventListener('click', async () => {
        const name = (nameInput?.value || '').trim();
        const email = emailInput.value.trim();
        const phoneDigits = digitsOnly(phoneInput?.value);

        if (name.length < 2) {
            nameInput?.classList.add('pv-input-error');
            nameInput?.setAttribute('aria-invalid', 'true');
            pvToast('Укажи имя — минимум 2 символа.');
            nameInput?.focus();

            return;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailInput.classList.add('pv-input-error');
            emailInput.setAttribute('aria-invalid', 'true');
            pvToast('Введи корректный email.');
            emailInput.focus();

            return;
        }
        if (phoneDigits.length < 10) {
            phoneInput?.classList.add('pv-input-error');
            phoneInput?.setAttribute('aria-invalid', 'true');
            if (phoneHint) {
                phoneHint.textContent = '';
                phoneHint.className = 'min-h-[1.25rem] text-xs';
            }
            pvToast('Номер полностью — не меньше 10 цифр.');
            phoneInput?.focus();

            return;
        }

        nextBtn.disabled = true;
        const ok = lastEmailOk === true ? true : await checkEmailNow(true);
        nextBtn.disabled = false;

        if (!ok) {
            emailInput.classList.add('pv-input-error');
            emailInput.setAttribute('aria-invalid', 'true');
            const msg = emailHint?.textContent?.trim() || 'Проверь email — возможно, он уже занят.';
            pvToast(msg);
            emailInput.focus();

            return;
        }

        if (!policyAccept?.checked) {
            policyAccept?.classList.add('pv-input-error');
            policyAccept?.setAttribute('aria-invalid', 'true');
            pvToast('Отметь согласие с офертой, политикой и обработкой данных.');
            policyAccept?.focus();

            return;
        }
        if (policyAcceptHint) {
            policyAcceptHint.textContent = '';
            policyAcceptHint.classList.add('hidden');
        }

        goStep2();
    });

    backBtn?.addEventListener('click', () => {
        goStep1();
    });

    pwInput.addEventListener('input', updateStrength);
    updateStrength();

    genBtn?.addEventListener('click', () => {
        generatePassword();
    });

    const eyeOpen = togglePwBtn?.querySelector('[data-pv-pw-eye]');
    const eyeOff = togglePwBtn?.querySelector('[data-pv-pw-eye-off]');
    let pwVisible = false;
    togglePwBtn?.addEventListener('click', () => {
        pwVisible = !pwVisible;
        pwInput.type = pwVisible ? 'text' : 'password';
        eyeOpen?.classList.toggle('hidden', pwVisible);
        eyeOff?.classList.toggle('hidden', !pwVisible);
        togglePwBtn.setAttribute('aria-label', pwVisible ? 'Скрыть пароль' : 'Показать пароль');
    });

    copyBtn?.addEventListener('click', async () => {
        const t = pwInput.value;
        if (!t) {
            pvToast('Нечего копировать — сначала введи или сгенерируй пароль.');
            return;
        }
        const prevLabel = copyBtn.getAttribute('aria-label');
        try {
            await navigator.clipboard.writeText(t);
            pvToast('Пароль скопирован.', 'success');
            copyBtn.setAttribute('aria-label', 'Скопировано');
            copyBtn.classList.add('text-[#869274]');
            window.setTimeout(() => {
                copyBtn.setAttribute('aria-label', prevLabel || 'Копировать пароль');
                copyBtn.classList.remove('text-[#869274]');
            }, 1200);
        } catch {
            pvToast('Не удалось скопировать — разреши доступ к буферу или скопируй вручную.');
            copyBtn.setAttribute('aria-label', 'Не удалось скопировать');
            window.setTimeout(() => {
                copyBtn.setAttribute('aria-label', prevLabel || 'Копировать пароль');
            }, 2000);
        }
    });

    if (!serverError) {
        step2.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    initPvPageValidationFeedback();
    initPvInputErrorAutoClear();
    initSplashIntro();
    initCabinetMobileNav();
    initAdminMobileNav();
    initMarketingMobileNav();
    initPresaleBarResponsiveMessage();
    initResults30EqualHeight();
    initProstoScrollReveal();
    initYouTubePoster();
    initHeroCounter();
    initProstoQuiz();
    initRegisterWizard();
});
