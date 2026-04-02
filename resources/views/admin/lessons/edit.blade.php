@extends('layouts.admin')

@section('title', 'Урок: ' . $lesson->title)

@section('content')
    <h1 class="text-2xl font-semibold text-white">Редактирование урока</h1>
    <p class="mt-2 text-sm text-white/50 font-mono">{{ $lesson->slug }}</p>
    <form action="{{ route('admin.lessons.update', $lesson) }}" method="post" enctype="multipart/form-data" class="mt-8 max-w-2xl space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="text-sm text-white/70">Курс (slug)</label>
            <input type="text" name="course_slug" value="{{ old('course_slug', $lesson->course_slug) }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 font-mono text-sm text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Порядок в курсе</label>
            <input type="number" name="order_index" value="{{ old('order_index', $lesson->order_index) }}" min="0" max="255" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Slug урока</label>
            <input type="text" name="slug" value="{{ old('slug', $lesson->slug) }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 font-mono text-sm text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Заголовок</label>
            <input type="text" name="title" value="{{ old('title', $lesson->title) }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Подзаголовок</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $lesson->subtitle) }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Краткое описание</label>
            <textarea name="short_description" rows="2" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">{{ old('short_description', $lesson->short_description) }}</textarea>
        </div>
        <div>
            <label class="text-sm text-white/70">Текст урока</label>
            <textarea name="body" rows="6" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">{{ old('body', $lesson->body) }}</textarea>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm text-white/70">Длительность, мин</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $lesson->duration_minutes) }}" min="1" max="600" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
            </div>
            <div>
                <label class="text-sm text-white/70">Ккал (оценка)</label>
                <input type="number" name="calories_estimate" value="{{ old('calories_estimate', $lesson->calories_estimate) }}" min="0" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
            </div>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
            <label class="text-sm font-medium text-white/90">Видео на сервере</label>
            @if ($lesson->hasServerVideo())
                <p class="mt-2 break-all font-mono text-xs text-emerald-400/90">{{ $lesson->video_path }}</p>
                <label class="mt-3 flex items-center gap-2 text-sm text-white/80">
                    <input type="checkbox" name="remove_video_file" value="1" class="rounded border-white/20">
                    Удалить файл с сервера
                </label>
            @else
                <p class="mt-1 text-xs text-white/45">Файл не загружен.</p>
            @endif
            <p class="mt-2 text-xs text-white/45">Новый файл заменит старый. Форматы: mp4, webm, mov (до 500 МБ).</p>
            <input type="file" name="video_file" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" class="mt-3 block w-full text-sm text-white/80 file:mr-4 file:rounded-lg file:border-0 file:bg-[#869274] file:px-4 file:py-2 file:text-sm file:text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Или URL видео</label>
            <input type="text" name="video_url" value="{{ old('video_url', $lesson->video_url) }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 font-mono text-xs text-white">
        </div>
        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
            <label class="text-sm font-medium text-white/90">Обложка (превью)</label>
            @if ($lesson->cover_image_path)
                <p class="mt-2 break-all font-mono text-xs text-emerald-400/90">{{ $lesson->cover_image_path }}</p>
                <label class="mt-3 flex items-center gap-2 text-sm text-white/80">
                    <input type="checkbox" name="remove_cover_image" value="1" class="rounded border-white/20">
                    Удалить обложку
                </label>
            @else
                <p class="mt-1 text-xs text-white/45">Не загружена.</p>
            @endif
            <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-3 block w-full text-sm text-white/80 file:mr-4 file:rounded-lg file:border-0 file:bg-[#869274] file:px-4 file:py-2 file:text-sm file:text-white">
        </div>
        <div>
            <label class="text-sm text-white/70">Дата публикации видео для учеников</label>
            <input type="datetime-local" name="released_at" value="{{ old('released_at', $lesson->released_at?->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white">
            <p class="mt-1 text-xs text-white/45">Пусто = «ещё не опубликовано». Ученик увидит плеер только если дата в прошлом и есть видео (файл или URL).</p>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
            <div class="flex cursor-pointer items-center justify-between gap-4">
                <label for="lesson_is_active" class="min-w-0 cursor-pointer">
                    <span class="block text-sm font-medium text-white/90">Урок опубликован</span>
                    <span class="mt-1 block text-xs leading-snug text-white/45">Выключи — карточка у всех в кабинете в режиме «готовится»: превью и текст притушены, плашки «Скоро» и «Готовится» — оливковые. Урок остаётся в списке из 12, открывается как раньше (видео — по дате релиза и файлу).</span>
                </label>
                <label for="lesson_is_active" class="relative inline-flex h-8 w-[3.25rem] shrink-0 cursor-pointer items-center rounded-full bg-white/15 transition-colors duration-200 has-[:checked]:bg-[#869274]">
                    <input id="lesson_is_active" type="checkbox" name="is_active" value="1" @checked(old('is_active', $lesson->is_active)) class="peer sr-only">
                    <span class="pointer-events-none absolute left-1 top-1 h-6 w-6 rounded-full bg-white shadow-md transition-transform duration-200 ease-[cubic-bezier(0.33,1,0.68,1)] peer-checked:translate-x-[1.35rem]" aria-hidden="true"></span>
                </label>
            </div>
        </div>
        <label class="flex items-center gap-2 text-sm text-white/80">
            <input type="checkbox" name="is_preview_free" value="1" @checked(old('is_preview_free', $lesson->is_preview_free)) class="rounded border-white/20">
            Бесплатное превью
        </label>
        @foreach ($errors->all() as $e)
            <p class="text-sm text-red-400">{{ $e }}</p>
        @endforeach
        <button type="submit" class="rounded-full bg-[#869274] px-6 py-2.5 text-sm font-medium text-white">Сохранить</button>
    </form>
@endsection
