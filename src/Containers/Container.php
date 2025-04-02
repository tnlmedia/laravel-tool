<?php

namespace TNLMedia\LaravelTool\Containers;

use Illuminate\Support\Arr;

class Container
{
    /**
     * Storage data
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Put data value
     *
     * @param string $key
     * @param $value
     * @return $this
     */
    public function setData(string $key, $value): Container
    {
        Arr::set($this->data, $key, $value);
        return $this;
    }

    /**
     * Check data value true or false
     *
     * @param string $key
     * @return bool
     */
    public function checkData(string $key): bool
    {
        return !!Arr::get($this->data, $key);
    }

    /**
     * Get data value
     *
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function getData(string $key, $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Export data
     *
     * @return array
     */
    public function export(): array
    {
        return $this->data;
    }
}
