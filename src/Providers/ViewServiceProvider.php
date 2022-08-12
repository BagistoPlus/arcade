<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\LivewireFeatures;
use EldoMagan\BagistoArcade\Theme\ThemeManager;
use EldoMagan\BagistoArcade\View\ArcadeTagsCompiler;
use EldoMagan\BagistoArcade\View\BladeDirectives;
use EldoMagan\BagistoArcade\View\JsonViewCompiler;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Livewire\Livewire;
use Webkul\Shop\Http\Middleware\Currency;
use Webkul\Shop\Http\Middleware\Locale;
use Webkul\Shop\Http\Middleware\Theme;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerJsonViewCompiler();
        $this->registerEngineResolver();
    }

    public function boot()
    {
        $this->registerViewExtensions();
        $this->registerArcadeTagsCompiler();
        $this->registerBladeDirectives();
        $this->registerLivewireSectionFeatures();
        $this->registerMiddlewaresForLivewire();

        $this->app->singleton('themes', function () {
            return new ThemeManager();
        });
    }

    /**
     * Register the Blade compiler implementation.
     *
     * @return void
     */
    public function registerJsonViewCompiler()
    {
        $this->app->singleton('jsonview.compiler', function ($app) {
            return new JsonViewCompiler(
                $app['files'],
                $app['config']['view.compiled'],
                $app['blade.compiler']
            );
        });
    }

    protected function registerEngineResolver()
    {
        $this->app->extend('view.engine.resolver', function ($resolver) {
            $resolver->register('jsonview', function () {
                return new CompilerEngine($this->app['jsonview.compiler'], $this->app['files']);
            });

            return $resolver;
        });
    }

    protected function registerViewExtensions()
    {
        foreach (JsonViewCompiler::EXTENSIONS as $extension) {
            $this->app['view']->addExtension($extension, 'jsonview');
        }
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('arcade_layout_content', [BladeDirectives::class, 'arcadeLayoutContent']);
        Blade::directive('arcade_content', [BladeDirectives::class, 'arcadeContent']);
        Blade::directive('end_arcade_content', [BladeDirectives::class, 'endArcadeContent']);

        Blade::directive('arcade_dymanic_content', [BladeDirectives::class, 'arcadeDynamicContent']);

        Blade::directive('arcade_slot', [BladeDirectives::class, 'arcadeSlot']);
        Blade::directive('preserve_query_string', [BladeDirectives::class, 'preserveQueryString']);
    }

    protected function registerArcadeTagsCompiler()
    {
        if (method_exists($this->app['blade.compiler'], 'precompiler')) {
            $this->app['blade.compiler']->precompiler(function ($string) {
                return app(ArcadeTagsCompiler::class)->compile($string);
            });
        }
    }

    public function registerLivewireSectionFeatures()
    {
        LivewireFeatures\SupportAttributes::init();
        LivewireFeatures\SupportSectionData::init();
    }

    protected function registerMiddlewaresForLivewire()
    {
        Livewire::addPersistentMiddleware([
            Locale::class,
            Theme::class,
            Currency::class,
        ]);
    }
}
