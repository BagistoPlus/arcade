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
            SettingType::make('image', __('arcade::app.sections.hero.background-image'))
                ->type('image'),

            SelectType::make('height', __('arcade::app.sections.hero.height'))
                ->options([
                    'small' => __('arcade::app.sections.hero.height-small'),
                    'medium' => __('arcade::app.sections.hero.height-medium'),
                    'large' => __('arcade::app.sections.hero.large'),
                ])
                ->default('medium'),

            SelectType::make('content_position', __('arcade::app.sections.hero.content-position'))
                ->options([
                    'top' => __('arcade::app.sections.hero.content-position-top'),
                    'middle' => __('arcade::app.sections.hero.content-position-middle'),
                    'bottom' => __('arcade::app.sections.hero.content-bottom'),
                ])
                ->default('middle')
                ->group('content'),

            CheckboxType::make('show_overlay', __('arcade::app.sections.hero.show-overlay'))
                ->default(true)
                ->group('content'),

            RangeType::make('overlay_opacity', __('arcade::app.sections.hero.overlay-opacity'))
                ->default(25)
                ->min(0)
                ->max(100)
                ->unit('%')
                ->group('content')
                ->info(__('arcade::app.sections.hero.overlay-opacity-info')),
        ];
    }

    public static function blocks(): array
    {
        return [
            Block::make('heading', __('arcade::app.sections.hero.blocks.heading.title'))
                ->limit(1)
                ->settings([
                    SettingType::make('heading', __('arcade::app.sections.hero.blocks.heading.heading'))
                        ->type('text')
                        ->default(__('arcade::app.sections.hero.blocks.heading.heading-default')),

                    SelectType::make('size', __('arcade::app.sections.hero.blocks.heading.size'))
                        ->options([
                            'small' => __('arcade::app.sections.hero.blocks.heading.size-small'),
                            'medium' => __('arcade::app.sections.hero.blocks.heading.size-medium'),
                            'large' => __('arcade::app.sections.hero.blocks.heading.size-large'),
                        ])
                        ->default('medium'),
                ]),

            Block::make('text', __('arcade::app.sections.hero.blocks.text.title'))
                ->limit(1)
                ->settings([
                    SettingType::make('text', __('arcade::app.sections.hero.blocks.text.text'))
                        ->type('textarea')
                        ->default(__('arcade::app.sections.hero.blocks.text.text-default')),
                ]),

            Block::make('button', __('arcade::app.sections.hero.blocks.button.title'))
                ->limit(1)
                ->settings([
                    SettingType::make('text', __('arcade::app.sections.hero.blocks.button.text'))
                        ->type('text')
                        ->default(__('arcade::app.sections.hero.blocks.button.text-default')),

                    SettingType::make('link', __('arcade::app.sections.hero.blocks.button.link'))
                        ->type('text')
                        ->default('#'),

                    SelectType::make('style', __('arcade::app.sections.hero.blocks.button.style'))
                        ->type('select')
                        ->options([
                            'primary' => __('arcade::app.sections.hero.blocks.button.style-primary'),
                            'secondary' => __('arcade::app.sections.hero.blocks.button.style-secondary'),
                        ])
                        ->default('primary'),
                ]),
        ];
    }
}
