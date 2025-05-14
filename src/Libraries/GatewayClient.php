<?php

namespace TNLMedia\LaravelTool\Libraries;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Throwable;

class GatewayClient
{
    /**
     * @var string|null
     */
    protected ?string $token;

    /**
     * API request
     *
     * @param string $path
     * @param array $parameters
     * @param string $method
     * @return array
     * @throws Throwable
     */
    public function api(string $path, array $parameters = [], string $method = 'GET'): array
    {
        for ($i = 0; $i < 2; $i++) {
            try {
                $response = $this->request($this->requestUrl($path), $method, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken(boolval($i)),
                    ],
                    'json' => (strtolower($method) != 'get') ? $parameters : null,
                    'query' => (strtolower($method) == 'get') ? $parameters : null,
                ]);
                $response = json_decode($response, true);
            } catch (Throwable $e) {
                if ($e->getCode() >= 400 && $e->getCode() < 500 && $i == 0) {
                    continue;
                }
                throw $e;
            }

            // Response
            $response += ['code' => 0, 'data' => [], 'message' => '', 'hint' => ''];
            if ($response['code'] != 20000) {
                throw new Exception(
                    'GatewayClient api: (' . $response['hint'] . ') ' . $response['message'],
                    $response['code']
                );
            }
            return $response['data'] ?: [];
        }
        return [];
    }

    /**
     * Multipart request
     *
     * @param string $path
     * @param array $form_data
     * @param string $method
     * @return array
     * @throws Throwable
     */
    public function upload(string $path, array $form_data = [], string $method = 'POST'): array
    {
        for ($i = 0; $i < 2; $i++) {
            try {
                $response = $this->request($this->requestUrl($path), $method, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken(boolval($i)),
                    ],
                    'multipart' => $form_data,
                ]);
                $response = json_decode($response, true);
            } catch (Throwable $e) {
                if ($e->getCode() >= 400 && $e->getCode() < 500 && $i == 0) {
                    continue;
                }
                throw $e;
            }

            // Response
            $response += ['code' => 0, 'data' => [], 'message' => '', 'hint' => ''];
            if ($response['code'] != 20000) {
                throw new Exception(
                    'GatewayClient upload: (' . $response['hint'] . ') ' . $response['message'],
                    $response['code']
                );
            }
            return $response['data'] ?: [];
        }
        return [];
    }

    /**
     * Oauth request
     *
     * @param array $parameters
     * @return array
     * @throws Throwable
     */
    public function oauth(array $parameters = []): array
    {
        // Token
        $response = $this->request($this->requestUrl('token'), 'POST', [
            'json' => $parameters,
        ]);
        $response = json_decode($response, true);

        // Response
        $response += [
            'token_type' => 0,
            'access_token' => [],
            'expires_in' => '',
            'code' => 0,
            'message' => '',
            'hint' => '',
        ];
        if (empty($response['access_token'])) {
            throw new Exception(
                'GatewayClient oauth: (' . $response['hint'] . ') ' . $response['message'],
                $response['code']
            );
        }
        $this->setAccessToken(strval($response['access_token']));

        // Current member
        return $this->api('members/current');
    }

    /**
     * Set access token
     *
     * @param string $token
     * @return $this
     */
    public function setAccessToken(string $token): GatewayClient
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Access token
     *
     * @param bool $reset
     * @return string
     * @throws Exception
     */
    protected function accessToken(bool $reset = false): string
    {
        // From variable
        if (!empty($this->token) && !$reset) {
            return $this->token;
        }

        // From cache
        $this->token = strval(Cache::get('GatewayClient.token'));
        if (!empty($this->token) && !$reset) {
            return $this->token;
        }

        // Request
        $response = json_decode($this->request($this->requestUrl('token'), 'POST', [
            'json' => [
                'grant_type' => 'client_credentials',
                'client_id' => strval(config('inkmagine.gateway.client')),
                'client_secret' => strval(config('inkmagine.gateway.secret')),
            ],
        ]), true);

        // Parser & cache
        $this->token = strval($response['access_token'] ?? '');
        Cache::set('GatewayClient.token', $this->token, intval($response['expires_in'] ?? 0) - 300);

        return $this->token;
    }

    /**
     * Make a request
     *
     * @param string $url
     * @param string $method
     * @param array $config
     * @return string
     * @throws Exception
     */
    protected function request(string $url, string $method = 'GET', array $config = []): string
    {
        // Request
        $config['headers'] = $config['headers'] ?? [];
        $config['headers'] += [
            'User-Agent' => 'GatewayClient/1.0 (+' . config('app.url') . ')',
            'Accept' => 'application/json',
        ];
        $config['timeout'] = $config['timeout'] ?? 300;
        $config['http_errors'] = false;
        $config['verify'] = false;
        try {
            $response = (new Client())->request($method, $url, $config);
        } catch (Throwable $e) {
            throw new Exception('GatewayClient[' . $url . '] request: ' . $e->getMessage(), $e->getCode());
        }

        // Get response
        if ($response->getStatusCode() >= 400) {
            throw new Exception(
                'GatewayClient[' . $url . '] request: ' . $response->getBody()->getContents(),
                $response->getStatusCode()
            );
        }

        return $response->getBody()->getContents();
    }

    /**
     * Build request url
     *
     * @param string $path
     * @return string
     */
    protected function requestUrl(string $path): string
    {
        if (App::environment('production')) {
            $url = 'https://gateway.inkmaginecms.com/api/v1/';
        } else {
            $url = 'https://sandbox-gateway.inkmaginecms.com/api/v1/';
        }
        $path = trim($path, '/');
        return $url . $path;
    }
}
