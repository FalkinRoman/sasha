<?php

use App\Models\LandingSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = DB::table('landing_sections')->where('key', 'reviews')->get(['id', 'body']);

        foreach ($rows as $row) {
            $b = $row->body;
            if (! is_string($b) || $b === '') {
                continue;
            }
            $next = str_replace(
                [
                    ' и фрагменты переписки. Зал или онлайн — без разницы.',
                    ' и фрагменты переписки. зал или онлайн — без разницы.',
                ],
                ' и фрагменты переписки после занятий.',
                $b
            );
            $next = str_replace(
                ['практике: зал или онлайн — без разницы.', 'практике: Зал или онлайн — без разницы.'],
                'практике после занятий.',
                $next
            );
            if ($next !== $b) {
                DB::table('landing_sections')->where('id', $row->id)->update(['body' => $next, 'updated_at' => now()]);
            }
        }

        LandingSection::bustCache();
    }
};
