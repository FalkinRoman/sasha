@extends('layouts.marketing')

@section('content')
    @include('partials.marketing-header')
    <main class="min-h-[50vh] bg-[#fffffa]">
        @yield('inner')
    </main>
    @include('partials.marketing-footer')
@endsection
