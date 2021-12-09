<?php

namespace EldoMagan\BagistoArcade\SettingTypes;

/**
 * @inheritDoc
 *
 * @property-read array $options
 * @method $this options(array $options)
 */
class SelectType extends SettingType
{
    protected $options = [];

    public static function make($id, $label = ''): SelectType
    {
        return parent::make($id, $label)->type('select');
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'options' => $this->options,
        ]);
    }
}
