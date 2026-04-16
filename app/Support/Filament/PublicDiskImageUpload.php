<?php

namespace App\Support\Filament;

use Closure;
use Filament\Forms\Components\BaseFileUpload;
use League\Flysystem\UnableToCheckFileExistence;

/**
 * Настройки превью FilePond для файлов на public disk.
 *
 * — Относительный /storage/… URL, чтобы fetch() шёл на тот же origin, что и админка.
 * — Нормализация MIME: локальный диск часто отдаёт application/octet-stream → FilePond не включает image preview.
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

    public static function resolveUploadedFileCallback(): Closure
    {
        return static function (BaseFileUpload $component, string $file, string|array|null $storedFileNames): ?array {
            $storage = $component->getDisk();
            $shouldFetchFileInformation = $component->shouldFetchFileInformation();

            if ($shouldFetchFileInformation) {
                try {
                    if (! $storage->exists($file)) {
                        return null;
                    }
                } catch (UnableToCheckFileExistence) {
                    return null;
                }
            }

            $mime = $shouldFetchFileInformation ? $storage->mimeType($file) : null;
            $mime = self::normalizeImageMimeForPath($mime, $file);

            return [
                'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($file),
                'size' => $shouldFetchFileInformation ? $storage->size($file) : 0,
                'type' => $mime,
                'url' => '/storage/'.ltrim($file, '/'),
            ];
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
            $storage = $component->getDisk();
            $shouldFetchFileInformation = $component->shouldFetchFileInformation();

            if ($shouldFetchFileInformation) {
                try {
                    if (! $storage->exists($file)) {
                        return null;
                    }
                } catch (UnableToCheckFileExistence) {
                    return null;
                }
            }

            $mime = $shouldFetchFileInformation ? $storage->mimeType($file) : null;
            $mime = self::normalizeVideoMimeForPath($mime, $file);

            return [
                'name' => ($component->isMultiple() ? ($storedFileNames[$file] ?? null) : $storedFileNames) ?? basename($file),
                'size' => $shouldFetchFileInformation ? $storage->size($file) : 0,
                'type' => $mime,
                'url' => '/storage/'.ltrim($file, '/'),
            ];
        };
    }
}
