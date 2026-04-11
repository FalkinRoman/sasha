@php
    /** @var \App\Models\SitePageBlock $block */
    $level = $block->title_level ?? 'h2';
    $extra = $blockReplacements ?? [];
@endphp
@if (filled($block->title) && $level !== 'none')
    @if ($level === 'h1')
        <h1 class="text-3xl font-semibold tracking-tight text-[#2d312d]">{{ $block->title }}</h1>
    @elseif ($level === 'h2_spaced')
        <h2 class="mt-10 text-xl font-semibold text-[#2d312d]">{{ $block->title }}</h2>
    @elseif ($level === 'h2_spaced_sm')
        <h2 class="mt-10 text-lg font-semibold text-[#2d312d]">{{ $block->title }}</h2>
    @elseif ($level === 'h2')
        <h2 class="text-xl font-semibold text-[#2d312d]">{{ $block->title }}</h2>
    @else
        <h2 class="text-xl font-semibold text-[#2d312d]">{{ $block->title }}</h2>
    @endif
@endif
@if (filled($block->subtitle))
    <p class="mt-2 text-sm text-[#7a837a]">{{ str_replace('__CURRENT_YEAR__', (string) now()->year, $block->subtitle) }}</p>
@endif
@php
    $illustrationUrl = $block->illustrationPublicUrl();
@endphp
@if (filled($illustrationUrl))
    @php
        $illTop = match (true) {
            filled($block->title) && ($block->title_level ?? 'h2') !== 'none' => 'mt-6',
            filled($block->subtitle) => 'mt-6',
            default => 'mt-0',
        };
    @endphp
    <figure class="{{ $illTop }} m-0 overflow-hidden rounded-2xl border border-[#e2e4df] bg-[#f9faf6] shadow-sm">
        <img
            src="{{ $illustrationUrl }}"
            alt=""
            class="block max-h-[min(28rem,70vh)] w-full object-cover object-center"
            loading="lazy"
            decoding="async"
        >
    </figure>
@endif
@if (filled($block->body))
    @php
        $bodyTop = match (true) {
            $level === 'h1' && filled($block->subtitle) => 'mt-10',
            $level === 'h1' && ! filled($block->subtitle) => 'mt-6',
            in_array($level, ['h2', 'h2_spaced', 'h2_spaced_sm'], true) => 'mt-6',
            $level === 'none' && ! filled($block->title) => 'mt-0',
            default => 'mt-4',
        };
    @endphp
    <div class="{{ $bodyTop }} space-y-6 text-[#5c655c] leading-relaxed [&_a]:text-[#869274] [&_a]:underline [&_a]:underline-offset-2 [&_a]:hover:text-[#2d312d]">
        {!! $block->interpolateBody($extra) !!}
    </div>
@endif
