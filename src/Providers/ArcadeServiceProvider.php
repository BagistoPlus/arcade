<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\ArcadeManager;
use Illuminate\Support\ServiceProvider;

class ArcadeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(ArcadeManager::class, function () {
            return new ArcadeManager();
        });
    }
}
