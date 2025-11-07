# GatewayClient

`GatewayClient` help you to interact with Gateway API easily.

More information about Gateway API can be found at [Inkmagine Gateway API Documentation](https://gateway.inkmaginecms.com/docs/).

## How to use

1. Config `gateway.client` and `gateway.secret` in your `config/inkmagine.php` file.
2. New a `GatewayClient` instance, start to call API.

## Methods

- `api(string $path, array $parameters = [], string $method = 'GET'): array`: Call Gateway API with given path and parameters.
- `upload(string $path, array $form_data = [], string $method = 'POST'): array`: Upload file to Gateway API with given path and form data.
- `oauth(string $code, string $redirect_uri): array`: Get login member info by OAuth code.
- `setAccessToken(string $token): GatewayClient`: Set exists access token for API calls.

## Example

### Make a request

```php
// Source
$source = new GatewayClient()->api('members/' . $this->target_id);
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

### Login progress

```php
$client = new GatewayClient();

// Member
$source = $client->oauth(strval($request->input('code')), route('member.process'));
$source['uuid'] = strval($source['uuid'] ?? '');
$member = MemberSeeker::query()
    ->memberUuid([$source['uuid']])
    ->first();
if (!$member) {
    MemberSyncJob::dispatchSync($source['uuid']);
    $member = MemberSeeker::query()
        ->memberUuid([$source['uuid']])
        ->first();
} else {
    MemberSyncJob::dispatch($member->member_uuid)
        ->onQueue(QueueRankKey::Inkmagine->value);
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
