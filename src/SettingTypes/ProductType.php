<?php

namespace EldoMagan\BagistoArcade\SettingTypes;

/**
 * @inheritDoc
 */
class ProductType extends SettingType
{
    public static function make($name, $label = null): ProductType
    {
        return parent::make($name, $label)->type('product');
    }
}
