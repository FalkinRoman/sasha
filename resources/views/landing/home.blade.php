@extends('layouts.marketing')

@section('title', 'PROSTO.YOGA — всё на самом деле просто')

@section('canonical', route('home'))

@section('meta_description', 'PROSTO.YOGA — 12 практик онлайн, 3 раза в неделю. За 30 дней: осанка, тело, энергия. Предпродажа со скидкой, бесплатный урок после регистрации.')

@section('content')
    @include('partials.splash-intro')
    @include('partials.marketing-header')

    @include('landing.partials.hero')
    @include('landing.partials.results-30')
    @include('landing.partials.practice-gallery')
    @include('landing.partials.preview-strip')
    @include('landing.partials.quiz')
    @include('landing.partials.author')
    @include('landing.partials.why-simple')
    @include('landing.partials.program-12')
    @include('landing.partials.surprise')
    @include('landing.partials.tariffs-landing')
    @include('landing.partials.reviews')
    @include('landing.partials.partners')
    @include('landing.partials.final-cta')

    @include('partials.marketing-footer')
@endsection
