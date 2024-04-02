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

    public function setTargeting(string $key, array $list = []): self
    {
        $this->targeting[$key] = $list;
        return $this;
    }

    /**
     * Render ad slot HTML
     *
     * @param string $slot
     * @param array $config
     * @return string
     */
    public function renderSlot(string $slot, array $config = []): string
    {
        if (empty($slot)) {
            return '';
        }

        // Merge
        $default = config('tmg-advertising.slot.' . $slot, []);
        foreach ($default as $key => $value) {
            if (!isset($config[$key])) {
                $config[$key] = $value;
                continue;
            }

            if ($key == 'targeting') {
                $config[$key] = array_merge($value, $this->targeting, $config[$key]);
            }
        }

        // Preprocess
        $config['slot'] = $slot;
        $config += [
            'size' => [],
            'mapping' => [],
        ];
        if (empty($config['size']) && !empty($config['mapping'])) {
            $config['size'] = current(end($config['mapping']))[1] ?? [];
        }
        if (empty($config['size'])) {
            return '';
        }
        if (empty($config['mapping'])) {
            $config['mapping'] = [[0, 0], $config['size']];
        }

        return view('TMG::advertising.slot', ['config' => $config])->toHtml();
    }
}
