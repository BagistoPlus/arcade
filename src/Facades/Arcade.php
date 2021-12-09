<?php

namespace EldoMagan\BagistoArcade\Facades;

use EldoMagan\BagistoArcade\ArcadeManager;
use Illuminate\Support\Facades\Facade;

class Arcade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ArcadeManager::class;
    }
}
