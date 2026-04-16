<?php

namespace App\Support\Filament;

use Closure;
use Filament\Forms\Components\BaseFileUpload;
use League\Flysystem\UnableToCheckFileExistence;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Throwable;

/**
 * Превью FilePond для FileUpload на public disk.
 *
 * — После сохранения: файл на public → URL `/storage/…` (тот же origin).
 * — До сохранения: файл во временном диске Livewire → signed `livewire.preview-file`, иначе Filament пишет «Не удалось загрузить» (это не запрет PNG).
 * — Нормализация MIME с диска (octet-stream → по расширению).
 */
final class PublicDiskImageUpload
{
    public static function normalizeImageMimeForPath(?string $mime, string $relativePath): ?string
    {
        if ($mime !== null && str_starts_with($mime, 'image/')) {
            return $mime;
        }

        return match (strtolower(pathinfo($relativePath, PATHINFO_EXTENSION))) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'avif' => 'image/avif',
            default => $mime,
        };
    }

    /**
     * Состояние Livewire может быть `livewire-file:&lt;имя&gt;` — обрезаем префикс для createFromLivewire().
     */
    public static function stripLivewireFilePrefix(string $file): string
    {
        if (str_starts_with($file, 'livewire-file:')) {
            return substr($file, strlen('livewire-file:'));
        }

        return $file;
    }

    public static function resolveUploadedFileCallback(): Closure
    {
        return static function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
            $publicDisk = $component->getDisk();
            $shouldFetchFileInformation = $component->shouldFetchFileInformation();
            $fileKey = self::stripLivewireFilePrefix($file);

            if ($shouldFetchFileInformation) {
                try {
                    if ($publicDisk->exists($fileKey)) {
                        $mime = $publicDisk->mimeType($fileKey);
                        $mime = self::normalizeImageMimeForPath($mime, $fileKey);

                        return [
                            'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($fileKey),
                            'size' => $publicDisk->size($fileKey),
                            'type' => $mime,
                            'url' => '/storage/'.ltrim($fileKey, '/'),
                        ];
                    }
                } catch (UnableToCheckFileExistence) {
                    // пробуем временный Livewire
                }
            }

            try {
                $tmp = TemporaryUploadedFile::createFromLivewire($fileKey);
                if ($tmp->exists()) {
                    return [
                        'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? $tmp->getClientOriginalName(),
                        'size' => $tmp->getSize(),
                        'type' => self::normalizeImageMimeForPath($tmp->getMimeType(), $fileKey),
                        'url' => $tmp->temporaryUrl(),
                    ];
                }
            } catch (Throwable) {
                // не временный файл
            }

            return null;
        };
    }

    public static function normalizeVideoMimeForPath(?string $mime, string $relativePath): ?string
    {
        if ($mime !== null && str_starts_with($mime, 'video/')) {
            return $mime;
        }

        return match (strtolower(pathinfo($relativePath, PATHINFO_EXTENSION))) {
            'mp4' => 'video/mp4',
            'webm' => 'video/webm',
            'mov' => 'video/quicktime',
            default => $mime,
        };
    }

    public static function resolveUploadedVideoFileCallback(): Closure
    {
        return static function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
            $publicDisk = $component->getDisk();
            $shouldFetchFileInformation = $component->shouldFetchFileInformation();
            $fileKey = self::stripLivewireFilePrefix($file);

            if ($shouldFetchFileInformation) {
                try {
                    if ($publicDisk->exists($fileKey)) {
                        $mime = $publicDisk->mimeType($fileKey);
                        $mime = self::normalizeVideoMimeForPath($mime, $fileKey);

                        return [
                            'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($fileKey),
                            'size' => $publicDisk->size($fileKey),
                            'type' => $mime,
                            'url' => '/storage/'.ltrim($fileKey, '/'),
                        ];
                    }
                } catch (UnableToCheckFileExistence) {
                    // временный Livewire
                }
            }

            try {
                $tmp = TemporaryUploadedFile::createFromLivewire($fileKey);
                if ($tmp->exists()) {
                    return [
                        'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? $tmp->getClientOriginalName(),
                        'size' => $tmp->getSize(),
                        'type' => self::normalizeVideoMimeForPath($tmp->getMimeType(), $fileKey),
                        'url' => $tmp->temporaryUrl(),
                    ];
                }
            } catch (Throwable) {
                // не временный файл
            }

            return null;
        };
    }
}
