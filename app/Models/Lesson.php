<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_slug', 'order_index', 'slug', 'title', 'subtitle',
        'short_description', 'body', 'duration_minutes', 'calories_estimate',
        'video_url', 'video_path', 'cover_image_path', 'released_at', 'is_preview_free',
        'hide_video_for_base', 'hide_video_for_community',
    ];

    protected function casts(): array
    {
        return [
            'is_preview_free' => 'boolean',
            'hide_video_for_base' => 'boolean',
            'hide_video_for_community' => 'boolean',
            'released_at' => 'datetime',
        ];
    }

    /** Можно открыть страницу урока (превью или оплаченный доступ). */
    public function userCanOpen(?User $user): bool
    {
        if ($user !== null && $user->is_admin) {
            return true;
        }

        if ($this->is_preview_free) {
            return $user !== null;
        }

        return $user !== null && $user->hasActiveCourseAccess();
    }

    /** @deprecated use userCanOpen */
    public function userCanWatch(?User $user): bool
    {
        return $this->userCanOpen($user);
    }

    /** Видео доступно для просмотра (релиз + источник). */
    public function isMediaReleased(): bool
    {
        if ($this->released_at === null || $this->released_at->isFuture()) {
            return false;
        }

        return $this->hasLessonVideoSource();
    }

    /** Есть ли загруженное видео / ссылка (без учёта даты релиза). */
    public function hasLessonVideoSource(): bool
    {
        return $this->hasServerVideo()
            || filled($this->video_url)
            || $this->youtubeVideoId() !== null;
    }

    /**
     * Видео можно показывать этому пользователю: участник — после даты релиза;
     * бесплатное превью — сразу при наличии файла/ссылки (без released_at и без режима предпродажи);
     * админ — любое загруженное видео.
     */
    public function mediaAvailableForUser(?User $user): bool
    {
        if ($user !== null && $user->is_admin) {
            return $this->hasLessonVideoSource();
        }

        if ($this->isVideoBlockedForUserTariff($user)) {
            return false;
        }

        if ($this->is_preview_free && $user !== null && $this->userCanOpen($user) && $this->hasLessonVideoSource()) {
            return true;
        }

        return $this->isMediaReleased();
    }

    public function isVideoBlockedForUserTariff(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        $purchase = $user->activePurchase();
        $tariffSlug = $purchase?->tariff?->slug;

        return ($this->hide_video_for_base && $tariffSlug === 'base')
            || ($this->hide_video_for_community && $tariffSlug === 'community');
    }

    /** На каких тарифах урок доступен по настройкам скрытия видео. */
    public function availableTariffLabels(): array
    {
        $labels = [];

        if (! $this->hide_video_for_base) {
            $labels[] = 'Эконом';
        }

        if (! $this->hide_video_for_community) {
            $labels[] = 'PROSTO.Yoga';
        }

        $labels[] = 'PROSTO.TOP';

        return $labels;
    }

    /** Обложка урока в кабинете. Без YouTube — только загруженный файл или null (тогда плейсхолдер в шаблоне). */
    public function posterPublicUrl(): ?string
    {
        if (! is_string($this->cover_image_path) || $this->cover_image_path === '') {
            return null;
        }

        return self::publicStorageUrl($this->cover_image_path);
    }

    /** Корневой относительный URL: не зависит от APP_URL (127.0.0.1:8001 vs localhost). */
    public static function publicStorageUrl(string $relativePath): string
    {
        $path = ltrim(str_replace('\\', '/', $relativePath), '/');

        return '/storage/'.$path;
    }

    /** Видеофайл на диске public (приоритетнее внешнего URL при отображении). */
    public function hasServerVideo(): bool
    {
        return is_string($this->video_path) && $this->video_path !== '';
    }

    public function serverVideoPublicUrl(): ?string
    {
        if (! $this->hasServerVideo()) {
            return null;
        }

        return self::publicStorageUrl($this->video_path);
    }

    public function youtubeVideoId(): ?string
    {
        $url = $this->video_url;
        if (! is_string($url) || $url === '') {
            return null;
        }

        if (preg_match('#youtube\.com/embed/([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        if (preg_match('#[?&]v=([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    /** URL для iframe embed (YouTube). */
    public function youtubeEmbedUrl(): ?string
    {
        $id = $this->youtubeVideoId();
        if ($id !== null) {
            return 'https://www.youtube.com/embed/'.$id;
        }

        $url = $this->video_url;
        if (is_string($url) && str_contains($url, 'youtube.com/embed')) {
            return $url;
        }

        return null;
    }
}
