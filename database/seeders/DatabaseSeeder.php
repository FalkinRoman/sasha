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

        User::query()->where('email', 'admin@prostoyoga.ru')->delete();

        User::query()->updateOrCreate(
            ['email' => 'prostoyoga@mail.ru'],
            [
                'name' => 'Администратор',
                'password' => 'password',
                'is_admin' => true,
                'referral_code' => 'PROSTOADM',
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'user@prostoyoga.ru'],
            [
                'name' => 'Обычный пользователь',
                'password' => 'password',
                'is_admin' => false,
                'referral_code' => 'PROSTOUSR',
                'email_verified_at' => now(),
            ]
        );

        $partner = User::query()->updateOrCreate(
            ['email' => 'partner@prostoyoga.ru'],
            [
                'name' => 'Партнёр (демо)',
                'password' => 'password',
                'is_admin' => false,
                'referral_code' => 'PARTNER01',
                'email_verified_at' => now(),
            ]
        );

        foreach (
            [
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
                ],
                [
                    'slug' => 'community',
                    'name' => 'PROSTO.Yoga',
                    'tagline' => 'Самый популярный формат',
                    'description' => 'Закрытый чат, напоминания, домашние задания, игровой формат, живая встреча с Сашей и бонусы.',
                    'price_rub' => 4900,
                    'duration_days' => 30,
                    'includes_telegram' => true,
                    'includes_bonus_materials' => true,
                    'includes_personal_online' => false,
                    'bonus_personal_sessions' => 0,
                    'sort_order' => 2,
                ],
                [
                    'slug' => 'intensive',
                    'name' => 'PROSTO.TOP',
                    'tagline' => 'Максимум поддержки',
                    'description' => 'Всё из PROSTO.Yoga плюс личный чат с Сашей, обратная связь по ДЗ, сессия 1:1 и разбор балансов.',
                    'price_rub' => 6900,
                    'duration_days' => 60,
                    'includes_telegram' => true,
                    'includes_bonus_materials' => true,
                    'includes_personal_online' => true,
                    'bonus_personal_sessions' => 1,
                    'sort_order' => 3,
                ],
            ] as $tariffRow
        ) {
            Tariff::query()->updateOrCreate(
                ['slug' => $tariffRow['slug']],
                $tariffRow
            );
        }

        PromoCode::query()->updateOrCreate(
            ['code' => 'PRESALE20'],
            [
                'discount_percent' => 20,
                'max_uses' => null,
                'used_count' => 0,
                'expires_at' => null,
                'is_active' => true,
                'owner_user_id' => null,
            ]
        );

        PromoCode::query()->updateOrCreate(
            ['code' => 'YOGA20'],
            [
                'discount_percent' => 20,
                'max_uses' => 100,
                'used_count' => 0,
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
                'owner_user_id' => null,
            ]
        );

        PromoCode::query()->updateOrCreate(
            ['code' => 'BLOGGER15'],
            [
                'discount_percent' => 15,
                'max_uses' => null,
                'used_count' => 0,
                'expires_at' => null,
                'is_active' => true,
                'owner_user_id' => $partner->id,
            ]
        );

        PromoCode::query()->firstOrCreate(
            ['code' => 'QUIZ5'],
            [
                'discount_percent' => 5,
                'max_uses' => null,
                'used_count' => 0,
                'expires_at' => null,
                'is_active' => true,
            ]
        );

        $lessons = [
            [
                'order_index' => 1,
                'slug' => 'praktika-probuzhdenie-aktivatsiya',
                'title' => 'Практика для пробуждения и активации тела',
                'subtitle' => null,
                'short_description' => 'Мягкий вход в движение и контакт с телом.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 30,
                'calories_estimate' => 130,
                'is_preview_free' => true,
            ],
            [
                'order_index' => 2,
                'slug' => 'kompleks-osanka-dyhanie',
                'title' => 'Комплекс на осанку и дыхательные техники',
                'subtitle' => null,
                'short_description' => 'Опора, выравнивание и осознанное дыхание.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 32,
                'calories_estimate' => 140,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 3,
                'slug' => 'nogi-gibkost',
                'title' => 'Укрепляем ноги и работаем над их гибкостью',
                'subtitle' => null,
                'short_description' => 'Сила и мобильность нижней части тела.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 35,
                'calories_estimate' => 175,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 4,
                'slug' => 'probuzhdaemsya-dyshim',
                'title' => 'Пробуждаемся и дышим',
                'subtitle' => null,
                'short_description' => 'Энергия и ясность через дыхание и движение.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 28,
                'calories_estimate' => 120,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 5,
                'slug' => 'taz-poyasnitsa',
                'title' => 'Раскрываем тазобедренные суставы и разгружаем поясницу',
                'subtitle' => null,
                'short_description' => 'Комфорт в тазу и пояснице без перегруза.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 34,
                'calories_estimate' => 155,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 6,
                'slug' => 'myshtsy-zhivota-ploskiy',
                'title' => 'Работаем с мышцами живота — «Плоский живот»',
                'subtitle' => null,
                'short_description' => 'Кор и контроль центра тела.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 32,
                'calories_estimate' => 190,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 7,
                'slug' => 'prodolnye-shpagaty',
                'title' => 'Идём в направление продольных шпагатов',
                'subtitle' => null,
                'short_description' => 'Пошаговая работа над амплитудой и безопасностью.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 38,
                'calories_estimate' => 200,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 8,
                'slug' => 'ruki-grudnoy-otdel',
                'title' => 'Укрепляем руки и раскрываем грудной отдел',
                'subtitle' => null,
                'short_description' => 'Верх тела: сила и мобильность грудного отдела.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 33,
                'calories_estimate' => 165,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 9,
                'slug' => 'yagoditsy-poperechnyy-shpagat',
                'title' => 'Практика на ягодицы + идём в сторону к поперечному шпагату',
                'subtitle' => null,
                'short_description' => 'Ягодицы и работа к широкому шпагату.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 36,
                'calories_estimate' => 210,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 10,
                'slug' => 'zhivaya-onlayn-prodolnye',
                'title' => 'Живая онлайн (практика на всё тело + продольные шпагаты)',
                'subtitle' => null,
                'short_description' => 'Эфир: полная практика и продольные шпагаты.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 50,
                'calories_estimate' => 260,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 11,
                'slug' => 'meditatsiya-uslysh-sebya',
                'title' => 'Медитация «услышь себя»',
                'subtitle' => null,
                'short_description' => 'Мягкая внутренняя практика и контакт с собой.',
                'body' => 'Материалы урока доступны в личном кабинете после оплаты.',
                'duration_minutes' => 25,
                'calories_estimate' => 60,
                'is_preview_free' => false,
            ],
            [
                'order_index' => 12,
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

        Lesson::query()->where('course_slug', 'modern-yoga')->delete();

        foreach ($lessons as $row) {
            Lesson::query()->create([
                ...$row,
                'course_slug' => 'modern-yoga',
                'video_url' => null,
                'video_path' => null,
                'cover_image_path' => null,
                'released_at' => null,
            ]);
        }
    }
}
