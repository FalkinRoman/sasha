<?php

namespace App\Filament\Resources\SitePageBlocks\Pages;

use App\Filament\Resources\SitePageBlocks\SitePageBlockResource;
use App\Models\SitePageBlock;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;

class ListSitePageBlocks extends ListRecords
{
    protected static string $resource = SitePageBlockResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    #[Url(as: 'p')]
    public string $pageKey = 'support';

    public function mount(): void
    {
        if (! in_array($this->pageKey, SitePageBlock::PAGE_KEYS, true)) {
            abort(404);
        }

        parent::mount();
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->where('page_key', $this->pageKey);
    }

    public function getTitle(): string|Htmlable
    {
        return match ($this->pageKey) {
            'support' => 'Поддержка — блоки страницы',
            'contacts' => 'Контакты — блоки страницы',
            'privacy' => 'Политика конфиденциальности — блоки',
            'personal_data' => 'Персональные данные — блоки',
            'terms' => 'Публичная оферта — блоки',
            'referrals' => 'Реферальная программа (лендинг) — блоки',
            default => 'Блоки страницы',
        };
    }
}
