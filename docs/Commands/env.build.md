# Build the `.env` file

Generates a `.env` file from various sources.

## Command

`env:build {--target=} {--batch=} {--line=*}`

## --target==

Target environment identifier (e.g. `production`, `sandbox`, `stage`).

Will load `.env.{target}` and `CI_{target}_` if it exists.

## --batch=

Raw dotenv-format content (can include multiple lines).

## --line=*

Can be provided multiple times, format `KEY,VALUE`.

## Priority

If the same variable is defined in multiple sources, will use as follows (highest priority last):

* .env.default
* .env.{target}
* Environment CIG_*
* Environment CI_{target}_*
* --batch
* --line=*
