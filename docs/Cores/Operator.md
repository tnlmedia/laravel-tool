# Operator

`Operator` is a write/delete operation helper that assists in managing data modifications in the database.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Operator`.
2. Implement methods for specific operations as required.

## Sample

```php
$operator = new TargetOperator();
$operator->delete($model);
```
