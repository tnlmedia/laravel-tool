# Libraries/CabinetClient.php

Overview

`CabinetClient` is a thin HTTP client wrapper for the Cabinet API. It handles access token management (with caching), standard JSON API requests (`api`), multipart uploads (`upload`) and lower-level request/URL building.

Class: TNLMedia\LaravelTool\Libraries\CabinetClient

Methods (detailed)

- `api(string $path, array $parameters = [], string $method = 'GET'): array`
  - Description: Perform an authenticated JSON API request.
  - Parameters:
    - `$path` (string): API path relative to the base (e.g. `materials/123`).
    - `$parameters` (array): Query parameters for GET or JSON body for non-GET.
    - `$method` (string): HTTP method, default `GET`.
  - Returns: `array` - the `data` field from the API response (decoded JSON).
  - Errors: Throws `Exception` when the API returns a non-success `code` or on HTTP/network errors.
  - Example:

```php
$client = new TNLMedia\LaravelTool\Libraries\CabinetClient();
try {
    $data = $client->api('materials/123', ['expand' => 'authors']);
} catch (Exception $e) {
    // handle error
}
```

- `upload(string $path, array $form_data = [], string $method = 'POST'): array`
  - Description: Perform a multipart upload (multipart/form-data).
  - Parameters:
    - `$path` (string): API path.
    - `$form_data` (array): Guzzle-style multipart array, e.g. `[['name'=>'file','contents'=>fopen($file,'r')]]`.
    - `$method` (string): HTTP method (usually `POST`).
  - Returns: `array` - `data` from response.
  - Example:

```php
$response = $client->upload('files', [['name' => 'file', 'contents' => fopen($path, 'r')]]);
```

- `setAccessToken(string $token): CabinetClient`
  - Description: Manually set the Authorization Bearer token for the client.
  - Returns: `CabinetClient` (for chaining).
  - Example:

```php
$client->setAccessToken('ey...');
```

Protected/Helper methods (behavior summary)

- `accessToken(bool $reset = false): string` - manages the cached token and requests a new token using `client_credentials` if needed.
- `request(string $url, string $method = 'GET', array $config = []): string` - low-level Guzzle wrapper; throws for HTTP >= 400 and wraps network errors.
- `requestUrl(string $path): string` - builds the base URL depending on environment (production vs sandbox).

Notes

- API responses are expected to follow `{ code: 200, data: ..., message: '', hint: '' }`. The method checks `code === 200`.
- Token TTL is cached in `Cache::set('CabinetClient.token', $token, $ttl)` with TTL derived as `expires_in - 300`.
- Guzzle defaults in `request()` disable TLS verification (`verify=false`) and set `http_errors=false` — review for production requirements.
