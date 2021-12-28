<?php

namespace EldoMagan\BagistoArcade\SettingTypes;

/**
 * @inheritDoc
 *
 * @property-read int $min
 * @property-read int $max
 * @property-read int $step
 * @property-read string $unit
 *
 * @method $this min(int $min)
 * @method $this max(int $max)
 * @method $this step(int $step)
 * @method $this unit(string $unit)
 */
class RangeType extends SettingType
{
    protected $min = 12;
    protected $max = 24;
    protected $step = 1;
    protected $unit = '';

    public static function make($id, $label = ''): RangeType
    {
        return parent::make($id, $label)->type('range');
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step,
            'unit' => $this->unit,
        ]);
    }
}
