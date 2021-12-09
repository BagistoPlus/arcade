<?php

namespace EldoMagan\BagistoArcade\SettingTypes;

/**
 * @inheritDoc
 */
class CheckboxType extends SettingType
{
    public static function make($id, $label = '')
    {
        return parent::make($id, $label)->type('checkbox');
    }
}
