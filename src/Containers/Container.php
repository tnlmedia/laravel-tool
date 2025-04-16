<?php

namespace TNLMedia\LaravelTool\Containers;

use Exception;
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
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call(string $name, array $arguments): mixed
    {
        // Quick function for first level
        if (preg_match('/^(set|get|check)([a-z0-9]+)$/i', $name, $match)) {
            $match[1] = strtolower($match[1]);
            $match[2] = strtolower($match[2]);

            $key = trim($match[2] . '.' . strtolower(strval($arguments[0] ?? '')), '.');
            if ($match[1] == 'set') {
                if (!Arr::has($this->data, $match[2])) {
                    throw new Exception('Method ' . $name . ' not found');
                }
                return $this->setData($key, $arguments[1] ?? null);
            } elseif ($match[1] == 'get') {
                return $this->getData($key, $arguments[1] ?? null);
            } elseif ($match[1] == 'check') {
                return $this->checkData($key);
            }
        }

        throw new Exception('Method ' . $name . ' not found');
    }

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
     * Export data
     *
     * @return array
     */
    public function export(): array
    {
        return $this->data;
    }
}
