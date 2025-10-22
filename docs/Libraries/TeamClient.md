# Libraries/TeamClient.php

Overview

`TeamClient` is similar to `CabinetClient` but targets the Team API. It wraps token management, standard API calls (`api`), multipart uploads (`upload`) and low-level HTTP request handling.

Class: TNLMedia\LaravelTool\Libraries\TeamClient

Methods (detailed)

- `api(string $path, array $parameters = [], string $method = 'GET'): array`
  - Description: Perform an authenticated JSON API request against the Team API.
  - Parameters:
    - `$path` (string): endpoint path.
    - `$parameters` (array): query for GET or JSON body for non-GET.
    - `$method` (string): HTTP method.
  - Returns: `array` - `data` field from the decoded response.
  - Errors: Throws `Exception` when the API returns `code` !== 200.
  - Example:

```php
$client = new TNLMedia\LaravelTool\Libraries\TeamClient();
$members = $client->api('members');
```

- `upload(string $path, array $form_data = [], string $method = 'POST'): array`
  - Description: Multipart uploads for the Team API.
  - Returns: `array` - `data` payload. Note: the Team API checks for `code === 20000` in upload responses.

Protected methods summary

- `accessToken(bool $reset = false): string` - gets token via `oauth/token` using config keys `inkmagine.team.client` and `.secret`.
- `request(...)` and `requestUrl(...)` - low-level HTTP helpers.

Notes

- Check the Team API's response codes (some endpoints return `200` while uploads may return `20000`).
- Like other clients, Guzzle is configured with `verify=false` by default in this package; change for stricter TLS requirements.
