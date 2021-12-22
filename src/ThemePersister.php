<?php

namespace EldoMagan\BagistoArcade;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Http;
use Webkul\Theme\Themes;

class ThemePersister
{
    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    /** @var \Webkul\Theme\Themes */
    protected $themes;

    public function __construct(Filesystem $files, Themes $themes)
    {
        $this->files = $files;
        $this->themes = $themes;
    }

    protected function getEditorTemplatePath($themeCode, $template)
    {
        return sprintf(
            "%s/themes/%s/editor/templates/%s.json",
            config('arcade.data_path'),
            $themeCode,
            $template
        );
    }

    protected function getEditorContentPath($themeCode, $template)
    {
        return sprintf(
            "%s/themes/%s/editor/__dynamic/%s.json",
            config('arcade.data_path'),
            $themeCode,
            $template
        );
    }

    protected function getEditorThemeDataPath($themeCode)
    {
        return sprintf(
            "%s/themes/%s/editor/theme.json",
            config('arcade.data_path'),
            $themeCode
        );
    }

    public function persist(string $themeCode, array $themeData)
    {
        $this->persistTemplate($themeCode, $themeData);
        $this->persistThemeData($themeCode, $themeData);

        return Http::get($themeData['url']);
    }

    protected function persistThemeData($themeCode, $themeData)
    {
        $content = [
            'sections' => [],
        ];

        foreach (array_merge($themeData['beforeContentSectionsOrder'], $themeData['afterContentSectionsOrder']) as $id) {
            $content['sections'][$id] = $themeData['sections'][$id];
        }

        $path = $this->getEditorThemeDataPath($themeCode);
        $this->files->ensureDirectoryExists(dirname($path));
        $this->files->put($path, json_encode($content));
    }

    protected function persistTemplate($themeCode, $themeData)
    {
        $path = $themeData['hasStaticContent']
            ? $this->getEditorContentPath($themeCode, $themeData['template'])
            : $this->getEditorTemplatePath($themeCode, $themeData['template']);

        $content = [
            'sections' => [],
            'order' => $themeData['sectionsOrder'],
        ];

        foreach ($themeData['sectionsOrder'] as $id) {
            $content['sections'][$id] = $themeData['sections'][$id];
        }

        $this->files->ensureDirectoryExists(dirname($path));
        $this->files->put($path, json_encode($content));
    }
}
