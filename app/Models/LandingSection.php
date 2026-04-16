<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class LandingSection extends Model
{
    /** Массивы в кэше, не сериализованные модели — иначе после деплоя/OPcache бывает __PHP_Incomplete_Class. */
    public const CACHE_KEY = 'landing_sections_map_v3';

    /** Дефолтные постеры видео-отзывов (public/), по порядку слотов 1–3. */
    public const REVIEW_VIDEO_DEFAULT_POSTERS = [
        'images/reviw/1.webp',
        'images/reviw/2.webp',
        'images/reviw/3.webp',
    ];

    /** Ключи секций, у которых на главной реально выводится одна картинка из админки. */
    public const KEYS_SINGLE_SITE_IMAGE = ['hero', 'preview_strip', 'quiz', 'author'];

    /**
     * Порядок файлов галереи «Горящие глаза» (как на лендинге). Последний — только desktop.
     *
     * @var list<string>
     */
    public const PRACTICE_GALLERY_FILENAMES = [
        'after-practice-01-tall-studio.png',
        'after-practice-02-narrow-stretch.png',
        'after-practice-03-square-calm.png',
        'after-practice-04-portrait-flow.png',
        'after-practice-05-portrait-soft.png',
        'after-practice-06-square-center.png',
        'after-practice-07-tall-radiant.png',
        'after-practice-08-vertical-exhale.png',
        'after-practice-09-portrait-glow.png',
    ];

    /**
     * @var array<string, array{0: int, 1: int, 2: string}>
     */
    protected static array $practiceGalleryMetaByFilename = [
        'after-practice-01-tall-studio.png' => [732, 824, 'После практики в студии: собранность и мягкий взгляд'],
        'after-practice-02-narrow-stretch.png' => [312, 554, 'Растяжение и выдох — узкий кадр с занятия'],
        'after-practice-03-square-calm.png' => [412, 438, 'Спокойное состояние после асан'],
        'after-practice-04-portrait-flow.png' => [358, 498, 'Поток практики: портрет участницы'],
        'after-practice-05-portrait-soft.png' => [356, 490, 'Мягкое лицо после тренировки'],
        'after-practice-06-square-center.png' => [414, 426, 'Центр, дыхание, ровный кадр'],
        'after-practice-07-tall-radiant.png' => [616, 802, 'Высокий кадр: энергия после занятия'],
        'after-practice-08-vertical-exhale.png' => [410, 624, 'Вертикальный кадр: лёгкость после выдоха'],
        'after-practice-09-portrait-glow.png' => [444, 544, 'Тепло и улыбка после сессии'],
    ];

    /**
     * Публичные пути относительно public/ — если в БД нет своих файлов.
     *
     * @var array<string, string>
     */
    protected static array $defaultSingleImageByKey = [
        'hero' => 'images/figma/decstop.webp',
        'results_30' => 'images/figma/1.png',
        'practice_gallery' => 'images/smile/after-practice-01-tall-studio.png',
        'practice_gallery_footer' => 'images/smile/after-practice-03-square-calm.png',
        'preview_strip' => 'images/figma/promo.png',
        'quiz' => 'images/figma/quiz.png',
        'author' => 'images/figma/yoga-second.png',
        'author_strip_caption' => 'images/figma/resume1.png',
        'reviews' => 'images/figma/promo.png',
    ];

    public static function defaultPreviewPathForKey(string $key): ?string
    {
        return static::$defaultSingleImageByKey[$key] ?? null;
    }

    protected $fillable = [
        'key',
        'admin_label',
        'title',
        'subtitle',
        'body',
        'image_path',
        'video_url',
        'video_path',
        'gallery_paths',
        'review_video_slots',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'gallery_paths' => 'array',
            'review_video_slots' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(static function (LandingSection $section): void {
            if ($section->key === 'reviews' && is_array($section->review_video_slots)) {
                $section->review_video_slots = self::normalizeReviewVideoSlotsForStorage($section->review_video_slots);
            }
        });
        static::saved(static fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(static fn () => Cache::forget(self::CACHE_KEY));
    }

    /**
     * Копирует дефолтные снимки из public/images/smile в storage и прописывает gallery_paths у practice_gallery (если пусто).
     */
    public static function ensurePracticeGalleryFilesFromPublicDefaults(): void
    {
        $section = static::query()->where('key', 'practice_gallery')->first();
        if (! $section) {
            return;
        }

        $existing = $section->gallery_paths;
        if (is_array($existing) && $existing !== []) {
            return;
        }

        $paths = [];
        foreach (self::PRACTICE_GALLERY_FILENAMES as $name) {
            $from = public_path('images/smile/'.$name);
            if (! is_file($from)) {
                continue;
            }
            $dest = 'landing/gallery/'.$name;
            Storage::disk('public')->put($dest, file_get_contents($from));
            $paths[] = $dest;
        }

        if ($paths === []) {
            return;
        }

        $section->gallery_paths = $paths;
        $section->save();
    }

    /**
     * @return Collection<string, self>
     */
    public static function mapForView(): Collection
    {
        /** @var array<string, array<string, mixed>> $rows */
        $rows = Cache::rememberForever(self::CACHE_KEY, function (): array {
            return static::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->keyBy('key')
                ->map(fn (self $section) => $section->getAttributes())
                ->all();
        });

        return collect($rows)->map(
            fn (array $attributes) => (new static)->newFromBuilder($attributes)
        );
    }

    public static function bustCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function imagePublicUrl(): ?string
    {
        if ($this->image_path === null || $this->image_path === '') {
            return null;
        }

        return static::publicUrlForStoredOrAssetPath($this->image_path);
    }

    public static function publicUrlForStoredOrAssetPath(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    public function usesSingleImageOnWebsite(): bool
    {
        $key = $this->key;

        return is_string($key) && in_array($key, self::KEYS_SINGLE_SITE_IMAGE, true);
    }

    /** URL одной картинки блока: загрузка из админки или дефолт из public. */
    public function displaySingleImageUrl(): ?string
    {
        $uploaded = $this->imagePublicUrl();
        if ($uploaded !== null) {
            return $uploaded;
        }

        $key = $this->key;
        if (! is_string($key) || $key === '') {
            return null;
        }
        $rel = static::$defaultSingleImageByKey[$key] ?? null;

        return $rel !== null ? asset($rel) : null;
    }

    /**
     * @return list<array{src: string, w: int, h: int, alt: string, desktop_only: bool}>
     */
    public function gallerySlidesForView(): array
    {
        if ($this->key !== 'practice_gallery') {
            return [];
        }

        $paths = is_array($this->gallery_paths) ? array_values(array_filter($this->gallery_paths)) : [];
        if ($paths === []) {
            foreach (self::PRACTICE_GALLERY_FILENAMES as $name) {
                $paths[] = 'images/smile/'.$name;
            }
        }

        $out = [];
        foreach ($paths as $i => $path) {
            $base = basename($path);
            $meta = self::$practiceGalleryMetaByFilename[$base] ?? [400, 500, 'Галерея практики'];
            $out[] = [
                'src' => static::publicUrlForStoredOrAssetPath($path),
                'w' => $meta[0],
                'h' => $meta[1],
                'alt' => $meta[2],
                'desktop_only' => $i === count($paths) - 1,
            ];
        }

        return $out;
    }

    /** @deprecated оставлено для совместимости; для UI превью больше не используется */
    public function previewThumbUrl(): ?string
    {
        return $this->displaySingleImageUrl();
    }

    /** YouTube watch / youtu.be / embed → URL для iframe. */
    public static function youtubeEmbedUrlFromString(string $u): ?string
    {
        $u = trim($u);
        if ($u === '') {
            return null;
        }
        if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $u, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }
        if (preg_match('#[?&]v=([a-zA-Z0-9_-]{11})#', $u, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }
        if (preg_match('#youtube\.com/embed/([a-zA-Z0-9_-]{11})#', $u, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }

        return null;
    }

    public static function pathOrUrlLooksLikeDirectVideo(string $u): bool
    {
        $u = strtolower(trim($u));

        return $u !== '' && (bool) preg_match('#\.(mp4|webm|mov)(\?|#|$)#', $u);
    }

    /**
     * Для секции preview_strip: ссылка на YouTube → embed URL, иначе null (тогда может быть прямой файл).
     */
    public function previewStripYoutubeEmbedUrl(): ?string
    {
        if ($this->key !== 'preview_strip') {
            return null;
        }

        return self::youtubeEmbedUrlFromString((string) ($this->video_url ?? ''));
    }

    public function previewStripIsDirectVideoUrl(): bool
    {
        if ($this->key !== 'preview_strip') {
            return false;
        }

        return self::pathOrUrlLooksLikeDirectVideo((string) ($this->video_url ?? ''));
    }

    /** Абсолютный URL для self-hosted видео: сначала файл из админки, иначе URL/путь в video_url. */
    public function previewStripDirectVideoPublicUrl(): ?string
    {
        if ($this->key !== 'preview_strip') {
            return null;
        }
        $stored = self::coerceStoredFilePath($this->video_path ?? null);
        if ($stored !== null && $stored !== '') {
            return static::publicUrlForStoredOrAssetPath($stored);
        }
        if (! $this->previewStripIsDirectVideoUrl()) {
            return null;
        }
        $u = trim((string) $this->video_url);

        return static::publicUrlForStoredOrAssetPath($u);
    }

    /**
     * Видео для модалки «Стиль практики»: загрузка/прямой .mp4 → YouTube из поля URL → тот же плейсхолдер, что у видео-отзывов.
     *
     * @return array{kind: 'native'|'youtube', src: string, youtube: string}
     */
    public function previewStripModalVideoForView(): array
    {
        if ($this->key !== 'preview_strip') {
            return self::defaultPreviewStripModalVideoForView();
        }
        $direct = $this->previewStripDirectVideoPublicUrl();
        if (is_string($direct) && trim($direct) !== '') {
            return ['kind' => 'native', 'src' => trim($direct), 'youtube' => ''];
        }
        $yt = $this->previewStripYoutubeEmbedUrl();
        if (is_string($yt) && trim($yt) !== '') {
            return ['kind' => 'youtube', 'src' => '', 'youtube' => trim($yt)];
        }

        return self::defaultPreviewStripModalVideoForView();
    }

    /** @return array{kind: 'native'|'youtube', src: string, youtube: string} */
    public static function defaultPreviewStripModalVideoForView(): array
    {
        $placeholder = config('prostoy.review_tiles_placeholder_video_url');
        if (is_string($placeholder) && trim($placeholder) !== '') {
            return ['kind' => 'native', 'src' => trim($placeholder), 'youtube' => ''];
        }

        return ['kind' => 'youtube', 'src' => '', 'youtube' => 'https://www.youtube.com/embed/jfKfPfyJRdk'];
    }

    /**
     * Один путь к файлу на public disk: строка или формат FileUpload (ассоциативный массив uuid → path).
     */
    public static function coerceStoredFilePath(mixed $value): ?string
    {
        if (is_string($value)) {
            $value = trim($value);

            return $value === '' ? null : $value;
        }
        if (! is_array($value) || $value === []) {
            return null;
        }
        if (! array_is_list($value)) {
            foreach ($value as $candidate) {
                $p = self::coerceStoredFilePath($candidate);
                if ($p !== null) {
                    return $p;
                }
            }

            return null;
        }
        foreach ($value as $candidate) {
            $p = self::coerceStoredFilePath($candidate);
            if ($p !== null) {
                return $p;
            }
        }

        return null;
    }

    /**
     * @return list<array{poster_path: ?string, video_path: ?string, video_url: ?string, caption: ?string}>
     */
    public static function normalizeReviewVideoSlotsForStorage(mixed $raw): array
    {
        $slots = is_array($raw) ? array_values($raw) : [];
        while (count($slots) < 3) {
            $slots[] = [];
        }
        $slots = array_slice($slots, 0, 3);
        $out = [];
        foreach ($slots as $s) {
            if (! is_array($s)) {
                $s = [];
            }
            $poster = self::coerceStoredFilePath($s['poster_path'] ?? null);
            $vp = self::coerceStoredFilePath($s['video_path'] ?? null);
            $vu = isset($s['video_url']) && is_string($s['video_url']) ? trim($s['video_url']) : '';
            $capRaw = isset($s['caption']) && is_string($s['caption']) ? trim($s['caption']) : '';
            $caption = $capRaw !== '' ? mb_substr($capRaw, 0, 120) : null;
            $out[] = [
                'poster_path' => $poster,
                'video_path' => $vp,
                'video_url' => $vu !== '' ? $vu : null,
                'caption' => $caption,
            ];
        }

        return $out;
    }

    /** Три плитки для лендинга: постер, тип плеера, src. */
    public function reviewsVideoTilesForView(): array
    {
        if ($this->key !== 'reviews') {
            return [];
        }
        $slots = self::normalizeReviewVideoSlotsForStorage($this->review_video_slots ?? []);
        $out = [];
        foreach ($slots as $i => $slot) {
            $defaultPoster = asset(self::REVIEW_VIDEO_DEFAULT_POSTERS[$i] ?? 'images/figma/promo.png');
            $poster = isset($slot['poster_path']) && $slot['poster_path']
                ? self::publicUrlForStoredOrAssetPath($slot['poster_path'])
                : $defaultPoster;
            $videoPath = (string) ($slot['video_path'] ?? '');
            $videoUrl = (string) ($slot['video_url'] ?? '');
            $native = $videoPath !== '' ? self::publicUrlForStoredOrAssetPath($videoPath) : null;
            if ($native === null && $videoUrl !== '' && self::pathOrUrlLooksLikeDirectVideo($videoUrl)) {
                $native = self::publicUrlForStoredOrAssetPath($videoUrl);
            }
            $yt = null;
            if ($native === null && $videoUrl !== '') {
                $yt = self::youtubeEmbedUrlFromString($videoUrl);
            }
            $kind = $native !== null ? 'native' : ($yt !== null ? 'youtube' : 'none');
            $placeholder = false;
            if ($kind === 'none') {
                $kind = 'native';
                $native = config('prostoy.review_tiles_placeholder_video_url');
                $placeholder = true;
            }
            $cap = isset($slot['caption']) && is_string($slot['caption']) ? trim($slot['caption']) : '';
            $caption = $cap !== '' ? $cap : null;
            $out[] = [
                'poster' => $poster,
                'kind' => $kind,
                'src' => $native,
                'youtube_embed' => $yt,
                'caption' => $caption,
                'placeholder' => $placeholder,
            ];
        }

        return $out;
    }

    /** Если секция reviews не загружена из БД — те же дефолтные постеры без видео. */
    public static function defaultReviewTilesForLandingView(): array
    {
        return (new static([
            'key' => 'reviews',
            'review_video_slots' => [[], [], []],
        ]))->reviewsVideoTilesForView();
    }
}
