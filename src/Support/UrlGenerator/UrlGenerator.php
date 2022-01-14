<?php

namespace EldoMagan\BagistoArcade\Support\UrlGenerator;

use Illuminate\Routing\Route;
use Illuminate\Routing\UrlGenerator as RoutingUrlGenerator;

class UrlGenerator extends RoutingUrlGenerator
{
    /**
     * Get the current URL for the request.
     *
     * @return string
     */
    public function current()
    {
        $url = parent::current();

        if (arcadeEditor()->inDesignMode() || arcadeEditor()->inPreviewMode()) {
            $url = explode('?', $url)[0];
        }

        return $url;
    }

    /**
     * Get the Route URL generator instance.
     *
     * @return \Illuminate\Routing\RouteUrlGenerator
     */
    protected function routeUrl()
    {
        if (! $this->routeGenerator) {
            $this->routeGenerator = new RouteUrlGenerator($this, $this->request);
        }

        return $this->routeGenerator;
    }

    /**
     * Extract the query string from the given path.
     *
     * @param  string  $path
     * @return array
     */
    protected function extractQueryString($path)
    {
        $query = '';

        if (arcadeEditor()->inDesignMode()) {
            $query = 'designMode=' . arcadeEditor()->editorTheme();
        } elseif (arcadeEditor()->inPreviewMode()) {
            $query = 'previewMode=' . arcadeEditor()->editorTheme();
        }

        if (($queryPosition = strpos($path, '?')) !== false) {
            return [
                substr($path, 0, $queryPosition),
                substr($path, $queryPosition) . '&' . $query,
            ];
        }

        return [$path, $query ? '?' . $query : ''];
    }
}
