<?php

namespace EldoMagan\BagistoArcade;

use Illuminate\Filesystem\Filesystem;
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

        return redirect($themeData['url']);
    }

    /**
     * We publish a versioned copy of the theme customization.
     * We should implement later a possibility to rollback the changes.
     *
     * @param string $themeCode
     * @return void
     */
    public function publish(string $themeCode)
    {
        $editorThemePath = sprintf(
            "%s/themes/%s/editor",
            config('arcade.data_path'),
            $themeCode
        );

        $newVersionPath = sprintf(
            "%s/themes/%s/%s",
            config('arcade.data_path'),
            $themeCode,
            'V' . time()
        );

        $livePath = sprintf(
            "%s/themes/%s/%s",
            config('arcade.data_path'),
            $themeCode,
            'live'
        );

        $files = $this->files->allFiles($editorThemePath);

        foreach ($files as $file) {
            $newVersionFilePath = $newVersionPath . '/' . $file->getRelativePathname();
            $this->files->ensureDirectoryExists($this->files->dirname($newVersionFilePath));
            $this->files->put($newVersionFilePath, $this->files->get($file->getPathname()));
        }

        if ($this->files->exists($livePath)) {
            $this->files->delete($livePath);
        }

        $this->files->link($newVersionPath, $livePath);
    }

    protected function persistThemeData($themeCode, $themeData)
    {
        $content = [
            'sections' => [],
            'settings' => $themeData['settings'],
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
