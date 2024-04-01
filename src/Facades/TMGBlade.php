<?php

namespace TNLMedia\LaravelTool\Facades;

use Illuminate\Support\Facades\Facade;
use TNLMedia\LaravelTool\Helpers\TMGBladeHelper;

class TMGBlade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TMGBladeHelper::class;
    }
}
