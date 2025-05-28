<?php

namespace TNLMedia\LaravelTool\Containers\Items;

/**
 * Image extension for XML sitemaps.
 *
 * @see https://developers.google.com/search/docs/crawling-indexing/sitemaps/image-sitemaps
 */
class SitemapImage
{
    /**
     * @param string $loc
     */
    public function __construct(protected string $loc)
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $xml = '<image:image>';
        $xml .= '<image:loc>' . htmlspecialchars($this->loc) . '</image:loc>';
        $xml .= '</image:image>';
        return $xml;
    }
}
