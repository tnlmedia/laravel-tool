<?php

namespace TNLMedia\LaravelTool\Containers\Items;

/**
 * Rss item author
 */
class RssAuthor
{
    /**
     * @param string $name
     */
    public function __construct(protected string $name)
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '<dc:creator>' . htmlspecialchars($this->name) . '</dc:creator>';
    }
}
