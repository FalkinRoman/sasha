<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('lessons')) {
            return;
        }

        $demo = 'https://www.youtube.com/embed/jfKfPfyJRdk';
        $now = now();

        $rows = [
            1 => [
                'slug' => 'praktika-probuzhdenie-aktivatsiya',
                'title' => 'Практика для пробуждения и активации тела',
                'subtitle' => null,
                'short_description' => 'Мягкий вход в движение и контакт с телом.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 30,
                'calories_estimate' => 130,
                'is_preview_free' => true,
            ],
            2 => [
                'slug' => 'kompleks-osanka-dyhanie',
                'title' => 'Комплекс на осанку и дыхательные техники',
                'subtitle' => null,
                'short_description' => 'Опора, выравнивание и осознанное дыхание.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 32,
                'calories_estimate' => 140,
                'is_preview_free' => false,
            ],
            3 => [
                'slug' => 'nogi-gibkost',
                'title' => 'Укрепляем ноги и работаем над их гибкостью',
                'subtitle' => null,
                'short_description' => 'Сила и мобильность нижней части тела.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 35,
                'calories_estimate' => 175,
                'is_preview_free' => false,
            ],
            4 => [
                'slug' => 'probuzhdaemsya-dyshim',
                'title' => 'Пробуждаемся и дышим',
                'subtitle' => null,
                'short_description' => 'Энергия и ясность через дыхание и движение.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 28,
                'calories_estimate' => 120,
                'is_preview_free' => false,
            ],
            5 => [
                'slug' => 'taz-poyasnitsa',
                'title' => 'Раскрываем тазобедренные суставы и разгружаем поясницу',
                'subtitle' => null,
                'short_description' => 'Комфорт в тазу и пояснице без перегруза.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 34,
                'calories_estimate' => 155,
                'is_preview_free' => false,
            ],
            6 => [
                'slug' => 'myshtsy-zhivota-ploskiy',
                'title' => 'Работаем с мышцами живота — «Плоский живот»',
                'subtitle' => null,
                'short_description' => 'Кор и контроль центра тела.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 32,
                'calories_estimate' => 190,
                'is_preview_free' => false,
            ],
            7 => [
                'slug' => 'prodolnye-shpagaty',
                'title' => 'Идём в направление продольных шпагатов',
                'subtitle' => null,
                'short_description' => 'Пошаговая работа над амплитудой и безопасностью.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 38,
                'calories_estimate' => 200,
                'is_preview_free' => false,
            ],
            8 => [
                'slug' => 'ruki-grudnoy-otdel',
                'title' => 'Укрепляем руки и раскрываем грудной отдел',
                'subtitle' => null,
                'short_description' => 'Верх тела: сила и мобильность грудного отдела.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 33,
                'calories_estimate' => 165,
                'is_preview_free' => false,
            ],
            9 => [
                'slug' => 'yagoditsy-poperechnyy-shpagat',
                'title' => 'Практика на ягодицы + идём в сторону к поперечному шпагату',
                'subtitle' => null,
                'short_description' => 'Ягодицы и работа к широкому шпагату.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 36,
                'calories_estimate' => 210,
                'is_preview_free' => false,
            ],
            10 => [
                'slug' => 'zhivaya-onlayn-prodolnye',
                'title' => 'Живая онлайн (практика на всё тело + продольные шпагаты)',
                'subtitle' => null,
                'short_description' => 'Эфир: полная практика и продольные шпагаты.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 50,
                'calories_estimate' => 260,
                'is_preview_free' => false,
            ],
            11 => [
                'slug' => 'meditatsiya-uslysh-sebya',
                'title' => 'Медитация «услышь себя»',
                'subtitle' => null,
                'short_description' => 'Мягкая внутренняя практика и контакт с собой.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 25,
                'calories_estimate' => 60,
                'is_preview_free' => false,
            ],
            12 => [
                'slug' => 'zhivaya-onlayn-dinamika-taz',
                'title' => 'Живая онлайн (динамичная практика на всё тело + работа с тазобедренными суставами)',
                'subtitle' => null,
                'short_description' => 'Эфир: динамика, всё тело и тазобедренные.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 50,
                'calories_estimate' => 270,
                'is_preview_free' => false,
            ],
        ];

        foreach ($rows as $orderIndex => $fields) {
            $existing = DB::table('lessons')
                ->where('course_slug', 'modern-yoga')
                ->where('order_index', $orderIndex)
                ->first();

            $payload = array_merge($fields, ['updated_at' => $now]);

            if ($existing) {
                DB::table('lessons')->where('id', $existing->id)->update($payload);
            } else {
                DB::table('lessons')->insert(array_merge($payload, [
                    'course_slug' => 'modern-yoga',
                    'order_index' => $orderIndex,
                    'video_url' => $demo,
                    'created_at' => $now,
                ]));
            }
        }
    }

    public function down(): void
    {
        // откат текстов не делаем — видео и слаги могли уже использоваться
    }
};
