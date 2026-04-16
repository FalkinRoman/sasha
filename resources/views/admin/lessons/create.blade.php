@extends('layouts.admin')

@section('title', 'Новый урок')

@section('content')
    <div class="max-w-lg">
        <h1 class="text-2xl font-semibold text-white">Новый урок</h1>
        <p class="mt-2 text-sm text-white/50">Достаточно названия и видео — урок сам появится в курсе в конце списка.</p>
    </div>

    <form
        action="{{ route('admin.lessons.store') }}"
        method="post"
        enctype="multipart/form-data"
        class="mt-8 max-w-lg space-y-8"
        data-lesson-upload="create"
    >
        @csrf

        <div>
            <label class="text-sm font-medium text-white/90" for="title">Название урока</label>
            <input
                id="title"
                type="text"
                name="title"
                value="{{ old('title') }}"
                required
                autocomplete="off"
                placeholder="Например: День 9 — мягкая сила"
                class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-white/30"
            >
        </div>

        <div>
            <p class="text-sm font-medium text-white/90">Видео</p>
            <p class="mt-1 text-xs text-white/45">Файл на сервер: до {{ (int) config('prostoy.lesson_video_max_mb', 16384) }} МБ, mp4 / webm / mov. Для плеера в кабинете и в VLC: кодек <span class="font-mono text-white/70">H.264 (AVC) + AAC</span> — iPhone: «наиболее совместимые», не только HEVC. Nginx/php на проде ≥ лимита. Без файла — ссылка в «Дополнительно».</p>
            <div class="relative mt-3">
                <input
                    id="video_file"
                    type="file"
                    name="video_file"
                    accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov"
                    class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0"
                >
                <div class="flex min-h-[140px] flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/20 bg-white/[0.04] px-6 py-8 text-center transition hover:border-[#869274]/50 hover:bg-white/[0.06]">
                    <span class="inline-flex items-center rounded-full bg-[#869274] px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-black/20 pointer-events-none">Загрузить видео</span>
                    <p id="video-file-name" class="mt-3 max-w-full truncate text-xs text-white/50">Файл не выбран</p>
                </div>
            </div>
            <div data-upload-progress class="mt-4 hidden rounded-xl border border-white/10 bg-white/[0.06] p-4">
                <div class="h-2 w-full overflow-hidden rounded-full bg-white/10">
                    <div data-upload-progress-bar class="h-full w-0 rounded-full bg-[#869274] transition-[width] duration-150"></div>
                </div>
                <p data-upload-progress-text class="mt-2 text-xs text-white/60"></p>
            </div>
        </div>

        <details class="group rounded-xl border border-white/10 bg-white/[0.02] p-4">
            <summary class="cursor-pointer text-sm font-medium text-white/80 outline-none marker:text-[#869274]">Дополнительно (необязательно)</summary>
            <div class="mt-4 space-y-4 border-t border-white/10 pt-4">
                <div>
                    <label class="text-xs text-white/60" for="video_url">Вместо файла — ссылка на видео (YouTube и т.п.)</label>
                    <input
                        id="video_url"
                        type="url"
                        name="video_url"
                        value="{{ old('video_url') }}"
                        placeholder="https://..."
                        class="mt-2 w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 font-mono text-xs text-white"
                    >
                </div>
                <label class="flex items-center gap-2 text-sm text-white/75">
                    <input type="checkbox" name="is_preview_free" value="1" @checked(old('is_preview_free')) class="rounded border-white/20">
                    Открыть как бесплатное превью (без оплаты)
                </label>
                <p class="text-xs text-white/35">Техническое: slug и порядок в курсе выставляются автоматически. Подправить текст и длительность можно позже в «Изменить».</p>
            </div>
        </details>

        @if ($errors->any())
            <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                @foreach ($errors->all() as $e)
                    <p>{{ $e }}</p>
                @endforeach
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-4">
            <button type="submit" class="rounded-full bg-[#869274] px-8 py-3 text-sm font-medium text-white shadow-lg shadow-black/20 hover:brightness-105">
                Добавить в курс
            </button>
            <a href="{{ route('admin.lessons.index') }}" class="text-sm text-white/50 hover:text-white/80">Отмена</a>
        </div>
    </form>

    <script>
        document.getElementById('video_file')?.addEventListener('change', function (e) {
            const nameEl = document.getElementById('video-file-name');
            const f = e.target.files && e.target.files[0];
            if (nameEl) nameEl.textContent = f ? f.name : 'Файл не выбран';
        });
    </script>
@endsection
