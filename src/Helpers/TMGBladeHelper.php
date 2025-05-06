<?php

namespace TNLMedia\LaravelTool\Helpers;

use Illuminate\Support\Arr;
use TNLMedia\LaravelTool\Containers\WebContainer;

class TMGBladeHelper
{
    /**
     * Page material
     *
     * @see WebContainer
     * @var array
     */
    protected array $material = [
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
        // [['type' => 'category', 'key' => 'slug', 'name' => 'name']]
        'terms' => [],
        // [['key' => 'slug', 'name' => 'name']]
        'authors' => [],
    ];

    /**
     * Cache targeting from material
     *
     * @var array
     */
    protected array $material_targeting = [];

    /**
     * Advertising targeting
     *
     * @var array
     */
    protected array $targeting = [];

    /**
     * Render header HTML
     *
     * @return string
     */
    public function renderHeader(): string
    {
        $header = '';

        // Analytics
        $payload = [
            'config' => config('tmg-analytics.ga4', []),
            'material' => $this->material,
        ];
        $header .= view('TMG::analytics.ga4', $payload)->toHtml();
        $payload = [
            'config' => config('tmg-analytics.gtm', []),
            'material' => $this->material,
        ];
        $header .= view('TMG::analytics.gtm', $payload)->toHtml();
        $payload = [
            'config' => config('tmg-analytics.comscore', []),
            'material' => $this->material,
        ];
        $header .= view('TMG::analytics.comscore', $payload)->toHtml();
        $payload = [
            'config' => config('tmg-analytics.facebook', []),
            'material' => $this->material,
        ];
        $header .= view('TMG::analytics.facebook', $payload)->toHtml();
        $payload = [
            'config' => config('tmg-analytics.chartbeat', []),
            'host' => parse_url(config('app.url'), PHP_URL_HOST),
            'material' => $this->material,
        ];
        $header .= view('TMG::analytics.chartbeat', $payload)->toHtml();
        $payload = [
            'config' => config('tmg-analytics.track', []),
            'material' => $this->material,
        ];
        $header .= view('TMG::analytics.track', $payload)->toHtml();

        // Advertising
        $payload = [
            'gam_status' => boolval(config('tmg-advertising.gam.status', false)),
            'gam_event' => config('tmg-advertising.gam.event', []),
            'flux_status' => boolval(config('tmg-advertising.flux.status', false)),
            'flux_core' => config('tmg-advertising.flux.core', ''),
            'flux_timeout' => intval(config('tmg-advertising.flux.timeout', 3000)),
        ];
        $payload['flux_status'] = $payload['flux_status'] && !empty($payload['flux_core']);
        $payload['gam_status'] = $payload['gam_status'] || $payload['flux_status'];
        $header .= view('TMG::advertising.header', $payload)->toHtml();

        return $header;
    }

    /**
     * Set page material
     *
     * @param string $key
     * @param $value
     * @return $this
     */
    public function setMaterial(string $key, $value): self
    {
        Arr::set($this->material, $key, $value);
        return $this;
    }

    /**
     * Set advertising targeting
     *
     * @param string $key
     * @param array $list
     * @return $this
     */
    public function setTargeting(string $key, array $list = []): self
    {
        $this->targeting[$key] = array_map('strval', $list);
        return $this;
    }

    /**
     * Render ad slot HTML
     *
     * @param string $name
     * @param array $config
     * @return string
     */
    public function renderSlot(string $name, array $config = []): string
    {
        if (empty($name)) {
            return '<!-- Invalid slot name -->';
        }

        // Merge targeting
        $config['targeting'] = $config['targeting'] ?? [];
        foreach ($config['targeting'] as $key => $list) {
            array_map('strval', $config['targeting'][$key]);
        }
        $config['targeting'] = array_merge($this->targeting, $config['targeting']);
        $config['targeting'] = array_merge($this->materialToTargeting(), $config['targeting']);

        // Merge default
        $default = config('tmg-advertising.slot.' . $name, []);
        if (empty($default)) {
            return '<!-- Invalid slot name -->';
        }
        foreach ($default as $key => $value) {
            if (!isset($config[$key])) {
                $config[$key] = $value;
                continue;
            }

            if (in_array($key, ['targeting'])) {
                foreach ($value as $serial => $list) {
                    array_map('strval', $value[$serial]);
                }
                $config[$key] = array_merge($value, $config[$key]);
            } elseif (in_array($key, ['class'])) {
                array_map('strval', $value);
                $config[$key] = array_merge($value, $config[$key]);
            }
        }

        // Preprocess
        $config['name'] = $name;
        $config += [
            'size' => [],
            'mapping' => [],
        ];
        if (empty($config['slot'])) {
            return '<!-- Invalid slot id -->';
        }
        if (empty($config['size']) && !empty($config['mapping'])) {
            $config['size'] = current(end($config['mapping']))[1] ?? [];
        }
        if (empty($config['size'])) {
            return '<!-- Invalid slot size -->';
        }
        if (empty($config['mapping'])) {
            $config['mapping'] = [[0, 0], $config['size']];
        }
        $config['targeting'] = array_filter($config['targeting']);

        return view('TMG::advertising.slot', ['config' => $config])->toHtml();
    }

    /**
     * Covert material to targeting
     *
     * @return array
     */
    protected function materialToTargeting(): array
    {
        if (!empty($this->material_targeting)) {
            return $this->material_targeting;
        }

        $targeting = [];
        foreach ($this->material as $key1 => $item1) {
            // key1 => item1
            if (!is_array($item1)) {
                if ($item1 == '') {
                    continue;
                }
                $key = strval($key1);
                $item = [strval($item1)];
                $targeting[$key] = $item;
                continue;
            }
            // key1 => []
            $key2 = array_keys($item1)[0] ?? '';
            $item2 = reset($item1);
            // key1 => [key2 => item2, key2 => item2]
            if (!is_numeric($key2)) {
                foreach ($item1 as $key2 => $item2) {
                    if ($item2 == '') {
                        continue;
                    }
                    $key = $key1 . '_' . $key2;
                    $item = is_array($item2) ? array_map('strval', $item2) : [strval($item2)];
                    $targeting[$key] = $item;
                }
                continue;
            }
            // key1 => [item2, item2]
            if (!is_array($item2)) {
                if (empty($item2)) {
                    continue;
                }
                $key = strval($key1);
                $item = array_map('strval', $item1);
                $targeting[$key] = $item;
                continue;
            }
            // key1 => [[type => type, key3 => item3], [type => type, key3 => item3]]
            if (Arr::has($item2, 'type')) {
                $list = [];
                foreach ($item1 as $item2) {
                    foreach ($item2 as $key3 => $item3) {
                        if ($key3 == 'type') {
                            continue;
                        }
                        $key = ($item2['type'] ?? '') . '_' . $key3;
                        $list[$key] = $list[$key] ?? [];
                        $list[$key][] = strval($item3);
                    }
                }
                foreach ($list as $key => $item) {
                    if (empty($item)) {
                        continue;
                    }
                    $targeting[$key] = $item;
                }
                continue;
            }
            // key1 => [[key3 => item3], [key3 => item3]]
            foreach (array_keys($item2) as $key3) {
                $key = $key1 . '_' . $key3;
                $item = array_map('strval', array_column($item1, $key3));
                if (empty($item)) {
                    continue;
                }
                $targeting[$key] = $item;
            }
        }
        $this->material_targeting = $targeting;
        return $this->material_targeting;
    }
}
