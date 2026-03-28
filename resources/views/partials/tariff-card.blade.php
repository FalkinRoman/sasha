@php
    /** @var string $icon */
    /** @var string $title */
    /** @var string $bg */
    /** @var array<int, array{label: string, per: string, block: string}> $rows */
@endphp
<article class="flex flex-col rounded-2xl {{ $bg }} p-6 shadow-[0_4px_24px_rgba(45,49,45,0.06)] md:p-8">
    <div class="flex items-start gap-4">
        <img src="{{ asset('images/figma/'.$icon) }}" alt="" class="h-12 w-12 shrink-0" width="48" height="48">
        <h3 class="text-base font-semibold text-[#2d312d]">{{ $title }}</h3>
    </div>
    <div class="mt-4 inline-flex max-w-full rounded-full bg-[#eaf3dd] px-3 py-2 text-[13px] text-[#2d312d]">
        Пробная тренировка -50%
    </div>

    <div class="mt-6 w-full overflow-x-auto">
        <table class="w-full min-w-[260px] border-collapse text-[13px]">
            <thead>
                <tr class="border-b border-[#ededed] text-[#7a837a]">
                    <th class="pb-2 text-left font-normal"></th>
                    <th class="pb-2 text-right font-normal underline decoration-[#7a837a]/40 underline-offset-4">Занятие</th>
                    <th class="pb-2 text-right font-normal underline decoration-[#7a837a]/40 underline-offset-4">Блок</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr class="border-b border-[#dadada]">
                        <td class="py-3 font-semibold text-[#2d312d]">{{ $row['label'] }}</td>
                        <td class="py-3 text-right text-[#2d312d]">{{ $row['per'] }}</td>
                        <td class="py-3 text-right text-[#2d312d]">{{ $row['block'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-6 text-[13px] leading-relaxed text-[#2d312d]">
        <span class="block text-[#2d312d]/80">Срок действия</span>
        <span class="font-medium">Блок 5/10/15</span> — <span class="font-medium">45/60/75 дней</span>
    </p>

    <a
        href="#lead-form"
        class="mt-6 inline-flex w-full items-center justify-center rounded-[1.875rem] bg-[#2d312d] py-[0.85rem] text-[13px] font-normal text-[#fffffa] transition hover:bg-black/85"
    >
        Записаться на тренировку
    </a>
</article>
