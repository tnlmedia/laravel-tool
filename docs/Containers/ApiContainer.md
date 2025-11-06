# ApiContainer

`ApiContainer` is a normalized container for structuring API response data.

Base usage see [`Container` documentation](./Container.md).

## Structure

- `code`: int. Process status code, combine 3-digit HTTP status code and 2-digit application code.
- `data`: mixed. Payload data.
- `message`: string. Human-readable message.
- `hint`: string. Optional internal hint for debugging.

## Extra Methods

Provide `setResult()`, `pushResult()`, `getResult()` and `checkResult()` method for `data` key.
