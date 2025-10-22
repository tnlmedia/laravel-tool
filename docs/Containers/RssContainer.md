# Containers/RssContainer

Overview

`RssContainer` helps build RSS 2.0 feeds with support for authors, categories and media items. It extends `XmlContainer` and stores feed-level and row-level information.

Key methods

- `__construct()` — seeds feed-level metadata from `config()` and request context (title, link, description, language, copyright, buildDate).

- `pushRow(string $guid, string $title, string $link, string $description = '', string $content = '', ?Carbon $pubDate = null, string $commentLink = '', array $authors = [], array $categories = [], array $medias = []): RssContainer`
  - Adds an item to the feed. Authors/categories/medias expect objects implementing their respective item classes (`RssAuthor`, `RssCategory`, `RssMedia`) or arrays convertible to those representations.
  - Returns the container for chaining.

- `response(): Response` — builds RSS XML and returns an HTTP response with XML headers.

Example

```php
$rss = new RssContainer();
$rss->pushRow('https://example.com/1','Post title','https://example.com/1','Short desc','<p>HTML</p>');
return $rss->response();
```

