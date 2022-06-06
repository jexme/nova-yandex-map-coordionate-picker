<?php

declare(strict_types=1);

namespace Jexme\YandexMapPicker;

use Laravel\Nova\Fields\Field;

class YandexMapPicker extends Field
{
    private const DEFAULT_ZOOM = 12;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'yandex-map-picker';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'apiKey' => config('yandex-map-picker.api_key'),
            'zoom'   => self::DEFAULT_ZOOM,
        ]);
    }

    public function setZoom(int $zoom): self
    {
        $this->withMeta([
            'zoom' => $zoom >= 1 && $zoom <= 20 ? $zoom : self::DEFAULT_ZOOM,
        ]);

        return $this;
    }
}
