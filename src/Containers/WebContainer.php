<?php

namespace TNLMedia\LaravelTool\Containers;

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
     * Schema.org Page type
     */
    const PAGE_TYPE = [
        'WebPage',
        'AboutPage',
        'CheckoutPage',
        'CollectionPage',
        'ContactPage',
        'FAQPage',
        'ItemPage',
        'MedicalWebPage',
        'ProfilePage',
        'QAPage',
        'RealEstateListing',
        'SearchResultsPage',
    ];

    /**
     * Schema.org Article type
     */
    const ARTICLE_TYPE = [
        'Article',
        'AdvertiserContentArticle',
        'NewsArticle',
        'Report',
        'SatiricalArticle',
        'ScholarlyArticle',
        'SocialMediaPosting',
        'TechArticle',
    ];

    /**
     * Storage data
     *
     * @var array
     */
    protected array $data = [
        // Rendered HTML
        // Override in process, from shared and material
        'html' => [
            // <html prefix="...">
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
            // [['type' => 'category', 'key' => 'slug', 'name' => 'name']]
            'terms' => [],
            // [['key' => 'slug', 'name' => 'name']]
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
        $meta = [];

        // Global
        $meta[] = '<meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">';

        // Title
        $value = trim($this->getShared('title.basic') . $this->getShared('title.extra'));
        $value = $value ? $value . config('tmg-website.separator.name', ' - ') : '';
        $value .= config('app.name');
        $this->setShared('title.full', $value);
        $meta[] = '<title>' . $this->getShared('title.full') . '</title>';

        // Prefetch
        $value = config('tmg-website.performance.prefetch', []);
        $value[] = parse_url(config('app.url'), PHP_URL_HOST);
        $value[] = 'bucket-image.inkmaginecms.com';
        $value[] = 'resource.tnlmediagene.com';
        $value[] = 'www.googletagmanager.com';
        $value[] = 'analytics.google.com';
        $value[] = 'ping.chartbeat.net';
        $value[] = 'pagead2.googlesyndication.com';
        $value[] = 'securepubads.g.doubleclick.net';
        $value[] = 'a.flux.jp';
        $value = array_unique($value);
        foreach ($value as $item) {
            $meta[] = '<link rel="dns-prefetch" href="//' . trim($item, '/') . '">';
        }

        // Url
        $value = $this->getShared('url');
        if (is_array($value)) {
            $meta[] = '<link rel="canonical" href="' . $value[$this->getShared('language')] ?? reset($value) . '">';
            foreach ($value as $key => $item) {
                $meta[] = '<link rel="alternate" href="' . $item . '" hreflang="' . $key . '">';
            }
        } else {
            $meta[] = '<link rel="canonical" href="' . $this->getShared('url') . '">';
            $meta[] = '<link rel="alternate" href="' . $this->getShared('url') . '" hreflang="' . $this->getShared('language') . '">';
        }
        $value = config('tmg-website.site.rss', []);
        $value = is_array($value) ? $value : [$this->getShared('language') => $value];
        foreach ($value as $key => $item) {
            $meta[] = '<link rel="alternate" type="application/rss+xml" title="' . config('app.name') . '" href="' . $item . '" hreflang="' . $key . '">';
        }

        // Detail
        $value = $this->getShared('description.basic');
        $value = mb_strlen($value) > 150 ? mb_substr($value, 0, 150) . '...' : $value;
        $value .= $this->getShared('description.extra');
        $this->setShared('description.full', $value);
        $meta[] = '<meta name="description" content="' . $this->getShared('description.full') . '">';
        if ($value = $this->getShared('keyword')) {
            $meta[] = '<meta name="keywords" content="' . $value . '">';
        }
        $meta[] = '<meta name="robots" content="' . $this->getShared('robots') . '">';
        foreach ($this->getMaterial('authors', []) as $item) {
            $item += ['name' => ''];
            if (empty($item['name'])) {
                continue;
            }
            $meta[] = '<meta name="author" content="' . $item['name'] . '">';
        }
        if (in_array($this->getShared('type'), self::ARTICLE_TYPE)) {
            if ($value = $this->getShared('keyword')) {
                $meta[] = '<meta name="news_keywords" content="' . $value . '">';
            }
            $meta[] = '<meta name="Googlebot-News" content="all">';
        }
        if ($value = config('tmg-website.performance.icon')) {
            $meta[] = '<link rel="shortcut icon" href="' . asset($value) . '" type="image/x-icon">';
            $meta[] = '<link rel="icon" href="' . asset($value) . '" type="image/x-icon">';
        }
        if ($value = config('tmg-website.performance.color')) {
            $meta[] = '<meta name="theme-color" content="' . $value . '">';
        }

        // Open graph
        $prefix['og'] = 'http://ogp.me/ns#';
        if (in_array($this->getShared('type'), self::ARTICLE_TYPE)) {
            $meta[] = '<meta property="og:type" content="article">';
        } else {
            $meta[] = '<meta property="og:type" content="website">';
        }
        $value = $this->getShared('url');
        if (is_array($value)) {
            $meta[] = '<meta property="og:url" content="' . $value[$this->getShared('language')] ?? reset($value) . '">';
        } else {
            $meta[] = '<meta property="og:url" content="' . $this->getShared('url') . '">';
        }
        $meta[] = '<meta property="og:site_name" content="' . config('app.name') . '">';
        $meta[] = '<meta property="og:title" content="' . $this->getShared('title.full') . '">';
        $meta[] = '<meta property="og:description" content="' . $this->getShared('description.full') . '">';
        if ($value = $this->getShared('image.url')) {
            $meta[] = '<meta property="og:image" content="' . $value . '">';
            if ($value = $this->getShared('image.width')) {
                $meta[] = '<meta property="og:image:width" content="' . $value . '">';
            }
            if ($value = $this->getShared('image.height')) {
                $meta[] = '<meta property="og:image:height" content="' . $value . '">';
            }
        }
        if (in_array($this->getShared('type'), self::ARTICLE_TYPE)) {
            $prefix['article'] = 'http://ogp.me/ns/article#';
            if ($value = config('tmg-website.site.facebook.fanpage')) {
                $meta[] = '<meta property="article:publisher" content="' . $value . '">';
            }
            foreach ($this->getMaterial('authors', []) as $item) {
                $item += ['name' => ''];
                if (empty($item['name'])) {
                    continue;
                }
                $meta[] = '<meta property="article:author" content="' . $item['name'] . '">';
            }
            $reset = false;
            foreach ($this->getMaterial('terms') as $item) {
                $item += ['name' => ''];
                if (empty($item['name'])) {
                    continue;
                }
                if (!$reset) {
                    $meta[] = '<meta property="article:section" content="' . $item['name'] . '">';
                    $reset = true;
                } else {
                    $meta[] = '<meta property="article:tag" content="' . $item['name'] . '">';
                }
            }
        }
        $meta[] = '<meta property="article:modified_time" content="' . date('c', $this->getShared('modified')) . '">';
        $meta[] = '<meta property="article:published_time" content="' . date('c', $this->getShared('published')) . '">';
        if ($value = config('tmg-website.site.facebook.application')) {
            $prefix['fb'] = 'http://ogp.me/ns/fb#';
            $meta[] = '<meta property="fb:app_id" content="' . $value . '">';
        }

        // Twitter
        $meta[] = '<meta name="twitter:card" content="summary_large_image">';
        $meta[] = '<meta name="twitter:title" content="' . $this->getShared('title.full') . '">';
        $meta[] = '<meta name="twitter:description" content="' . $this->getShared('description.full') . '">';
        if ($value = config('tmg-website.site.x.id')) {
            $meta[] = '<meta name="twitter:site" content="@' . $value . '">';
            $meta[] = '<meta name="twitter:creator" content="@' . $value . '">';
        }
        if ($value = $this->getShared('image.url')) {
            $meta[] = '<meta name="twitter:image" content="' . $value . '">';
        }

        // Schema
        $type = $this->getShared('type');
        if (in_array($type, self::ARTICLE_TYPE)) {
            $item = [
                '@context' => 'https://schema.org',
                '@type' => $type,
                'headline' => $this->getShared('title.full'),
                'mainEntityOfPage' => $this->getShared('url'),
                'datePublished' => date('c', $this->getShared('published')),
                'dateModified' => date('c', $this->getShared('modified')),
                'author' => array_column($this->getMaterial('authors', []), 'name'),
                'keywords' => array_column($this->getMaterial('terms', []), 'name'),
                'description' => $this->getShared('description.full'),
            ];
            if ($value = $this->getShared('image.url')) {
                $item['image'] = [
                    '@type' => 'ImageObject',
                    'contentUrl' => $value,
                ];
                if ($value = $this->getShared('image.width')) {
                    $item['image']['width'] = $value;
                }
                if ($value = $this->getShared('image.height')) {
                    $item['image']['height'] = $value;
                }
            }
            if ($value = $this->getShared('body')) {
                $item['articleBody'] = $value;
            }
        } else {
            $type = in_array($type, self::PAGE_TYPE) ? $type : 'WebPage';
            $item = [
                '@context' => 'https://schema.org',
                '@type' => $type,
                'name' => $this->getShared('title.full'),
                'description' => $this->getShared('description.full'),
                'dateCreated' => date('c', $this->getShared('published')),
                'dateModified' => date('c', $this->getShared('modified')),
                'primaryImageOfPage' => [
                    '@type' => 'ImageObject',
                    'contentUrl' => $this->getMeta('image', ''),
                ],
            ];
            if ($value = $this->getShared('keyword')) {
                $item['keywords'] = explode(',', $value);
            }
            if ($value = $this->getShared('image.url')) {
                $item['primaryImageOfPage'] = [
                    '@type' => 'ImageObject',
                    'contentUrl' => $value,
                ];
                if ($value = $this->getShared('image.width')) {
                    $item['primaryImageOfPage']['width'] = $value;
                }
                if ($value = $this->getShared('image.height')) {
                    $item['primaryImageOfPage']['height'] = $value;
                }
            }
        }
        $this->setSchema($type, $item);

        // JSON
        $meta[] = '<script type="application/json" id="config-material">' . json_encode($this->getMaterial(null, []),
                JSON_UNESCAPED_UNICODE) . '</script>';
        $meta[] = '<script type="application/json" id="config-shared">' . json_encode($this->getShared(null, []),
                JSON_UNESCAPED_UNICODE) . '</script>';
        foreach ($this->getSchema(null, []) as $item) {
            $meta[] = '<script type="application/ld+json">' . json_encode($item, JSON_UNESCAPED_UNICODE) . '</script>';
        }

        // Store
        $value = [];
        foreach ($prefix as $key => $item) {
            $value[] = $key . ': ' . $item;
        }
        $this->setData('html.prefix', implode(' ', $value));
        $this->setData('html.meta', implode(PHP_EOL, $meta));
    }
}
