<?php

namespace App\Filament\Resources\LandingSections\Pages;

use App\Filament\Resources\LandingSections\LandingSectionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListLandingSections extends ListRecords
{
    protected static string $resource = LandingSectionResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;
}
