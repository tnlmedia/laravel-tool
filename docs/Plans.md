# Plans

`Plan` allows scheduling tasks to be defined in a structured way by extending the `Plan` base class.

## How to use

1. Create a new class under `app/Console/Plans` that extends `TNLMedia\LaravelTool\Console\Plans\Plan`.
2. Implement your task logic in the `handle()` method.

## Properties

- `public string $frequencies`: Name of a scheduler method from `Illuminate\Console\Scheduling\ManagesFrequencies` (e.g. `hourly`, `daily`, `everyMinute`). Default: `'everyMinute'`.
- `public array $frequencies_arguments`: Array of arguments passed to the frequency method (if needed).
- `public array $environment`: List of environments where the plan is active. An empty array means active in all environments.
- `public bool $status`: Whether the plan is active (default: `true`).

## Predefined plans

The package includes some predefined plans for common tasks. You can enable them by creating subclasses in your `app/Console/Plans` directory and setting their `$status` to `true`.

### SessionCleanPlan

Cleans non-active sessions from the database.
