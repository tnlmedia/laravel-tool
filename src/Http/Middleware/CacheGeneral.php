<?php

namespace TNLMedia\LaravelTool\Http\Middleware;

use Closure;
use Illuminate\Http\Middleware\SetCacheHeaders;

class CacheGeneral extends SetCacheHeaders
{
    /**
     * {@inheritdoc }
     */
    public function handle($request, Closure $next, $options = [])
    {
        return parent::handle($request, $next, 'public;max_age=300;etag;must_revalidate');
    }
}
