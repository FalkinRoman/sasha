/**
 * Админка уроков: AJAX-отправка форм с прогрессом загрузки + flash после редиректа.
 */
function showFormErrors(form, errors) {
    form.querySelectorAll('.pv-lesson-ajax-errors').forEach((el) => el.remove());
    if (!errors || typeof errors !== 'object') {
        return;
    }
    const keys = Object.keys(errors);
    if (keys.length === 0) {
        return;
    }
    const box = document.createElement('div');
    box.className =
        'pv-lesson-ajax-errors rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200';
    keys.forEach((k) => {
        (errors[k] || []).forEach((msg) => {
            const p = document.createElement('p');
            p.textContent = msg;
            box.appendChild(p);
        });
    });
    form.insertBefore(box, form.firstChild);
}

function resetProgress(wrap, bar, text, submitBtn) {
    if (wrap) {
        wrap.classList.add('hidden');
    }
    if (bar) {
        bar.style.width = '0%';
    }
    if (text) {
        text.textContent = '';
    }
    if (submitBtn) {
        submitBtn.disabled = false;
    }
}

function initLessonFormUpload() {
    const form = document.querySelector('form[data-lesson-upload]');
    if (!form) {
        return;
    }

    const progressWrap = document.querySelector('[data-upload-progress]');
    const progressBar = document.querySelector('[data-upload-progress-bar]');
    const progressText = document.querySelector('[data-upload-progress-text]');
    const submitBtn = form.querySelector('button[type="submit"]');
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        form.querySelectorAll('.pv-lesson-ajax-errors').forEach((el) => el.remove());

        const videoInput = form.querySelector('input[name="video_file"]');
        const videoUrlInput = form.querySelector('input[name="video_url"]');
        const isCreate = form.getAttribute('data-lesson-upload') === 'create';
        if (isCreate) {
            const hasFile = videoInput?.files?.length > 0;
            const urlVal = (videoUrlInput?.value || '').trim();
            if (!hasFile && !urlVal) {
                showFormErrors(form, {
                    video_file: ['Загрузите видеофайл или укажите ссылку в «Дополнительно».'],
                });
                return;
            }
        }

        const fd = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', form.action);

        xhr.setRequestHeader('X-CSRF-TOKEN', token);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        if (progressWrap) {
            progressWrap.classList.remove('hidden');
        }
        if (submitBtn) {
            submitBtn.disabled = true;
        }

        xhr.upload.addEventListener('progress', (ev) => {
            if (!ev.lengthComputable) {
                if (progressText) {
                    progressText.textContent = 'Загрузка…';
                }
                return;
            }
            const pct = Math.min(100, Math.round((ev.loaded / ev.total) * 100));
            if (progressBar) {
                progressBar.style.width = `${pct}%`;
            }
            if (progressText) {
                progressText.textContent = `Загрузка на сервер: ${pct}%`;
            }
        });

        xhr.addEventListener('load', () => {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const data = JSON.parse(xhr.responseText || '{}');
                    if (data.redirect) {
                        if (data.message) {
                            sessionStorage.setItem('pv_admin_ok', data.message);
                        }
                        window.location.href = data.redirect;
                        return;
                    }
                } catch {
                    /* not JSON */
                }
                window.location.reload();
                return;
            }

            if (xhr.status === 422) {
                try {
                    const data = JSON.parse(xhr.responseText || '{}');
                    showFormErrors(form, data.errors || {});
                } catch {
                    showFormErrors(form, { error: ['Проверьте поля формы.'] });
                }
                resetProgress(progressWrap, progressBar, progressText, submitBtn);
                return;
            }

            if (xhr.status === 413) {
                showFormErrors(form, {
                    video_file: [
                        'Файл больше, чем разрешает веб-сервер (nginx client_max_body_size / PHP upload_max_filesize). Увеличь лимиты или уменьши файл.',
                    ],
                });
                resetProgress(progressWrap, progressBar, progressText, submitBtn);
                return;
            }

            let msg = `Ошибка ${xhr.status}`;
            try {
                const data = JSON.parse(xhr.responseText || '{}');
                if (data.message) {
                    msg = data.message;
                }
            } catch {
                /* ignore */
            }
            showFormErrors(form, { error: [msg] });
            resetProgress(progressWrap, progressBar, progressText, submitBtn);
        });

        xhr.addEventListener('error', () => {
            showFormErrors(form, { error: ['Сеть или таймаут. Проверь соединение и лимиты nginx/php на размер файла.'] });
            resetProgress(progressWrap, progressBar, progressText, submitBtn);
        });

        xhr.addEventListener('abort', () => {
            resetProgress(progressWrap, progressBar, progressText, submitBtn);
        });

        xhr.send(fd);
    });
}

function initLessonsIndexFlash() {
    const el = document.querySelector('[data-pv-admin-flash]');
    if (!el) {
        return;
    }
    const m = sessionStorage.getItem('pv_admin_ok');
    if (!m) {
        return;
    }
    sessionStorage.removeItem('pv_admin_ok');
    el.textContent = m;
    el.classList.remove('hidden');
}

initLessonFormUpload();
initLessonsIndexFlash();
