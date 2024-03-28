<?php

namespace TNLMedia\LaravelTool\Facades;

use Illuminate\Support\Facades\Facade;
use TNLMedia\LaravelTool\Helpers\BladeHelper;

class TNLMediaAD extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BladeHelper::class;
    }
}
