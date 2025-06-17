<?php

namespace TNLMedia\LaravelTool\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RefererLock
{
    /**
     * Check referer equal to host.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (parse_url(strval($request->headers->get('Referer')), PHP_URL_HOST) != $request->getHost()) {
            abort(403);
        }
        return $next($request);
    }
}
