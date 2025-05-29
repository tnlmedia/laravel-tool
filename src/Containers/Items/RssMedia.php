<?php

namespace TNLMedia\LaravelTool\Containers\Items;

use TNLMedia\LaravelTool\Enums\RssMediaMedium;

/**
 * Rss item category
 *
 * @see https://www.rssboard.org/media-rss
 */
class RssMedia
{
    /**
     * @param string $url
     * @param string $mimeType
     * @param RssMediaMedium $medium
     * @param int $width
     * @param int $height
     * @param int $duration
     * @param string $title
     * @param string $description
     * @param string $thumbnailUrl
     * @param string $credit
     */
    public function __construct(
        protected string $url,
        protected string $mimeType,
        protected RssMediaMedium $medium = RssMediaMedium::Image,
        protected int $width = 0,
        protected int $height = 0,
        protected int $duration = 0,
        protected string $title = '',
        protected string $description = '',
        protected string $thumbnailUrl = '',
        protected string $credit = '',
    ) {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $xml = '<media:content';
        $xml .= ' url="' . htmlspecialchars($this->url) . '"';
        $xml .= ' type="' . htmlspecialchars($this->mimeType) . '"';
        $xml .= ' medium="' . $this->medium->value . '"';
        if ($this->width) {
            $xml .= ' width="' . $this->width . '"';
        }
        if ($this->height) {
            $xml .= ' height="' . $this->height . '"';
        }
        if ($this->duration) {
            $xml .= ' duration="' . $this->duration . '"';
        }
        $xml .= '>';
        if ($this->title) {
            $xml .= PHP_EOL . '<media:title type="plain">' . htmlspecialchars($this->title) . '</media:title>';
        }
        if ($this->description) {
            $xml .= PHP_EOL . '<media:description type="plain">' . htmlspecialchars($this->description) . '</media:description>';
        }
        if ($this->thumbnailUrl) {
            $xml .= PHP_EOL . '<media:thumbnail url="' . htmlspecialchars($this->thumbnailUrl) . '" />';
        }
        if ($this->credit) {
            $xml .= PHP_EOL . '<media:credit>' . htmlspecialchars($this->credit) . '</media:credit>';
        }
        $xml .= '</media:content>';
        return $xml;
    }
}
