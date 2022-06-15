<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\SettingType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;
use Webkul\Product\Repositories\ProductFlatRepository;

class FeaturedCategory extends BladeSection
{
    protected static string $view = 'shop::sections.featured-category';

    public $category;

    public $products = [];

    public function __construct($arcadeId, ProductFlatRepository $productFlatRepository)
    {
        parent::__construct($arcadeId);

        $this->category = arcade_get_category($this->section->settings->category);

        if ($this->category) {
            $this->products = $productFlatRepository->scopeQuery(function ($query) {
                $channel = core()->getRequestedChannelCode();
                $locale = core()->getRequestedLocaleCode();

                return $query->distinct()
                    ->addSelect('product_flat.*')
                    ->leftJoin('product_categories', 'product_categories.product_id', '=', 'product_flat.product_id')
                    ->where('product_flat.status', 1)
                    ->where('product_flat.visible_individually', 1)
                    ->where('product_flat.new', 1)
                    ->where('product_flat.channel', $channel)
                    ->where('product_flat.locale', $locale)
                    ->whereIn('product_categories.category_id', [$this->category->id])
                    ->limit($this->section->settings->products_to_show);
                ;
            })->get();
        }
    }

    public static function settings(): array
    {
        return [
            SettingType::make('category', 'Category')
                ->type('category'),

            TextType::make('heading', 'Heading')
                ->default('Featured Category'),

            TextType::make('products_to_show', 'Products to show')
                ->type('number')
                ->default(6),
        ];
    }
}
