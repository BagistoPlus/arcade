<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\ArcadeManager;
use EldoMagan\BagistoArcade\Components\AccountMenu;
use EldoMagan\BagistoArcade\Components\CurrencySwitcher;
use EldoMagan\BagistoArcade\Components\MiniCart;
use EldoMagan\BagistoArcade\Facades\Arcade;
use EldoMagan\BagistoArcade\Sections\AnnouncementBar;
use EldoMagan\BagistoArcade\Sections\Header;
use EldoMagan\BagistoArcade\Sections\SectionDataCollector;
use EldoMagan\BagistoArcade\Sections\SectionRepository;
use EldoMagan\BagistoArcade\Sections\Slideshow;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class CoreServiceProvider extends ServiceProvider
{
    protected static $bladeComponents = [
        'account-menu' => AccountMenu::class,
        'currency-switcher' => CurrencySwitcher::class,
    ];

    protected static $livewireComponents = [
        'mini-cart' => MiniCart::class,
    ];

    protected $sections = [
        Header::class,
        AnnouncementBar::class,
        Slideshow::class,
    ];

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/shop.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'arcade');

        $this->registerBladeComponents();
        $this->registerLivewireComponents();
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

    protected function registerBladeComponents()
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            foreach (self::$bladeComponents as $name => $component) {
                $blade->component($component, $name);
            }
        });
    }

    protected function registerLivewireComponents()
    {
        foreach (self::$livewireComponents as $name => $component) {
            Livewire::component($name, $component);
        }
    }
}
