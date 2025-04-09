<?php

namespace TNLMedia\LaravelTool\Containers;

use Carbon\Carbon;
use Exception;

/**
 * @method WebContainer setShared(string $key, $value)
 * @method mixed getShared(string $key, $default = null)
 * @method bool checkShared(string $key)
 * @method WebContainer setMaterial(string $key, $value)
 * @method mixed getMaterial(string $key, $default = null)
 * @method bool checkMaterial(string $key)
 * @method WebContainer setSchema(string $key, $value)
 * @method mixed getSchema(string $key, $default = null)
 * @method bool checkSchema(string $key)
 * @method WebContainer robotsAllow()
 * @method WebContainer robotsArticle()
 * @method WebContainer robotsNextPage()
 * @method WebContainer robotsDisabled()
 */
class WebContainer extends Container
{
    /**
     * Storage data
     *
     * @var array
     */
    protected array $data = [
        // Rendered HTML
        // Override in process, from shared and material
        'html' => [
            // <html
            'prefix' => '',
            'meta' => '',
        ],
        // Share basic data
        'shared' => [
            'id' => 0,
            'slug' => '',
            // For multi-language: ['zh-tw' => '', 'en-us' => '']
            'url' => '',
            'title' => [
                'basic' => '',
                'extra' => '',
                // Override in process, from basic and extra
                'full' => '',
            ],
            'description' => [
                'basic' => '',
                'extra' => '',
                // Override in process, from basic and extra
                'full' => '',
            ],
            'image' => [
                'url' => '',
                'width' => 0,
                'height' => 0,
            ],
            'keyword' => '',
            'published' => 0,
            'modified' => 0,
            'robots' => 'all',
            // hreflang in ISO 3166-1 Alpha 2 or ISO 15924
            // @see https://developers.google.com/search/docs/specialty/international/localized-versions
            'language' => 'zh-tw',
            // Page schema type
            // @see https://schema.org/WebPage
            // @see https://schema.org/Article
            'type' => 'WebPage',
            // Override in process, from material
            'section' => '',
            'body' => '',
        ],
        // Material for analytics and advertising targeting
        'material' => [
            'cabinet' => 0,
            'advertising' => 0,
            // Sponsor type
            // 0: none, 1: sponsor
            'sponsor' => 0,
            // Paid content
            // 0: free, 1: paid, 2: user
            'paid' => 0,
            'page' => [
                'key' => 'index',
                'name' => 'index',
            ],
            'terms' => [],
            'authors' => [],
        ],
        'schema' => [],
    ];

    /**
     * Set default from config
     */
    public function __construct()
    {
        $this->setShared('url', url(request()->path()));
        $this->setShared('description.basic', config('tmg-website.site.slogan', ''));
        $this->setShared('image.url', config('tmg-website.site.image.url', ''));
        $this->setShared('image.width', config('tmg-website.site.image.width', 0));
        $this->setShared('image.height', config('tmg-website.site.image.height', 0));
        $this->setShared('keyword', implode(',', config('tmg-website.site.keyword', [])));
        $this->setShared('published', time());
        $this->setShared('modified', time());
        $this->setShared('language', config('tmg-website.site.language', 'zh-tw'));
        $this->setMaterial('page.key', request()->segment(1) ?: 'index');
        $this->setMaterial('page.name', request()->segment(1) ?: 'index');
        $this->setSchema(null, config('tmg-website.schema', []));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call(string $name, array $arguments): mixed
    {
        // Robots helper
        if (preg_match('/^robots([a-z0-9])$/i', $name, $match)) {
            $match[1] = strtolower($match[1]);
            $value = match ($match[1]) {
                'article' => 'all, max-image-preview:large',
                'nextpage' => 'noindex, follow',
                'disabled' => 'noindex, nofollow',
                default => 'all',
            };
            return $this->setShared('robots', $value);
        }

        return parent::__call($name, $arguments);
    }

    /**
     * {@inheritdoc }
     */
    public function export(): array
    {
        $this->process();
        return $this->data;
    }

    protected function process(): void
    {
        $prefix = [];
        // og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#
        $meta = [];

        // Global
        $meta[] = '<meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">';

        // Basic
        $value = trim($this->getShared('title.basic') . $this->getShared('title.extra'));
        $value = $value ? $value . config('tmg-website.separator.name') : '';
        $value .= config('app.name');
        $this->setShared('title.full', $value);
        $meta[] = '<title>' . $this->getShared('title.full') . '</title>';



        $description = $this->getShared('description.basic');
        // TODO: 150 characters

        // Open graph
        // TODO
        $meta['og'] += [
            'see_also' => [],
            'section' => 'Technology',
            'author' => [],
            'modified' => Carbon::now()->format('c'),
            'published' => Carbon::now()->format('c'),
        ];

        // Schema




        // Store
        $this->setData('html.prefix', implode(' ', $prefix));
        $this->setData('html.meta', implode(PHP_EOL, $meta));
    }
}
