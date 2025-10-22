# Containers/ApiContainer

Overview

`ApiContainer` extends `Container` to provide a standard API response payload shape and convenience helpers for setting the `data` result. It also supports building a `JsonResponse` from the container.

Default data structure

- `code` (int) — default `20000` (API-level success code)
- `data` (mixed) — payload content
- `message` (string) — human readable message
- `hint` (string) — optional internal hint

Dynamic result helpers (via `__call`)

- `setResult(?string $key = null, mixed $value = null): ApiContainer`
  - If `$key` is null sets entire `data` to `$value`. If key provided, sets nested data `data.key = value`.
  - Returns the container.
  - Example: `$api->setResult('user', ['id'=>1]);`

- `pushResult(?string $key = null, mixed $value = null): ApiContainer`
  - Pushes value into `data` or nested key. Behaves like `pushData`.

- `getResult(?string $key = null, mixed $default = null): mixed`
  - Retrieves `data` or nested key.

- `checkResult(?string $key = null): bool`
  - Truthy check for `data` or nested key.

Errors and exceptions

- `throwError(Throwable $throwable, string $message = '', string $hint = ''): ApiContainer`
  - Populates `code`, `message` and `hint` from a Throwable. If the Throwable has a `render()` method that returns JSON, the command tries to extract `message` and `hint` from it.
  - Example usage in a controller's catch block:

```php
try {
    // ... do work
} catch (Throwable $e) {
    return $api->throwError($e)->response();
}
```

Building the HTTP response

- `response(): JsonResponse` — builds a JSON response from the container, maps the API `code` to an HTTP status by taking the first three digits (falls back to 500 on invalid codes), and sets `Cache-Control` headers.

Example

```php
$api = new ApiContainer();
$api->setResult(null, ['hello' => 'world']);
return $api->response();
```

