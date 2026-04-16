<?php

use App\Models\LandingSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $subtitle = 'Три коротких видео — отзывы, которые записали ученицы';
        $body = '<p class="text-lg text-[#5c655c]">Ученицы иногда записывают короткое видео или пишут в чат. Ниже — три таких отзыва и фрагменты переписки после занятий.</p>';

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where(function ($q) {
                $q->where('subtitle', 'like', '%коврик%')
                    ->orWhere('subtitle', 'Три коротких включения — голоса и эмоции с коврика')
                    ->orWhere('subtitle', 'На видео · 20–40 сек в кадре · каждое до ~90 сек');
            })
            ->update(['subtitle' => $subtitle, 'updated_at' => now()]);

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where(function ($q) {
                $q->where('body', 'like', '%С коврика%')
                    ->orWhere('body', 'like', '%с коврика%');
            })
            ->update(['body' => $body, 'updated_at' => now()]);

        LandingSection::bustCache();
    }

    public function down(): void
    {
        // Откат текста не делаем — могли уже править вручную.
        LandingSection::bustCache();
    }
};
