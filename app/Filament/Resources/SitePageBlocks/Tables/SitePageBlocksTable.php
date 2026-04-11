<?php

namespace App\Filament\Resources\SitePageBlocks\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SitePageBlocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('№')
                    ->sortable(),
                TextColumn::make('admin_label')
                    ->label('Блок')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->limit(40)
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Вкл.')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
