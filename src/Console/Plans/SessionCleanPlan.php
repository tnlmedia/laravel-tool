<?php

namespace TNLMedia\LaravelTool\Console\Plans;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SessionCleanPlan extends Plan
{
    /**
     * {@inheritdoc }
     */
    public string $frequencies = 'hourly';

    /**
     * {@inheritdoc }
     */
    public bool $status = false;

    /**
     * @return void
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
