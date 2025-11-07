# Seeker

`Seeker` allows building queries on Eloquent models in a semantic way.

## How to use

1. Create a new class that extends `TNLMedia\LaravelTool\Cores\Seeker`.
2. Set the `$model` property to your target model class.
3. Add methods for common conditions as needed.

## Query

Basic usage example:

```php
$result = TargetSeeker::query()
    ->status(true)
    ->sortCreated()
    ->preload(['relation1', 'relation2'])
    ->get(0, 20);
```

You can combine multiple conditions in several parts.

```php
$query = TargetSeeker::query()->status(true);
if ($keyword) {
    $query->search($keyword);
}
$result = $query->sortCreated()->get(0, 20);
```

## Methods

- `query(): Seeker`: Start a new query instance.
- `primaryKey($value): Seeker`: Apply a condition on the primary key field.
- `primaryKeyNot($value): Seeker`: Apply a negative condition on the primary key field.
- `sortPrimaryKey(bool $reverse = true): Seeker`: Apply sort order on the primary key field.
- `sortCreated(bool $reverse = true): Seeker`: Apply sort order on the created timestamp field.
- `sortUpdated(bool $reverse = true): Seeker`: Apply sort order on the updated timestamp field.
- `preload(array $relations): Seeker`: Eager load related models.
- `count(string $field = '*'): int`: Get count of matched records.
- `max(?string $column = null): mixed`: Get the maximum value of a column.
- `get(int $offset = 0, int $limit = 0, array $relations = []): Collection`: Get matched records.
- `first(): ModelOrm|Model|null`: Get the first matched record.

## Tips

### Naming methods

A few rules can help you name seeker methods:

- `something($value)`: Apply a condition on field `something`.
    - Use `condition(array $conditions): Seeker` to apply multiple conditions at once.
    - Use `conditionNot(array $conditions): Seeker` to apply multiple negative conditions.
- `joinSomething()`: Join a related table.
    - Use `join($table, $first, $operator = null, $second = null): Seeker` to join arbitrary relations.
- `sortSomething(bool $reverse = true)`: Apply sort order.
    - Use `sort(string $field, bool $reverse = false): Seeker` to apply sort on an arbitrary field.
