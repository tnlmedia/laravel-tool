# Supplier

`Supplier` is a reusable class to retrieve records using a `Seeker`.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Supplier`.
2. Set the `$seeker` property to your target seeker class.
3. Add methods for common lookups as needed.

## Get

```php
$supplier = new TargetSupplier();
$item = $supplier->findId(123);
```

## Methods

- `findId($value): ?ModelOrm`: Find a single record by primary key.
- `collectId($value): ?Collection`: Collect multiple records by primary key.
- `query(): Seeker`: Start a new seeker instance in supplier methods.

## Tips

### Naming methods

A few rules can help you name supplier methods:

- `findSomething($value)`: Find a single record by field `something`.
- `collectSomething($value)`: Collect multiple records by field `something`.
- `countSomething($value)`: Count records by field `something`.
