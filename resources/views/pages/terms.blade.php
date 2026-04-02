@extends('layouts.marketing-inner')

@section('title', 'Публичная оферта — ProstoYoga')

@section('inner')
    <article class="mx-auto max-w-2xl px-5 py-16 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <h1 class="text-3xl font-semibold tracking-tight text-[#2d312d]">Публичная оферта</h1>
            <p class="mt-2 text-sm text-[#7a837a]">Образовательный контент онлайн. Не является медицинской услугой.</p>
            <div class="mt-10 space-y-6 text-[#5c655c] leading-relaxed">
                <h2 class="text-xl font-semibold text-[#2d312d]">1. Предмет</h2>
                <p>Исполнитель предоставляет пользователю доступ к видеоматериалам и сопутствующим материалам курса ProstoYoga на срок и на условиях выбранного тарифа.</p>
                <h2 class="mt-10 text-xl font-semibold text-[#2d312d]">2. Оплата и доступ</h2>
                <p>Доступ открывается после подтверждения оплаты платёжной системой. Срок доступа указан в описании тарифа.</p>
                <h2 class="mt-10 text-xl font-semibold text-[#2d312d]">3. Ограничение ответственности</h2>
                <p>Практика — на свой страх и риск; при заболеваниях проконсультируйтесь с врачом. Мы не гарантируем конкретный результат.</p>
                <h2 class="mt-10 text-xl font-semibold text-[#2d312d]">4. Возврат</h2>
                <p>Условия возврата регулируются законодательством РФ и договором с платёжным агрегатором. Запросы на <a href="mailto:{{ $contactEmail }}" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">{{ $contactEmail }}</a>.</p>
            </div>
        </div>
    </article>
@endsection
