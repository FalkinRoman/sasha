@extends('layouts.marketing-inner')

@section('title', 'Контакты — ProstoYoga')

@section('inner')
    <article class="mx-auto max-w-2xl px-5 py-16 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <h1 class="text-3xl font-semibold tracking-tight text-[#2d312d]">Контакты</h1>
            <p class="mt-6 text-lg leading-relaxed text-[#5c655c]">Связь с командой ProstoYoga — для партнёрств, СМИ и общих вопросов.</p>
            <div class="mt-10 space-y-6 rounded-2xl border border-[#e2e4df] bg-[#f9faf6] p-8 text-[#2d312d]">
                <p><span class="font-medium text-[#869274]">Общие вопросы</span><br><a href="mailto:hello@prostoyoga.ru" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">hello@prostoyoga.ru</a></p>
                <p><span class="font-medium text-[#869274]">Поддержка пользователей</span><br><a href="mailto:support@prostoyoga.ru" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">support@prostoyoga.ru</a></p>
                <p class="text-sm text-[#7a837a]">Юридический адрес и реквизиты предоставляются по запросу на hello@prostoyoga.ru.</p>
            </div>
        </div>
    </article>
@endsection
