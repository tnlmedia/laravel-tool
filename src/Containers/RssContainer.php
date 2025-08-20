<?php

namespace TNLMedia\LaravelTool\Containers;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use TNLMedia\LaravelTool\Containers\Items\RssAuthor;
use TNLMedia\LaravelTool\Containers\Items\RssCategory;
use TNLMedia\LaravelTool\Containers\Items\RssMedia;

class RssContainer extends XmlContainer
{
    /**
     * Set data structure
     */
    public function __construct()
    {
        $this->setData('title', config('app.name'));
        $this->setData('link', url(request()->path()));
        $this->setData('description', config('tmg-website.site.slogan', ''));
        $this->setData('language', config('tmg-website.site.language', 'zh-tw'));
        $this->setData('copyright', 'TNL Mediagene');
        $this->setData('buildDate', Carbon::now()->format('r'));
        $this->setData('row', []);
    }

    /**
     * Add a index item
     *
     */
    public function pushRow(
        string $guid,
        string $title,
        string $link,
        string $description = '',
        string $content = '',
        ?Carbon $pubDate = null,
        string $commentLink = '',
        array $authors = [],
        array $categories = [],
        array $medias = [],
    ): RssContainer {
        $this->pushData('row', [
            'guid' => $guid,
            'title' => $title,
            'link' => $link,
            'description' => $description,
            'content' => $content,
            'pubDate' => $pubDate ? $pubDate->format('r') : Carbon::now()->format('r'),
            'comments' => $commentLink,
            'authors' => $authors,
            'categories' => $categories,
            'medias' => $medias,
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

        // item
        foreach ($this->getData('row', []) as $row) {
            $item = '<item>';
            foreach ($row as $key => $value) {
                if (!$value) {
                    continue;
                }
                switch ($key) {
                    case 'guid':
                        $item .= PHP_EOL . '<guid isPermaLink="true">' . htmlspecialchars(strval($value)) . '</guid>';
                        break;

                    case 'content':
                        $namespace['xmlns:content'] = 'http://purl.org/rss/1.0/modules/content/';
                        $item .= PHP_EOL . '<content:encoded><![CDATA[' . $value . ']]></content:encoded>';
                        break;

                    case 'authors':
                        $namespace['xmlns:dc'] = 'http://purl.org/dc/elements/1.1/';
                        foreach ($value as $value_item) {
                            if ($value_item instanceof RssAuthor) {
                                $item .= PHP_EOL . $value_item;
                            }
                        }
                        break;

                    case 'categories':
                        foreach ($value as $value_item) {
                            if ($value_item instanceof RssCategory) {
                                $item .= PHP_EOL . $value_item;
                            }
                        }
                        break;

                    case 'medias':
                        $namespace['xmlns:media'] = 'http://search.yahoo.com/mrss/';
                        foreach ($value as $value_item) {
                            if ($value_item instanceof RssMedia) {
                                $item .= PHP_EOL . $value_item;
                            }
                        }
                        break;

                    case 'description':
                        $item .= PHP_EOL . '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>';
                        break;

                    default:
                        $item .= PHP_EOL . '<' . $key . '>' . htmlspecialchars(strval($value)) . '</' . $key . '>';
                        break;
                }
            }
            $item .= '</item>';
            $list[] = $item;
        }

        $content = '<rss version="2.0"';
        foreach ($namespace as $name => $space) {
            $content .= ' ' . $name . '="' . $space . '"';
        }
        $content .= '>';
        $content .= PHP_EOL . '<channel>';
        $content .= PHP_EOL . '<title>' . htmlspecialchars($this->getData('title')) . '</title>';
        $content .= PHP_EOL . '<link>' . htmlspecialchars($this->getData('link')) . '</link>';
        $content .= PHP_EOL . '<description>' . htmlspecialchars($this->getData('description')) . '</description>';
        $content .= PHP_EOL . '<language>' . htmlspecialchars($this->getData('language')) . '</language>';
        $content .= PHP_EOL . '<copyright>' . htmlspecialchars($this->getData('copyright')) . '</copyright>';
        $content .= PHP_EOL . '<lastBuildDate>' . $this->getData('buildDate') . '</lastBuildDate>';
        $content .= PHP_EOL . implode(PHP_EOL, $list);
        $content .= PHP_EOL . '</channel>';
        $content .= PHP_EOL . '</rss>';
        $this->setData('content', $content);

        return parent::response();
    }
}
