# Package Documentation - Overview & Index

This folder contains generated documentation for the package's public/internal classes and Blade partials found under `src/`.

Overview

The package provides helpers for injecting analytics and advertising snippets into Blade views, lightweight HTTP clients for interacting with remote services (Cabinet, Team, Gateway), middleware utilities and a service provider to wire everything into a Laravel application.

How the docs are organized

- `Providers/` - service providers (wiring and bootstrapping)
- `Libraries/` - HTTP client utilities and other library classes
- `Helpers/` - Blade helper used by the package facade
- `Http/` - middleware and related docs
- `Facades/` - facades exposing helpers
- `Exceptions.md` - consolidated exceptions table
- `Containers/` - container helpers and XML builders
- `Console/` - console commands and plan classes

Index (links to individual files)

- Providers
  - [Providers/TMGProvider.md](Providers/TMGProvider.md)

- Libraries
  - [Libraries/CabinetClient.md](Libraries/CabinetClient.md)
  - [Libraries/TeamClient.md](Libraries/TeamClient.md)
  - [Libraries/GatewayClient.md](Libraries/GatewayClient.md)
  - [Libraries/ContentSplitter.md](Libraries/ContentSplitter.md)

- Helpers
  - [Helpers/TMGBladeHelper.md](Helpers/TMGBladeHelper.md)

- Facades
  - [Facades/TMGBlade.md](Facades/TMGBlade.md)

- Http
  - [Http/Middleware.md](Http/Middleware.md)

- Exceptions
  - [Exceptions.md](Exceptions.md)

- Containers
  - [Containers/Container.md](Containers/Container.md)
  - [Containers/ApiContainer.md](Containers/ApiContainer.md)
  - [Containers/XmlContainer.md](Containers/XmlContainer.md)
  - [Containers/WebContainer.md](Containers/WebContainer.md)
  - [Containers/RssContainer.md](Containers/RssContainer.md)
  - [Containers/SitemapContainer.md](Containers/SitemapContainer.md)
  - [Containers/SitemapIndexContainer.md](Containers/SitemapIndexContainer.md)

- Console
  - [Console/EnvBuildCommand.md](Console/EnvBuildCommand.md)
  - [Console/Plans.md](Console/Plans.md)

Quick start

1. Read `Providers/TMGProvider.md` to understand how the package wires into Laravel.
2. Use `TMGBlade` facade to render header and slots in your Blade templates (`docs/Helpers/TMGBladeHelper.md`).
3. Configure analytics and advertising via the published config files (tag `tmg-config`).

If you want more detailed API examples or additional docs structure (per-class API reference, quick code snippets for tests), tell me which areas you'd like expanded and I will add them.

Overview

TMGProvider is a Laravel service provider that registers middleware, publishes configuration files, loads Blade views and auto-registers scheduled "Plan" classes found in Console/Plans. It is intended to be registered by the package and run as part of a Laravel application's boot sequence.

Classes & Responsibilities

- TNLMedia\LaravelTool\Providers\TMGProvider
  - boot(Router $router): Registers middleware aliases, console commands, schedules Plan classes, loads views and publishes config files.

Key behaviors

- Middleware aliases: registers `json`, `referer`, and `cache.general` to their middleware classes.
- Console commands: registers `EnvBuildCommand` when running in console.
- Plans auto-discovery: searches both `app/Console/Plans` and the package `Console/Plans` directory for classes that extend `TNLMedia\LaravelTool\Console\Plans\Plan` and if active, schedules them using the Schedule object and the `frequencies` property on the plan.
- Views: loads package views under the `TMG` namespace.
- Config publishing: publishes three config files (`tmg-website.php`, `tmg-analytics.php`, `tmg-advertising.php`) under the tag `tmg-config`.

Usage

The provider is automatically used when the package's service provider is registered. No manual calls are normally required. If you need to extend or debug:

- Check middleware aliases in your routes/middleware groups.
- Add plans under `app/Console/Plans` to have the application auto-discover them.
- Ensure your Plan subclasses set `public $status = true` and define `public $frequencies` and `public $frequencies_arguments` appropriately.

Notes on Plan scheduling

- Plans must extend `TNLMedia\LaravelTool\Console\Plans\Plan`.
- The provider checks that the `frequencies` property corresponds to a valid method on Laravel's `ManagesFrequencies` (the scheduler frequency methods), and then calls that frequency with `frequencies_arguments`.

Examples

No direct invocation examples — this provider wires package pieces into Laravel at boot time.
