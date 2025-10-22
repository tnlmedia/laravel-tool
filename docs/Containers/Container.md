# Containers/Container

Overview

`Container` is a small key/value storage utility used throughout the package. It provides explicit methods for manipulating stored data (`setData`, `pushData`, `getData`, `checkData`) and also exposes a dynamic `__call` convenience for camel-cased helper calls.

Public methods

- `setData(?string $key, $value): Container`
  - Stores `$value` at `$key` (dot notation supported). Returns the container for chaining.
  - Example: `$c->setData('shared.title', 'Hello');`

- `pushData(?string $key, $value): Container`
  - If the key does not exist, sets it to `$value`.
  - If current value is array, appends `$value`.
  - If current value and `$value` are integers/floats, adds numerically.
  - Otherwise concatenates strings.
  - Returns the container for chaining.
  - Example: `$c->pushData('numbers', 3);`

- `getData(?string $key = null, mixed $default = null): mixed`
  - Retrieves value stored at `$key` or `$default` if missing. If `$key` is null, returns the entire backing array.
  - Example: `$title = $c->getData('shared.title', 'default');`

- `checkData(?string $key): bool`
  - Returns boolean truthiness for `$key` (non-empty values yield `true`).
  - Example: `if ($c->checkData('shared.image')) { ... }`

- `export(): array`
  - Returns the entire internal data array.

Dynamic helpers via `__call`

- You can call helper methods like `setSharedTitleBasic('value')`, `pushSharedId(5)`, `getSharedUrl()` and `checkShared('key')`.
- The `__call` implementation maps method names with prefixes `(set|push|get|check)` and camel-cased suffixes into dot-notated keys.

Example

```php
$c = new Container();
$c->setData('shared.title', 'Hi');
$c->pushData('tags', 'news');
echo $c->getData('shared.title');
```

