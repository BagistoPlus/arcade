<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\ArcadeManager;
use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Sections\AnnoucementBar;
use EldoMagan\BagistoArcade\Sections\SectionDataCollector;
use EldoMagan\BagistoArcade\Sections\SectionRepository;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    protected $sections = [
        AnnoucementBar::class,
    ];

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/shop.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'arcade');

        Arcade::registerSections($this->sections, 'arcade');

        if ($this->app->runningInConsole()) {
            $this->publishViews();
        }
    }

    public function register()
    {
        $this->registerConfigs();

        $this->app->singleton(SectionRepository::class, function ($app) {
            return new SectionRepository();
        });

        $this->app->singleton(SectionDataCollector::class, function ($app) {
            return new SectionDataCollector($app['files']);
        });

        $this->app->singleton(ArcadeManager::class, function ($app) {
            return new ArcadeManager($app[SectionDataCollector::class]);
        });
    }

    protected function publishViews()
    {
        $this->publishes([
            __DIR__ . '/../../resources/views/theme' => resource_path('themes/arcade/views'),
        ], 'arcade-views');
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/arcade.php', 'arcade');
        $this->mergeConfigFrom(__DIR__ . '/../../config/theme.php', 'themes.themes');
    }
}
