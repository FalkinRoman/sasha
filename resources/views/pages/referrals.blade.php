@extends('layouts.marketing-inner')

@section('title', 'Реферальная программа — ProstoYoga')

@section('inner')
    @php
        $blockReplacements = [
            '__COMMISSION_PERCENT__' => e((string) $commissionPercent),
            '__SUPPORT_URL__' => e(route('pages.support')),
            '__MARKETING_HOME__' => e($marketingHome),
        ];
    @endphp
    <article class="mx-auto max-w-2xl px-5 py-14 sm:px-8 sm:py-16 lg:px-12">
        @foreach (\App\Models\SitePageBlock::orderedActiveForPage('referrals') as $block)
            @if ($block->key === 'intro')
                @include('pages.partials.site-block', ['block' => $block, 'blockReplacements' => $blockReplacements])
                @include('pages.partials.referrals-bonus-box')
            @elseif ($block->key === 'footer_note')
                <div class="mt-14 border-t border-[#ecece8] pt-10">
                    {!! $block->interpolateBody($blockReplacements) !!}
                    @include('pages.partials.referrals-footer-cta')
                </div>
            @else
                @include('pages.partials.site-block', ['block' => $block, 'blockReplacements' => $blockReplacements])
            @endif
        @endforeach
    </article>
@endsection
