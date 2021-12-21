<?php

namespace EldoMagan\BagistoArcade\Middlewares;

use Closure;

class AllowSameOriginIframe
{
    public function handle($request, Closure $next)
    {
        // Should on execute on designMode/previewMode
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        return $response;
    }
}
