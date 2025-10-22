# Exceptions

This document consolidates package-specific exceptions into a single reference table.

| Exception class                                            | Default code | Description                       |
|------------------------------------------------------------|--------------|-----------------------------------|
| `TNLMedia\\LaravelTool\\Exceptions\\Exception`             | `50000`      | Base exception                    |
| `TNLMedia\\LaravelTool\\Exceptions\\ForbiddenException`    | `40300`      | User without permission to access |
| `TNLMedia\\LaravelTool\\Exceptions\\NotFoundException`     | `40400`      | Target can't be found             |
| `TNLMedia\\LaravelTool\\Exceptions\\UnauthorizedException` | `40100`      | Require authorize to access       |

## Usage

You can throw these exceptions in your package code or application logic to signal specific error conditions. For example:

```php
use TNLMedia\LaravelTool\Exceptions\NotFoundException;

throw NotFoundException::invalidField('id');
```

## Exception extend

You can extend the base `TNLMedia\LaravelTool\Exceptions\Exception` class to create custom exceptions for your application. This allows you to maintain consistent error handling and leverage the existing structure for error codes.

## Code

Exception code use three digits for HTTP status mapping and two digits for specific error identification within the package.

## Hint

Exceptions can include an optional `hint` property to provide additional context for debugging. This hint can be set when throwing the exception and can be retrieved later for logging or display purposes.

You can use the `setHint(string $hint): void` method to set the hint and the `getHint(): string` method to retrieve it.

## Message

You can use the `setMessage(string $message): void` and `getMessage(): string` methods to set and retrieve the exception message.

## invalidField

The `invalidField(string $hint = '', ?Throwable $previous = null): Exception` static method can quickly create an exception indicating an invalid field error, with an optional hint and previous throwable for chaining.
