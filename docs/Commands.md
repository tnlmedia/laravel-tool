# Commands

All support artisan commands below.

| Command     | Description           |
|-------------|-----------------------|
| `env:build` | Build the `.env` file |

## env:build

`env:build {--target=} {--batch=} {--line=*}`

### --target==

Target environment identifier (e.g. `production`, `sandbox`, `stage`).

Will load `.env.{target}` and `CI_{target}_` if it exists.

### --batch=

Raw dotenv-format content (can include multiple lines).

### --line=*

Can be provided multiple times, format `KEY,VALUE`.

### Priority

If the same variable is defined in multiple sources, will use as follows (highest priority last):

* .env.default
* .env.{target}
* Environment CIG_*
* Environment CI_{target}_*
* --batch
* --line=*
