<?php

namespace EldoMagan\BagistoArcade\Http\Controllers\Admin;

use EldoMagan\BagistoArcade\Http\Controllers\Controller;
use EldoMagan\BagistoArcade\ThemePersister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'imagesBaseUrl' => Storage::disk(config('arcade.images_storage'))->url(''),
        ]);
    }

    public function persistTheme(Request $request, $theme)
    {
        return $this->themePersister->persist($theme, $request->toArray());
    }

    public function publishTheme(Request $request, $theme)
    {
        return $this->themePersister->publish($theme);
    }

    public function listImages()
    {
        $diskName = config('arcade.images_storage');
        $images = Storage::disk($diskName)
            ->files(config('arcade.images_directory'));

        return collect($images)->map(function ($image) use ($diskName) {
            return [
                'path' => $image,
                'url' => Storage::disk($diskName)->url($image),
            ];
        });
    }

    public function importImage(Request $request)
    {
        $path = $request->file('image')->store(
            config('arcade.images_directory'),
            config('arcade.images_storage'),
        );

        return [
            'path' => $path,
            'url' => Storage::disk(config('arcade.images_storage'))->url($path),
        ];
    }
}
