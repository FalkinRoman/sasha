<?php

namespace App\Filament\Resources\LandingSections\Pages;

use App\Filament\Resources\LandingSections\LandingSectionResource;
use App\Models\LandingSection;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditLandingSection extends EditRecord
{
    protected static string $resource = LandingSectionResource::class;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected function afterFill(): void
    {
        if ($this->record->key !== 'practice_gallery') {
            return;
        }

        $paths = $this->record->gallery_paths;
        if (! is_array($paths) || $paths === []) {
            LandingSection::ensurePracticeGalleryFilesFromPublicDefaults();
            $this->record->refresh();
        }

        // Нельзя form->fill([...]) только с gallery_paths — в Filament это затирает весь state формы.
        $this->refreshFormData(['gallery_paths']);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
