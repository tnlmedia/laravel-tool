# Console/Plans

Overview

This document covers the `Plan` base class used by the package for scheduling tasks and examples for concrete plan implementations.

Class: TNLMedia\LaravelTool\Console\Plans\Plan

Properties

- `public string $frequencies` — name of a scheduler method from `Illuminate\Console\Scheduling\ManagesFrequencies` (e.g. `hourly`, `daily`, `everyMinute`). Default: `everyMinute`.
- `public array $frequencies_arguments` — array of arguments passed to the frequency method (if needed).
- `public array $environment` — list of environments where the plan is active. Empty means active in all environments.
- `public bool $status` — whether the plan is active (default: `true`).

Methods

- `handle(): void` — the plan's actual job implementation. Subclasses must implement this.

Example: SessionCleanPlan

- File: `src/Console/Plans/SessionCleanPlan.php`
- Properties:
  - `public string $frequencies = 'hourly';`
  - `public bool $status = false;` (disabled by default)
- `handle()` implementation: deletes anonymous session records older than 6 hours when `sessions` table exists.

Enabling a plan

- Place custom plan classes under `app/Console/Plans` (they will be discovered by the provider). Ensure they extend `TNLMedia\LaravelTool\Console\Plans\Plan`, set `$status = true` and configure `$frequencies`/`$frequencies_arguments` if needed.

Notes

- The service provider scans both `app/Console/Plans` and the package `Console/Plans` directory. Plans that are not subclasses of `Plan` are ignored.
- The scheduler only registers plans whose `status` is truthy and whose `environment` (if not empty) includes the current application environment.

