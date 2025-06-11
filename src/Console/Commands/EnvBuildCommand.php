<?php

namespace TNLMedia\LaravelTool\Console\Commands;

use Dotenv\Dotenv;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EnvBuildCommand extends Command
{
    /**
     * {@inheritdoc }
     */
    protected $signature = 'env:build {--target=} {--batch=} {--line=*}';

    /**
     * {@inheritdoc }
     */
    protected $description = 'Build environment file';

    /**
     * @return void
     */
    public function handle(): void
    {
        $variables = collect();

        // Environment
        $environment = trim(strtolower(strval($this->option('target'))));
        if (empty($environment)) {
            $this->error('Target environment is not specified');
            return;
        }
        $this->info('Build ' . $environment . ' environment file');

        // From .env file
        $source = [];
        $source[] = '.env.default';
        $source[] = '.env.' . $environment;
        foreach ($source as $file) {
            $this->line('Load ' . $file);
            $variables = $variables->merge(Dotenv::parse(File::get(base_path($file))));
        }

        // From $_ENV global variables
        $source = [];
        $source[] = 'CIG_';
        $source[] = 'CI_' . preg_replace('/\.-/i', '_', strtoupper($environment)) . '_';
        foreach ($source as $prefix) {
            $this->line('Load $_ENV[\'' . $prefix . '{VARIABLE}\']');
            foreach (getenv() as $key => $value) {
                if (preg_match('/^' . preg_quote($prefix, '/') . '([\S]+)$/i', $key, $match)) {
                    $value = trim($value);
                    $value = trim($value, '"');
                    $variables->put($match[1], $value);
                }
            }
        }

        // From batch input
        $source = $this->option('batch');
        if (!empty($source)) {
            $this->line('Load --batch');

            // Temporary file
            $tmp = tempnam(sys_get_temp_dir(), '');
            file_put_contents($tmp, $source);

            // Load
            $variables = $variables->merge(Dotenv::createImmutable(dirname($tmp), basename($tmp))->safeLoad());

            // Clear
            unlink($tmp);
        }

        // From line input
        $source = $this->option('line');
        if (!empty($source)) {
            $this->line('Load --line');
            foreach ($source as $item) {
                $item = trim($item);
                $item = explode(',', $item, 2);
                $item[0] = trim($item[0] ?? '');
                if (empty($item[0])) {
                    continue;
                }
                $variables->put($item[0], trim($item[1] ?? ''));
            }
        }

        // Write .env
        if (!File::put(base_path('.env'), $variables->filter(function ($item) {
            return $item != '';
        })->map(function ($item, $key) {
            return $key . '="' . $item . '"';
        })->implode("\n"))) {
            $this->error('Environment file write failed');
        } else {
            $this->info('Environment file build successfully');
        }
    }
}
