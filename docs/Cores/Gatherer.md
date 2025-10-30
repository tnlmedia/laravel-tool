# Gatherer

Overview

The Gatherer class is a small helper that prepares and executes search-like queries by composing a `Seeker` instance, applying conditions, sort and pagination, and returning results as an `Illuminate\Support\Collection`.

Usage contract

- Input: optional conditions (array), sort (string), offset (int) and limit (int).
- Output: `Illuminate\Support\Collection` for `result()` and `int` for `total()`.
- Error modes: none thrown by this class directly; underlying query may throw exceptions when executed.

Properties

- `protected string $seeker` — Seeker classname used to build queries (defaults to `Seeker::class`).
- `protected array $conditions` — Conditions applied to the query.
- `protected string $sort` — Sort descriptor (string).
- `protected int $offset` — Result offset for pagination.
- `protected int $limit` — Result limit for pagination.

Main methods

- `setConditions(array $conditions = []): Gatherer`
  - Parameters: `$conditions` — associative array of condition keys and values.
  - Returns: `$this` (Gatherer)
  - Example:

```php
use TNLMedia\LaravelTool\Cores\Gatherer;

$g = new Gatherer();
$g->setConditions(['status' => 'active', 'category_id' => [1,2,3]]);
```

- `setSort(string $sort = ''): Gatherer`
  - Parameters: `$sort` — a string descriptor (class uses internal `processSort`).
  - Returns: `$this`
  - Example:

```php
$g->setSort('created_desc');
```

- `setLimit(int $offset = 0, int $limit = 10): Gatherer`
  - Parameters: `$offset` — start index; `$limit` — number of items.
  - Returns: `$this`
  - Example:

```php
$g->setLimit(10, 25); // offset=10, limit=25
```

- `result(): Illuminate\Support\Collection`
  - Parameters: none
  - Returns: Collection of Eloquent model instances matching conditions, respecting sort and pagination.
  - Example:

```php
$items = $g->result();
foreach ($items as $item) {
    echo $item->id . "\n";
}
```

- `total(): int`
  - Parameters: none
  - Returns: integer total count for the current conditions (ignores pagination)
  - Example:

```php
$total = $g->total();
```

Protected/helper methods (useful to override in subclasses)

- `protected function processCondition(Seeker $query): Seeker` — Hook to add conditions to the `Seeker`. The base implementation returns the query unchanged. Subclasses should apply `$this->conditions` here.

- `protected function processSort(Seeker $query): Seeker` — Applies default sort order (created, primary). Subclasses may override to implement `$this->sort` parsing.

- `protected function query(): Seeker` — Instantiates the configured seeker class.

- `protected function conditionIntegerList($value): array` — Normalizes a scalar or array into an array of integers.

- `protected function conditionStringList($value): array` — Normalizes a scalar or array into an array of strings.

- `protected function conditionStringToArray($value): array` — Splits string by spaces and trims empty tokens.

Example: a small subclass that applies conditions

```php
use TNLMedia\LaravelTool\Cores\Gatherer;
use TNLMedia\LaravelTool\Cores\Seeker;

class ArticleGatherer extends Gatherer
{
    protected string $seeker = Seeker::class; // use the appropriate seeker

    protected function processCondition(Seeker $query): Seeker
    {
        // example: apply a status filter if provided
        if (!empty($this->conditions['status'])) {
            $query->condition(['status' => $this->conditions['status']]);
        }
        if (!empty($this->conditions['ids'])) {
            $query->condition(['id' => $this->conditionIntegerList($this->conditions['ids'])]);
        }
        return $query;
    }
}

$g = (new ArticleGatherer())
    ->setConditions(['status' => 'published', 'ids' => '1 2 3'])
    ->setLimit(0, 20);
$items = $g->result();
```

Notes

- Gatherer is designed to be extended for domain-specific searches; override `processCondition` and `processSort` to implement search logic.

