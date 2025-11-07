# WebContainer

`WebContainer` is a normalized container for handling web page metadata.

Base usage: see [`Container` documentation](./Container.md).

## Structure

- `html`: array. Rendered metadata.
    - `prefix`: string. `<html>` prefix attributes.
    - `meta`: string. `<meta>`, `<link>`, etc. tags.
- `shared`: array. Basic metadata for the frontend.
    - `id`: string. Unique identifier for the web page.
    - `slug`: string. The slug of the web page.
    - `url`: string. The canonical URL of the web page; defaults to the current URL.
    - `title`: array. The title of the web page.
        - `basic`: string. Basic title.
        - `extra`: string. Extra title information.
        - `full`: string. Full title combining basic and extra.
    - `description`: array. A brief description of the web page.
        - `basic`: string. Basic description; defaults to the site slogan (`tmg-website.site.slogan`).
        - `extra`: string. Extra description information.
        - `full`: string. Full description combining basic and extra.
    - `image`: array. The main image representing the web page.
        - `url`: string. Image URL; defaults to the site image (`tmg-website.site.image.url`).
        - `width`: int. Image width; defaults to the site image width (`tmg-website.site.image.width`).
        - `height`: int. Image height; defaults to the site image height (`tmg-website.site.image.height`).
    - `keyword`: string. Keywords associated with the web page; defaults to site keywords (`tmg-website.site.keyword`).
    - `published`: int. Timestamp of when the web page was published; defaults to the current time.
    - `modified`: int. Timestamp of the last update to the web page; defaults to the current time.
    - `robots`: string. Instructions for web crawlers.
    - `language`: string. The language of the web page in ISO codes; defaults to site locale (`tmg-website.site.language`).
    - `type`: string. The type of the web page (e.g., `article`, `website`).
    - `body`: string. The main content of the web page.
- `material`: array. Analysis metadata for frontend, advertising, and analytics.
    - `cabinet`: array. ID from cabinet system.
    - `advertising`: int. Whether advertising is available (0/1).
    - `sponsor`: int. Whether sponsored content is available (0/1).
    - `paid`: int. Paid content flag: `0` for free, `1` for paid, `2` for members only.
    - `page`: array. First-level path information.
        - `key`: string. Key of the first-level path; defaults to `index`.
        - `name`: string. Name of the first-level path; defaults to `index`.
    - `terms`: array. Terms associated with the web page.
        - Each term contains:
            - `type`: string. Term type (e.g., `category`, `tag`).
            - `key`: string. Term slug or ID.
            - `name`: string. Term name.
            - `url`: string. Term URL.
    - `authors`: array. Authors associated with the web page.
        - Each author contains:
            - `key`: string. Author slug or ID.
            - `name`: string. Author name.
            - `url`: string. Author URL.
- `schema`: array. Schema.org structured data; defaults to the global schema (`tmg-website.schema`).

## Extra Methods

### robots*()

Set the `robots` key for different web page types.

- `robotsAllow()`: `all` for general web pages.
- `robotsArticle()`: `all, max-image-preview:large` for article pages.
- `robotsNextPage()`: `noindex, follow` for paginated pages starting from the second page.
- `robotsDisabled()`: `noindex, nofollow` to disable web crawler indexing.

### type*()

Set the `type` key for different web page types.

You can get types from `WebContainer::PAGE_TYPE` and `WebContainer::ARTICLE_TYPE` constants.

### export()

This function behaves like the base `Container::export()` method but will automatically generate metadata before export and set material for [`TMGBlade`](../TMGBlade.md).
