# Seeker

Overview

`Seeker` is a reusable query builder helper that wraps an Eloquent model and provides convenience methods for adding conditions, sorting, joins, eager loading, and fetching results. It is used by `Gatherer` and `Supplier` to perform model queries consistently.

Contract

- Input: Methods accept arrays, scalars and control parameters for pagination and relations.
- Output: Returns `Seeker` for chainable calls; retrieval methods return `Collection`, `Model` instances, or scalars (`int`, `mixed`).

Properties

- `protected string $model` — target model classname (defaults to `ModelOrm::class`).
- `protected ModelOrm|Model|null $entity` — model instance.
- `protected ?Builder $query` — Eloquent query builder.
- `protected array $sorts` — applied sort columns.

Constructor

- Prepares the entity and a query with the entity table selected.

Quick usage example

```php
use TNLMedia\LaravelTool\Cores\Seeker;

$seeker = Seeker::query()
    ->condition(['status' => 'active'])
    ->sortCreated()
    ->get(0, 20);

foreach ($seeker as $item) {
    echo $item->id . "\n";
}
```

Main methods (public / protected)

- `static function query(): Seeker` — Shortcut constructor.

- `protected function condition(array $conditions = []): Seeker`
  - Accepts an associative array of column => value.
  - Behavior:
    - array values => whereIn
    - null => whereNull
    - scalar => where(column, value)
  - Example:

```php
$seeker->condition(['id' => [1,2,3], 'category' => 'news']);
```

- `protected function conditionNot(array $conditions = []): Seeker` — Negative forms of `condition` (whereNotIn, whereNotNull, whereNot).

- `public function primaryKey($value): Seeker` — Apply condition on primary key.
  - Example: `$seeker->primaryKey(5)` or `$seeker->primaryKey([1,2,3])`

- `public function primaryKeyNot($value): Seeker` — Negative primary key.

- `protected function sort(string $column, bool $reverse = true): Seeker` — Internal helper to add orderBy for a column.

- `public function sortPrimary(bool $reverse = true): Seeker` — Sort by primary key.

- `public function sortCreated(bool $reverse = true): Seeker` — Sort by `created_at`.

- `public function sortUpdated(bool $reverse = true): Seeker` — Sort by `updated_at`.

- `protected function join($table, $first, $operator = null, $second = null): Seeker` — Adds a `leftJoin` if not already joined.

- `public function preload(array $relations = []): Seeker` — Eager loads relations via `with()`.

- `public function count(string $column = '*'): int` — Counts results. If column is provided, uses DISTINCT on that column.

- `public function max(?string $column = null): mixed` — Max value of a column, defaults to primary key.

- `public function get(int $offset = 0, int $limit = 0, array $relations = []): Collection`
  - Applies limit & offset when provided and returns the result collection.
  - Example: `$seeker->get(0, 50, ['author', 'tags'])`

- `public function first(): ModelOrm|Model|null` — Returns the first matching model or null.

- `protected function complexColumn(string $column): string` — Ensures column is prefixed with the table name if not already.

Notes and examples

- `Seeker` is intended to be extended for model-specific advanced conditions. For example, an `ArticleSeeker` could expose a `byCategory()` helper that calls `condition()`.

Example subclass

```php
class ArticleSeeker extends Seeker
{
    protected string $model = \App\Models\Article::class;

    public function byAuthor($authorId): Seeker
    {
        return $this->condition(['author_id' => $authorId]);
    }
}

$articles = (new ArticleSeeker())->byAuthor(5)->sortCreated()->get(0, 20);
```

