# TMGBlade

`TMGBlade` is a facade for Laravel Blade that renders analytics and advertising HTML snippets.

## `TMGBlade::renderHeader()`

Returns header HTML with analytics and advertising bootstrap.

You can configure analytics and advertising settings in the `tmg-analytics` and `tmg-advertising` config files.

Example:

```php
{{ TMGBlade::renderHeader() }}
```

## `TMGBlade::setTargeting($key, $list = [])`

Sets custom Google Ad Manager targeting keys and values. `$key` is the targeting key (string) and `$list` is an array of string values.

## `TMGBlade::setMaterial($key, $value)`

Sets nested material metadata used for analytics and converted into advertising targeting. See material structure details in the `tmg-analytics` config file.

## `TMGBlade::renderSlot($name, $config = [])`

Renders an ad slot by merging default config from `tmg-advertising.slot.{name}` with the supplied `$config` and page targeting.

Example:

```php
{{ TMGBlade::renderSlot('leaderboard', ['targeting' => ['section' => ['news']]]) }}
```
