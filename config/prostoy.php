<?php

$videoExplicit = env('VIDEO_UPLOAD_MAX_MB');
$videoUploadMaxMb = max(1, (int) (
    $videoExplicit !== null && $videoExplicit !== ''
        ? $videoExplicit
        : env('LESSON_VIDEO_MAX_MB', 16384)
));

return [

    /*
    |--------------------------------------------------------------------------
    | Предпродажа в кабинете и ценах
    |--------------------------------------------------------------------------
    | Включение «этапа предпродажи» для участников — переключатель в админке «Настройки» (/admin/settings):
    | таблица site_settings.cabinet_presale_mode. От него зависят тексты, скидка PRESALE20
    | в корзине и отсутствие отсчёта срока доступа до переключения на «проект запущен».
    |
    | PRESALE_MANUAL_PAYMENT=true: заказ в статусе «ожидает оплаты», доступ после подтверждения
    | админом или ЮKassa.
    */
    'presale_manual_payment' => env('PRESALE_MANUAL_PAYMENT', true),

    /** Промокод из БД: автоматически учитывается в расчёте, пока cabinet_presale_mode = true. */
    'presale_auto_promo_code' => env('PRESALE_AUTO_PROMO_CODE', 'PRESALE20'),

    /** Единая почта поддержки и контактов (футер, страницы, письма). */
    'contact_email' => env('PROSTOY_CONTACT_EMAIL', 'prostoyoga@mail.ru'),

    /** SEO / Open Graph: название бренда, описание по умолчанию, превью для соцсетей (герой). */
    'site_name' => env('PROSTOY_SITE_NAME', 'PROSTO.YOGA'),

    'meta_description' => env(
        'PROSTOY_META_DESCRIPTION',
        'PROSTO.YOGA — 12 практик онлайн, 3 раза в неделю. За 30 дней: осанка, тело, энергия. Тарифы и предпродажа на prostoyoga.ru.'
    ),

    /** Путь от public/ или полный URL для og:image (шаринг ссылки). */
    'og_image' => env('PROSTOY_OG_IMAGE', 'images/figma/decstop.webp'),

    'og_image_width' => (int) env('PROSTOY_OG_IMAGE_WIDTH', 1920),

    'og_image_height' => (int) env('PROSTOY_OG_IMAGE_HEIGHT', 1080),

    /**
     * Макс. размер видеофайла в админке (МБ): уроки + превью лендинга (Filament / Livewire).
     * Приоритет: VIDEO_UPLOAD_MAX_MB, иначе LESSON_VIDEO_MAX_MB (дефолт 16384 ≈ 16 ГБ).
     * Синхронизируй с PHP upload_max_filesize / post_max_size (в Docker — docker/php/conf.d/99-prostoyoga-uploads.ini) и nginx client_max_body_size.
     * Кодек на сервере не меняется: в кабинете нативный плеер (video) — для всех ОС/браузеров лучше H.264 (AVC) + AAC в mp4/mov; HEVC с iPhone в Chrome на части ПК может не играться.
     */
    'lesson_video_max_mb' => $videoUploadMaxMb,

    /**
     * Пока в слоте «Отзывы» нет своего видео — в модалке играет этот URL (https .mp4).
     * Переопредели в .env: REVIEW_TILES_PLACEHOLDER_VIDEO_URL=
     */
    'review_tiles_placeholder_video_url' => (static function (): string {
        $u = env('REVIEW_TILES_PLACEHOLDER_VIDEO_URL');
        if (is_string($u) && trim($u) !== '') {
            return trim($u);
        }

        return 'https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4';
    })(),

    /** Промокод блогера: скидка участнику, % от полной цены тарифа (до скидки) — вознаграждение блогеру. */
    'blogger_promo_discount_percent' => (int) env('BLOGGER_PROMO_DISCOUNT_PERCENT', 10),

    'blogger_commission_percent' => (int) env('BLOGGER_COMMISSION_PERCENT', 10),

];
