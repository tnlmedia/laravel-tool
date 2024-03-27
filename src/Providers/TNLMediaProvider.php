<?php

namespace TNLMedia\LaravelTool\Providers;

use Illuminate\Support\ServiceProvider;

class TNLMediaProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'TNLMedia');
    }
}
