@extends('layouts.app')

@section('title', $lesson->title.' — ProstoYoga')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div data-pv-reveal class="pv-reveal pv-reveal--fade">
            <a href="{{ route('dashboard') }}" class="text-sm text-[#869274] hover:underline">← Назад к курсу</a>
        </div>
        <div data-pv-reveal class="pv-reveal pv-reveal--up mt-6" style="--rv-delay: 0.06s">
            <p class="text-xs font-medium uppercase tracking-wider text-[#869274]">Урок {{ $lesson->order_index }}</p>
            <h1 class="mt-2 text-3xl font-semibold text-[#2d312d]">{{ $lesson->title }}</h1>
            @if ($lesson->subtitle)
                <p class="mt-2 text-lg text-[#7a837a]">{{ $lesson->subtitle }}</p>
            @endif
        </div>

        @if ($lesson->hasServerVideo() || $lesson->video_url)
            @php $embedUrl = $lesson->youtubeEmbedUrl(); @endphp
            <div
                data-pv-reveal
                class="pv-reveal pv-reveal--up pv-video-reveal relative mt-8 overflow-hidden rounded-2xl p-3 shadow-[0_12px_40px_-20px_rgba(45,49,45,0.12)] sm:p-4 md:p-5"
                style="--rv-delay: 0.1s"
            >
                <div class="relative z-10">
                    @if ($lesson->hasServerVideo())
                        <div class="aspect-video overflow-hidden rounded-xl bg-[#1a1d1a] shadow-[0_12px_40px_-22px_rgba(45,49,45,0.14)]">
                            <video
                                class="h-full w-full object-contain"
                                controls
                                playsinline
                                preload="metadata"
                                src="{{ $lesson->serverVideoPublicUrl() }}"
                            >
                                В браузере нет поддержки воспроизведения этого видео.
                            </video>
                        </div>
                    @elseif ($embedUrl)
                        <div class="pv-video-frame aspect-video w-full overflow-hidden rounded-xl">
                            <iframe
                                class="absolute inset-0 z-20 hidden h-full w-full"
                                data-youtube-src="{{ $embedUrl }}"
                                src="about:blank"
                                title="Видео урока"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                            ></iframe>
                            <button
                                type="button"
                                class="absolute inset-0 z-10 flex h-full w-full cursor-pointer items-stretch justify-stretch border-0 bg-transparent p-0"
                                aria-label="Смотреть видео урока"
                                data-youtube-poster-btn
                            >
                                <img
                                    src="{{ asset('images/figma/promo.png') }}"
                                    alt=""
                                    class="pointer-events-none absolute inset-0 h-full w-full object-cover object-center"
                                    width="1200"
                                    height="675"
                                >
                                <span class="pv-video-playhint">
                                    <span class="pv-video-playhint-icon">
                                        <svg class="ml-1 h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
                                    </span>
                                </span>
                            </button>
                        </div>
                    @elseif ($lesson->video_url)
                        <div class="aspect-video overflow-hidden rounded-xl bg-[#eef0ea] shadow-[0_12px_40px_-22px_rgba(45,49,45,0.14)]">
                            <iframe src="{{ $lesson->video_url }}" class="h-full w-full" title="Видео урока" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-8 grid gap-4 rounded-2xl border border-[#dcdddb] bg-[#f6f8f1]/50 p-6 sm:grid-cols-3" style="--rv-delay: 0.08s">
            <div>
                <p class="text-xs font-medium uppercase text-[#7a837a]">Длительность</p>
                <p class="mt-1 text-lg font-semibold">{{ $lesson->duration_minutes }} мин</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-[#7a837a]">В программе курса</p>
                <p class="mt-1 text-lg font-semibold">День {{ $lesson->order_index }} из 8</p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-[#7a837a]">Доступ</p>
                <p class="mt-1 text-lg font-semibold">{{ $lesson->is_preview_free ? 'Открыт' : 'По тарифу' }}</p>
            </div>
        </div>

        <div data-pv-reveal class="prose prose-neutral pv-reveal pv-reveal--up mt-10 max-w-none text-[#2d312d]" style="--rv-delay: 0.06s">
            <h2 class="text-xl font-semibold">О уроке</h2>
            <p class="mt-4 whitespace-pre-line text-[#7a837a] leading-relaxed">{{ $lesson->body }}</p>
        </div>

        @if ($purchase?->tariff->includes_telegram)
            <div data-pv-reveal class="pv-reveal pv-reveal--fade mt-10 rounded-2xl bg-[#869274] p-6 text-[#fffffa]" style="--rv-delay: 0.08s">
                <p class="font-semibold">Мотивация в чате</p>
                <p class="mt-2 text-sm text-white/90">Поделись впечатлением в Telegram — там еженедельные чек-ины и ответы на вопросы.</p>
                <a href="https://t.me/telegram" target="_blank" rel="noopener" class="mt-4 inline-block text-sm font-medium underline">Перейти в сообщество</a>
            </div>
        @endif
    </div>
@endsection
