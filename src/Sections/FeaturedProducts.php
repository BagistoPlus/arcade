<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\RadioType;
use EldoMagan\BagistoArcade\SettingTypes\RangeType;
use EldoMagan\BagistoArcade\SettingTypes\SettingType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;
use Webkul\Product\Repositories\ProductFlatRepository;

class FeaturedProducts extends BladeSection
{
    protected static int $maxBlocks = 4;

    protected static string $view = 'shop::sections.featured-products';

    public function getProducts()
    {
        if (count($this->section->blocks) > 0) {
            return $this->section->blocks
                ->map(function ($block) {
                    return arcade_get_product($block->settings->product);
                })
                ->filter()
            ;
        }

        if ($this->section->settings->product_type === 'featured') {
            return $this->getFeaturedProducts($this->section->settings->nb_products);
        }

        return $this->getNewProducts($this->section->settings->nb_products);
    }

    protected function getFeaturedProducts($count = 4)
    {
        return app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = core()->getRequestedChannelCode();
            $locale = core()->getRequestedLocaleCode();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.featured', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->take($count)->get();
    }

    protected function getNewProducts($count = 4)
    {
        return app(ProductFlatRepository::class)->scopeQuery(function ($query) {
            $channel = core()->getRequestedChannelCode();
            $locale = core()->getRequestedLocaleCode();

            return $query->distinct()
                ->addSelect('product_flat.*')
                ->where('product_flat.status', 1)
                ->where('product_flat.visible_individually', 1)
                ->where('product_flat.new', 1)
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->inRandomOrder();
        })->take($count)->get();
    }

    public static function settings(): array
    {
        return [
            TextType::make('heading', 'Heading')
                ->default('Featured Products'),

            TextType::make('subheading', 'Subheading')
                ->default('Use this section to show off a few of your favourite products'),

            RangeType::make('nb_products', 'Number of products')
                ->default(4)
                ->min(4)
                ->max(16)
                ->info('The number of products to display when no product block is added'),

            RadioType::make('product_type', 'Product type')
                ->options([
                    'new' => 'New products',
                    'featured' => 'Featured products',
                ])
                ->default('new')
                ->info('Applicable only when there are no product blocks added'),
        ];
    }

    public static function blocks(): array
    {
        return [
            Block::make('product', 'Product')
                ->settings([
                    SettingType::make('product', 'Product')->type('product'),
                ]),
        ];
    }
}
