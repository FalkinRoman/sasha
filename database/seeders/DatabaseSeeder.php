<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\PromoCode;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->where('email', 'test@example.com')->delete();

        User::query()->updateOrCreate(
            ['email' => 'admin@prostoyoga.ru'],
            [
                'name' => 'Администратор',
                'password' => 'password',
                'is_admin' => true,
                'referral_code' => 'PROSTOADM',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'user@prostoyoga.ru'],
            [
                'name' => 'Обычный пользователь',
                'password' => 'password',
                'is_admin' => false,
                'referral_code' => 'PROSTOUSR',
            ]
        );

        Tariff::query()->insert([
            [
                'slug' => 'base',
                'name' => 'Эконом',
                'tagline' => '10 тренировок в записи',
                'description' => 'Полностью самостоятельное прохождение: все практики в записи, без чата и сопровождения.',
                'price_rub' => 2900,
                'duration_days' => 30,
                'includes_telegram' => false,
                'includes_bonus_materials' => false,
                'includes_personal_online' => false,
                'bonus_personal_sessions' => 0,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'community',
                'name' => 'PROSTO.Yoga',
                'tagline' => 'Самый популярный формат',
                'description' => 'Закрытый чат, напоминания, домашние задания, игровой формат, живая встреча с Сашей и бонусы.',
                'price_rub' => 4500,
                'duration_days' => 30,
                'includes_telegram' => true,
                'includes_bonus_materials' => true,
                'includes_personal_online' => false,
                'bonus_personal_sessions' => 0,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'intensive',
                'name' => 'PROSTO.TOP',
                'tagline' => 'Максимум поддержки',
                'description' => 'Всё из PROSTO.Yoga плюс личный чат с Сашей, обратная связь по ДЗ, сессия 1:1 и разбор балансов.',
                'price_rub' => 6900,
                'duration_days' => 90,
                'includes_telegram' => true,
                'includes_bonus_materials' => true,
                'includes_personal_online' => true,
                'bonus_personal_sessions' => 1,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        PromoCode::query()->create([
            'code' => 'YOGA20',
            'discount_percent' => 20,
            'max_uses' => 100,
            'used_count' => 0,
            'expires_at' => now()->addMonths(6),
            'is_active' => true,
        ]);

        PromoCode::query()->firstOrCreate(
            ['code' => 'QUIZ10'],
            [
                'discount_percent' => 10,
                'max_uses' => null,
                'used_count' => 0,
                'expires_at' => null,
                'is_active' => true,
            ]
        );

        $lessons = [
            [
                'order_index' => 1,
                'slug' => 'den-1-dyhanie',
                'title' => 'День 1 — Дыхание и база',
                'subtitle' => 'Фундамент современной практики',
                'short_description' => 'Настраиваем дыхание, учимся чувствовать опору и мягко включать тело.',
                'body' => 'В этом уроке вы освоите диафрагмальное дыхание, разберём безопасность суставов и подготовим кор к дальнейшим занятиям.',
                'duration_minutes' => 28,
                'calories_estimate' => 120,
                'is_preview_free' => true,
            ],
            [
                'order_index' => 2,
                'slug' => 'den-2-pozvonochnik',
                'title' => 'День 2 — скрутки и мобильность',
                'subtitle' => 'Лёгкий позвоночник',
                'short_description' => 'Мягкие скручивания и мобилизация грудного отдела.',
                'body' => 'Работаем с вращением, снимаем зажимы после сидячей работы.',
                'duration_minutes' => 32,
                'calories_estimate' => 145,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 3,
                'slug' => 'den-3-nogi',
                'title' => 'День 3 — ноги и баланс',
                'subtitle' => 'Сила без перегруза',
                'short_description' => 'Укрепляем устойчивость, работаем в стоячих и полустоячих позах.',
                'body' => 'Внимание к коленям и стопам, выстраиваем линию от центра к опоре.',
                'duration_minutes' => 35,
                'calories_estimate' => 180,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 4,
                'slug' => 'den-4-bedra',
                'title' => 'День 4 — раскрытие бёдер',
                'subtitle' => 'Гибкость и комфорт',
                'short_description' => 'Наклоны вперёд и мягкие выпады для здоровых бёдер.',
                'body' => 'Работаем с тазобедренными суставами, не форсируя амплитуду.',
                'duration_minutes' => 30,
                'calories_estimate' => 150,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 5,
                'slug' => 'den-5-plechi',
                'title' => 'День 5 — плечи и шея',
                'subtitle' => 'Снять напряжение',
                'short_description' => 'Мобилизация плечевого пояса, безопасные наклоны головы.',
                'body' => 'Освобождаем шею от «офисного» блока, улучшаем кровоток.',
                'duration_minutes' => 26,
                'calories_estimate' => 95,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 6,
                'slug' => 'den-6-kor',
                'title' => 'День 6 — кор и осанка',
                'subtitle' => 'Стабильный центр',
                'short_description' => 'Планки, мягкие скручивания и работа с прессом осознанно.',
                'body' => 'Соединяем дыхание и удержание корпуса без задержки дыхания.',
                'duration_minutes' => 34,
                'calories_estimate' => 200,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 7,
                'slug' => 'den-7-rasslablenie',
                'title' => 'День 7 — растяжка и отдых',
                'subtitle' => 'Восстановление',
                'short_description' => 'Мягкие yin-подходы и расслабляющие позы.',
                'body' => 'Снижаем стресс, работаем с нервной системой через длительные позы.',
                'duration_minutes' => 40,
                'calories_estimate' => 110,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 8,
                'slug' => 'den-8-polnyy-potok',
                'title' => 'День 8 — полный поток',
                'subtitle' => 'Интеграция всего курса',
                'short_description' => 'Связываем всё в одну цельную практику.',
                'body' => 'Финальный урок: плавный динамический поток с акцентом на то, что вы уже освоили.',
                'duration_minutes' => 45,
                'calories_estimate' => 240,
                'is_preview_free' => false,
            ],
        ];

        $demo = 'https://www.youtube.com/embed/jfKfPfyJRdk';

        foreach ($lessons as $row) {
            Lesson::query()->create([
                ...$row,
                'course_slug' => 'modern-yoga',
                'video_url' => $demo,
            ]);
        }
    }
}
