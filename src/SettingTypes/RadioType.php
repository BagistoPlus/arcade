<?php

namespace EldoMagan\BagistoArcade\SettingTypes;

/**
 * @inheritDoc
 *
 * @property-read array $options
 * @method $this options(array $options)
 */
class RadioType extends SettingType
{
    protected $options = [];

    public static function make($id, $label = ''): RadioType
    {
        return parent::make($id, $label)->type('radio');
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'options' => $this->options,
        ]);
    }
}
