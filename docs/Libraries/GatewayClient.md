# GatewayClient

`GatewayClient` helps you interact with the Gateway API.

More information about the Gateway API can be found at [Inkmagine Gateway API Documentation](https://gateway.inkmaginecms.com/docs/).

## How to use

1. Configure `gateway.client` and `gateway.secret` in your `config/inkmagine.php` file.
2. Instantiate a `GatewayClient` and call the API methods.

## Methods

- `api(string $path, array $parameters = [], string $method = 'GET'): array`: Call the Gateway API with the given path and parameters.
- `upload(string $path, array $form_data = [], string $method = 'POST'): array`: Upload a file or form data to the Gateway API at the given path.
- `oauth(string $code, string $redirect_uri): array`: Retrieve login/member information using an OAuth code.
- `setAccessToken(string $token): GatewayClient`: Set an existing access token for subsequent API calls.

## Example

### Make a request

```php
$source = (new GatewayClient())->api('members/' . $this->target_id);
if (empty($source)) {
    throw NotFoundException::invalidField('target_id');
}

// Get
$new = false;
$member = MemberSeeker::query()->memberUuid([$source['uuid'] ?? ''])->first();
if (!$member) {
    $member = new Member();
    $member->fill([
        'member_uuid' => strval($source['uuid'] ?? ''),
        'member_id' => intval($source['id'] ?? 0),
    ]);
    $new = true;
}
```

### Login process

```php
$client = new GatewayClient();

// Member
$source = $client->oauth(strval($request->input('code')), route('member.process'));
$source['uuid'] = strval($source['uuid'] ?? '');
$member = MemberSeeker::query()->memberUuid([$source['uuid']])->first();
if (!$member) {
    MemberSyncJob::dispatchSync($source['uuid']);
    $member = MemberSeeker::query()->memberUuid([$source['uuid']])->first();
} else {
    MemberSyncJob::dispatch($member->member_uuid)->onQueue(QueueRankKey::Inkmagine->value);
}
if (!$member) {
    throw new Exception('Member not found');
}

// Login
if (Auth::check()) {
    Auth::logout();
}
Auth::login($member);
```
