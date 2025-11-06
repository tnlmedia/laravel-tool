# Container

`Container` is a basic key/value storage utility used throughout the package.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Containers\Container`.
2. Modify `$data` property for default structure if needed.
3. Override `export()` method to customize exported data if needed.
4. Write phpdoc for your custom container class to describe stored keys.

## Sample

```php
$container = new TargetContainer();
$container->setKey('value');
return $container->export();
```

## Methods

- `setData(?string $key, $value): Container`: Set value for a key, can use dot notation for nested keys.
- `pushData(?string $key, $value): Container`: Push value into array or combine value at key, can use dot notation for nested keys.
    - array: Append value to array
    - int: Plus value to current value
    - float: Plus value to current value
    - string: Combine value to end of string`
- `getData(?string $key = null, mixed $default = null): mixed`: Get value for a key, can use dot notation for nested keys.
- `checkData(?string $key): bool`: Check if value is `true` for a key, can use dot notation for nested keys.
- `export(): array`: Export all stored data as an array.

### Magic methods

`setData()`, `pushData()`, `getData()`, and `checkData()` methods can be called using magic methods.

If data structure is:

```php
$data = [
    'first' => [
        'second' => null,
    ],
];
```

- `setFirstSecond(?string $key, $value): Container`: Set value for `first.second.$key`.
- `setFirstSecond($value): Container`: Set value for `first.second`.
- `pushFirstSecond(?string $key, $value): Container`: Push value into array or combine value at `first.second.$key`.
- `pushFirstSecond($value): Container`: Push value into array or combine value at `first.second`.
- `getFirstSecond(?string $key = null, mixed $default = null): mixed`: Get value for `first.second.$key`.
- `getFirstSecond(mixed $default = null): mixed`: Get value for `first.second`.
- `checkFirstSecond(?string $key): bool`: Check if value is `true` for `first.second.$key`.
- `checkFirstSecond(): bool`: Check if value is `true` for `first.second`.
