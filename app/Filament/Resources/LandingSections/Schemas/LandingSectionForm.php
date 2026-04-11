<?php

namespace App\Filament\Resources\LandingSections\Schemas;

use App\Models\LandingSection;
use App\Support\Filament\PublicDiskImageUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LandingSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Тексты')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('key')
                            ->label('Ключ')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('admin_label')
                            ->label('Название в списке')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('title')
                            ->label('Заголовок (title / h1-h2)')
                            ->maxLength(500),
                        Textarea::make('subtitle')
                            ->label('Подзаголовок / лейбл')
                            ->rows(3)
                            ->maxLength(2000),
                        Textarea::make('body')
                            ->label('Текст / HTML')
                            ->helperText(fn (?LandingSection $record): string => $record instanceof LandingSection && $record->key === 'practice_gallery'
                                ? 'Текст под заголовком секции (HTML и Tailwind). Сами кадры — в блоке «Изображения» ниже.'
                                : 'Можно HTML и классы Tailwind, как в вёрстке лендинга.')
                            ->rows(18)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(65535),
                        Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('Изображения')
                    ->description('Сохрани запись, чтобы изменения попали на сайт. Для галереи — перетаскивание кадров за иконку сортировки.')
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('Одна картинка блока')
                            ->helperText('Только для героя, превью видео, квиза и фото автора. Миниатюра — кликни, чтобы заменить.')
                            ->image()
                            ->getUploadedFileUsing(PublicDiskImageUpload::resolveUploadedFileCallback())
                            ->directory('landing')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->downloadable()
                            ->openable()
                            ->panelLayout('compact')
                            ->imagePreviewHeight('4.5rem')
                            ->placeholder('Нажми или перетащи файл')
                            ->nullable()
                            ->visible(fn (?LandingSection $record): bool => $record instanceof LandingSection && $record->usesSingleImageOnWebsite()),
                        FileUpload::make('gallery_paths')
                            ->label('Галерея «Горящие глаза»')
                            ->helperText('Несколько файлов за раз, обрезка по клику на карандаш. На сайте последний кадр показывается только на больших экранах.')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->image()
                            ->imageEditor()
                            ->downloadable()
                            ->openable()
                            ->getUploadedFileUsing(PublicDiskImageUpload::resolveUploadedFileCallback())
                            ->disk('public')
                            ->directory('landing/gallery')
                            ->visibility('public')
                            ->panelLayout('grid')
                            ->itemPanelAspectRatio('1')
                            ->imagePreviewHeight('7.5rem')
                            ->maxFiles(24)
                            ->maxSize(10240)
                            ->placeholder('Перетащи фото сюда или нажми для выбора')
                            ->nullable()
                            ->visible(fn (?LandingSection $record): bool => $record instanceof LandingSection && $record->key === 'practice_gallery'),
                    ]),
            ]);
    }
}
