<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class Footer extends BladeSection
{
    public static string $view = 'shop::sections.footer';

    protected static array $default = [
        'blocks' => [
            ['type' => 'about'],
            ['type' => 'quick-links'],
            ['type' => 'newsletter'],
        ],
    ];

    public static function settings(): array
    {
        return [
            CheckboxType::make('show_payment_methods', __('arcade::app.sections.footer.show-payment-methods'))
                ->default(true),
            CheckboxType::make('show_shipping_methods', __('arcade::app.sections.footer.show-shipping-methods'))
                ->default(true),
            CheckboxType::make('show_locale_selector', __('arcade::app.sections.footer.show-locale-selector'))
                ->default(true),
        ];
    }

    public static function blocks(): array
    {
        return [
            Block::make('about', __('arcade::app.sections.footer.blocks.about.title'))
                ->limit(1)
                ->settings([
                    TextType::make('heading', __('arcade::app.sections.footer.blocks.about.heading'))
                        ->default(__('arcade::app.sections.footer.blocks.about.heading-default')),
                    TextType::make('content', __('arcade::app.sections.footer.blocks.about.content'))
                        ->type('textarea')
                        ->default(__('arcade::app.sections.footer.blocks.about.content-default')),
                ]),

            Block::make('quick-links', __('arcade::app.sections.footer.blocks.quick-links.title'))
                ->limit(1)
                ->settings([
                    TextType::make('heading', __('arcade::app.sections.footer.blocks.quick-links.heading'))
                        ->default(__('arcade::app.sections.footer.blocks.quick-links.heading-default')),
                ]),

            Block::make('newsletter', __('arcade::app.sections.footer.blocks.newsletter.title'))
                ->limit(1)
                ->settings([
                    TextType::make('heading', __('arcade::app.sections.footer.blocks.newsletter.heading'))
                        ->default(__('arcade::app.sections.footer.blocks.newsletter.heading-default')),
                    TextType::make('content', __('arcade::app.sections.footer.blocks.newsletter.content'))
                        ->type('textarea')
                        ->default(__('arcade::app.sections.footer.blocks.newsletter.content-default')),
                ]),
        ];
    }
}
