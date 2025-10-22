# Libraries/GatewayClient.php

Overview

`GatewayClient` is a HTTP client for the Gateway API with methods for oauth flow, token management and standard API/multipart calls.

Class: TNLMedia\LaravelTool\Libraries\GatewayClient

Methods (detailed)

- `api(string $path, array $parameters = [], string $method = 'GET'): array`
  - Description: Request data from Gateway API; expects `code === 20000` in successful responses.
  - Parameters:
    - `$path` (string): API path.
    - `$parameters` (array): GET query or JSON body.
    - `$method` (string): HTTP method.
  - Returns: `array` - `data` field.
  - Example:

```php
$gw = new TNLMedia\LaravelTool\Libraries\GatewayClient();
$data = $gw->api('resources/123');
```

- `upload(string $path, array $form_data = [], string $method = 'POST'): array`
  - Multipart upload; expects `code === 20000` on success.

- `oauth(string $code, string $redirect_uri): array`
  - Performs an `authorization_code` exchange against the Gateway `/token` endpoint.
  - Parameters:
    - `$code` (string): authorization code received from the provider.
    - `$redirect_uri` (string): redirect URI used in the OAuth dance.
  - Returns: `array` - the current member info from `members/current` (calls `api('members/current')`).
  - Behavior: Sets the access token on success via `setAccessToken()`.
  - Example:

```php
$member = $gw->oauth($code, 'https://app.example.com/callback');
```

- `setAccessToken(string $token): GatewayClient` — set token manually.

Protected/internal

- `accessToken(bool $reset = false)` - obtains token via client credentials when no runtime token is set.
- `request()` and `requestUrl()` - HTTP helpers used internally.

Notes

- The `oauth` method throws if the token exchange returns no `access_token`.
- Gateway API uses `20000` as a success code convention; the wrapper validates that.
