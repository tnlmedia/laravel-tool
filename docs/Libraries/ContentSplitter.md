# Libraries/ContentSplitter.php

Overview

`ContentSplitter` helps extract candidate keywords from article content. It offers methods to sanitize content, pick the most relevant term, and extract UTF-8 and alphanumeric keyword candidates.

Class: TNLMedia\LaravelTool\Libraries\ContentSplitter

Methods (detailed)

- `setTitle(string $value): self`
  - Sets the source title used to avoid picking terms that appear in the title.
  - Returns: `$this` for chaining.
  - Example: `$splitter->setTitle('Hello World');`

- `setContent(string $value): self`
  - Cleans HTML: strips <script>/<style> tags, comments, strip_tags, normalize whitespace and store sanitized content.
  - Returns: `$this`.
  - Example: `$splitter->setContent($html);`

- `setTerm(array $value): self`
  - Provide candidate terms (array of strings) used by `pickTerm()`.
  - Returns: `$this`.

- `pickTerm(): string`
  - Returns: the most frequent term from `$this->terms` found in the content excluding terms that appear in the title. Returns empty string if none found.
  - Example: `$best = $splitter->pickTerm();`

- `cutUtfKeyword(int $pick = 0): array`
  - Extracts CJK-style keyword candidates.
  - Parameters: `$pick` limit number of results (0 = no limit).
  - Returns: `array` of string keywords.
  - Example: `$keywords = $splitter->cutUtfKeyword(5);`

- `cutAlphanumericKeyword(int $pick = 0): array`
  - Extracts alphanumeric and multi-token keywords.
  - Returns: array of keywords; `$pick` limits the number returned.

- `sort($a, $b): int` (static)
  - Comparator used to order candidate suggestions by frequency then length.

Notes

- `cutUtfKeyword` contains an extensive blacklist tailored for Chinese-language content; results are tuned accordingly.
- Short content may yield few candidates; adjust `$pick` and post-filtering as needed.
