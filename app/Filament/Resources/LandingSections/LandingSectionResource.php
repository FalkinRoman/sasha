<?php

namespace App\Filament\Resources\LandingSections;

use App\Filament\Resources\LandingSections\Pages\EditLandingSection;
use App\Filament\Resources\LandingSections\Pages\ListLandingSections;
use App\Filament\Resources\LandingSections\Schemas\LandingSectionForm;
use App\Filament\Resources\LandingSections\Tables\LandingSectionsTable;
use App\Models\LandingSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LandingSectionResource extends Resource
{
    protected static ?string $model = LandingSection::class;

    protected static ?string $navigationLabel = 'Секции лендинга';

    protected static ?string $modelLabel = 'Секция';

    protected static ?string $pluralModelLabel = 'Секции лендинга';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Лендинг';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return LandingSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LandingSectionsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLandingSections::route('/'),
            'edit' => EditLandingSection::route('/{record}/edit'),
        ];
    }
}
