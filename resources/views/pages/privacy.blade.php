@extends('layouts.marketing-inner')

@section('title', 'Политика конфиденциальности — ProstoYoga')

@section('inner')
    <article class="mx-auto max-w-2xl px-5 py-16 sm:px-8 lg:px-12">
        <div data-pv-reveal class="pv-reveal pv-reveal--up">
            @foreach (\App\Models\SitePageBlock::orderedActiveForPage('privacy') as $block)
                @include('pages.partials.site-block', ['block' => $block])
            @endforeach
        </div>
    </article>
@endsection
