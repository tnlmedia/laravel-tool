# Containers/XmlContainer

Overview

`XmlContainer` provides a base for building XML responses. It stores `content` in the container and exposes a `response()` method returning an XML `Response` with proper headers.

Public methods

- `response(): Response` — returns an HTTP `Response` with `Content-Type: text/xml; charset=utf-8` and the XML prolog plus the container's `content`.

Example

```php
$xml = new XmlContainer();
$xml->setData('content', '<root><item>1</item></root>');
return $xml->response();
```

