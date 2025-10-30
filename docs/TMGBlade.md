# TMGBlade

`TMGBlade` is a facade for laravel blade quickly rendering analytics and advertising HTML.

## `TMGBlade::renderHeader()`

Returns header HTML with analytics and advertising bootstrap.

You can configure analytics and advertising settings in the `tmg-analytics` and `tmg-advertising` config files.

Example:

```php
{{ TMGBlade::renderHeader() }}
```

## `TMGBlade::setTargeting($key, $list = [])`

Sets custom google ad manager targeting keys and values.

## `TMGBlade::setMaterial($key, $value)`

Sets nested material metadata used for analytics and convert to advertising targeting.

See material structure details in `tmg-analytics` config file. TODO: TBD

## `TMGBlade::renderSlot($name, $config = [])`

Render an ad slot by merging default config from `tmg-advertising.slot.{name}` with supplied `$config` and page targeting.

Example:

```php
{{ TMGBlade::renderSlot('leaderboard', ['targeting' => ['section' => ['news']]]) }}
```
