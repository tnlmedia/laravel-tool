# PHP Laravel toolkit

## Install

```shell
composer require tnlmedia/laravel-tool
```

### Config

```shell
php artisan vendor:publish --tag=tmg-config
```

| Name                | Description           |
|---------------------|-----------------------|
| tmg-advertising.php | Advertising config    |
| tmg-website.php     | Website global config |

## How to use

### Advertising

```php
// Set page targeting
$key = 'targeting-key';
$list = ['value1', 'value2'];
TMGBlade::setTargeting($key, $list);
```

```php
// In blade <head> for advertising core javascript
{!! TMGBlade::renderHeader() !!}
```

```php
// In blade slot position
// You can override config if need
{!! TMGBlade::renderSlot('sample', [
    'targeting' => [
        'key1' => ['value1'],
        'key2' => ['value2', 'value3'],
    ],
]) !!}
```

### Website core

TBD

## Available PHP version

* 8.2
* 8.4

## Available Laravel version

* 8.x
* 9.x
* 10.x
* 11.x
