<?php

namespace EldoMagan\BagistoArcade\Providers;

use Illuminate\Support\AggregateServiceProvider;

class ArcadeServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        CoreServiceProvider::class,
        ViewServiceProvider::class,
        ArcadeThemeServiceProvider::class,
    ];
}
