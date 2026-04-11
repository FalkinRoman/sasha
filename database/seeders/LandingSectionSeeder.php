<?php

namespace Database\Seeders;

use App\Models\LandingSection;
use Illuminate\Database\Seeder;

class LandingSectionSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'key' => 'hero',
                'admin_label' => 'Герой (первый экран)',
                'sort_order' => 10,
                'title' => 'Всё на самом деле просто.',
                'subtitle' => 'PROSTO.YOGA',
                'body' => <<<'HTML'
<div class="space-y-3 text-base leading-relaxed text-[#eef1e8] drop-shadow-md md:text-[1.05rem]">
<p><span class="font-semibold text-[#eaf3dd]">PROSTO</span> возьми коврик.</p>
<p><span class="font-semibold text-[#eaf3dd]">PROSTO</span> доверься.</p>
<p><span class="font-semibold text-[#eaf3dd]">PROSTO</span> скажи «Блин, а ведь я это сделала!»</p>
</div>
<p class="mt-8 max-w-xl text-sm leading-relaxed text-[#dfe6d8] md:text-base">Результат за 30 дней: ровная осанка, круглая попа, плоский живот, горящие глаза и чувство «я крутая».</p>
<p class="mt-6 max-w-lg text-xs leading-relaxed text-[#b8c4ae] md:text-[13px]">Для девушек, которые хотят выглядеть и чувствовать себя на миллион уже этим летом. Ты уже готова. Prosto ещё не знаешь об этом…</p>
HTML,
            ],
            [
                'key' => 'results_30',
                'admin_label' => 'Блок «Результаты» — заголовки',
                'sort_order' => 20,
                'title' => 'РЕЗУЛЬТАТЫ',
                'subtitle' => 'И это будет самое приятное «Блин, я это сделала» в твоей жизни.',
                'body' => null,
            ],
            [
                'key' => 'practice_gallery',
                'admin_label' => 'Галерея «Горящие глаза»',
                'sort_order' => 30,
                'title' => 'Горящие глаза после практики',
                'subtitle' => 'Атмосфера',
                'body' => '<p class="text-base leading-relaxed text-[#5c655c] md:text-lg">Подборка кадров с занятий — как выглядит энергия и радость после того, как выдохнули и сделали своё.</p>',
            ],
            [
                'key' => 'practice_gallery_footer',
                'admin_label' => 'Галерея — текст под сеткой',
                'sort_order' => 35,
                'title' => null,
                'subtitle' => null,
                'body' => '<p>Здесь не про идеальную позу в кадре — улыбки, смех, лёгкий каприз и та самая свобода, когда можно вести себя по-честному, почти как дети: без маски «для фото».</p>',
            ],
            [
                'key' => 'preview_strip',
                'admin_label' => 'Превью видео (заголовки)',
                'sort_order' => 40,
                'title' => 'Загляни внутрь: темп, подача, атмосфера',
                'subtitle' => 'Стиль практики',
                'body' => null,
            ],
            [
                'key' => 'quiz',
                'admin_label' => 'PROSTO TEST (квиз)',
                'sort_order' => 50,
                'title' => 'PROSTO TEST',
                'subtitle' => null,
                'body' => '<p class="mx-auto mt-4 max-w-2xl text-base font-medium leading-snug text-[#3f463f] md:text-lg">За 22 секунды узнай, какая версия Prosto<br class="hidden sm:block">создана для тебя!</p>',
            ],
            [
                'key' => 'author',
                'admin_label' => 'Блок «Автор»',
                'sort_order' => 60,
                'title' => 'Александра Вихорева',
                'subtitle' => 'Автор программы',
                'body' => '<p class="text-lg leading-relaxed text-[#2d312d]">Мою йогу смотрят на IVI, Okko, World Class и в сети Fitmost. Но самое важное — я научилась снимать страх и делать так, чтобы даже новичок через неделю сказал: «Как круто, что я это могу!».</p>',
            ],
            [
                'key' => 'author_strip_caption',
                'admin_label' => 'Автор — над каруселью (подзаголовок) и цитата под ней',
                'sort_order' => 65,
                'title' => null,
                'subtitle' => 'Из зала, кемпа, дома',
                'body' => '<p>«Мне не важно где и не важно сколько вас… Каждая получит результат и останется довольной».</p>',
            ],
            [
                'key' => 'why_simple',
                'admin_label' => 'Тёмный блок «Зачем усложнять»',
                'sort_order' => 70,
                'title' => 'Зачем все усложнять, если всё PROSTO?',
                'subtitle' => null,
                'body' => <<<'HTML'
<div class="space-y-6 text-base leading-relaxed text-[#c5ccc0] md:text-lg">
<p>В 2026 году мир превратился в испытание.</p>
<p>Йога — в 8 ступеней просветления.<br>Тело — в бесконечные челленджи и «ты должна».<br>Голова — в «сначала подготовься, потом начнёшь».</p>
<p class="text-xl font-semibold tracking-wide text-[#f5a08a]">ХВАТИТ!</p>
<p><span class="font-semibold text-[#eaf3dd]">PROSTO.YOGA</span> — это не очередной курс.</p>
<p>Это когда ты просыпаешься и думаешь не «надо заставить себя», а «сегодня я prosto сделаю».</p>
<p>Это когда после практики ты выходишь заряженной.</p>
<p>Это когда через 30 дней ты смотришь в зеркало и впервые за долгое время думаешь: «Блин… я реально крутая».</p>
<p class="text-[#b8c4ae]">Здесь нет воды, нет эзотерики, нет давления.</p>
<p class="font-medium text-[#fffffa]">Здесь есть только ты, коврик и 12 лет моего опыта, чтобы у тебя всё получилось!</p>
</div>
HTML,
            ],
            [
                'key' => 'program_12',
                'admin_label' => '12 практик — вводный текст',
                'sort_order' => 80,
                'title' => '12 рабочих практик',
                'subtitle' => null,
                'body' => '<p class="text-sm leading-relaxed text-[#5c655c] md:text-base">График 3 раза в неделю. Никакого хаоса. Смотри первые 4, остальные подгрузи ниже.</p>',
            ],
            [
                'key' => 'surprise',
                'admin_label' => 'Блок «Сюрприз»',
                'sort_order' => 90,
                'title' => 'Чтобы ты точно дошла до конца',
                'subtitle' => 'Внутри тебя ждёт сюрприз',
                'body' => '<p class="text-base leading-relaxed text-[#5c655c] md:text-lg">Мы превратили прохождение программы в игру: бонусы, подарки, задания, особая валюта, призовые места и офлайн-выпускной после программы. Детали дополним — следи за чатом после старта.</p>',
            ],
            [
                'key' => 'reviews',
                'admin_label' => 'Отзывы — заголовок',
                'sort_order' => 100,
                'title' => 'Что пишут после практики со мной',
                'subtitle' => null,
                'body' => '<p class="text-lg text-[#5c655c]">С коврика это часто переходит в слова — благодарность, ощущения, про то, как веду урок. Ниже короткое видео и ещё от тех, кто уже занимался; зал или онлайн, без разницы.</p>',
            ],
            [
                'key' => 'reviews_ps',
                'admin_label' => 'Отзывы — P.S.',
                'sort_order' => 105,
                'title' => null,
                'subtitle' => null,
                'body' => '<p class="text-lg font-medium text-[#2d312d]">P.S. Ко мне ходят даже тренеры по йоге.</p>',
            ],
            [
                'key' => 'partners',
                'admin_label' => 'Партнёрская программа',
                'sort_order' => 110,
                'title' => 'Приходите вместе — выгоднее',
                'subtitle' => 'Партнёрская программа',
                'body' => <<<'HTML'
<p class="text-base leading-relaxed text-[#5c655c]">Если приходите с подругой — <span class="font-semibold text-[#2d312d]">скидка 15%</span> на общий чек.</p>
<p class="mt-4 text-base leading-relaxed text-[#5c655c]">Если есть кому порекомендовать программу — за каждого приведённого человека <span class="font-semibold text-[#2d312d]">кэшбэк 10%</span> от суммы его оплаты (условия в личном кабинете).</p>
HTML,
            ],
            [
                'key' => 'final_cta',
                'admin_label' => 'Финальный CTA',
                'sort_order' => 120,
                'title' => 'Лучше сделать и пожалеть, чем всё время жалеть о том, чего не сделала',
                'subtitle' => 'PROSTO ЗНАЙ',
                'body' => '<p class="text-lg text-[#c5ccc0]">Prosto начни. Prosto сделай. ProstoYoga.</p>',
            ],
            [
                'key' => 'footer_brand',
                'admin_label' => 'Футер — текст под логотипом',
                'sort_order' => 200,
                'title' => null,
                'subtitle' => null,
                'body' => '<p class="text-sm leading-relaxed text-[#9aa396]">Онлайн-практика для города: дыхание, осанка, движение без давления. Живи в теле — в своём темпе.</p>',
            ],
        ];

        foreach ($rows as $row) {
            LandingSection::query()->updateOrCreate(
                ['key' => $row['key']],
                [
                    'admin_label' => $row['admin_label'],
                    'title' => $row['title'],
                    'subtitle' => $row['subtitle'],
                    'body' => $row['body'],
                    'sort_order' => $row['sort_order'],
                    'is_active' => true,
                ]
            );
        }

        LandingSection::ensurePracticeGalleryFilesFromPublicDefaults();
        LandingSection::bustCache();
    }
}
