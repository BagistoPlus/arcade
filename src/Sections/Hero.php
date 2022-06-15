<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\RangeType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\SettingType;

class Hero extends BladeSection
{
    protected static string $view = 'shop::sections.hero';
    protected static int $maxBlocks = 4;

    public static function settings(): array
    {
        return [
            SettingType::make('image', 'Background Image')
                ->type('image'),

            SelectType::make('height', 'Height')
                ->options([
                    'small' => 'Small',
                    'medium' => 'Medium',
                    'large' => 'Large',
                ])
                ->default('medium'),

            SelectType::make('content_position', 'Content position')
                ->options([
                    'top' => 'Top',
                    'middle' => 'Middle',
                    'bottom' => 'Bottom',
                ])
                ->default('middle')
                ->group('content'),

            CheckboxType::make('show_overlay', 'Show overlay')
                ->default(true)
                ->group('content'),

            RangeType::make('overlay_opacity', 'Overlay opacity')
                ->default(25)
                ->min(0)
                ->max(100)
                ->unit('%')
                ->group('content')
                ->info('Only applicable when overlay is enabled.'),
        ];
    }

    public static function blocks(): array
    {
        return [
            Block::make('heading', 'Heading')
                ->limit(1)
                ->settings([
                    SettingType::make('heading', 'Heading')
                        ->type('text')
                        ->default('Your heading'),

                    SelectType::make('size', 'Heading size')
                        ->options([
                            'small' => 'Small',
                            'medium' => 'Medium',
                            'large' => 'Large',
                        ])
                        ->default('medium'),
                ]),

            Block::make('text', 'Text')
                ->limit(1)
                ->settings([
                    SettingType::make('text', 'Text')
                        ->type('textarea')
                        ->default('Nisi nulla consectetur fugiat consectetur laborum id.'),
                ]),

            Block::make('button', 'Button')
                ->limit(1)
                ->settings([
                    SettingType::make('text', 'Text')
                        ->type('text')
                        ->default('Button'),

                    SettingType::make('link', 'Link')
                        ->type('text')
                        ->default('#'),

                    SelectType::make('style', 'Style')
                        ->type('select')
                        ->options([
                            'primary' => 'Primary',
                            'secondary' => 'Secondary',
                        ])
                        ->default('primary'),
                ]),
        ];
    }
}
