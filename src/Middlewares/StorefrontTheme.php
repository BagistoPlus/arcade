<?php

namespace EldoMagan\BagistoArcade\Middlewares;

use Closure;
use Webkul\Shop\Http\Middleware\Theme;

class StorefrontTheme extends Theme
{
    public function handle($request, Closure $next)
    {
        if ($request->inDesignMode() || $request->inPreviewMode()) {
            themes()->set(arcadeEditor()->editorTheme());

            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
