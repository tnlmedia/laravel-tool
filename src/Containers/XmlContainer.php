<?php

namespace TNLMedia\LaravelTool\Containers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;

class XmlContainer extends Container
{
    /**
     * {@inheritdoc }
     */
    protected array $data = [
        // Rendered XML content
        'content' => '',
    ];

    /**
     * Build XML
     *
     * @return Response
     * @throws BindingResolutionException
     */
    public function response(): Response
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= PHP_EOL . $this->data['content'];
        return response()->make($content, Response::HTTP_OK, [
            'Content-Type' => 'text/xml; charset=utf-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
