<?php

namespace TNLMedia\LaravelTool\Containers;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use TNLMedia\LaravelTool\Containers\Items\SitemapImage;
use TNLMedia\LaravelTool\Containers\Items\SitemapNews;
use TNLMedia\LaravelTool\Containers\Items\SitemapVideo;
use TNLMedia\LaravelTool\Enums\SitemapFrequency;
use TNLMedia\LaravelTool\Enums\SitemapPriority;

class SitemapContainer extends XmlContainer
{
    /**
     * Set data structure
     */
    public function __construct()
    {
        $this->setData('row', []);
    }

    /**
     * Add an item
     *
     * @param string $loc
     * @param Carbon|null $modified
     * @param SitemapFrequency $frequency
     * @param SitemapPriority $priority
     * @param SitemapNews|null $news
     * @param array $image
     * @param array $video
     * @return $this
     */
    public function pushRow(
        string $loc,
        ?Carbon $modified = null,
        SitemapFrequency $frequency = SitemapFrequency::Daily,
        SitemapPriority $priority = SitemapPriority::Article,
        ?SitemapNews $news = null,
        array $image = [],
        array $video = []
    ): SitemapContainer {
        $this->pushData('row', [
            'loc' => $loc,
            'lastmod' => $modified ? $modified->format('c') : Carbon::now()->format('c'),
            'changefreq' => $frequency,
            'priority' => $priority,
            'news' => $news,
            'image' => $image,
            'video' => $video,
        ]);
        return $this;
    }

    /**
     * Build sitemap XML
     *
     * @return Response
     * @throws BindingResolutionException
     */
    public function response(): Response
    {
        $list = [];
        $namespace = [];
        $namespace['xmlns'] = 'http://www.sitemaps.org/schemas/sitemap/0.9';
        foreach ($this->getData('row', []) as $row) {
            if (empty($row['loc'] ?? '')) {
                continue;
            }

            $item = '<url>';
            foreach ($row as $key => $value) {
                switch ($key) {
                    case 'news':
                        if ($value instanceof SitemapNews) {
                            $namespace['xmlns:news'] = 'http://www.google.com/schemas/sitemap-news/0.9';
                            $item .= PHP_EOL . $value;
                        }
                        break;

                    case 'image':
                        if (!empty($value)) {
                            $namespace['xmlns:image'] = 'http://www.google.com/schemas/sitemap-image/1.1';
                        }
                        foreach ($value as $value_item) {
                            if ($value_item instanceof SitemapImage) {
                                $item .= PHP_EOL . $value_item;
                            }
                        }
                        break;

                    case 'video':
                        if (!empty($value)) {
                            $namespace['xmlns:video'] = 'http://www.google.com/schemas/sitemap-video/1.1';
                        }
                        foreach ($value as $value_item) {
                            if ($value_item instanceof SitemapVideo) {
                                $item .= PHP_EOL . $value_item;
                            }
                        }
                        break;

                    case 'changefreq':
                    case 'priority':
                        $item .= PHP_EOL . '<' . $key . '>' . $value->value . '</' . $key . '>';
                        break;

                    default:
                        $item .= PHP_EOL . '<' . $key . '>' . htmlspecialchars(strval($value)) . '</' . $key . '>';
                        break;
                }
            }
            $item .= '</url>';
            $list[] = $item;
        }

        $content = '<urlset';
        foreach ($namespace as $name => $space) {
            $content .= ' ' . $name . '="' . $space . '"';
        }
        $content .= '>';
        $content .= PHP_EOL . implode(PHP_EOL, $list);
        $content .= PHP_EOL . '</urlset>';
        $this->setData('content', $content);

        return parent::response();
    }
}
