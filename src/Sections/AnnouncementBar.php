<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class AnnouncementBar extends BladeSection
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

            SelectType::make('style', 'Style')
                ->default('primary')
                ->options([
                    ['label' => 'Primary', 'value' => 'primary'],
                    ['label' => 'Secondary', 'value' => 'secondary'],
                    ['label' => 'Accent', 'value' => 'accent']
                ]),

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

    public function render()
    {
        return view('shop::sections.announcement-bar');
    }
}
