<?php

namespace TNLMedia\LaravelTool\Cores;

use Illuminate\Support\Collection;

class Gatherer
{
    /**
     * Process query builder
     *
     * @var string
     */
    protected string $seeker = Seeker::class;

    /**
     * Condition list
     *
     * @var array
     */
    protected array $conditions = [];

    /**
     * Sort type
     *
     * @var string
     */
    protected string $sort = '';

    /**
     * Offset result item
     *
     * @var int
     */
    protected int $offset = 0;

    /**
     * Result total count
     *
     * @var int
     */
    protected int $limit = 10;

    /**
     * Set conditions
     *
     * @param array $conditions
     * @return $this
     */
    public function setConditions(array $conditions = []): Gatherer
    {
        $this->conditions = $conditions + $this->conditions;
        return $this;
    }

    /**
     * Set sort
     *
     * @param string $sort
     * @return $this
     */
    public function setSort(string $sort = ''): Gatherer
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Set result limit
     *
     * @param int $offset
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $offset = 0, int $limit = 10): Gatherer
    {
        $this->offset = max($offset, 0);
        $this->limit = $limit > 0 ? $limit : 10;
        return $this;
    }

    /**
     * Get search result list
     *
     * @return Collection
     */
    public function result(): Collection
    {
        $query = $this->query();
        $query = $this->processCondition($query);
        $query = $this->processSort($query);
        return $query->get($this->offset, $this->limit);
    }

    /**
     * Get total hits
     *
     * @return int
     */
    public function total(): int
    {
        $query = $this->query();
        $query = $this->processCondition($query);
        return $query->count();
    }

    /**
     * Add condition to query
     *
     * @param Seeker $query
     * @return Seeker
     */
    protected function processCondition(Seeker $query): Seeker
    {
        return $query;
    }

    /**
     * Set sort
     *
     * @param Seeker $query
     * @return Seeker
     */
    protected function processSort(Seeker $query): Seeker
    {
        $query->sortCreated();
        $query->sortPrimary();
        return $query;
    }

    /**
     * Start query
     *
     * @return Seeker
     */
    protected function query(): Seeker
    {
        $class = $this->seeker;
        return new $class();
    }

    /**
     * Make value as integer list
     *
     * @param $value
     * @return array
     */
    protected function conditionIntegerList($value): array
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        foreach ($value as $serial => $item) {
            $value[$serial] = intval($item);
        }
        return $value;
    }

    /**
     * Make value as string list
     *
     * @param $value
     * @return array
     */
    protected function conditionStringList($value): array
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        foreach ($value as $serial => $item) {
            $value[$serial] = strval($item);
        }
        return $value;
    }

    /**
     * Make value split by blank from string
     *
     * @param $value
     * @return array
     */
    protected function conditionStringToArray($value): array
    {
        $value = explode(' ', strval($value));
        foreach ($value as $serial => $item) {
            $item = trim($item);
            if ($item == '') {
                unset($value[$serial]);
                continue;
            }
            $value[$serial] = $item;
        }
        return array_values($value);
    }
}
