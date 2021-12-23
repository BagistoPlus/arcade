<?php

namespace EldoMagan\BagistoArcade\Theme;

use Illuminate\Support\Str;
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
            $attributes['name'] ?? $attributes['code'],
            $attributes['assets_path'] ?? $attributes['code'],
            $attributes['views_path'] ?? $attributes['code']
        );

        $this->attributes = $attributes;
        $this->attributes['isArcadeTheme'] = $attributes['arcade_theme'] ?? false;
    }

    public function __get($attr)
    {
        $snakeCasedAttr = Str::snake($attr);

        if (isset($this->attributes[$attr])) {
            return $this->attributes[$attr];
        } else if (isset($this->attributes[$snakeCasedAttr])) {
            return $this->attributes[$snakeCasedAttr];
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
            $paths[] = substr(config('arcade.data_path') . '/themes/' . $this->code . '/editor', strlen(base_path('')) + 1);
        }

        $paths[] = substr(config('arcade.data_path') . '/themes/' . $this->code . '/live', strlen(base_path('')) + 1);

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
