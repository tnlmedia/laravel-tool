# RssContainer

`RssContainer` is a normalized container for handling RSS feeds.

Base usage: see [`Container`](./Container.md) and [`XmlContainer`](./XmlContainer.md).

## Structure

- `title`: string. The title of the RSS feed; defaults to the site name (`app.name`).
- `link`: string. The link to the RSS feed; defaults to the RSS URL.
- `description`: string. A brief description of the RSS feed; defaults to the site slogan (`tmg-website.site.slogan`).
- `language`: string. The language of the RSS feed; defaults to the site locale (`tmg-website.site.language`).
- `copyright`: string. Copyright information for the RSS feed; defaults to `TNL Mediagene`.
- `buildDate`: string. The build date of the RSS feed in RFC-2822 format; defaults to the current date.
- `row`: array. An array of RSS feed items.

## Extra Methods

### pushRow()

Append an item to the `row` array. Each item may include the following keys:

- `guid`: string. A unique identifier for the RSS item.
- `title`: string. The title of the RSS item.
- `link`: string. The link to the RSS item.
- `description`: string. A brief description of the RSS item.
- `content`: string. The full content of the RSS item.
- `pubDate`: DateTime. The publication date of the RSS item.
- `commentLink`: string. A link to the comments for the RSS item.
- `authors`: array. An array of authors for the RSS item. Only accepts instances of `Containers\Items\RssAuthor`.
- `categories`: array. An array of categories for the RSS item. Only accepts instances of `Containers\Items\RssCategory`.
- `medias`: array. An array of media attachments for the RSS item. Only accepts instances of `Containers\Items\RssMedia`.

Example:

```php
$container = new RssContainer();
$container->pushRow([
    'title' => 'Sample Item',
    'link' => 'https://example.com/sample-item',
    'description' => 'This is a sample RSS feed item.',
]);
```
