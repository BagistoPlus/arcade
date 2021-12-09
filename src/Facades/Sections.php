<?php

namespace EldoMagan\BagistoArcade\Facades;

use EldoMagan\BagistoArcade\Sections\SectionRepository;
use Illuminate\Support\Facades\Facade;

class Sections extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SectionRepository::class;
    }
}
