# Nova Yandex Map Picker

This field allows you to select coordinates from Yandex.Maps for Laravel Nova

## Installation

You can install the package in to a Laravel app that uses Nova via composer:

```bash
composer require jexme/nova-yandex-map-coordionate-picker
```

Now publish config and localization files:

```shell
php artisan vendor:publish --tag=yandex-map-picker-config
php artisan vendor:publish --tag=yandex-map-picker-lang
```

Add your api key to .env file

```shell
YANDEX_MAP_PICKER_API_KEY=#######################
```

## Usage

Add the use declaration to your resource and use the fields:

```php
use Jexme\YandexMapPicker\YandexMapPicker;
// ....

YandexMapPicker::make('Coordinates'),

// also you can set zoom from 1 to 20 (default: 12)
YandexMapPicker::make('Coordinates')->setZoom(12),
```
