<?php

namespace Jexme\YandexMapPicker\Traits;

use Laravel\Nova\Nova;

trait LoadTranslate
{
    protected function loadTranslates(): void
    {
        $path = $this->pathToAnExistingLocalizationFile([app()->getLocale(), config('app.fallback_locale')]);

        Nova::translations($path);
    }

    protected function pathToAnExistingLocalizationFile(array $localeFiles = []): ?string
    {
        foreach ($localeFiles as $localeFile) {
            if (!is_string($localeFile)) {
                continue;
            }

            $path = $this->pathToLocalizationFile($localeFile);
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    protected function pathToLocalizationFile(string $locale): string
    {
        return __DIR__ . '/../../resources/lang/' . $locale . '.json';
    }
}