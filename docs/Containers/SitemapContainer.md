# Containers/SitemapContainer

Overview

`SitemapContainer` builds a sitemap XML (urlset) with support for image, video and Google News extensions.

Key methods

- `pushRow(string $loc, ?Carbon $modified = null, SitemapFrequency $frequency = SitemapFrequency::Daily, SitemapPriority $priority = SitemapPriority::Article, ?SitemapNews $news = null, array $image = [], array $video = []): SitemapContainer`
  - Adds a sitemap entry with optional news/image/video objects. Accepts typed enums for frequency and priority.

- `response(): Response` — builds the XML and returns it as an HTTP response.

Example

```php
$sitemap = new SitemapContainer();
$sitemap->pushRow('https://example.com/article/1', Carbon::now(), SitemapFrequency::Daily, SitemapPriority::Article);
return $sitemap->response();
```

