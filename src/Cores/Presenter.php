<?php

namespace TNLMedia\LaravelTool\Cores;

use Illuminate\Database\Eloquent\Model;

class Presenter
{
    /**
     * @param ModelOrm|Model $entity
     */
    public function __construct(protected ModelOrm|Model $entity)
    {
    }

    /**
     * Allow for property-style retrieval
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }
        return $this->entity->{$property};
    }
}
