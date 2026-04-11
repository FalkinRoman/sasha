<?php

namespace App\Filament\Resources\SitePageBlocks;

use App\Filament\Resources\SitePageBlocks\Pages\EditSitePageBlock;
use App\Filament\Resources\SitePageBlocks\Pages\ListSitePageBlocks;
use App\Filament\Resources\SitePageBlocks\Schemas\SitePageBlockForm;
use App\Filament\Resources\SitePageBlocks\Tables\SitePageBlocksTable;
use App\Models\SitePageBlock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SitePageBlockResource extends Resource
{
    protected static ?string $model = SitePageBlock::class;

    protected static ?string $navigationLabel = 'Блоки страниц';

    protected static ?string $modelLabel = 'Блок';

    protected static ?string $pluralModelLabel = 'Блоки страницы';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return SitePageBlockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SitePageBlocksTable::configure($table);
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
            'index' => ListSitePageBlocks::route('/'),
            'edit' => EditSitePageBlock::route('/{record}/edit'),
        ];
    }
}
