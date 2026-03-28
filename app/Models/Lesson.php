<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lesson extends Model
{
    protected $fillable = [
        'course_slug', 'order_index', 'slug', 'title', 'subtitle',
        'short_description', 'body', 'duration_minutes', 'calories_estimate',
        'video_url', 'video_path', 'is_preview_free',
    ];

    protected function casts(): array
    {
        return [
            'is_preview_free' => 'boolean',
        ];
    }

    public function userCanWatch(?User $user): bool
    {
        if ($this->is_preview_free) {
            return true;
        }

        return $user !== null && $user->hasActiveCourseAccess();
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

        return Storage::disk('public')->url($this->video_path);
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

    /** Превью как у YouTube (mqdefault ~ 320×180). Для файла на сервере — null (постер в UI отдельно). */
    public function thumbnailUrl(): ?string
    {
        $id = $this->youtubeVideoId();

        return $id !== null ? "https://img.youtube.com/vi/{$id}/mqdefault.jpg" : null;
    }
}
