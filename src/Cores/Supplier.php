<?php

namespace TNLMedia\LaravelTool\Cores;

use Illuminate\Support\Collection;

class Supplier
{
    /**
     * Query builder classname
     *
     * @var string
     */
    protected string $seeker = Seeker::class;

    /**
     * Find specific from primary
     *
     * @param $value
     * @return ModelOrm|null
     */
    public function findId($value): ?ModelOrm
    {
        return $this->query()->primaryKey($value)->first();
    }

    /**
     * Pick specific from primary
     *
     * @param $value
     * @return Collection|null
     */
    public function collectId($value): ?Collection
    {
        return $this->query()->primaryKey($value)->get();
    }

    /**
     * Start a new query
     *
     * @return Seeker
     */
    protected function query(): Seeker
    {
        $class = $this->seeker;
        return new $class();
    }
}
