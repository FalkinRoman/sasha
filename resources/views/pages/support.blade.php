@extends('layouts.marketing-inner')

@section('title', 'Поддержка — ProstoYoga')

@section('inner')
    <article class="mx-auto max-w-2xl px-5 py-16 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <h1 class="text-3xl font-semibold tracking-tight text-[#2d312d]">Поддержка</h1>
            <p class="mt-6 text-lg leading-relaxed text-[#5c655c]">Мы рядом, если вопрос по доступу, оплате или технике. Пиши удобным способом — ответим в порядке очереди.</p>
            <ul class="mt-10 space-y-4 text-[#2d312d]">
                <li><strong class="text-[#869274]">Email:</strong> <a href="mailto:{{ $contactEmail }}" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">{{ $contactEmail }}</a></li>
                <li><strong class="text-[#869274]">Telegram:</strong> <a href="https://t.me/sasha_vikh" target="_blank" rel="noopener" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">@sasha_vikh</a> (будни, 10:00–19:00 МСК)</li>
            </ul>
            <p class="mt-10 text-sm leading-relaxed text-[#7a837a]">В письме укажи email аккаунта и кратко суть проблемы — так мы быстрее найдём твой доступ.</p>
        </div>
    </article>
@endsection
