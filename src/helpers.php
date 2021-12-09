<?php

use EldoMagan\BagistoArcade\ArcadeManager;

if (! function_exists('arcade')) {
    function arcade()
    {
        return app(ArcadeManager::class);
    }
}
