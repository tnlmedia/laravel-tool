# Supplier

`Supplier` is a reusable class for get records by `Seeker`.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Supplier`.
2. Change the `$seeker` property to your target seeker class.
3. Add methods for common lookup if needed.

## Get

```php
$supplier = new TargetSupplier();
$item = $supplier->findId(123);
```

## Methods

- `findId($value): ?ModelOrm`: Find single record by primary key.
- `collectId($value): ?Collection`: Collect multiple records by primary key.
- `query(): Seeker`: Start a new seeker instance in supplier methods.

## Tips

### Naming methods

Usually, few rule can help you to name your supplier methods:

- findSomething($value): Find single record by field `something`.
- collectSomething($value): Collect multiple records by field `something`.
- countSomething($value): Count records by field `something`.
