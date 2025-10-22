# PHP Laravel toolkit

This repository includes a small Laravel helper/toolkit used for analytics, advertising and small API clients.

## Documentation

Full documentation is available in the `docs/` folder. Open the index:

- `(docs/INDEX.md)[docs/INDEX.md]` — primary index and overview for this package.

## Install

```shell
composer require tnlmedia/laravel-tool
```

## Configuration

```shell
php artisan vendor:publish --tag=tmg-config
```

Configuration files produced by the above command include:

| Name                | Description           |
|---------------------|-----------------------|
| tmg-advertising.php | Advertising config    |
| tmg-website.php     | Website global config |
| tmg-analytics.php   | Analytics config      |

## Compatibility & Requirements

- PHP: 8.2+ (tested on PHP 8.4)
- Laravel: 8.0+ (tested on Laravel 12.x)
