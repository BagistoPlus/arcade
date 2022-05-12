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
            CheckboxType::make('show_payment_methods', 'Show Payment Methods')
                ->default(true),
            CheckboxType::make('show_shipping_methods', 'Show Shipping Methods')
                ->default(true),
            CheckboxType::make('show_locale_selector', 'Show language selector')
                ->default(true),
        ];
    }

    public static function blocks(): array
    {
        return [
            Block::make('about', 'About')
                ->limit(1)
                ->settings([
                    TextType::make('heading', 'Heading')
                        ->default('About our store'),
                    TextType::make('content', 'Content')
                        ->type('textarea')
                        ->default('Use this text area to tell your customers about your brand and vision. You can change it in the theme editor.'),
                ]),

            Block::make('quick-links', 'Quick Links')
                ->limit(1)
                ->settings([
                    TextType::make('heading', 'Heading')
                        ->default('Quick Links'),
                ]),

            Block::make('newsletter', 'Newsletter')
                ->limit(1)
                ->settings([
                    TextType::make('heading', 'Heading')
                        ->default('Newsletter'),
                    TextType::make('content', 'Content')
                        ->type('textarea')
                        ->default('A short sentence describing what someone will receive by subscribing'),
                ]),
        ];
    }
}
