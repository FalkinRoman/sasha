@extends('layouts.admin')

@section('title', 'Уроки — админка')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-semibold text-white">Уроки (видео)</h1>
        <a href="{{ route('admin.lessons.create') }}" class="inline-flex rounded-full bg-[#869274] px-5 py-2 text-sm font-medium text-white">Новый урок</a>
    </div>
    @if (session('ok'))
        <p class="mt-4 text-sm text-emerald-400">{{ session('ok') }}</p>
    @endif
    <div class="mt-8 overflow-x-auto rounded-2xl border border-white/10">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="border-b border-white/10 bg-white/5 text-xs uppercase text-white/50">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Курс</th>
                    <th class="px-4 py-3">Название</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Видео</th>
                    <th class="px-4 py-3">Релиз</th>
                    <th class="px-4 py-3">Превью</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($lessons as $lesson)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-4 py-3 text-white/50">{{ $lesson->order_index }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-white/60">{{ $lesson->course_slug }}</td>
                        <td class="px-4 py-3">{{ $lesson->title }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $lesson->slug }}</td>
                        <td class="px-4 py-3 text-white/60">
                            @if ($lesson->hasServerVideo())
                                файл
                            @elseif ($lesson->youtubeVideoId())
                                YouTube
                            @elseif ($lesson->video_url)
                                URL
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-white/60">
                            @if ($lesson->released_at && $lesson->released_at->isPast())
                                {{ $lesson->released_at->format('d.m.Y H:i') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $lesson->is_preview_free ? 'да' : '—' }}</td>
                        <td class="px-4 py-3 text-xs">
                            @if ($lesson->is_active)
                                <span class="text-emerald-400/90">Опубликован</span>
                            @else
                                <span class="text-amber-200/80">Готовится</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="{{ route('admin.lessons.edit', $lesson) }}" class="text-[#869274] hover:underline">Изменить</a>
                            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="post" class="ml-3 inline" onsubmit="return confirm('Удалить урок?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400/90 hover:underline">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
