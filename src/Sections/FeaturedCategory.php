<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use EldoMagan\BagistoArcade\SettingTypes\SelectType;
use EldoMagan\BagistoArcade\SettingTypes\SettingType;
use EldoMagan\BagistoArcade\SettingTypes\TextType;

class FeaturedCategory extends BladeSection
{
    protected static $view = 'shop::sections.featured-category';

    public static function settings()
    {
        return [
            SettingType::make('category', 'Category')
                ->type('category'),

            TextType::make('heading', 'Heading')
                ->default('Featured Category'),

            TextType::make('products_to_show', 'Products to show')
                ->type('number')
                ->default(6),

            SelectType::make('layout', 'Product grid layout')
                ->options([
                    ['label' => 'Vertical', 'value' => 'vertical'],
                    ['label' => 'Horizontal', 'value' => 'horizontal'],
                ])
                ->default('vertical'),

            CheckboxType::make('stack_products', 'Stack products')
                ->default(false)
                ->info('Only applicable for vertical layout'),
        ];
    }
}
