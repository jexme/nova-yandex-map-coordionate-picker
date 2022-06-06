<?php

declare(strict_types=1);

namespace Jexme\YandexMapPicker;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Jexme\YandexMapPicker\Traits\LoadTranslate;

class FieldServiceProvider extends ServiceProvider
{
    use LoadTranslate;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config' => config_path(),
            ], 'yandex-map-picker-config');

            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/yandex-map-picker'),
            ], 'yandex-map-picker-lang');
        }

        Nova::serving(function (ServingNova $event) {
            Nova::script('yandex-map-picker', __DIR__ . '/../dist/js/field.js');
            Nova::style('yandex-map-picker', __DIR__ . '/../dist/css/field.css');

            $locale = app()->getLocale();
            Nova::remoteScript(sprintf(
                "https://api-maps.yandex.ru/2.1/?lang=%s&apikey=%s",
                strtolower($locale) . '_' . strtoupper($locale),
                config('yandex-map-picker.api_key', ''),
            ));

            $this->loadTranslates();
        });
    }
}
