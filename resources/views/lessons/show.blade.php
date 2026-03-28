@extends('layouts.app')

@section('title', $lesson->title.' — ProstoYoga')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('dashboard') }}" class="text-sm text-[#869274] hover:underline">← Назад к курсу</a>
        <p class="mt-6 text-xs font-medium uppercase tracking-wider text-[#869274]">Урок {{ $lesson->order_index }}</p>
        <h1 class="mt-2 text-3xl font-semibold text-[#2d312d]">{{ $lesson->title }}</h1>
        @if ($lesson->subtitle)
            <p class="mt-2 text-lg text-[#7a837a]">{{ $lesson->subtitle }}</p>
        @endif

        <div class="mt-8 aspect-video overflow-hidden rounded-2xl bg-black shadow-xl">
            @if ($lesson->video_url)
                <iframe src="{{ $lesson->video_url }}" class="h-full w-full" title="Видео урока" allowfullscreen></iframe>
            @endif
        </div>

        <div class="mt-8 grid gap-4 rounded-2xl border border-[#dcdddb] bg-[#f6f8f1]/50 p-6 sm:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase text-[#7a837a]">Длительность</p>
                <p class="mt-1 text-lg font-semibold">{{ $lesson->duration_minutes }} мин</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-[#7a837a]">Ккал (оценка)</p>
                <p class="mt-1 text-lg font-semibold">{{ $lesson->calories_estimate ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-[#7a837a]">Доступ</p>
                <p class="mt-1 text-lg font-semibold">{{ $lesson->is_preview_free ? 'Открыт' : 'По тарифу' }}</p>
            </div>
        </div>

        <div class="prose prose-neutral mt-10 max-w-none text-[#2d312d]">
            <h2 class="text-xl font-semibold">О уроке</h2>
            <p class="mt-4 whitespace-pre-line text-[#7a837a] leading-relaxed">{{ $lesson->body }}</p>
        </div>

        @if ($purchase?->tariff->includes_telegram)
            <div class="mt-10 rounded-2xl bg-[#869274] p-6 text-[#fffffa]">
                <p class="font-semibold">Мотивация в чате</p>
                <p class="mt-2 text-sm text-white/90">Поделись впечатлением в Telegram — там еженедельные чек-ины и ответы на вопросы.</p>
                <a href="https://t.me/telegram" target="_blank" rel="noopener" class="mt-4 inline-block text-sm font-medium underline">Перейти в сообщество</a>
            </div>
        @endif
    </div>
@endsection
