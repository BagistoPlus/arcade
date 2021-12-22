<?php

namespace EldoMagan\BagistoArcade\Support\UrlGenerator;

use Illuminate\Routing\RouteUrlGenerator as RoutingRouteUrlGenerator;

class RouteUrlGenerator extends RoutingRouteUrlGenerator
{
    /**
     * Get the query string for a given route.
     *
     * @param  array  $parameters
     * @return string
     */
    protected function getRouteQueryString(array $parameters)
    {
        if (arcadeEditor()->inDesignMode()) {
            $parameters['designMode'] = arcadeEditor()->editorTheme();
        } elseif (arcadeEditor()->inPreviewMode()) {
            $parameters['previewMode'] = arcadeEditor()->editorTheme();
        }

        return parent::getRouteQueryString($parameters);
    }
}
