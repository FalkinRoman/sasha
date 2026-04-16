<?php

use App\Models\LandingSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $newTitle = 'Что говорят после практики со мной';
        $newSubtitle = 'Три коротких включения — голоса и эмоции с коврика';
        $newBody = '<p class="text-lg text-[#5c655c]">С коврика часто выходит не только благодарность в сообщениях, но и живые слова «в кадр». Ниже — три коротких отрывка с занятий и переписка от тех, кто уже был в практике: зал или онлайн — без разницы.</p>';
        $oldTitle = 'Что пишут после практики со мной';
        $oldSubtitle = 'На видео · 20–40 сек в кадре · каждое до ~90 сек';

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where('title', $oldTitle)
            ->update(['title' => $newTitle, 'updated_at' => now()]);

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where(function ($q) use ($oldSubtitle) {
                $q->where('subtitle', $oldSubtitle)->orWhereNull('subtitle')->orWhere('subtitle', '');
            })
            ->update(['subtitle' => $newSubtitle, 'updated_at' => now()]);

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where('body', 'like', '%Ниже короткое видео%')
            ->update(['body' => $newBody, 'updated_at' => now()]);

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where('admin_label', 'Отзывы — заголовок')
            ->update(['admin_label' => 'Отзывы — видео и чат', 'updated_at' => now()]);

        LandingSection::bustCache();
    }

    public function down(): void
    {
        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where('title', 'Что говорят после практики со мной')
            ->update(['title' => 'Что пишут после практики со мной', 'updated_at' => now()]);

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where('subtitle', 'Три коротких включения — голоса и эмоции с коврика')
            ->update(['subtitle' => null, 'updated_at' => now()]);

        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where('admin_label', 'Отзывы — видео и чат')
            ->update(['admin_label' => 'Отзывы — заголовок', 'updated_at' => now()]);

        LandingSection::bustCache();
    }
};
