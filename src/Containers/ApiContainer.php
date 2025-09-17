<?php

namespace TNLMedia\LaravelTool\Containers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Throwable;

/**
 * @method ApiContainer setResult(?string $key = null, mixed $value = null)
 * @method ApiContainer pushResult(?string $key = null, mixed $value = null)
 * @method mixed getResult(?string $key = null, mixed $default = null)
 * @method bool checkResult(?string $key = null)
 * @method ApiContainer setCode(int $value = 0)
 * @method ApiContainer setMessage(string $value = '')
 * @method ApiContainer setHint(string $value = '')
 */
class ApiContainer extends Container
{
    /**
     * {@inheritdoc }
     */
    protected array $data = [
        'code' => 20000,
        'data' => [],
        'message' => '',
        'hint' => '',
    ];

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call(string $name, array $arguments): mixed
    {
        // Quick function for data as result
        if (preg_match('/^(set|push|get|check)Result$/i', $name, $match)) {
            $action = strtolower($match[1]);
            $key = 'data';
            $value = null;
            if (count($arguments) > 1) {
                $key .= '.' . strval($arguments[0] ?? '');
                $value = $arguments[1] ?? null;
            } else {
                if ($action == 'check') {
                    $key .= '.' . strval($arguments[0] ?? '');
                } else {
                    $value = $arguments[0] ?? null;
                    if (is_string($value)) {
                        if (Arr::has($this->data, strtolower($key . '.' . $value))) {
                            $key .= '.' . strtolower($value);
                            $value = null;
                        }
                    }
                }
            }
            $key = strtolower(trim($key, '.'));

            if ($action == 'set') {
                return $this->setData($key, $value);
            } elseif ($action == 'push') {
                return $this->pushData($key, $value);
            } elseif ($action == 'get') {
                return $this->getData($key, $value);
            } elseif ($action == 'check') {
                return $this->checkData($key);
            }
        }

        return parent::__call($name, $arguments);
    }

    /**
     * Set data from exception
     *
     * @param Throwable $throwable
     * @param string $message
     * @param string $hint
     * @return $this
     */
    public function throwError(Throwable $throwable, string $message = '', string $hint = ''): ApiContainer
    {
        // Try render
        if (method_exists($throwable, 'render')) {
            try {
                $content = json_decode($throwable->render(request())->getContent(), true);
                $message = $message ?: ($content['message'] ?? '');
                $hint = $hint ?: ($content['hint'] ?? '');
            } catch (Throwable $e) {
            }
        }

        // Message
        $message = $message ?: $throwable->getMessage();

        // Hint
        if (method_exists($throwable, 'getHint')) {
            $hint = $hint ?: $throwable->getHint();
        }

        $this->setCode(intval($throwable->getCode()));
        $this->setMessage(strval($message));
        $this->setHint(strval($hint));
        return $this;
    }

    /**
     * Build response instance
     *
     * @return JsonResponse
     */
    public function response(): JsonResponse
    {
        $export = $this->export();
        $code = intval(substr($export['code'], 0, 3));
        $code = $code < 100 || $code > 999 ? 500 : $code;
        return response()
            ->json($export, $code)
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
    }
}
