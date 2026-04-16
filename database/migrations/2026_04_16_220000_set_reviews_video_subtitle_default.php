<?php

use App\Models\LandingSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $text = 'Три коротких видео — отзывы, которые записали ученицы';
        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where(function ($q) {
                $q->whereNull('subtitle')->orWhere('subtitle', '');
            })
            ->update(['subtitle' => $text, 'updated_at' => now()]);
        LandingSection::bustCache();
    }

    public function down(): void
    {
        DB::table('landing_sections')
            ->where('key', 'reviews')
            ->where('subtitle', 'Три коротких видео — отзывы, которые записали ученицы')
            ->update(['subtitle' => null, 'updated_at' => now()]);
        LandingSection::bustCache();
    }
};
