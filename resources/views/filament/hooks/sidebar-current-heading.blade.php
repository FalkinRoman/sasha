@php
    $livewire = \Livewire\Livewire::current();
    $title = null;
    if ($livewire instanceof \Livewire\Component && method_exists($livewire, 'getTitle')) {
        $t = $livewire->getTitle();
        $title = is_string($t) ? $t : (string) $t;
    }
@endphp
@if (filled($title))
    <div class="fi-sidebar-current-heading mb-3 border-b border-gray-200 px-4 py-3 dark:border-white/10 lg:hidden">
        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-gray-500 dark:text-gray-400">Страница</p>
        <p class="mt-0.5 text-sm font-semibold leading-snug text-gray-950 dark:text-white">{{ $title }}</p>
    </div>
@endif
