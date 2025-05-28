<?php

namespace TNLMedia\LaravelTool\Containers\Items;

use Carbon\Carbon;

/**
 * News extension for XML sitemaps.
 *
 * @see https://developers.google.com/search/docs/crawling-indexing/sitemaps/news-sitemap
 */
class SitemapNews
{
    /**
     * @param string $publicationName
     * @param string $language
     * @param string $title
     * @param Carbon $publicationDate
     */
    public function __construct(
        protected string $publicationName,
        protected string $language,
        protected string $title,
        protected Carbon $publicationDate,
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $xml = '<news:news>';
        $xml .= '<news:publication>';
        $xml .= '<news:name>' . htmlspecialchars($this->publicationName) . '</news:name>';
        $xml .= '<news:language>' . htmlspecialchars($this->language) . '</news:language>';
        $xml .= '</news:publication>';
        $xml .= '<news:title>' . htmlspecialchars($this->title) . '</news:title>';
        $xml .= '<news:publication_date>' . $this->publicationDate->format('c') . '</news:publication_date>';
        $xml .= '</news:news>';
        return $xml;
    }
}
