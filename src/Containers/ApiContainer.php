<?php

namespace TNLMedia\LaravelTool\Containers;

use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @method ApiContainer setCode(string $key = null, int $value = 0)
 * @method ApiContainer setMessage(string $key = null, string $value = '')
 * @method ApiContainer setHint(string $key = null, string $value = '')
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
                $message = $message ?? $content['message'] ?? null;
                $hint = $content['hint'] ?? $hint;
            } catch (Throwable $e) {
            }
        }

        // Message
        $message = $message ?? $throwable->getMessage();

        // Hint
        if (method_exists($throwable, 'getHint')) {
            $hint = $throwable->getHint();
        }

        $this->setCode(null, intval($throwable->getCode()));
        $this->setMessage(null, strval($message));
        $this->setHint(null, strval($hint));
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
            ->json($export(), $code)
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);
    }
}
