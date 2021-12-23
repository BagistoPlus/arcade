<?php

namespace EldoMagan\BagistoArcade\Theme;

use Webkul\Theme\Theme as BagistoTheme;

/**
 * @property-read string $code
 * @property-read string $name
 * @property-read string $viewsPath
 * @property-read string $assetsPath
 * @property-read Theme parent
 * @property-read bool isArcadeTheme
 */
class Theme extends BagistoTheme
{
    protected $attributes;

    public function __construct(array $attributes)
    {
        parent::__construct(
            $attributes['code'],
            $attributes['name'],
            $attributes['assets_path'],
            $attributes['views_path']
        );

        $this->attributes = $attributes;
        $this->attributes['isArcadeTheme'] = $attributes['arcade_theme'] ?? false;
    }

    public function __get($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
    }

    /**
     * Return all the possible view paths
     *
     * @return array
     */
    public function getViewPaths()
    {
        $paths = [];

        if (arcadeEditor()->active()) {
            $paths[] = substr(storage_path('bagisto-arcade/themes/' . $this->code . '/editor'), strlen(base_path('')) + 1);
        }

        $paths[] = substr(storage_path('bagisto-arcade/themes/' . $this->code . '/live'), strlen(base_path('')) + 1);

        $theme = $this;

        do {
            if (substr($theme->viewsPath, 0, 1) === DIRECTORY_SEPARATOR) {
                $path = base_path(substr($theme->viewsPath, 1));
            } else {
                $path = $theme->viewsPath;
            }

            if (! in_array($path, $paths)) {
                $paths[] = $path;
            }
        } while ($theme = $theme->parent);

        return $paths;
    }
}
