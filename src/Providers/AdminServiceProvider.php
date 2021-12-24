<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\Middlewares\AllowSameOriginIframe;
use EldoMagan\BagistoArcade\Middlewares\InjectThemeEditorScript;
use EldoMagan\BagistoArcade\Middlewares\StorefrontTheme;
use EldoMagan\BagistoArcade\Support\UrlGenerator\UrlGenerator;
use EldoMagan\BagistoArcade\ThemeEditor;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'arcade');

        $this->bootMiddlewares();
        $this->bootRequestMacros();
        $this->bootViewEventListeners();

        if ($this->app->runningInConsole()) {
            $this->publishAssets();
        }
    }

    public function register()
    {
        $this->registerConfigs();

        $this->app->singleton(ThemeEditor::class, function ($app) {
            return new ThemeEditor();
        });

        $this->registerCustomUrlGenerator();
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/admin-menu.php', 'menu.admin');
    }

    protected function registerCustomUrlGenerator()
    {
        $this->app->bind('url', function ($app) {
            $routes = $app['router']->getRoutes();

            return new UrlGenerator(
                $routes,
                $app->rebinding('request', function ($app, $request) {
                    $app['url']->setRequest($request);
                }),
                $app['config']['app.asset_url']
            );
        });
    }

    protected function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../../dist/admin' => public_path('vendor/arcade/admin'),
            __DIR__ . '/../../dist/theme-editor' => public_path('vendor/arcade/theme-editor'),
        ], 'public');
    }

    protected function bootRequestMacros()
    {
        Request::macro('inDesignMode', function() { return ThemeEditor::inDesignMode(); });
        Request::macro('inPreviewMode', function() { return ThemeEditor::inPreviewMode(); });
    }

    protected function bootMiddlewares()
    {
        $kernel = $this->app[Kernel::class];

        $kernel->pushMiddleware(InjectThemeEditorScript::class);
        $kernel->prependMiddleware(AllowSameOriginIframe::class);

        $this->app->booted(function () {
            $router = $this->app[Router::class];
            $router->aliasMiddleware('theme', StorefrontTheme::class);
        });
    }

    protected function bootViewEventListeners()
    {
        Event::listen('bagisto.admin.layout.head', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('arcade::admin.layouts.style');
        });
    }
}
