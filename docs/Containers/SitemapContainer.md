# SitemapContainer

`SitemapContainer` is a normalized container for handling sitemap data.

Base usage: see [`Container`](./Container.md) and [`XmlContainer`](./XmlContainer.md).

## Structure

- `row`: array. An array of sitemap entries.

## Extra Methods

### pushRow()

Append an entry to the `row` array. Each entry may include the following keys:

- `loc`: string. The URL of the sitemap entry.
- `lastmod`: DateTime. The last modification date of the sitemap entry.
- `frequency`: SitemapFrequency. A hint about how frequently the page is likely to change.
- `priority`: SitemapPriority. The priority of this URL relative to other URLs on your site.
- `news`: SitemapNews. An optional news sitemap entry.
- `image`: array. An array of images associated with the sitemap entry. Only accepts instances of `Containers\Items\SitemapImage`.
- `video`: array. An array of videos associated with the sitemap entry. Only accepts instances of `Containers\Items\SitemapVideo`.
