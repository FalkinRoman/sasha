<?php

namespace App\Filament\Resources\LandingSections\Schemas;

use App\Models\LandingSection;
use App\Support\Filament\PublicDiskImageUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
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
                            ->helperText(fn (?LandingSection $record): ?string => $record instanceof LandingSection && $record->key === 'reviews'
                                ? 'Одна строка над тремя превью. Пример: «Три коротких видео — отзывы, которые записали ученицы».'
                                : null)
                            ->rows(3)
                            ->maxLength(2000),
                        Textarea::make('body')
                            ->label('Текст / HTML')
                            ->helperText(function (?LandingSection $record): string {
                                if ($record instanceof LandingSection && $record->key === 'practice_gallery') {
                                    return 'Текст под заголовком секции (HTML и Tailwind). Сами кадры — в блоке «Изображения» ниже.';
                                }
                                if ($record instanceof LandingSection && $record->key === 'reviews') {
                                    return 'Абзац под заголовком: про видео-отрывки и переписку ниже. Можно HTML и классы Tailwind.';
                                }

                                return 'Можно HTML и классы Tailwind, как в вёрстке лендинга.';
                            })
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
                        FileUpload::make('video_path')
                            ->label('Видеофайл (превью на главной)')
                            ->helperText(fn (): string => 'mp4 / webm / mov, макс. '.(int) config('prostoy.lesson_video_max_mb', 16384).' МБ (.env VIDEO_UPLOAD_MAX_MB). Для веба: H.264 + AAC; с iPhone лучше «наиболее совместимые», не только HEVC. Файл важнее ссылки ниже.')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->maxSize((int) config('prostoy.lesson_video_max_mb', 16384) * 1024)
                            ->getUploadedFileUsing(PublicDiskImageUpload::resolveUploadedVideoFileCallback())
                            ->directory('landing/videos')
                            ->disk('public')
                            ->visibility('public')
                            ->downloadable()
                            ->openable()
                            ->nullable()
                            ->visible(fn (?LandingSection $record): bool => $record instanceof LandingSection && $record->key === 'preview_strip'),
                        TextInput::make('video_url')
                            ->label('URL видео (YouTube или прямой .mp4)')
                            ->helperText('YouTube: watch, youtu.be или embed. Либо полный URL / путь landing/… к файлу, если не грузишь файлом выше.')
                            ->maxLength(2048)
                            ->nullable()
                            ->visible(fn (?LandingSection $record): bool => $record instanceof LandingSection && $record->key === 'preview_strip'),
                        FileUpload::make('image_path')
                            ->label('Одна картинка блока')
                            ->helperText('Только для героя, превью видео, квиза и фото автора. Форматы: PNG, JPG, WebP, GIF. Миниатюра — кликни, чтобы заменить.')
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
                Section::make('Видео-отзывы (главная)')
                    ->description('Только секция «Отзывы». Для каждого слота: обложка (или дефолт из public/images/reviw/), видеофайл или ссылка YouTube / .mp4, подпись на превью. Пока своего видео нет — на сайте по клику откроется демо-ролик (URL в config prostoy.review_tiles_placeholder_video_url или .env REVIEW_TILES_PLACEHOLDER_VIDEO_URL).')
                    ->columnSpanFull()
                    ->columns(3)
                    ->visible(fn (?LandingSection $record): bool => $record instanceof LandingSection && $record->key === 'reviews')
                    ->schema([
                        Fieldset::make('Отзыв 1')->schema(self::reviewVideoSlotFields(0))->columnSpan(1),
                        Fieldset::make('Отзыв 2')->schema(self::reviewVideoSlotFields(1))->columnSpan(1),
                        Fieldset::make('Отзыв 3')->schema(self::reviewVideoSlotFields(2))->columnSpan(1),
                    ]),
            ]);
    }

    /**
     * @return list<FileUpload|TextInput>
     */
    private static function reviewVideoSlotFields(int $index): array
    {
        $maxKb = (int) config('prostoy.lesson_video_max_mb', 16384) * 1024;
        $base = 'review_video_slots.'.$index;

        return [
            FileUpload::make($base.'.poster_path')
                ->label('Обложка')
                ->helperText('Необязательно — иначе дефолт из public/images/reviw/')
                ->image()
                ->getUploadedFileUsing(PublicDiskImageUpload::resolveUploadedFileCallback())
                ->directory('landing/reviews/posters')
                ->disk('public')
                ->visibility('public')
                ->imageEditor()
                ->downloadable()
                ->openable()
                ->panelLayout('compact')
                ->imagePreviewHeight('3.5rem')
                ->nullable(),
            FileUpload::make($base.'.video_path')
                ->label('Видеофайл')
                ->helperText('mp4 / webm / mov; для плеера в браузере — H.264 + AAC')
                ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                ->maxSize($maxKb)
                ->getUploadedFileUsing(PublicDiskImageUpload::resolveUploadedVideoFileCallback())
                ->directory('landing/reviews/videos')
                ->disk('public')
                ->visibility('public')
                ->downloadable()
                ->openable()
                ->nullable(),
            TextInput::make($base.'.video_url')
                ->label('Ссылка на видео')
                ->helperText('YouTube или прямой URL к .mp4, если файл не грузишь выше')
                ->maxLength(2048)
                ->nullable(),
            TextInput::make($base.'.caption')
                ->label('Подпись под превью')
                ->helperText('Имя, город или одна короткая фраза — на сайте мелким текстом под плиткой.')
                ->maxLength(120)
                ->nullable(),
        ];
    }
}
