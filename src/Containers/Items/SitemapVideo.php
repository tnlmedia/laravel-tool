<?php

namespace TNLMedia\LaravelTool\Containers\Items;

use Carbon\Carbon;

/**
 * Video extension for XML sitemaps.
 *
 * @see https://developers.google.com/search/docs/crawling-indexing/sitemaps/video-sitemaps
 */
class SitemapVideo
{
    /**
     * @param string $title
     * @param string $description
     * @param string $thumbnailLoc
     * @param string $contentLoc
     * @param string $playerLoc
     * @param bool $familyFriendly
     * @param bool $live
     * @param Carbon|null $publicationDate
     * @param Carbon|null $expirationDate
     * @param string|null $uploader
     * @param int|null $duration
     * @param float|null $rating
     * @param int|null $viewCount
     */
    public function __construct(
        protected string $title,
        protected string $description,
        protected string $thumbnailLoc,
        protected string $contentLoc,
        protected string $playerLoc,
        protected bool $familyFriendly = true,
        protected bool $live = false,
        protected ?Carbon $publicationDate = null,
        protected ?Carbon $expirationDate = null,
        protected ?string $uploader = null,
        protected ?int $duration = null,
        protected ?float $rating = null,
        protected ?int $viewCount = null,
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $xml = '<video:video>';
        $xml .= '<video:title><![CDATA[' . htmlspecialchars($this->title) . ']]></video:title>';
        $xml .= '<video:description><![CDATA[' . htmlspecialchars($this->description) . ']]></video:description>';
        $xml .= '<video:thumbnail_loc>' . htmlspecialchars($this->thumbnailLoc) . '</video:thumbnail_loc>';
        $xml .= '<video:content_loc>' . htmlspecialchars($this->contentLoc) . '</video:content_loc>';
        $xml .= '<video:player_loc>' . htmlspecialchars($this->playerLoc) . '</video:player_loc>';
        $xml .= '<video:family_friendly>' . ($this->familyFriendly ? 'yes' : 'no') . '</video:family_friendly>';
        $xml .= '<video:live>' . ($this->live ? 'yes' : 'no') . '</video:live>';
        if ($this->publicationDate) {
            $xml .= '<video:publication_date>' . $this->publicationDate->format('c') . '</video:publication_date>';
        }
        if ($this->expirationDate) {
            $xml .= '<video:expiration_date>' . $this->expirationDate->format('c') . '</video:expiration_date>';
        }
        if ($this->uploader) {
            $xml .= '<video:uploader>' . htmlspecialchars($this->uploader) . '</video:uploader>';
        }
        if ($this->duration) {
            $xml .= '<video:duration>' . $this->duration . '</video:duration>';
        }
        if ($this->rating) {
            $xml .= '<video:rating>' . $this->rating . '</video:rating>';
        }
        if ($this->viewCount) {
            $xml .= '<video:view_count>' . $this->viewCount . '</video:view_count>';
        }
        $xml .= '</video:video>';
        return $xml;
    }
}
