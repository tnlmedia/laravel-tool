# Containers/WebContainer

Overview

`WebContainer` extends `Container` with many convenience helpers tailored for building HTML page metadata, OpenGraph, schema.org structures and material used for analytics/advertising.

Key behaviors

- Exposes many magic accessors via `@method` docblocks (e.g. `setSharedTitleBasic`, `setMaterialAuthors`, `setSchema`, `robotsAllow`, `typeArticle`, etc.).
- Constructor seeds sensible defaults from `config()` and request context (shared URLs, images, language, published/modified timestamps).
- `export()` calls `process()` which prepares HTML meta tags, OpenGraph, Twitter, schema.org JSON-LD and stores them under `html.meta`.
- During `export()` the container pushes material values into `TMGBlade` helper (`TMGBlade::setMaterial(...)`) for advertising/analytics targeting.

Common usage

```php
$wc = new WebContainer();
$wc->setSharedTitleBasic('Hello')->setSharedDescriptionBasic('Short summary');
$wc->setMaterialAuthors([['key'=>'alice','name'=>'Alice']]);
$html = $wc->export();
// $html['html']['meta'] contains the assembled <meta> and JSON-LD strings
```

Notes on magic methods

- The container supports dynamic `set`/`push`/`get`/`check` helpers for `shared`, `material`, `schema` and commonly used properties (see the docblocks in the source for the full list).
- Use `robots*()` helpers to set common `robots` directives, and `type*()` helpers to set schema types.

Examples

- Set page as article and author:

```php
$wc->typeArticle()->setSharedTitleBasic('Article Title');
$wc->setMaterialAuthors([['name' => 'Author Name', 'url' => 'https://example.com/a']]);
$data = $wc->export();
```

