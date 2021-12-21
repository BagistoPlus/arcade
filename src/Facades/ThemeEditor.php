<?php

namespace EldoMagan\BagistoArcade\Facades;

use EldoMagan\BagistoArcade\ThemeEditor as ThemeEditorManager;
use Illuminate\Support\Facades\Facade;

class ThemeEditor extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeEditorManager::class;
    }
}
