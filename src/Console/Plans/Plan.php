<?php

namespace TNLMedia\LaravelTool\Console\Plans;

use Illuminate\Console\Scheduling\ManagesFrequencies;

class Plan
{
    /**
     * Schedule frequencies
     *
     * @var string
     * @see ManagesFrequencies
     */
    public string $frequencies = 'everyMinute';

    /**
     * Frequencies method arguments
     *
     * @var array
     * @see ManagesFrequencies
     */
    public array $frequencies_arguments = [];

    /**
     * Limit available environment, blank for all
     *
     * @var string[]
     */
    public array $environment = [];

    /**
     * Active or disable schedule
     *
     * @var bool
     */
    public bool $status = true;

    /**
     * Run the plan
     */
    public function handle(): void
    {
    }
}
