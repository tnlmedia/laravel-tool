<?php

namespace TNLMedia\LaravelTool\Providers;

use Illuminate\Support\ServiceProvider;

class TMGProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/tmg-website.php' => config_path('tmg-website.php'),
            __DIR__ . '/../config/tmg-analytics.php' => config_path('tmg-analytics.php'),
            __DIR__ . '/../config/tmg-advertising.php' => config_path('tmg-advertising.php'),
        ], 'tmg-config');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'TMG');
    }
}
