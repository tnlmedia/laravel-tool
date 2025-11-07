# Container

`Container` is a basic key/value storage utility used throughout the package.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Containers\Container`.
2. Modify the `$data` property to change the default structure if needed.
3. Override the `export()` method to customize exported data if required.
4. Add PHPDoc for your custom container class to describe stored keys.

## Sample

```php
$container = new TargetContainer();
$container->setKey('value');
return $container->export();
```

## Methods

- `setData(?string $key, $value): Container`: Set a value for a key; supports dot notation for nested keys.
- `pushData(?string $key, $value): Container`: Push a value into an array or combine a value at a key; supports dot notation for nested keys.
    - array: Append value to array.
    - int: Add value to current integer value.
    - float: Add value to current float value.
    - string: Concatenate the value to the end of the string.
- `getData(?string $key = null, mixed $default = null): mixed`: Get a value for a key; supports dot notation for nested keys.
- `checkData(?string $key): bool`: Check whether a value is `true` for a key; supports dot notation for nested keys.
- `export(): array`: Export all stored data as an array.

### Magic methods

The `setData()`, `pushData()`, `getData()`, and `checkData()` methods can be called using magic methods.

If the data structure is:

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
- `checkFirstSecond(?string $key): bool`: Check whether value is `true` for `first.second.$key`.
- `checkFirstSecond(): bool`: Check whether value is `true` for `first.second`.
