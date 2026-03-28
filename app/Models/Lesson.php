<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_slug', 'order_index', 'slug', 'title', 'subtitle',
        'short_description', 'body', 'duration_minutes', 'calories_estimate',
        'video_url', 'is_preview_free',
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
}
