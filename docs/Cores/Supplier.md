# Supplier

Overview

`Supplier` provides a tiny convenience wrapper that instantiates a `Seeker` and exposes common lookup helpers such as `findId()` and `collectId()` for retrieving single or multiple records by primary key.

Main methods

- `findId($value): ?ModelOrm`
  - Parameters: `$value` — primary key value (scalar) or array of keys.
  - Returns: `ModelOrm|null` — first matching model or `null`.
  - Example:

```php
$supplier = new \TNLMedia\LaravelTool\Cores\Supplier();
$item = $supplier->findId(123);
if ($item) {
    echo $item->id;
}
```

- `collectId($value): ?\Illuminate\Support\Collection`
  - Parameters: `$value` — primary key value(s).
  - Returns: `Collection` of matched items.
  - Example:

```php
$items = $supplier->collectId([1,2,3]);
foreach ($items as $i) {
    echo $i->id . "\n";
}
```

Notes

- `Supplier` is a lightweight façade — extend or inject a different `seeker` class when you need custom query behavior.

