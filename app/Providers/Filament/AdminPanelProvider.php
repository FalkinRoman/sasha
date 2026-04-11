<?php

namespace App\Providers\Filament;

use App\Filament\Resources\LandingSections\LandingSectionResource;
use App\Filament\Resources\SitePageBlocks\SitePageBlockResource;
use App\Models\SitePageBlock;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public static function sitePageBlocksNavActive(string $pageKey): bool
    {
        if (request()->routeIs('filament.filament.resources.site-page-blocks.index')) {
            return request()->query('p') === $pageKey;
        }

        if (request()->routeIs('filament.filament.resources.site-page-blocks.edit')) {
            $record = request()->route('record');

            return $record instanceof SitePageBlock && $record->page_key === $pageKey;
        }

        return false;
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('filament')
            ->path('filament')
            ->brandName('Контент сайта')
            ->authGuard('web')
            ->login()
            ->colors([
                'primary' => Color::hex('#869274'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->navigationItems([
                NavigationItem::make('Админка Laravel')
                    ->url(fn (): string => url('/admin'))
                    ->icon(Heroicon::OutlinedRectangleGroup)
                    ->group('Кабинет ProstoYoga')
                    ->sort(1),
                NavigationItem::make('Главная — лендинг')
                    ->url(fn (): string => LandingSectionResource::getUrl())
                    ->icon(Heroicon::OutlinedHome)
                    ->group('Страницы сайта')
                    ->sort(10)
                    ->isActiveWhen(fn (): bool => request()->routeIs([
                        'filament.filament.resources.landing-sections.index',
                        'filament.filament.resources.landing-sections.edit',
                    ])),
                NavigationItem::make('Поддержка')
                    ->url(fn (): string => SitePageBlockResource::getUrl('index').'?p=support')
                    ->icon(Heroicon::OutlinedLifebuoy)
                    ->group('Страницы сайта')
                    ->sort(11)
                    ->isActiveWhen(fn (): bool => self::sitePageBlocksNavActive('support')),
                NavigationItem::make('Контакты')
                    ->url(fn (): string => SitePageBlockResource::getUrl('index').'?p=contacts')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->group('Страницы сайта')
                    ->sort(12)
                    ->isActiveWhen(fn (): bool => self::sitePageBlocksNavActive('contacts')),
                NavigationItem::make('Политика конфиденциальности')
                    ->url(fn (): string => SitePageBlockResource::getUrl('index').'?p=privacy')
                    ->icon(Heroicon::OutlinedShieldCheck)
                    ->group('Страницы сайта')
                    ->sort(13)
                    ->isActiveWhen(fn (): bool => self::sitePageBlocksNavActive('privacy')),
                NavigationItem::make('Персональные данные')
                    ->url(fn (): string => SitePageBlockResource::getUrl('index').'?p=personal_data')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->group('Страницы сайта')
                    ->sort(14)
                    ->isActiveWhen(fn (): bool => self::sitePageBlocksNavActive('personal_data')),
                NavigationItem::make('Публичная оферта')
                    ->url(fn (): string => SitePageBlockResource::getUrl('index').'?p=terms')
                    ->icon(Heroicon::OutlinedDocumentMagnifyingGlass)
                    ->group('Страницы сайта')
                    ->sort(15)
                    ->isActiveWhen(fn (): bool => self::sitePageBlocksNavActive('terms')),
                NavigationItem::make('Реферальная программа (лендинг)')
                    ->url(fn (): string => SitePageBlockResource::getUrl('index').'?p=referrals')
                    ->icon(Heroicon::OutlinedUserGroup)
                    ->group('Страницы сайта')
                    ->sort(16)
                    ->isActiveWhen(fn (): bool => self::sitePageBlocksNavActive('referrals')),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_START,
                fn (): string => view('filament.hooks.sidebar-current-heading')->render(),
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => view('filament.styles.compact-landing-file-upload')->render(),
            );
    }
}
