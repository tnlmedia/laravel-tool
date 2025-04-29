<?php

namespace TNLMedia\LaravelTool\Cores;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Seeker
{
    /**
     * Target model classname
     *
     * @var string
     */
    protected string $model = ModelOrm::class;

    /**
     * Model instance
     *
     * @var ModelOrm|Model|null
     */
    protected ModelOrm|Model|null $entity;

    /**
     * Query builder
     *
     * @var Builder|null
     */
    protected ?Builder $query;

    /**
     * Order column list
     *
     * @var array
     */
    protected array $sorts = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        // Prepare entity
        $class = $this->model;
        $this->entity = new $class();

        // Prepare query
        $this->query = $this->entity->query();
        $this->query->addSelect($this->entity->getTable() . '.*');
    }

    /**
     * Quick start query
     *
     * @return Seeker
     */
    public static function query(): Seeker
    {
        return new static();
    }

    /**
     * Simple conditions
     *
     * @param array $conditions
     * @return $this
     */
    protected function condition(array $conditions = []): Seeker
    {
        foreach ($conditions as $column => $value) {
            $column = $this->complexColumn($column);
            if (is_array($value)) {
                $this->query->whereIn($column, $value);
            } elseif (is_null($value)) {
                $this->query->whereNull($column);
            } else {
                $this->query->where($column, $value);
            }
        }
        return $this;
    }

    /**
     * Simple negative conditions
     *
     * @param array $conditions
     * @return $this
     */
    protected function conditionNot(array $conditions = []): Seeker
    {
        foreach ($conditions as $column => $value) {
            $column = $this->complexColumn($column);
            if (is_array($value)) {
                $this->query->whereNotIn($column, $value);
            } elseif (is_null($value)) {
                $this->query->whereNotNull($column);
            } else {
                $this->query->whereNot($column, $value);
            }
        }
        return $this;
    }

    /**
     * Add Key conditions
     *
     * @param $value
     * @return $this
     */
    public function primaryKey($value): Seeker
    {
        return $this->condition([$this->entity->getKeyName() => $value]);
    }

    /**
     * Negative Key conditions
     *
     * @param $value
     * @return $this
     */
    public function primaryKeyNot($value): Seeker
    {
        return $this->conditionNot([$this->entity->getKeyName() => $value]);
    }

    /**
     * Add sort by column
     *
     * @param string $column
     * @param bool $reverse
     * @return $this
     */
    protected function sort(string $column, bool $reverse = true): Seeker
    {
        // Check exists
        $column = $this->complexColumn($column);
        if (isset($this->sorts[$column])) {
            return $this;
        }

        // Add column for order by
        if (!in_array($column, $this->query->getQuery()->columns)) {
            $this->query->addSelect($column);
        }

        $this->query->orderBy($column, $reverse ? 'desc' : 'asc');
        $this->sorts[$column] = $reverse;
        return $this;
    }

    /**
     * Sort by primary key
     *
     * @param bool $reverse
     * @return $this
     */
    public function sortPrimary(bool $reverse = true): Seeker
    {
        return $this->sort($this->entity->getKeyName(), $reverse);
    }

    /**
     * Sort by created time
     *
     * @param bool $reverse
     * @return $this
     */
    public function sortCreated(bool $reverse = true): Seeker
    {
        return $this->sort($this->entity::CREATED_AT, $reverse);
    }

    /**
     * Sort by updated time
     *
     * @param bool $reverse
     * @return $this
     */
    public function sortUpdated(bool $reverse = true): Seeker
    {
        return $this->sort($this->entity::UPDATED_AT, $reverse);
    }

    /**
     * Add table
     *
     * @param $table
     * @param $first
     * @param $operator
     * @param $second
     * @return $this
     * @see Builder::leftJoin()
     */
    protected function join($table, $first, $operator = null, $second = null): Seeker
    {
        // Check joins
        $target = explode(' ', strtolower(preg_replace('/[\s]+/i', ' ', $table)));
        $target = $target[2] ?? $target[0];
        foreach ($this->query->getQuery()->joins ?? [] as $item) {
            $joined = explode(' ', strtolower(preg_replace('/[\s]+/i', ' ', $item->table)));
            $joined = $joined[2] ?? $joined[0];
            if ($joined == $target) {
                return $this;
            }
        }

        // Join
        $this->query->leftJoin($table, $first, $operator, $second);
        return $this;
    }

    /**
     * Eager load relations
     *
     * @param array $relations
     * @return $this
     */
    public function preload(array $relations = []): Seeker
    {
        if (!empty($relations)) {
            $this->query->with($relations);
        }
        return $this;
    }

    /**
     * Get total hits
     *
     * @param string $column
     * @return int
     */
    public function count(string $column = '*'): int
    {
        if ($column == '*') {
            return $this->query->count();
        }
        return $this->query->count(DB::raw('DISTINCT ' . $this->complexColumn($column)));
    }

    /**
     * Get max value in column
     *
     * @param string|null $column
     * @return mixed
     */
    public function max(string $column = null): mixed
    {
        if (empty($column)) {
            $column = $this->entity->getKeyName();
        }
        return $this->query->max($this->complexColumn($column));
    }

    /**
     * Get result
     *
     * @param int $offset
     * @param int $limit
     * @param array $relations
     * @return Collection
     */
    public function get(int $offset = 0, int $limit = 0, array $relations = []): Collection
    {
        if ($limit > 0) {
            $this->query->limit($limit);
            if ($offset > 0) {
                $this->query->offset($offset);
            }
        }
        $this->preload($relations);

        /** @var Collection $result */
        $this->query->distinct();
        $result = $this->query->get();
        return $result;
    }

    /**
     * Get first match
     *
     * @return ModelOrm|Model|null
     */
    public function first(): ModelOrm|Model|null
    {
        /** @var ModelOrm $result */
        $result = $this->query->first();
        return $result;
    }

    /**
     * Complex column with table name
     *
     * @param string $column
     * @return string
     */
    protected function complexColumn(string $column): string
    {
        if (!str_contains($column, '.')) {
            $column = $this->entity->getTable() . '.' . $column;
        }
        return $column;
    }
}
