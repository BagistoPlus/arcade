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
            CheckboxType::make('show_announcement', 'Show Announcement')
                ->default(true)
                ->info('You can toggle the announcement bar using this checkbox'),

            TextType::make('announcement', 'Announcement')
                ->default('Announcement text')
                ->info('The announcement text'),

            TextType::make('bg_color', 'Background Color')
                ->default('blue')
                ->info('The announcement bar color'),

            TextType::make('text_color', 'Text Color')
                ->default('white')
                ->info('The announcement text color'),

            SelectType::make('position', 'Position')
                ->options([
                    ['label' => 'Left', 'value' => 'left'],
                    ['label' => 'Center', 'value' => 'center'],
                    ['label' => 'Right', 'value' => 'right'],
                ])
                ->default('center')
                ->info('The announcement bar position'),
        ];
    }

    public static function blocks()
    {
        return [
            Block::make('announcement', 'Announcement')->settings([
                TextType::make('text', 'Announcement')
                    ->default('Announcement text')
                    ->info('The announcement text'),
            ]),
        ];
    }

    public function render()
    {
        return view('shop::sections.announcement-bar');
    }
}
