<?php

namespace TNLMedia\LaravelTool\Containers\Items;

/**
 * Rss item category
 *
 * @see https://www.rssboard.org/rss-specification#ltcategorygtSubelementOfLtitemgt
 */
class RssCategory
{
    /**
     * @param string $name
     * @param string|null $link
     */
    public function __construct(
        protected string $name,
        protected ?string $link = null,
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $xml = '<category';
        if ($this->link) {
            $xml .= ' domain="' . htmlspecialchars($this->link) . '"';
        }
        $xml .= '>' . htmlspecialchars($this->name) . '</category>';
        return $xml;
    }
}
