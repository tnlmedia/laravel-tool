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
        if (preg_match('/^(set|push|get|check)([a-z0-9]+)$/i', $name, $match)) {
            $action = strtolower($match[1]);
            $match[2] = preg_split('/(?=[A-Z])/', $match[2], -1, PREG_SPLIT_NO_EMPTY);
            $key = implode('.', $match[2]);
            $value = null;
            if (count($arguments) > 1) {
                $key .= '.' . strval($arguments[0] ?? '');
                $value = $arguments[1] ?? null;
            } else {
                if ($action == 'check') {
                    $key .= '.' . strval($arguments[0] ?? '');
                } else {
                    $value = $arguments[0] ?? null;
                    if (is_string($value)) {
                        if (Arr::has($this->data, strtolower($key . '.' . $value))) {
                            $key .= '.' . strtolower($value);
                            $value = null;
                        }
                    }
                }
            }
            $key = strtolower(trim($key, '.'));

            if ($action == 'set') {
                return $this->setData($key, $value);
            } elseif ($action == 'push') {
                return $this->pushData($key, $value);
            } elseif ($action == 'get') {
                return $this->getData($key, $value);
            } elseif ($action == 'check') {
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
     * @param mixed|null $default
     * @return mixed
     */
    public function getData(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Push data value
     *   array: Append value to array
     *   int: Plus value to current value
     *   float: Plus value to current value
     *   string: Combine value to end of string
     *
     * @param string $key
     * @param $value
     * @return $this
     */
    public function pushData(string $key, $value): Container
    {
        $current = $this->getData($key);
        if (!isset($current)) {
            return $this->setData($key, $value);
        }
        if (is_array($current)) {
            $current[] = $value;
            return $this->setData($key, $current);
        }
        if (is_int($current) && is_int($value)) {
            $current += $value;
            return $this->setData($key, $current);
        }
        if (is_float($current) && is_float($value)) {
            $current += $value;
            return $this->setData($key, $current);
        }
        return $this->setData($key, $current . $value);
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
