<?php

namespace TNLMedia\LaravelTool\Containers;

use Carbon\Carbon;
use Illuminate\Support\Arr;

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

    public function __construct()
    {
        // TODO: TBD
    }

    /**
     * Update shared data
     *
     * @param string $key
     * @param $value
     * @return Container
     */
    public function setShared(string $key, $value): Container
    {
        Arr::set($this->data, 'shared.' . $key, $value);
        return $this;
    }

    /**
     * Update material data
     *
     * @param string $key
     * @param $value
     * @return Container
     */
    public function setMaterial(string $key, $value): Container
    {
        Arr::set($this->data, 'material.' . $key, $value);
        return $this;
    }

    /**
     * Set extra schema JSON
     *
     * @param string $key
     * @param $value
     * @return Container
     */
    public function setSchema(string $key, $value): Container
    {
        Arr::set($this->data, 'schema.' . $key, $value);
        return $this;
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

    }
}
