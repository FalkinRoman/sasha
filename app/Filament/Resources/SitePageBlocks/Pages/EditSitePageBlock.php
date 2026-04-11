<?php

namespace App\Filament\Resources\SitePageBlocks\Pages;

use App\Filament\Resources\SitePageBlocks\SitePageBlockResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditSitePageBlock extends EditRecord
{
    protected static string $resource = SitePageBlockResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        $base = SitePageBlockResource::getUrl('index');

        return $base.'?p='.urlencode($this->record->page_key);
    }
}
