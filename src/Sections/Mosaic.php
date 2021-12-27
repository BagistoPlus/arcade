<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\SettingType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class Mosaic extends BladeSection
{
    public static $maxBlocks = 5;

    public static function settings()
    {
        return [
            SelectType::make('height', 'Section height')
                ->options([
                    ['label' => 'Small', 'value' => 'small'],
                    ['label' => 'Medium', 'value' => 'medium'],
                    ['label' => 'Large', 'value' => 'large'],
                ])
                ->default('medium'),
        ];
    }

    public static function blocks()
    {
        return [
            Block::make('item', 'Item')
                ->settings([
                    SettingType::make('image', 'Image')
                        ->type('image')
                        ->info('800 x 520px .jpg recommended for standard images. 1100 x 1100px .jpg recommended for center images.'),

                    CheckboxType::make('show_overlay', 'Show overlay')
                        ->default(true)
                        ->info('Increase text readability on busy images.'),

                    TextType::make('overlay_opacity', 'Overlay Opacity')
                        ->type('range')
                        ->default(0.5),

                    TextType::make('bg_color', 'Background Color')
                        ->type('color')
                        ->default('#F3F4F4'),

                    TextType::make('text_color', 'Text Color')
                        ->type('color')
                        ->default('#4F5558'),

                    TextType::make('heading', 'Heading')
                        ->default('Your heading'),

                    TextType::make('text', 'Text')
                        ->type('textarea')
                        ->default('Nisi nulla consectetur fugiat consectetur laborum id.'),

                    SelectType::make('content_position', 'Content position')
                        ->options([
                            ['label' => 'Top left', 'value' => 'top-left'],
                            ['label' => 'Top center', 'value' => 'top-center'],
                            ['label' => 'Top right', 'value' => 'top-right'],
                            ['label' => 'Middle left', 'value' => 'middle-left'],
                            ['label' => 'Middle center', 'value' => 'middle-center'],
                            ['label' => 'Middle right', 'value' => 'middle-right'],
                            ['label' => 'Bottom left', 'value' => 'bottom-left'],
                            ['label' => 'Bottom center', 'value' => 'bottom-center'],
                            ['label' => 'Bottom right', 'value' => 'bottom-right'],
                        ])
                        ->default('top-left'),

                        TextType::make('button_bg_color', 'Background color')
                            ->type('color')
                            ->group('Button')
                            ->default('#ffffff'),

                        TextType::make('button_text_color', 'Text color')
                            ->type('color')
                            ->group('Button')
                            ->default('#4F5558'),

                        TextType::make('button_text', 'Button text')
                            ->group('Button')
                            ->default('Shop now'),

                        TextType::make('button_url', 'Button url')
                            ->group('Button'),
                    ]),
        ];
    }

    public function render()
    {
        return view('shop::sections.mosaic');
    }
}
