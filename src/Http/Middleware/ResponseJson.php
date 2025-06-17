<?php

namespace TNLMedia\LaravelTool\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResponseJson
{
    /**
     * Force response to be JSON format.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accept = $request->headers->get('Accept');
        if (!preg_match('/application\/json/i', $accept)) {
            $request->headers->set('Accept', 'application/json');
        }
        return $next($request);
    }
}
