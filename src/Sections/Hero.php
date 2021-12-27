<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\SettingType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class Hero extends BladeSection
{
    public static $maxBlocks = 4;

    public static function settings()
    {
        return [
            SettingType::make('image1', 'First image')
                ->type('image'),

            SettingType::make('image2', 'Second image')
                ->type('image'),

            SelectType::make('height', 'Height')
                ->options([
                    ['label' => 'Small', 'value' => 'small'],
                    ['label' => 'Medium', 'value' => 'medium'],
                    ['label' => 'Large', 'value' => 'large'],
                ])
                ->default('medium'),

            SelectType::make('content_position', 'Content position')
                ->options([
                    ['label' => 'Top', 'value' => 'top'],
                    ['label' => 'Middle', 'value' => 'middle'],
                    ['label' => 'Bottom', 'value' => 'bottom'],
                ])
                ->default('middle')
                ->group('content'),

            CheckboxType::make('show_overlay', 'Show overlay')
                ->default(false)
                ->group('content'),

            TextType::make('overlay_opacity', 'Overlay opacity')
                ->type('range')
                ->default('25')
                ->group('content'),

            CheckboxType::make('show_content_bg', 'Show content background')
                ->default(true)
                ->group('content'),

            SelectType::make('content_bg_style', 'Content background style')
                ->options([
                    ['label' => 'Primary', 'value' => 'primary'],
                    ['label' => 'Secondary', 'value' => 'secondary'],
                    ['label' => 'Primary invert', 'value' => 'primary-invert'],
                    ['label' => 'Secondary invert', 'value' => 'secondary-invert'],
                ])
                ->default('primary-invert')
                ->group('content'),
        ];
    }

    public static function blocks()
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
                            ['label' => 'Small', 'value' => 'small'],
                            ['label' => 'Medium', 'value' => 'medium'],
                            ['label' => 'Large', 'value' => 'large'],
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
                ->limit(2)
                ->settings([
                    SettingType::make('text', 'Text')
                        ->type('text')
                        ->default('Button'),

                    SettingType::make('link', 'Link')
                        ->type('text')
                        ->default('#'),

                    SettingType::make('style', 'Style')
                        ->type('select')
                        ->options([
                            ['label' => 'Primary', 'value' => 'primary'],
                            ['label' => 'Secondary', 'value' => 'secondary'],
                            ['label' => 'Accent', 'value' => 'accent'],
                        ])
                        ->default('accent'),
                ]),
        ];
    }

    public function render()
    {
        return view('shop::sections.hero');
    }
}
