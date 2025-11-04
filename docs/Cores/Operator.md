# Operator

`Operator` is a Write/Delete operation class, helping to manage data modifications in the database.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Operator`.
2. Implement methods for specific operations as needed.

## Sample

```php
$operator = new TargetOperator();
$operator->delete($model);
```
