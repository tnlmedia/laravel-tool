# Exceptions

This document consolidates package-specific exceptions into a single reference table.

| Exception class                                         | Default code | Description                             |
|---------------------------------------------------------|--------------|-----------------------------------------|
| `TNLMedia\LaravelTool\Exceptions\Exception`             | `50000`      | Base exception                          |
| `TNLMedia\LaravelTool\Exceptions\ForbiddenException`    | `40300`      | User does not have permission to access |
| `TNLMedia\LaravelTool\Exceptions\NotFoundException`     | `40400`      | Target not found                        |
| `TNLMedia\LaravelTool\Exceptions\UnauthorizedException` | `40100`      | Authorization required to access        |

## Usage

Throw these exceptions in your package code or application logic to signal specific error conditions. For example:

```php
use TNLMedia\LaravelTool\Exceptions\NotFoundException;

throw NotFoundException::invalidField('id');
```

## Extending the base exception

You can extend the base `TNLMedia\\LaravelTool\\Exceptions\\Exception` class to create custom exceptions for your application. This allows you to maintain consistent error handling and leverage the existing structure for error codes.

## Exception codes

Exception codes use three digits for HTTP status mapping and two digits for package-specific error identification.

## Hints and messages

Exceptions can include an optional `hint` property to provide additional context for debugging. This hint can be set when throwing the exception and retrieved later for logging or display purposes.

Use `setHint(string $hint): void` to set the hint and `getHint(): string` to retrieve it.

Use `setMessage(string $message): void` and `getMessage(): string` to set and retrieve the exception message.

## invalidField helper

The `invalidField(string $hint = '', ?Throwable $previous = null): Exception` static method creates an exception indicating an invalid field error, with an optional hint and previous throwable for chaining.
