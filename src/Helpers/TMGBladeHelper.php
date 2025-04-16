<?php

namespace TNLMedia\LaravelTool\Helpers;

class TMGBladeHelper
{
    /**
     * Advertising targeting
     *
     * @var array
     */
    private array $targeting = [];

    /**
     * Render header HTML
     *
     * @return string
     */
    public function renderHeader(): string
    {
        $header = '';

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
     * Set advertising targeting
     *
     * @param string $key
     * @param array $list
     * @return $this
     */
    public function setTargeting(string $key, array $list = []): self
    {
        foreach ($list as $serial => $item) {
            $list[$serial] = strval($item);
        }
        $this->targeting[$key] = $list;
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

        return view('TMG::advertising.slot', ['config' => $config])->toHtml();
    }
}
