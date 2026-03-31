<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tariffs')) {
            return;
        }

        $rows = [
            'base' => [
                'name' => 'Эконом',
                'tagline' => '10 тренировок в записи',
                'description' => 'Полностью самостоятельное прохождение: все практики в записи, без чата и сопровождения.',
                'price_rub' => 2900,
                'duration_days' => 30,
                'includes_telegram' => false,
                'includes_bonus_materials' => false,
                'includes_personal_online' => false,
                'bonus_personal_sessions' => 0,
            ],
            'community' => [
                'name' => 'PROSTO.Yoga',
                'tagline' => 'Самый популярный формат',
                'description' => 'Закрытый чат, напоминания, домашние задания, игровой формат, живая встреча с Сашей и бонусы.',
                'price_rub' => 4500,
                'duration_days' => 30,
                'includes_telegram' => true,
                'includes_bonus_materials' => true,
                'includes_personal_online' => false,
                'bonus_personal_sessions' => 0,
            ],
            'intensive' => [
                'name' => 'PROSTO.TOP',
                'tagline' => 'Максимум поддержки',
                'description' => 'Всё из PROSTO.Yoga плюс личный чат с Сашей, обратная связь по ДЗ, сессия 1:1 и разбор балансов.',
                'price_rub' => 6900,
                'duration_days' => 60,
                'includes_telegram' => true,
                'includes_bonus_materials' => true,
                'includes_personal_online' => true,
                'bonus_personal_sessions' => 1,
            ],
        ];

        foreach ($rows as $slug => $data) {
            DB::table('tariffs')->where('slug', $slug)->update(array_merge($data, ['updated_at' => now()]));
        }

        if (Schema::hasTable('promocodes')) {
            $exists = DB::table('promocodes')->where('code', 'QUIZ10')->exists();
            if (! $exists) {
                DB::table('promocodes')->insert([
                    'code' => 'QUIZ10',
                    'discount_percent' => 10,
                    'max_uses' => null,
                    'used_count' => 0,
                    'expires_at' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // намеренно без отката цен — данные могли измениться в админке
    }
};
