<?php

namespace TNLMedia\LaravelTool\Console\Plans;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SessionCleanPlan extends Plan
{
    /**
     * @var string
     */
    public string $frequencies = 'hourly';

    /**
     * Active or disable schedule
     *
     * @var bool
     */
    public bool $status = false;

    /**
     * Run the plan
     */
    public function handle(): void
    {
        // No active user sessions older than 6 hours
        if (Schema::hasTable('sessions')) {
            DB::table('sessions')
                ->whereNull('user_id')
                ->where('last_activity', '<', time() - 21600)
                ->delete();
        }
    }
}
