<?php

namespace EldoMagan\BagistoArcade\Providers;

use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Theme code
     *
     * @var string
     */
    protected $code;

    /**
     * Theme name
     *
     * @var string
     */
    protected $name;

    /**
     * Theme version
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Theme author name
     *
     * @var string
     */
    protected $author;

    /**
     * Theme preview image path. Shown on admin
     *
     * @var string
     */
    protected $previewImagePath;

    /**
     * Theme documentation url. Displayed in admin and theme editor
     *
     * @var string
     */
    protected $documentationUrl = '';

    /**
     * Theme support url. Displayed in admin and theme editor
     *
     * @var string
     */
    protected $supportUrl = '';

    protected $sections = [];

    private array $themeConfig = [];

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function settings(): array
    {
        $settingsFilePath = $this->getPackageBaseDir() . '/../config/settings.php';

        if (file_exists($settingsFilePath)) {
            return require $settingsFilePath;
        }

        return [];
    }

    protected function getThemeConfig()
    {
        if (empty($this->themeConfig)) {
            $this->themeConfig = [
                'code' => $this->code,
                'name' => $this->name,
                'version' => $this->version,
                'author' => $this->author,
                'preview_image_url' => asset($this->previewImagePath),
                'documentation_url' => $this->documentationUrl,
                'support_url' => $this->supportUrl,
                'views_path' => '',
                'arcade_theme' => true,
                'settings' => $this->settings(),
            ];
        }

        return $this->themeConfig;
    }

    public function boot()
    {
        $this->mergeConfigFromArray('themes.themes', [
            $this->code => $this->getThemeConfig(),
        ]);
    }

    protected function getPackageBaseDir()
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName());
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string  $key
     * @param  array  $config
     * @return void
     */
    protected function mergeConfigFromArray($key, array $config)
    {
        if (! ($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
            $configBag = $this->app->make('config');

            $configBag->set($key, array_merge(
                $config,
                $configBag->get($key, [])
            ));
        }
    }
}
