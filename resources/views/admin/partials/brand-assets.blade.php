@php
    $btnClass = 'inline-flex flex-1 min-w-[7.5rem] items-center justify-center rounded-full border border-[#869274]/45 bg-[#869274]/15 px-3 py-2 text-xs font-semibold text-[#c5d4b8] transition hover:border-[#869274] hover:bg-[#869274]/25 hover:text-white';
    $items = [
        [
            'title' => 'Favicon (PY)',
            'hint' => 'Как favicon.svg: Montserrat 700, P #0f0f0f, Y #c8e650, белый фон, rx 14. PNG — для писем, превью, где SVG неудобен.',
            'preview' => asset('favicon.svg'),
            'previewPad' => 'bg-white p-4 rounded-xl',
            'downloads' => [
                ['href' => asset('favicon.svg'), 'filename' => 'prostoyoga-favicon.svg', 'label' => 'SVG'],
                ['href' => asset('brand/favicon-py-64.png'), 'filename' => 'prostoyoga-favicon-py-64.png', 'label' => 'PNG 64'],
                ['href' => asset('brand/favicon-py-128.png'), 'filename' => 'prostoyoga-favicon-py-128.png', 'label' => 'PNG 128'],
                ['href' => asset('brand/favicon-py-256.png'), 'filename' => 'prostoyoga-favicon-py-256.png', 'label' => 'PNG 256'],
                ['href' => asset('brand/favicon-py-512.png'), 'filename' => 'prostoyoga-favicon-py-512.png', 'label' => 'PNG 512'],
            ],
        ],
        [
            'title' => 'Знак «лотос»',
            'hint' => 'Прозрачный фон · иконка, как на заставке',
            'preview' => asset('brand/lotus-symbol.svg'),
            'previewPad' => 'bg-[#2a2d2a] p-4 rounded-xl',
            'downloads' => [
                ['href' => asset('brand/lotus-symbol.svg'), 'filename' => 'prostoyoga-lotus.svg', 'label' => 'SVG'],
            ],
        ],
        [
            'title' => 'Логотип — компакт',
            'hint' => '~252×52 · шапка, мобильные баннеры',
            'preview' => asset('brand/wordmark-s.svg'),
            'previewPad' => 'bg-[#2a2d2a] p-4 rounded-xl',
            'downloads' => [
                ['href' => asset('brand/wordmark-s.svg'), 'filename' => 'prostoyoga-wordmark-compact.svg', 'label' => 'SVG'],
            ],
        ],
        [
            'title' => 'Логотип — средний',
            'hint' => '~440×88 · презентации, документы',
            'preview' => asset('brand/wordmark-m.svg'),
            'previewPad' => 'bg-[#2a2d2a] p-4 rounded-xl',
            'downloads' => [
                ['href' => asset('brand/wordmark-m.svg'), 'filename' => 'prostoyoga-wordmark-medium.svg', 'label' => 'SVG'],
            ],
        ],
        [
            'title' => 'Логотип — крупный',
            'hint' => '~880×168 · печать, крупные носители',
            'preview' => asset('brand/wordmark-l.svg'),
            'previewPad' => 'bg-[#2a2d2d] p-3 rounded-xl overflow-hidden',
            'downloads' => [
                ['href' => asset('brand/wordmark-l.svg'), 'filename' => 'prostoyoga-wordmark-large.svg', 'label' => 'SVG'],
            ],
        ],
        [
            'title' => 'Для писем (Mail, рассылки)',
            'hint' => 'Фон #fffffa · Montserrat 600. В письмах вставляй PNG (клиенты часто режут SVG). 1920×600 — запас по чёткости на ретине.',
            'preview' => asset('brand/wordmark-email.svg'),
            'previewPad' => 'bg-[#e8e8e4] p-2 rounded-xl',
            'downloads' => [
                ['href' => asset('brand/wordmark-email.svg'), 'filename' => 'prostoyoga-wordmark-email-640.svg', 'label' => 'SVG 640×200'],
                ['href' => asset('brand/wordmark-email-1280.png'), 'filename' => 'prostoyoga-wordmark-email-1280.png', 'label' => 'PNG 1280×400'],
                ['href' => asset('brand/wordmark-email-1920.png'), 'filename' => 'prostoyoga-wordmark-email-1920.png', 'label' => 'PNG 1920×600'],
            ],
        ],
    ];
@endphp

<div class="mt-10 max-w-5xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 sm:p-8">
    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#a4b092]">Логотип и файлы бренда</p>
    <p class="mt-3 max-w-3xl text-sm leading-relaxed text-white/65">
        Фавикон — монограмма <strong class="text-white/90">PY</strong> (чёрная + салатовая). Полное <strong class="text-white/90">Prosto.Yoga</strong> — Montserrat 600, салатовая #c8e650, тёмный текст #0f0f0f. Для e-mail лучше прикреплять/вставлять <strong class="text-white/90">PNG</strong> (ниже), в шаблоне задай ширину картинки ~600px — файл даст запас по плотности пикселей.
    </p>

    <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($items as $row)
            <div class="flex flex-col rounded-2xl border border-white/[0.08] bg-black/20 p-4 transition hover:border-[#869274]/35">
                <div class="flex min-h-[7.5rem] items-center justify-center {{ $row['previewPad'] }}">
                    <img src="{{ $row['preview'] }}" alt="" class="max-h-20 max-w-full object-contain" loading="lazy" decoding="async">
                </div>
                <p class="mt-4 text-sm font-semibold text-white/95">{{ $row['title'] }}</p>
                <p class="mt-1 text-xs leading-snug text-white/45">{{ $row['hint'] }}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($row['downloads'] as $dl)
                        <a
                            href="{{ $dl['href'] }}"
                            download="{{ $dl['filename'] }}"
                            class="{{ $btnClass }}"
                        >
                            {{ $dl['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <p class="mt-6 text-xs text-white/35">Пересборка PNG: <code class="rounded bg-black/30 px-1.5 py-0.5 text-white/60">npm run brand:png</code> (favicon PY + логотип для писем) или по отдельности <code class="rounded bg-black/30 px-1 py-0.5 text-white/60">brand:favicon-png</code> / <code class="rounded bg-black/30 px-1 py-0.5 text-white/60">brand:email-png</code>.</p>
</div>
