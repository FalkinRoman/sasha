<?php

namespace App\Filament\Resources\SitePageBlocks\Schemas;

use App\Support\Filament\PublicDiskImageUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SitePageBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('page_key')
                            ->label('Страница (ключ)')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('key')
                            ->label('Ключ блока')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('admin_label')
                            ->label('Название в списке')
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('title')
                            ->label('Заголовок (если нужен на странице)')
                            ->maxLength(500),
                        Textarea::make('subtitle')
                            ->label('Подзаголовок под H1')
                            ->rows(2)
                            ->maxLength(2000),
                        Select::make('title_level')
                            ->label('Тип заголовка')
                            ->options([
                                'h1' => 'H1 (главный заголовок страницы)',
                                'h2' => 'H2 (раздел, без отступа сверху)',
                                'h2_spaced' => 'H2 с отступом (как следующие разделы в политике)',
                                'h2_spaced_sm' => 'H2 компактный с отступом (лендинг рефералок)',
                                'none' => 'Без заголовка (только HTML ниже)',
                            ])
                            ->required()
                            ->native(false),
                        Textarea::make('body')
                            ->label('HTML контента')
                            ->helperText('Плейсхолдер __CONTACT_EMAIL__ подставит почту из настроек. На рефералке: __COMMISSION_PERCENT__, __SUPPORT_URL__, __MARKETING_HOME__.')
                            ->rows(18)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(65535),
                        Toggle::make('is_active')
                            ->label('Вкл.')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('Иллюстрация к блоку')
                    ->description('Опционально: картинка над HTML (как на лендинге). Сохрани блок после загрузки.')
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('illustration_path')
                            ->label('Изображение')
                            ->helperText('Превью в сетке, обрезка по карандашу. На странице — скруглённый блок на всю ширину колонки.')
                            ->image()
                            ->getUploadedFileUsing(PublicDiskImageUpload::resolveUploadedFileCallback())
                            ->directory('site/blocks')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->downloadable()
                            ->openable()
                            ->panelLayout('compact')
                            ->imagePreviewHeight('8rem')
                            ->maxSize(10240)
                            ->placeholder('Перетащи файл или нажми')
                            ->nullable(),
                    ]),
            ]);
    }
}
