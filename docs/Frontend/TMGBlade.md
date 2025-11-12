# TMGBlade

`TMGBlade` is a facade for Laravel Blade that renders analytics and advertising HTML snippets.

## TMGBlade::renderHeader()

Returns header HTML containing analytics and advertising bootstrap code.

Configure analytics and advertising settings in the `tmg-analytics` and `tmg-advertising` configuration files.

Example:

```php
{{ TMGBlade::renderHeader() }}
```

## TMGBlade::setTargeting($key, $list = [])

Set custom Google Ad Manager targeting keys and values. `$key` is the targeting key (string). `$list` is an array of string values.

Example:

```php
TMGBlade::setTargeting('section', ['news', 'sports']);
```

## TMGBlade::setMaterial($key, $value)

Set nested material metadata used for analytics and converted into advertising targeting. See material structure details in the `tmg-analytics` configuration file.

Example:

```php
TMGBlade::setMaterial('author', 'John Doe');
```

## TMGBlade::renderSlot($name, $config = [])

Render an ad slot by merging the default config from `tmg-advertising.slot.{name}` with the supplied `$config` and page targeting.

Example:

```php
{{ TMGBlade::renderSlot('leaderboard', ['targeting' => ['section' => ['news']]]) }}
```
