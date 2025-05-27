<?php

namespace TNLMedia\LaravelTool\Containers;

use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;

/**
 * @method SitemapIndexContainer pushRow(array $value)
 * @method mixed getRow(string $key, $default = null)
 */
class SitemapIndexContainer extends Container
{
    /**
     * {@inheritdoc }
     */
    protected array $data = [
        'row' => [],
    ];

    /**
     * Add a index item
     *
     * @param string $loc
     * @param Carbon|null $modified
     * @return $this
     */
    public function pushItem(string $loc, Carbon $modified = null): SitemapIndexContainer
    {
        $this->pushRow([
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
        $namespace['xmlns'] = 'http://www.sitemaps.org/schemas/sitemap/0.9';
        foreach ($this->getData('row', []) as $row) {
            $row += [
                'loc' => '',
                'lastmod' => Carbon::now()->format('c'),
            ];
            if (!$row['loc']) {
                continue;
            }

            $item = '<sitemap>';
            $item .= '<loc>' . htmlspecialchars($row['loc']) . '</loc>';
            $item .= '<lastmod>' . htmlspecialchars($row['lastmod']) . '</lastmod>';
            $item .= '</sitemap>';
            $list[] = $item;
        }

        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= '<sitemapindex';
        foreach ($namespace as $name => $space) {
            $result .= ' ' . $name . '="' . htmlspecialchars($space) . '"';
        }
        $result .= '>' . PHP_EOL;
        $result .= implode(PHP_EOL, $list);
        $result .= PHP_EOL . '</sitemapindex>';

        return response()->make($result, Response::HTTP_OK, [
            'Content-Type' => 'text/xml; charset=utf-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
