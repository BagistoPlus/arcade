<?php

namespace EldoMagan\BagistoArcade\Theme;

use Illuminate\Support\Str;
use Webkul\Theme\Themes;

class ThemeManager extends Themes
{
    /**
     * Contains all themes
     *
     * @var Theme[]
     */
    protected $themes = [];

    /**
     * Contains current activated theme
     *
     * @var Theme
     */
    protected $activeTheme = null;

    /**
     * Prepare all themes.
     *
     * @return Theme[]
     */
    public function loadThemes()
    {
        $parentThemes = [];

        if (request()->route() !== null && Str::contains(request()->route()->uri, config('app.admin_url') . '/')) {
            $themes = config('themes.admin-themes', []);
        } else {
            $themes = config('themes.themes', []);
        }

        foreach ($themes as $code => $data) {
            $this->themes[] = $this->createTheme(array_merge($data, ['code' => $code]));

            if (isset($data['parent']) && $data['parent']) {
                $parentThemes[$code] = $data['parent'];
            }
        }

        foreach ($parentThemes as $childCode => $parentCode) {
            $child = $this->find($childCode);

            if ($this->exists($parentCode)) {
                $parent = $this->find($parentCode);
            } else {
                $parent = $this->createTheme(['code' => $parentCode]);
            }

            $child->setParent($parent);
        }

        return $this->themes;
    }

    public function createTheme($attributes)
    {
        return new Theme($attributes);
    }

    /**
     * Enable theme
     *
     * @param  string  $themeName
     * @return \Webkul\Theme\Theme
     */
    public function set($themeName)
    {
        $result = parent::set($themeName);

        if ($this->activeTheme instanceof Theme && $this->activeTheme->isArcadeTheme) {
            app('view')->prependNamespace('shop', __DIR__ . '/../../resources/views/theme');
            app('view')->prependNamespace('core', __DIR__ . '/../../resources/views/webkul/core');
            app('view')->prependNamespace('paypal', __DIR__ . '/../../resources/views/webkul/paypal');
        }

        return $result;
    }
}
