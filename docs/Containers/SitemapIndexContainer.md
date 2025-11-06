# SitemapIndexContainer

`SitemapIndexContainer` is a normalized container for managing and organizing sitemap index files.

Base usage see [`Container`](./Container.md) and [`XmlContainer`](./XmlContainer.md) documentation

## Structure

- `row`: array. An array of sitemap index entries.

## Extra Methods

### pushRow()

Append an entry to the `row` array.

- `loc`: string. The URL of the sitemap.
- `lastmod`: DateTime. The last modification date of the sitemap.
