<?php

namespace Database\Seeders;

use App\Models\SitePageBlock;
use Illuminate\Database\Seeder;

class SitePageBlockSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // ——— support ———
            [
                'page_key' => 'support',
                'key' => 'hero',
                'admin_label' => 'Шапка: заголовок и вводный текст',
                'title' => 'Поддержка',
                'subtitle' => null,
                'title_level' => 'h1',
                'body' => '<p class="text-lg leading-relaxed text-[#5c655c]">Мы рядом, если вопрос по доступу, оплате или технике. Пиши удобным способом — ответим в порядке очереди.</p>',
                'sort_order' => 1,
            ],
            [
                'page_key' => 'support',
                'key' => 'channels',
                'admin_label' => 'Контакты (список)',
                'title' => null,
                'subtitle' => null,
                'title_level' => 'none',
                'body' => '<ul class="mt-10 space-y-4 text-[#2d312d]"><li><strong class="text-[#869274]">Email:</strong> <a href="mailto:__CONTACT_EMAIL__" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">__CONTACT_EMAIL__</a></li><li><strong class="text-[#869274]">Telegram:</strong> <a href="https://t.me/sasha_vikh" target="_blank" rel="noopener" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">@sasha_vikh</a> (будни, 10:00–19:00 МСК)</li></ul>',
                'sort_order' => 2,
            ],
            [
                'page_key' => 'support',
                'key' => 'hint',
                'admin_label' => 'Подсказка внизу',
                'title' => null,
                'subtitle' => null,
                'title_level' => 'none',
                'body' => '<p class="mt-10 text-sm leading-relaxed text-[#7a837a]">В письме укажи email аккаунта и кратко суть проблемы — так мы быстрее найдём твой доступ.</p>',
                'sort_order' => 3,
            ],
            // ——— contacts ———
            [
                'page_key' => 'contacts',
                'key' => 'hero',
                'admin_label' => 'Шапка',
                'title' => 'Контакты',
                'subtitle' => null,
                'title_level' => 'h1',
                'body' => '<p class="text-lg leading-relaxed text-[#5c655c]">Связь с командой ProstoYoga — для партнёрств, СМИ и общих вопросов.</p>',
                'sort_order' => 1,
            ],
            [
                'page_key' => 'contacts',
                'key' => 'card',
                'admin_label' => 'Карточка с почтой',
                'title' => null,
                'subtitle' => null,
                'title_level' => 'none',
                'body' => '<div class="mt-10 space-y-6 rounded-2xl border border-[#e2e4df] bg-[#f9faf6] p-8 text-[#2d312d]"><p><span class="font-medium text-[#869274]">Почта</span><br><a href="mailto:__CONTACT_EMAIL__" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">__CONTACT_EMAIL__</a></p><p class="text-sm text-[#7a837a]">Общие вопросы, поддержка участников, партнёрства и СМИ — на этот адрес. Юридический адрес и реквизиты — по запросу на ту же почту.</p></div>',
                'sort_order' => 2,
            ],
            // ——— privacy ———
            [
                'page_key' => 'privacy',
                'key' => 'hero',
                'admin_label' => 'Заголовок страницы',
                'title' => 'Политика конфиденциальности',
                'subtitle' => 'Действует с __CURRENT_YEAR__ года. Редакция может обновляться — актуальная версия всегда на этой странице.',
                'title_level' => 'h1',
                'body' => null,
                'sort_order' => 1,
            ],
            [
                'page_key' => 'privacy',
                'key' => 's1',
                'admin_label' => '1. Кто мы',
                'title' => '1. Кто мы',
                'subtitle' => null,
                'title_level' => 'h2',
                'body' => '<p>ProstoYoga — онлайн-сервис доступа к образовательному контенту по йоге и телесным практикам. Оператор обрабатывает данные в целях предоставления доступа, коммуникации и улучшения качества сервиса.</p>',
                'sort_order' => 2,
            ],
            [
                'page_key' => 'privacy',
                'key' => 's2',
                'admin_label' => '2. Какие данные собираем',
                'title' => '2. Какие данные собираем',
                'subtitle' => null,
                'title_level' => 'h2_spaced',
                'body' => '<p>Имя, email, данные аккаунта; технические данные (IP, cookie, тип устройства) — в объёме, необходимом для работы сайта и аналитики; при оплате — данные, которые передаёт платёжный провайдер (мы не храним полные данные банковских карт на своих серверах).</p>',
                'sort_order' => 3,
            ],
            [
                'page_key' => 'privacy',
                'key' => 's3',
                'admin_label' => '3. Цели обработки',
                'title' => '3. Цели обработки',
                'subtitle' => null,
                'title_level' => 'h2_spaced',
                'body' => '<p>Регистрация и вход, выдача доступа к материалам, поддержка пользователей, реферальная программа, соблюдение законодательства, защита прав.</p>',
                'sort_order' => 4,
            ],
            [
                'page_key' => 'privacy',
                'key' => 's4',
                'admin_label' => '4. Права пользователя',
                'title' => '4. Права пользователя',
                'subtitle' => null,
                'title_level' => 'h2_spaced',
                'body' => '<p>Ты можешь запросить доступ к своим данным, уточнение, ограничение, удаление (если это не противоречит закону) — через <a href="mailto:__CONTACT_EMAIL__">__CONTACT_EMAIL__</a>.</p>',
                'sort_order' => 5,
            ],
            [
                'page_key' => 'privacy',
                'key' => 's5',
                'admin_label' => '5. Cookie',
                'title' => '5. Cookie',
                'subtitle' => null,
                'title_level' => 'h2_spaced',
                'body' => '<p>Cookie — небольшие файлы, которые сайт сохраняет в браузере. Мы используем их для сессии и входа в аккаунт (технически необходимые), запоминания настроек и, при подключении аналитики, — в обезличенном виде.</p><p class="mt-4">Ты можешь отключить cookie в настройках браузера; без части из них вход и личный кабинет могут работать некорректно.</p>',
                'sort_order' => 6,
            ],
            // ——— personal_data ———
            [
                'page_key' => 'personal_data',
                'key' => 'hero',
                'admin_label' => 'Заголовок',
                'title' => 'Согласие на обработку персональных данных',
                'subtitle' => 'Документ для заказчиков и пользователей: в общих чертах описывает правовую основу обработки.',
                'title_level' => 'h1',
                'body' => null,
                'sort_order' => 1,
            ],
            [
                'page_key' => 'personal_data',
                'key' => 'p1',
                'admin_label' => 'Абзац 1',
                'title' => null,
                'subtitle' => null,
                'title_level' => 'none',
                'body' => '<div class="mt-10 space-y-6 text-[#5c655c] leading-relaxed"><p>Регистрируясь на сайте ProstoYoga и/или оформляя доступ к курсу, вы подтверждаете, что ознакомлены с <a href="'.route('pages.privacy').'" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">политикой конфиденциальности</a> и даёте согласие на обработку персональных данных (в т.ч. имя, email, технические данные, история обращений в поддержку) способами и в целях, указанных в политике.</p><p>Согласие на рассылку (если есть отдельная подписка) даётся отдельно через двойное подтверждение или галочку в форме.</p><p>Согласие можно отозвать, написав на <a href="mailto:__CONTACT_EMAIL__" class="text-[#869274] underline underline-offset-2 hover:text-[#2d312d]">__CONTACT_EMAIL__</a>. Отзыв не влияет на законность обработки до момента отзыва.</p></div>',
                'sort_order' => 2,
            ],
            // ——— terms ———
            [
                'page_key' => 'terms',
                'key' => 'hero',
                'admin_label' => 'Заголовок',
                'title' => 'Публичная оферта',
                'subtitle' => 'Образовательный контент онлайн. Не является медицинской услугой.',
                'title_level' => 'h1',
                'body' => null,
                'sort_order' => 1,
            ],
            [
                'page_key' => 'terms',
                'key' => 's1',
                'admin_label' => '1. Предмет',
                'title' => '1. Предмет',
                'subtitle' => null,
                'title_level' => 'h2',
                'body' => '<p>Исполнитель предоставляет пользователю доступ к видеоматериалам и сопутствующим материалам курса ProstoYoga на срок и на условиях выбранного тарифа.</p>',
                'sort_order' => 2,
            ],
            [
                'page_key' => 'terms',
                'key' => 's2',
                'admin_label' => '2. Оплата и доступ',
                'title' => '2. Оплата и доступ',
                'subtitle' => null,
                'title_level' => 'h2_spaced',
                'body' => '<p>Доступ открывается после подтверждения оплаты платёжной системой. Срок доступа указан в описании тарифа.</p>',
                'sort_order' => 3,
            ],
            [
                'page_key' => 'terms',
                'key' => 's3',
                'admin_label' => '3. Ограничение ответственности',
                'title' => '3. Ограничение ответственности',
                'subtitle' => null,
                'title_level' => 'h2_spaced',
                'body' => '<p>Практика — на свой страх и риск; при заболеваниях проконсультируйтесь с врачом. Мы не гарантируем конкретный результат.</p>',
                'sort_order' => 4,
            ],
            [
                'page_key' => 'terms',
                'key' => 's4',
                'admin_label' => '4. Возврат',
                'title' => '4. Возврат',
                'subtitle' => null,
                'title_level' => 'h2_spaced',
                'body' => '<p>Условия возврата регулируются законодательством РФ и договором с платёжным агрегатором. Запросы на <a href="mailto:__CONTACT_EMAIL__">__CONTACT_EMAIL__</a>.</p>',
                'sort_order' => 5,
            ],
            // ——— referrals ———
            [
                'page_key' => 'referrals',
                'key' => 'intro',
                'admin_label' => 'Заголовок и вводный абзац',
                'title' => 'Реферальная программа',
                'subtitle' => null,
                'title_level' => 'h1',
                'body' => '<p class="mt-4 text-base leading-relaxed text-[#5c655c]">Ты делишься ссылкой или кодом — друг покупает курс. С оплаты тебе начисляется доля: <strong class="text-[#2d312d]">__COMMISSION_PERCENT__%</strong> от суммы, которую он реально заплатил (после скидки по промокоду, если она была).</p>',
                'sort_order' => 1,
            ],
            [
                'page_key' => 'referrals',
                'key' => 'how',
                'admin_label' => 'Как это устроено',
                'title' => 'Как это устроено',
                'subtitle' => null,
                'title_level' => 'h2_spaced_sm',
                'body' => '<ol class="mt-4 list-decimal space-y-2 pl-5 text-[#5c655c] leading-relaxed"><li>Регистрируешься — в кабинете в разделе «Рефералы» лежат ссылка и код.</li><li>Друг переходит по ссылке или вводит код при регистрации.</li><li>После успешной оплаты курса начисляется бонус.</li></ol>',
                'sort_order' => 2,
            ],
            [
                'page_key' => 'referrals',
                'key' => 'promo',
                'admin_label' => 'Промокод',
                'title' => 'Промокод',
                'subtitle' => null,
                'title_level' => 'h2_spaced_sm',
                'body' => '<p class="mt-3 text-[#5c655c] leading-relaxed">Скидка по промокоду и реферал не одно и то же. Процент с реферала считается с суммы после скидки.</p>',
                'sort_order' => 3,
            ],
            [
                'page_key' => 'referrals',
                'key' => 'limits',
                'admin_label' => 'Ограничения',
                'title' => 'Ограничения',
                'subtitle' => null,
                'title_level' => 'h2_spaced_sm',
                'body' => '<ul class="mt-3 list-disc space-y-2 pl-5 text-[#5c655c] leading-relaxed"><li>Бонус только после подтверждённой оплаты.</li><li>Без перехода по ссылке и без кода при регистрации привязка может не сохраниться.</li><li>Выплаты — по правилам проекта; вопросы: <a href="__SUPPORT_URL__">поддержка</a>.</li></ul>',
                'sort_order' => 4,
            ],
            [
                'page_key' => 'referrals',
                'key' => 'footer_note',
                'admin_label' => 'Текст над кнопками входа',
                'title' => null,
                'subtitle' => null,
                'title_level' => 'none',
                'body' => '<p class="text-sm text-[#7a837a]">Ссылку и код видно только в аккаунте.</p>',
                'sort_order' => 5,
            ],
            [
                'page_key' => 'referrals',
                'key' => 'back',
                'admin_label' => 'Ссылка «На главную»',
                'title' => null,
                'subtitle' => null,
                'title_level' => 'none',
                'body' => '<p class="mt-12 text-sm text-[#7a837a]"><a href="__MARKETING_HOME__" class="text-[#869274] hover:text-[#2d312d]">← На главную</a></p>',
                'sort_order' => 6,
            ],
        ];

        foreach ($rows as $row) {
            SitePageBlock::query()->updateOrCreate(
                [
                    'page_key' => $row['page_key'],
                    'key' => $row['key'],
                ],
                [
                    ...$row,
                    'is_active' => true,
                ]
            );
        }

        SitePageBlock::bustCache();
    }
}
