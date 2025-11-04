# Seeker

`Seeker` allow building query on Eloquent models as semantically as possible.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Seeker`.
2. Change the `$model` property to your target model class.
3. Add methods for common conditions if needed.

## Query

Basic usage example:

```php
$result = TargetSeeker::query()
    ->status(true)
    ->sortCreated()
    ->preload(['relation1', 'relation2'])
    ->get(0, 20);
```

You can combine multiple conditions in several part.

```php
$query = TargetSeeker::query()
    ->status(true);
if ($keyword) {
    $query->search($keyword);
}
$result = $query->sortCreated()->get(0, 20);
```

## Methods

- `query(): Seeker`: Start a new query instance.
- `primaryKey($value): Seeker`: Apply condition on primary key field.
- `primaryKeyNot($value): Seeker`: Apply negative condition on primary key field.
- `sortPrimaryKey(bool $reverse = true): Seeker`: Apply sort order on primary key field.
- `sortCreated(bool $reverse = true): Seeker`: Apply sort order on created timestamp field.
- `sortUpdated(bool $reverse = true): Seeker`: Apply sort order on updated timestamp field.
- `preload(array $relations): Seeker`: Eager load related models.
- `count(string $field = '*'): int`: Get count of matched records.
- `max(?string $column = null): mixed`: Get maximum value of a column.
- `get(int $offset = 0, int $limit = 0, array $relations = []): Collection`: Get matched records.
- `first(): ModelOrm|Model|null`: Get first matched record.

## Tips

### Naming methods

Usually, few rule can help you to name your seeker methods:

- something($value): Apply condition on field `something`.
    - You can use below method to apply multiple conditions at once.
    - `condition(array $conditions): Seeker`: Apply multiple conditions at once.
    - `conditionNot(array $conditions): Seeker`: Apply multiple negative conditions at once.
- joinSomething(): Join related table.
    - You can use `join($table, $first, $operator = null, $second = null): Seeker` to join arbitrary relation.
- sortSomething(bool $reverse = true): Apply sort order.
    - You can use `sort(string $field, bool $reverse = false): Seeker` to apply sort on arbitrary field.

