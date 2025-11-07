# ContentSplitter

`ContentSplitter` helps you extract candidate keywords from article content.

## Methods

- `setTitle(string $value): ContentSplitter`: Set the source title to avoid picking terms that appear in the title.
- `setContent(string $value): ContentSplitter`: Set the article content; it may contain HTML, which will be stripped and sanitized.
- `setTerm(array $value): ContentSplitter`: Provide candidate terms (array of strings) to consider.
- `pickTerm(): string`: Pick the most frequent term from the provided terms found in the content, excluding those in the title.
- `cutUtfKeyword(int $pick = 0): array`: Extract CJK-style keyword candidates.
- `cutAlphanumericKeyword(int $pick = 0): array`: Extract alphanumeric and multi-token keyword candidates.

## Example

```php
$splitter = new ContentSplitter();
$splitter->setTitle($article->title)
    ->setContent(strval($article->detail->body))
    ->setTerm($article->tags->pluck('name')->toArray());

$hashtag = $splitter->pickTerm();
$keyword = array_merge($splitter->cutUtfKeyword(3), $splitter->cutAlphanumericKeyword(1));
```
