# Helpers/TMGBladeHelper.php

Overview

`TMGBladeHelper` is a helper class that aggregates page "material" (metadata), renders header analytics/advertising HTML and produces ad slot markup. It is the main integration point used by the package facade `TMGBlade`.

Class: TNLMedia\LaravelTool\Helpers\TMGBladeHelper

Methods (detailed)

- `renderHeader(): string`
  - Description: Composes analytics (GA4, GTM, Comscore, Facebook, Chartbeat, tracking) and advertising header HTML by rendering Blade partials and package config.
  - Parameters: none
  - Returns: `string` — full HTML to be inserted into `<head>`.
  - Example: `echo TMGBlade::renderHeader();`

- `setMaterial(string $key, $value): self`
  - Description: Set nested material metadata used for analytics/advertising. Accepts dot-notated keys (delegates to `Arr::set`).
  - Example: `TMGBlade::setMaterial('page.key', 'article');`
  - Returns: `$this`.

- `setTargeting(string $key, array $list = []): self`
  - Description: Add or replace custom ad targeting keys. Values are cast to strings.
  - Example: `TMGBlade::setTargeting('author', ['alice','bob']);`

- `renderSlot(string $name, array $config = []): string`
  - Description: Render an ad slot by merging default config from `tmg-advertising.slot.{name}` with supplied `$config` and page targeting.
  - Parameters:
    - `$name` (string): slot name configured in package config.
    - `$config` (array): overrides (targeting, size, mapping, class, style, etc.).
  - Returns: `string` — HTML fragment for the ad slot or an HTML comment on invalid config.
  - Example:

```php
$html = TMGBlade::renderSlot('leaderboard', ['targeting' => ['section' => ['news']]]);
```

Notes

- `renderSlot` validates the presence of slot defaults in config and required fields like `slot` and `size`.
- For advanced usage, adjust `config('tmg-advertising.slot')` to define default definitions.
