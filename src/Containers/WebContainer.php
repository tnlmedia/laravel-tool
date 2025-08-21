<?php

namespace TNLMedia\LaravelTool\Containers;

use Exception;
use Illuminate\Support\Arr;
use TNLMedia\LaravelTool\Facades\TMGBlade;

/**
 * == Shared Properties ==
 * @method WebContainer setShared(string $key, $value)
 * @method mixed getShared(string $key, mixed $default = null)
 * @method bool checkShared(string $key)
 * @method WebContainer setSharedId(int $value)
 * @method WebContainer pushSharedId(int $value)
 * @method mixed getSharedId(mixed $default = null)
 * @method bool checkSharedId(string $key)
 * @method WebContainer setSharedSlug(string $value)
 * @method WebContainer pushSharedSlug(string $value)
 * @method mixed getSharedSlug(mixed $default = null)
 * @method bool checkSharedSlug(string $key)
 * @method WebContainer setSharedUrl(string $value)
 * @method WebContainer pushSharedUrl(string $value)
 * @method mixed getSharedUrl(mixed $default = null)
 * @method bool checkSharedUrl(string $key)
 * @method WebContainer setSharedTitleBasic(string $value)
 * @method WebContainer pushSharedTitleBasic(string $value)
 * @method mixed getSharedTitleBasic(mixed $default = null)
 * @method bool checkSharedTitleBasic(string $key)
 * @method WebContainer setSharedTitleExtra(string $value)
 * @method WebContainer pushSharedTitleExtra(string $value)
 * @method mixed getSharedTitleExtra(mixed $default = null)
 * @method bool checkSharedTitleExtra(string $key)
 * @method WebContainer setSharedDescriptionBasic(string $value)
 * @method WebContainer pushSharedDescriptionBasic(string $value)
 * @method mixed getSharedDescriptionBasic(mixed $default = null)
 * @method bool checkSharedDescriptionBasic(string $key)
 * @method WebContainer setSharedDescriptionExtra(string $value)
 * @method WebContainer pushSharedDescriptionExtra(string $value)
 * @method mixed getSharedDescriptionExtra(mixed $default = null)
 * @method bool checkSharedDescriptionExtra(string $key)
 * @method WebContainer setSharedImageUrl(string $value)
 * @method WebContainer pushSharedImageUrl(string $value)
 * @method mixed getSharedImageUrl(mixed $default = null)
 * @method bool checkSharedImageUrl(string $key)
 * @method WebContainer setSharedImageWidth(int $value)
 * @method WebContainer pushSharedImageWidth(int $value)
 * @method mixed getSharedImageWidth(mixed $default = null)
 * @method bool checkSharedImageWidth(string $key)
 * @method WebContainer setSharedImageHeight(int $value)
 * @method WebContainer pushSharedImageHeight(int $value)
 * @method mixed getSharedImageHeight(mixed $default = null)
 * @method bool checkSharedImageHeight(string $key)
 * @method WebContainer setSharedKeyword(string $value)
 * @method WebContainer pushSharedKeyword(string $value)
 * @method mixed getSharedKeyword(mixed $default = null)
 * @method bool checkSharedKeyword(string $key)
 * @method WebContainer setSharedPublished(int $value)
 * @method WebContainer pushSharedPublished(int $value)
 * @method mixed getSharedPublished(mixed $default = null)
 * @method bool checkSharedPublished(string $key)
 * @method WebContainer setSharedModified(int $value)
 * @method WebContainer pushSharedModified(int $value)
 * @method mixed getSharedModified(mixed $default = null)
 * @method bool checkSharedModified(string $key)
 * @method WebContainer setSharedRobots(string $value)
 * @method WebContainer pushSharedRobots(string $value)
 * @method mixed getSharedRobots(mixed $default = null)
 * @method bool checkSharedRobots(string $key)
 * @method WebContainer setSharedLanguage(string $value)
 * @method WebContainer pushSharedLanguage(string $value)
 * @method mixed getSharedLanguage(mixed $default = null)
 * @method bool checkSharedLanguage(string $key)
 * @method WebContainer setSharedType(string $value)
 * @method WebContainer pushSharedType(string $value)
 * @method mixed getSharedType(mixed $default = null)
 * @method bool checkSharedType(string $key)
 * @method WebContainer setSharedBody(string $value)
 * @method WebContainer pushSharedBody(string $value)
 * @method mixed getSharedBody(mixed $default = null)
 * @method bool checkSharedBody(string $key)
 *
 * == Robots quick set ==
 * @method WebContainer robotsAllow()
 * @method WebContainer robotsArticle()
 * @method WebContainer robotsNextPage()
 * @method WebContainer robotsDisabled()
 *
 * == Page type quick set ==
 * @method WebContainer typeWebPage()
 * @method WebContainer typeAboutPage()
 * @method WebContainer typeCheckoutPage()
 * @method WebContainer typeCollectionPage()
 * @method WebContainer typeContactPage()
 * @method WebContainer typeFAQPage()
 * @method WebContainer typeItemPage()
 * @method WebContainer typeMedicalWebPage()
 * @method WebContainer typeProfilePage()
 * @method WebContainer typeQAPage()
 * @method WebContainer typeRealEstateListing()
 * @method WebContainer typeSearchResultsPage()
 * @method WebContainer typeArticle()
 * @method WebContainer typeAdvertiserContentArticle()
 * @method WebContainer typeNewsArticle()
 * @method WebContainer typeReport()
 * @method WebContainer typeSatiricalArticle()
 * @method WebContainer typeScholarlyArticle()
 * @method WebContainer typeSocialMediaPosting()
 * @method WebContainer typeTechArticle()
 *
 * == Material Properties ==
 * @method WebContainer setMaterial(string $key, $value)
 * @method mixed getMaterial(string $key, mixed $default = null)
 * @method bool checkMaterial(string $key)
 * @method WebContainer setMaterialCabinet(int $value)
 * @method WebContainer pushMaterialCabinet(int $value)
 * @method mixed getMaterialCabinet(mixed $default = null)
 * @method bool checkMaterialCabinet(string $key)
 * @method WebContainer setMaterialAdvertising(int $value)
 * @method WebContainer pushMaterialAdvertising(int $value)
 * @method mixed getMaterialAdvertising(mixed $default = null)
 * @method bool checkMaterialAdvertising(string $key)
 * @method WebContainer setMaterialSponsor(int $value)
 * @method WebContainer pushMaterialSponsor(int $value)
 * @method mixed getMaterialSponsor(mixed $default = null)
 * @method bool checkMaterialSponsor(string $key)
 * @method WebContainer setMaterialPaid(int $value)
 * @method WebContainer pushMaterialPaid(int $value)
 * @method mixed getMaterialPaid(mixed $default = null)
 * @method bool checkMaterialPaid(string $key)
 * @method WebContainer setMaterialPageKey(string $value)
 * @method WebContainer pushMaterialPageKey(string $value)
 * @method mixed getMaterialPageKey(mixed $default = null)
 * @method bool checkMaterialPageKey(string $key)
 * @method WebContainer setMaterialPageName(string $value)
 * @method WebContainer pushMaterialPageName(string $value)
 * @method mixed getMaterialPageName(mixed $default = null)
 * @method bool checkMaterialPageName(string $key)
 * @method WebContainer setMaterialTypeKey(string $value)
 * @method WebContainer pushMaterialTypeKey(string $value)
 * @method mixed getMaterialTypeKey(mixed $default = null)
 * @method bool checkMaterialTypeKey(string $key)
 * @method WebContainer setMaterialTypeName(string $value)
 * @method WebContainer pushMaterialTypeName(string $value)
 * @method mixed getMaterialTypeName(mixed $default = null)
 * @method bool checkMaterialTypeName(string $key)
 * @method WebContainer setMaterialTerms(array $value)
 * @method WebContainer pushMaterialTerms(array $value)
 * @method mixed getMaterialTerms(mixed $default = null)
 * @method bool checkMaterialTerms(string $key)
 * @method WebContainer setMaterialAuthors(array $value)
 * @method WebContainer pushMaterialAuthors(array $value)
 * @method mixed getMaterialAuthors(mixed $default = null)
 * @method bool checkMaterialAuthors(string $key)
 *
 * == Schema Properties ==
 * @method WebContainer setSchema(string $key, array $value)
 * @method WebContainer pushSchema(array $value)
 * @method mixed getSchema(string $key, mixed $default = null)
 * @method bool checkSchema(string $key)
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
            // Path first level
            'page' => [
                'key' => 'index',
                'name' => 'index',
            ],
            // Article type
            'type' => [
                'key' => '',
                'name' => '',
            ],
            // [['type' => 'category', 'key' => 'slug', 'name' => 'name', 'url' => 'https://sample.com/category']]
            'terms' => [],
            // [['key' => 'slug', 'name' => 'name', 'url' => 'https://sample.com/author']]
            'authors' => [],
        ],
        'schema' => [],
    ];

    /**
     * Set default from config
     */
    public function __construct()
    {
        $this->setSharedUrl(url(request()->path()));
        $this->setSharedDescriptionBasic(config('tmg-website.site.slogan', ''));
        $url = config('tmg-website.site.image.url', '');
        if (!parse_url($url, PHP_URL_HOST)) {
            $url = asset($url);
        }
        $this->setSharedImageUrl($url);
        $this->setSharedImageWidth(config('tmg-website.site.image.width', 0));
        $this->setSharedImageHeight(config('tmg-website.site.image.height', 0));
        $this->setSharedKeyword(implode(',', config('tmg-website.site.keyword', [])));
        $this->setSharedPublished(time());
        $this->setSharedModified(time());
        $this->setSharedLanguage(config('tmg-website.site.language', 'zh-tw'));
        $this->setMaterialPageKey(request()->segment(1) ?: 'index');
        $this->setMaterialPageName(request()->segment(1) ?: 'index');
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
        if (preg_match('/^robots([a-z0-9]+)$/i', $name, $match)) {
            $match[1] = strtolower($match[1]);
            $value = match ($match[1]) {
                'article' => 'all, max-image-preview:large',
                'nextpage' => 'noindex, follow',
                'disabled' => 'noindex, nofollow',
                default => 'all',
            };
            return $this->setSharedRobots($value);
        }

        // Type helper
        if (preg_match('/^type([a-z0-9]+)$/i', $name, $match)) {
            if (preg_match('/^(?:' . implode('|', self::PAGE_TYPE) . ')$/i', $match[1])) {
                return $this->setSharedType($match[1]);
            }
            if (preg_match('/^(?:' . implode('|', self::ARTICLE_TYPE) . ')$/i', $match[1])) {
                return $this->setSharedType($match[1]);
            }
        }

        return parent::__call($name, $arguments);
    }

    /**
     * {@inheritdoc }
     */
    public function export(): array
    {
        $this->process();
        // TMGBlade
        $material = $this->getData('material', []);
        foreach ($material as $key => $target) {
            if (is_array($target)) {
                foreach ($target as $serial => $item) {
                    if (is_array($item)) {
                        Arr::forget($target[$serial], 'url');
                    }
                }
            }
            TMGBlade::setMaterial($key, $target);
        }
        return $this->data;
    }

    /**
     * @return void
     */
    protected function process(): void
    {
        $prefix = [];
        $meta = [];

        // Global
        $meta[] = '<meta http-equiv="Content-Security-Policy" content="block-all-mixed-content">';

        // Title
        $value = trim($this->getSharedTitleBasic() . $this->getSharedTitleExtra());
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
        $value = $this->getSharedUrl();
        if (is_array($value)) {
            $meta[] = '<link rel="canonical" href="' . $value[$this->getSharedLanguage()] ?? reset($value) . '">';
            foreach ($value as $key => $item) {
                $meta[] = '<link rel="alternate" href="' . $item . '" hreflang="' . $key . '">';
            }
        } else {
            $meta[] = '<link rel="canonical" href="' . $this->getSharedUrl() . '">';
            $meta[] = '<link rel="alternate" href="' . $this->getSharedUrl() . '" hreflang="' . $this->getSharedLanguage() . '">';
        }
        $value = config('tmg-website.site.rss', []);
        $value = is_array($value) ? $value : [$this->getSharedLanguage() => $value];
        foreach ($value as $key => $item) {
            $meta[] = '<link rel="alternate" type="application/rss+xml" title="' . config('app.name') . '" href="' . $item . '" hreflang="' . $key . '">';
        }

        // Detail
        $value = $this->getSharedDescriptionBasic();
        $value = mb_strlen($value) > 150 ? mb_substr($value, 0, 150) . '...' : $value;
        $value .= $this->getSharedDescriptionExtra();
        $this->setShared('description.full', $value);
        $meta[] = '<meta name="description" content="' . $this->getShared('description.full') . '">';
        if ($value = $this->getSharedKeyword()) {
            $meta[] = '<meta name="keywords" content="' . $value . '">';
        }
        $meta[] = '<meta name="robots" content="' . $this->getSharedRobots() . '">';
        foreach ($this->getMaterialAuthors([]) as $item) {
            $item += ['name' => ''];
            if (empty($item['name'])) {
                continue;
            }
            $meta[] = '<meta name="author" content="' . $item['name'] . '">';
        }
        if (in_array($this->getSharedType(), self::ARTICLE_TYPE)) {
            if ($value = $this->getSharedKeyword()) {
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
        if (in_array($this->getSharedType(), self::ARTICLE_TYPE)) {
            $meta[] = '<meta property="og:type" content="article">';
        } else {
            $meta[] = '<meta property="og:type" content="website">';
        }
        $value = $this->getSharedUrl();
        if (is_array($value)) {
            $meta[] = '<meta property="og:url" content="' . $value[$this->getSharedLanguage()] ?? reset($value) . '">';
        } else {
            $meta[] = '<meta property="og:url" content="' . $this->getSharedUrl() . '">';
        }
        $meta[] = '<meta property="og:site_name" content="' . config('app.name') . '">';
        $meta[] = '<meta property="og:title" content="' . $this->getShared('title.full') . '">';
        $meta[] = '<meta property="og:description" content="' . $this->getShared('description.full') . '">';
        if ($value = $this->getSharedImageUrl()) {
            $meta[] = '<meta property="og:image" content="' . $value . '">';
            if ($value = $this->getSharedImageWidth()) {
                $meta[] = '<meta property="og:image:width" content="' . $value . '">';
            }
            if ($value = $this->getSharedImageHeight()) {
                $meta[] = '<meta property="og:image:height" content="' . $value . '">';
            }
        }
        if (in_array($this->getSharedType(), self::ARTICLE_TYPE)) {
            $prefix['article'] = 'http://ogp.me/ns/article#';
            if ($value = config('tmg-website.site.facebook.fanpage')) {
                $meta[] = '<meta property="article:publisher" content="' . $value . '">';
            }
            foreach ($this->getMaterialAuthors([]) as $item) {
                $item += ['name' => ''];
                if (empty($item['name'])) {
                    continue;
                }
                $meta[] = '<meta property="article:author" content="' . $item['name'] . '">';
            }
            $reset = false;
            foreach ($this->getMaterialTerms([]) as $item) {
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
            $meta[] = '<meta property="article:modified_time" content="' . date('c', $this->getSharedModified()) . '">';
            $meta[] = '<meta property="article:published_time" content="' . date(
                    'c',
                    $this->getSharedPublished()
                ) . '">';
        }
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
        if ($value = $this->getSharedImageUrl()) {
            $meta[] = '<meta name="twitter:image" content="' . $value . '">';
        }

        // Schema
        $type = $this->getSharedType();
        if (in_array($type, self::ARTICLE_TYPE)) {
            $item = [
                '@context' => 'https://schema.org',
                '@type' => $type,
                'headline' => $this->getShared('title.full'),
                'mainEntityOfPage' => $this->getSharedUrl(),
                'datePublished' => date('c', $this->getSharedPublished()),
                'dateModified' => date('c', $this->getSharedModified()),
                'author' => [],
                'keywords' => [],
                'description' => $this->getShared('description.full'),
            ];
            foreach ($this->getMaterial('authors', []) as $material) {
                $item['author'][] = array_filter([
                    '@type' => 'Person',
                    'name' => $material['name'] ?? '',
                    'url' => $material['url'] ?? '',
                ]);
            }
            foreach ($this->getMaterial('terms', []) as $material) {
                $item['keywords'][] = array_filter([
                    '@type' => 'DefinedTerm',
                    'name' => $material['name'] ?? '',
                    'url' => $material['url'] ?? '',
                ]);
            }
            if ($value = $this->getSharedImageUrl()) {
                $item['image'] = [
                    '@type' => 'ImageObject',
                    'contentUrl' => $value,
                ];
                if ($value = $this->getSharedImageWidth()) {
                    $item['image']['width'] = $value;
                }
                if ($value = $this->getSharedImageHeight()) {
                    $item['image']['height'] = $value;
                }
            }
            if ($value = $this->getSharedBody()) {
                $item['articleBody'] = $value;
            }
        } else {
            $type = in_array($type, self::PAGE_TYPE) ? $type : 'WebPage';
            $item = [
                '@context' => 'https://schema.org',
                '@type' => $type,
                'name' => $this->getShared('title.full'),
                'description' => $this->getShared('description.full'),
                'dateCreated' => date('c', $this->getSharedPublished()),
                'dateModified' => date('c', $this->getSharedModified()),
                'primaryImageOfPage' => [
                    '@type' => 'ImageObject',
                    'contentUrl' => $this->getMeta('image', ''),
                ],
            ];
            if ($value = $this->getSharedKeyword()) {
                $item['keywords'] = explode(',', $value);
            }
            if ($value = $this->getSharedImageUrl()) {
                $item['primaryImageOfPage'] = [
                    '@type' => 'ImageObject',
                    'contentUrl' => $value,
                ];
                if ($value = $this->getSharedImageWidth()) {
                    $item['primaryImageOfPage']['width'] = $value;
                }
                if ($value = $this->getSharedImageHeight()) {
                    $item['primaryImageOfPage']['height'] = $value;
                }
            }
        }
        $this->setSchema($type, $item);

        // JSON
        $meta[] = '<script type="application/json" id="config-material">' . json_encode(
                $this->getMaterial(null, []),
                JSON_UNESCAPED_UNICODE
            ) . '</script>';
        $meta[] = '<script type="application/json" id="config-shared">' . json_encode(
                $this->getShared(null, []),
                JSON_UNESCAPED_UNICODE
            ) . '</script>';
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
