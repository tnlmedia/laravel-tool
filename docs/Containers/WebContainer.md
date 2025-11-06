# WebContainer

`WebContainer` is a normalized container for handling web page metadata.

Base usage see [`Container` documentation](./Container.md).

## Structure

- `html`: array. Rendered metadata.
    - `prefix`: string. <html> prefix attributes.
    - `meta`: string. <meta>, <link> ext... tags.
- `shared`: array. Basic metadata for frontend.
    - `id`: string. Unique identifier for the web page.
    - `slug`: string. The slug of the web page.
    - `url`: string. The canonical URL of the web page, default provide current URL.
    - `title`: array. The title of the web page.
        - `basic`: string. Basic title.
        - `extra:` string. Extra title information.
        - `full`: string. Full title combining basic and extra.
    - `description`: array. A brief description of the web page.
        - `basic`: string. Basic description, default provide site slogan (tmg-website.site.slogan).
        - `extra:` string. Extra description information.
        - `full`: string. Full description combining basic and extra.
    - `image`: string. The URL of the main image representing the web page.
        - `url`: string. Image URL, default provide site image (tmg-website.site.image.url).
        - `width`: int. Image width, default provide site image width (tmg-website.site.image.width).
        - `height`: int. Image height, default provide site image height (tmg-website.site.image.height).
    - `kewyword`: string. Keywords associated with the web page, default provide site keywords (tmg-website.site.keyword).
    - `published`: int. Timestamp of when the web page was published, default provide current time.
    - `modified`: int. Timestamp of the last update to the web page, default provide current time.
    - `robots`: string. Instructions for web crawlers.
    - `language`: string. The language of the web page in ISO 3166-1 Alpha 2 or ISO 15924, default provide site locale (tmg-website.site.language).
    - `type`: string. The type of the web page (e.g., article, website).
    - `body`: string. The main content of the web page.
- `material`: array. Analysis metadata for frontend, advertising, analytics.
    - `cabinet`: array. ID from cabinet system.
    - `advertising`: int. Advertising is available or not.
    - `sponsor`: int. Sponsored content is available or not.
    - `paid`: int. Paid content is available or not. 0 for free, 1 for paid, 2 for members only.
    - `page`: array. First-level of path.
        - `key`: string. Key of the first-level path, default provide 'index'.
        - `name`: string. Name of the first-level path, default provide 'index'.
    - `terms`: array. Terms associated with the web page.
        - Every term contain:
            - `type`: string. Term type (e.g., category, tag).
            - `key`: string. Term slug or ID.
            - `name`: string. Term name.
            - `url`: string. Term URL.
    - `authors`: array. Authors associated with the web page.
        - Every author contain:
            - `key`: string. Author slug or ID.
            - `name`: string. Author name.
            - `url`: string. Author URL.
- schema: array. Schema.org structured data, default provide global schema (tmg-website.schema)

## Extra Methods

### robots*()

Set `robots` key for different web page types.

- `robotsAllow()`: `all` for general web page.
- `robotsArticle()`: `all, max-image-preview:large` for article type web page.
- `robotsNextPage()`: `noindex, follow` for paginated web page start from second page.
- `robotsDisabled()`: `noindex, nofollow` to disable web crawler indexing.

### type*()

Set `type` key for different web page types.

You can get type from `WebContainer::PAGE_TYPE` and `WebContainer::ARTICLE_TYPE` constant.

### export()

This function same as base `Container::export()` method but will automatically generate metadata before export, and set material to [TMGBlade](../TMGBlade.md)
