<?php

namespace EldoMagan\BagistoArcade;

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
