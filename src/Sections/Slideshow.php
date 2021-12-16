<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\SettingType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class Slideshow extends BladeSection
{
    protected static $maxBlocks = 6;

    public static function settings()
    {
        return [
            CheckboxType::make('enable_autoplay', 'Enable Autoplay')
                ->default(true)
                ->info('Automatically change slide'),

            TextType::make('autolplay_delay', 'Autoplay delay (in seconds)')
                ->type('number')
                ->default(5)
                ->info('Automatically change slide after'),

            CheckboxType::make('show_controls', 'Show Controls')
                ->default(true)
                ->info('Show previous and next buttons'),

            SelectType::make('slide_width', 'Slide width')
                ->default('full')
                ->options([
                    ['label' => 'Full width', 'value' => 'full'],
                    ['label' => 'Content width', 'value' => 'half'],
                ])
                ->info('Select the width of the slide.'),

            SelectType::make('slide_height', 'Slide height')
                ->default('medium')
                ->options([
                    ['label' => 'Small (400px)', 'value' => 'small'],
                    ['label' => 'Medium (500px)', 'value' => 'medium'],
                    ['label' => 'Large (600px)', 'value' => 'large'],
                    ['label' => 'Fit screen', 'value' => 'screen'],
                ]),
        ];
    }

    public static function blocks()
    {
        return [
            Block::make('slide', 'Slide')
                ->settings([
                    SettingType::make('image', 'Image')
                        ->type('image')
                        ->default('')
                        ->info('Select the image to display.'),

                    TextType::make('title', 'Title')
                        ->group('Content')
                        ->info('Enter the title of the slide.'),

                    TextType::make('subtitle', 'Subtitle')
                        ->group('Content'),

                    SettingType::make('text_color', 'Text color')
                        ->type('color')
                        ->group('Content'),

                    SelectType::make('text_alignment', 'Text alignment')
                        ->default('center')
                        ->options([
                            ['label' => 'Left', 'value' => 'left'],
                            ['label' => 'Center', 'value' => 'center'],
                            ['label' => 'Right', 'value' => 'right'],
                        ]),

                    TextType::make('button_text', 'Button text')
                        ->group('Buttons'),

                    TextType::make('button_link', 'Button URL')
                        ->group('Buttons'),

                    SelectType::make('button_style', 'Button style')
                        ->default('primary')
                        ->group('Buttons')
                        ->options([
                            ['label' => 'Primary', 'value' => 'primary'],
                            ['label' => 'Secondary', 'value' => 'secondary'],
                            ['label' => 'Tertiary', 'value' => 'tertiary'],
                        ]),
                ]),
        ];
    }

    public function render()
    {
        return view('shop::sections.slideshow');
    }
}
