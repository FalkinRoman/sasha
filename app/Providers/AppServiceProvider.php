<?php

namespace App\Providers;

use App\Models\LandingSection;
use App\Models\Purchase;
use App\Support\MarketingUrl;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* Сообщения валидации / auth из lang/ru — без этого при отсутствии файлов был бы английский из фреймворка */
        App::setLocale('ru');

        Carbon::setLocale('ru');

        /* После config:cache без пересборки ключа contact_email бывает null — пустые mailto в футере */
        $contact = config('prostoy.contact_email');
        View::share('contactEmail', is_string($contact) && $contact !== '' ? $contact : 'prostoyoga@mail.ru');

        View::share('marketingHome', MarketingUrl::base());

        View::composer('partials.marketing-footer', function (\Illuminate\View\View $view): void {
            $footer = LandingSection::mapForView()->get('footer_brand');
            $view->with('landingFooterBrandBody', $footer?->body);
        });

        View::composer('layouts.admin', function (\Illuminate\View\View $view): void {
            $view->with(
                'adminPendingPurchasesCount',
                Purchase::query()->where('status', 'pending')->count()
            );
        });

        View::composer('partials.marketing-header', function (\Illuminate\View\View $view): void {
            $view->with([
                'presaleTopBar' => false,
                'presaleTopBarPercent' => null,
            ]);
        });

        /** Не зависит от intl / локали PHP — всегда русские названия месяцев */
        Carbon::macro('toRussianLongDate', function (): string {
            /** @var Carbon $this */
            $months = [
                1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня',
                7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря',
            ];

            return $this->day.' '.$months[(int) $this->month].' '.$this->year.' г.';
        });
    }
}
