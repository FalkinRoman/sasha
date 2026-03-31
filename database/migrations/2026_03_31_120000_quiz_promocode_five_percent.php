<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('promocodes')) {
            return;
        }

        $now = now();

        $has5 = DB::table('promocodes')->where('code', 'QUIZ5')->exists();
        $quiz10 = DB::table('promocodes')->where('code', 'QUIZ10')->first();

        if ($quiz10) {
            if ($has5) {
                DB::table('promocodes')->where('id', $quiz10->id)->delete();
            } else {
                DB::table('promocodes')->where('id', $quiz10->id)->update([
                    'code' => 'QUIZ5',
                    'discount_percent' => 5,
                    'updated_at' => $now,
                ]);
            }

            return;
        }

        if (! $has5) {
            DB::table('promocodes')->insert([
                'code' => 'QUIZ5',
                'discount_percent' => 5,
                'max_uses' => null,
                'used_count' => 0,
                'expires_at' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // без отката: код мог уже использоваться в покупках
    }
};
