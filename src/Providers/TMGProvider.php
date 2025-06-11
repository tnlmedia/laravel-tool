<?php

namespace TNLMedia\LaravelTool\Providers;

use Illuminate\Console\Scheduling\ManagesFrequencies;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use TNLMedia\LaravelTool\Console\Commands\EnvBuildCommand;
use TNLMedia\LaravelTool\Console\Plans\Plan;

class TMGProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // Commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                EnvBuildCommand::class,
            ]);
        }

        // Schedule plan
        $this->app->booted(function () {
            $environment = App::environment();
            $namespace = App::getNamespace();
            $schedule = app(Schedule::class);
            $folder = [];
            $folder[] = app_path('Console/Plans');
            $folder[] = __DIR__ . '/../Console/Plans';
            foreach ($folder as $path) {
                foreach ((new Finder)->in($path)->files() as $plan) {
                    /** @var SplFileInfo $plan */
                    $plan = $namespace . str_replace(
                            ['/', '.php'],
                            ['\\', ''],
                            Str::after($plan->getPathname(), realpath(app_path()) . DIRECTORY_SEPARATOR)
                        );

                    // Check class
                    /** @var Plan $plan */
                    if (!is_subclass_of($plan, Plan::class)) {
                        continue;
                    }
                    $plan = new $plan();

                    // Check active
                    if (!$plan->status) {
                        continue;
                    }
                    if (!empty($plan->environment) && !in_array($environment, $plan->environment)) {
                        continue;
                    }

                    // Check frequencies
                    $frequencies = $plan->frequencies;
                    if (!method_exists(ManagesFrequencies::class, $frequencies)) {
                        continue;
                    }

                    // Run
                    $schedule->call(function () use ($plan) {
                        $plan->handle();
                    })->name(get_class($plan))
                        ->withoutOverlapping()
                        ->$frequencies(...$plan->frequencies_arguments);
                }
            }
        });

        // Config file
        $this->publishes([
            __DIR__ . '/../config/tmg-website.php' => config_path('tmg-website.php'),
            __DIR__ . '/../config/tmg-analytics.php' => config_path('tmg-analytics.php'),
            __DIR__ . '/../config/tmg-advertising.php' => config_path('tmg-advertising.php'),
        ], 'tmg-config');

        // Blade
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'TMG');
    }
}
