# Gatherer

`Gatherer` provides a argument-driven way to build and execute search-like queries using a `Seeker` instance,

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Gatherer`.
2. Change the `$seeker` property to your target seeker class.
3. Override `processCondition` and `processSort` methods to implement your search logic.

## Sample

```php
$gatherer = new TargetGatherer();
$gatherer->setConditions(['status' => 'active', 'category_id' => [1,2,3]]);
$gatherer->setSort('created');
$gatherer->setLimit(0, 20);
$total = $gatherer->total();
$results = $gatherer->result();
```

## Methods

- `setConditions(array $conditions = []): Gatherer`: Set search conditions, can set multi times to combine.
- `setSort(string $sort = ''): Gatherer`: Set sort descriptor.
- `setLimit(int $offset = 0, int $limit = 10): Gatherer`: Set pagination parameters.
- `result(): Collection`: Execute the query and return results.
- `total(): int`: Get total count of matched records.

## processCondition

Allow you to preprocess conditions before applying to the seeker instance.

Follow method can help you to normalize condition values:

- `conditionIntegerList($value): array`: Normalize a scalar or array into an array of integers.
- `conditionStringList($value): array`: Normalize a scalar or array into an array of strings.
- `conditionStringToArray($value): array`: Split string by spaces.

## processSort

Allow you to provide custom sort parsing logic.
