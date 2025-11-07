# Laravel Middleware

This package provides a small set of middleware. This document lists them and shows example usage.

| Alias           | Purpose                                                                                                                                |
|-----------------|----------------------------------------------------------------------------------------------------------------------------------------|
| `json`          | Forces the request `Accept` header to `application/json` so responses are formatted as JSON.                                           |
| `referer`       | Verifies the `Referer` host matches the current host; aborts with 403 if not. Useful for forms/posts that require same-origin referer. |
| `cache.general` | Applies default cache headers (public, max-age=300, ETag, must-revalidate).                                                            |

## Usage notes

- `RefererLock` will abort if the `Referer` header is missing or different; only apply it when clients/browsers are expected to send a referer header.
- `CacheGeneral` delegates to Laravel's `SetCacheHeaders` and sets a practical default caching policy for public pages.
