<?php

namespace TNLMedia\LaravelTool\Containers;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;

class SitemapIndexContainer extends XmlContainer
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
     * @return $this
     */
    public function pushRow(string $loc, Carbon $modified = null): SitemapIndexContainer
    {
        $this->pushData('row', [
            'loc' => $loc,
            'lastmod' => $modified ? $modified->format('c') : Carbon::now()->format('c'),
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

            $item = '<sitemap>';
            foreach ($row as $key => $value) {
                $item .= '<' . $key . '>' . htmlspecialchars($value) . '</' . $key . '>';
            }
            $item .= '</sitemap>';
            $list[] = $item;
        }

        $content = '<sitemapindex';
        foreach ($namespace as $name => $space) {
            $content .= ' ' . $name . '="' . $space . '"';
        }
        $content .= '>';
        $content .= PHP_EOL . implode(PHP_EOL, $list);
        $content .= PHP_EOL . '</sitemapindex>';
        $this->setData('content', $content);

        return parent::response();
    }
}
