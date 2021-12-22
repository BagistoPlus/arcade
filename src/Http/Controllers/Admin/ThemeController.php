<?php

namespace EldoMagan\BagistoArcade\Http\Controllers\Admin;

use EldoMagan\BagistoArcade\Http\Controllers\Controller;
use EldoMagan\BagistoArcade\ThemePersister;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    protected $themePersister;

    public function __construct(ThemePersister $themePersister)
    {
        $this->themePersister = $themePersister;
    }

    public function index()
    {
        $themes = collect(config('themes.themes'))->filter(function ($theme) {
            return $theme['arcade_theme'] ?? false === true;
        });

        return view('arcade::admin.themes.index', ['themes' => $themes]);
    }

    public function editor($code)
    {
        $theme = config('themes.themes')[$code];
        $theme['code'] = $code;

        return view('arcade::admin.themes.editor', [
            'theme' => $theme,
            'storefrontUrl' => url('/') . http_build_query(['designMode' => $code]),
        ]);
    }

    public function persistTheme(Request $request, $theme)
    {
        return $this->themePersister->persist($theme, $request->toArray());
    }
}
