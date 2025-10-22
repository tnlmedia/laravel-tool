# Containers/SitemapIndexContainer

Overview

`SitemapIndexContainer` builds a sitemap index (list of sitemap files).

Key methods

- `pushRow(string $loc, ?Carbon $modified = null): SitemapIndexContainer` — add a sitemap file entry.
- `response(): Response` — build and return XML response.

Example

```php
$index = new SitemapIndexContainer();
$index->pushRow('https://example.com/sitemap-1.xml', Carbon::now());
return $index->response();
```
# Console/EnvBuildCommand

Overview

`EnvBuildCommand` is a console command that builds a `.env` file for a target environment by merging multiple sources (default env files, environment variables, batch input and explicit lines).

Signature

- `env:build {--target=} {--batch=} {--line=*}`

Options

- `--target` (string, required): environment slug (e.g. `production`, `staging`, `develop`). The command will look for `.env.{target}` and merge with `.env.default`.
- `--batch` (string, optional): raw dotenv-format content. The command writes this to a temporary file and loads variables from it.
- `--line` (multiple, optional): one or more "lines" in the form `KEY,VALUE`. Each entry is parsed and added to the final `.env`.

Behavior

1. Loads variables from `.env.default` and `.env.{target}` (base_path).
2. Reads global environment variables with prefixes `CIG_` and `CI_{ENV}_` (uppercase target) and adds matched keys (prefix stripped).
3. Optionally merges variables from `--batch` (dotenv content) and `--line` entries.
4. Writes `.env` at project base path with non-empty values, quoting them as `KEY="value"`.

Exit/Errors

- If `--target` is not specified, the command prints an error and exits without writing.
- If writing `.env` fails, the command prints an error; otherwise prints success message.

Examples

- Build a production `.env`:

```bash
php artisan env:build --target=production
```

- Build from a batch string (dotenv content):

```bash
php artisan env:build --target=staging --batch="APP_DEBUG=false\nDB_HOST=db.example" 
```

- Override/add single variables via `--line` (can pass multiple):

```bash
php artisan env:build --target=develop --line=APP_DEBUG,false --line=API_URL,https://api.local
```

Notes

- Values passed via `--line` are split on the first comma; the left side is the key, the right side is taken as the value (can be empty).
- The command trims quotes and whitespace from environment variables loaded from the runtime environment.
- `--batch` content is treated as a dotenv file and loaded using vlucas/phpdotenv.

