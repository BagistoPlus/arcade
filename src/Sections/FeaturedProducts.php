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
            TextType::make('heading', __('arcade::app.sections.featured-products.heading'))
                ->default(__('arcade::app.sections.featured-products.heading')),

            TextType::make('subheading', __('arcade::app.sections.featured-products.subheading'))
                ->default(__('arcade::app.sections.featured-products.default-subheading')),

            RangeType::make('nb_products', __('arcade::app.sections.featured-products.nb-products'))
                ->default(4)
                ->min(4)
                ->max(16)
                ->info(__('arcade::app.sections.featured-products.nb-info')),

            RadioType::make('product_type', __('arcade::app.sections.featured-products.product-type'))
                ->options([
                    'new' => __('arcade::app.sections.featured-products.product-type-new'),
                    'featured' => __('arcade::app.sections.featured-products.product-type-featured'),
                ])
                ->default('new')
                ->info(__('arcade::app.sections.featured-products.product-type-info')),
        ];
    }

    public static function blocks(): array
    {
        return [
            Block::make('product', __('arcade::app.sections.featured-products.blocks.product.title'))
                ->settings([
                    SettingType::make('product', __('arcade::app.sections.featured-products.blocks.product.title'))
                        ->type('product'),
                ]),
        ];
    }
}
