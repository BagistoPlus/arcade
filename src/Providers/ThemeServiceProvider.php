<?php

namespace EldoMagan\BagistoArcade\Providers;

use Illuminate\Support\ServiceProvider;

abstract class ThemeServiceProvider extends ServiceProvider
{
    public static string $name;

    public static $sections = [];
}
