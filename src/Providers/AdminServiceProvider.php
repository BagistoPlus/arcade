<?php

namespace EldoMagan\BagistoArcade\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'arcade');

        $this->bootViewEventListeners();

        if ($this->app->runningInConsole()) {
            $this->publishAssets();
        }
    }

    public function register()
    {
        $this->registerConfigs();
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/admin-menu.php', 'menu.admin');
    }

    protected function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../../dist/admin' => public_path('vendor/arcade/admin'),
        ], 'public');
    }

    protected function bootViewEventListeners()
    {
        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('arcade::admin.layouts.style');
        });
    }
}
