@extends('layouts.marketing-inner')

@section('title', 'Персональные данные — ProstoYoga')

@section('inner')
    <article class="mx-auto max-w-2xl px-5 py-16 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            <h1 class="text-3xl font-semibold tracking-tight text-[#2d312d]">Согласие на обработку персональных данных</h1>
            <p class="mt-2 text-sm text-[#7a837a]">Документ для заказчиков и пользователей: в общих чертах описывает правовую основу обработки.</p>
            <div class="mt-10 space-y-6 text-[#5c655c] leading-relaxed">
                <p>Регистрируясь на сайте ProstoYoga и/или оформляя доступ к курсу, вы подтверждаете, что ознакомлены с <a href="{{ route('pages.privacy') }}" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">политикой конфиденциальности</a> и даёте согласие на обработку персональных данных (в т.ч. имя, email, технические данные, история обращений в поддержку) способами и в целях, указанных в политике.</p>
                <p>Согласие на рассылку (если есть отдельная подписка) даётся отдельно через двойное подтверждение или галочку в форме.</p>
                <p>Согласие можно отозвать, написав на <a href="mailto:{{ $contactEmail }}" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">{{ $contactEmail }}</a>. Отзыв не влияет на законность обработки до момента отзыва.</p>
            </div>
        </div>
    </article>
@endsection
