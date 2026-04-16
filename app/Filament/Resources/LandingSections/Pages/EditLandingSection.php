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

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (($data['key'] ?? null) === 'reviews') {
            $data['review_video_slots'] = LandingSection::normalizeReviewVideoSlotsForStorage(
                $data['review_video_slots'] ?? []
            );
        }

        return $data;
    }

    protected function afterFill(): void
    {
        if ($this->record->key === 'practice_gallery') {
            $paths = $this->record->gallery_paths;
            if (! is_array($paths) || $paths === []) {
                LandingSection::ensurePracticeGalleryFilesFromPublicDefaults();
                $this->record->refresh();
            }

            // Нельзя form->fill([...]) только с gallery_paths — в Filament это затирает весь state формы.
            $this->refreshFormData(['gallery_paths']);

            return;
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
