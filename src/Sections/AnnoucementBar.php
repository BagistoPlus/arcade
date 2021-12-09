<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class AnnoucementBar extends BladeSection
{
    protected static $previewDescription = 'Vous pouvez annonces des choses ici';

    public static function settings()
    {
        return [
            CheckboxType::make('show_annoucement', 'Show Annoucement')
                ->default(true)
                ->info('You can toggle the annoucement bar using this checkbox'),

            TextType::make('annoucement', 'Annoucement')
                ->default('Annoucement text')
                ->info('The annoucement text'),

            TextType::make('bg_color', 'Background Color')
                ->default('blue')
                ->info('The annoucement bar color'),

            TextType::make('text_color', 'Text Color')
                ->default('white')
                ->info('The annoucement text color'),

            SelectType::make('position', 'Position')
                ->options([
                    ['label' => 'Left', 'value' => 'left'],
                    ['label' => 'Center', 'value' => 'center'],
                    ['label' => 'Right', 'value' => 'right'],
                ])
                ->default('center')
                ->info('The annoucement bar position'),
        ];
    }

    public static function blocks()
    {
        return [
            Block::make('annoucement', 'Annoucement')->settings([
                TextType::make('text', 'Annoucement')
                    ->default('Annoucement text')
                    ->info('The annoucement text'),
            ]),
        ];
    }

    public function render()
    {
        return view('shop::sections.annoucement-bar');
    }
}
