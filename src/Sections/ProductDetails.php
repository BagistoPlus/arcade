<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Actions\AddProductToCart;
use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;
use Webkul\Product\Helpers\ProductType;

class ProductDetails extends LivewireSection
{
    protected static string $view = 'shop::sections.product-details';

    public $quantity = 1;

    public $data = [];

    public function setData($key, $value)
    {
        if (! array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;
        }
    }

    protected function productHasVariants()
    {
        return ProductType::hasVariants($this->context['product']->type);
    }

    public function addToCart(AddProductToCart $addProductToCart)
    {
        $addProductToCart->execute(array_merge([
            'product_id' => $this->context['product']->product_id,
            'quantity' => $this->quantity,
        ], $this->data));

        $this->quantity = 1;
        $this->emit('cartItemAdded');
    }

    public function buyNow(AddProductToCart $addProductToCart)
    {
        $this->quantity = 1;

        return $addProductToCart->execute(array_merge([
            'product_id' => $this->context['product']->product_id,
            'quantity' => $this->quantity,
            'is_buy_now' => true,
        ], $this->data));
    }

    public static function blocks(): array
    {
        return [
            Block::make('title', __('arcade::app.sections.product-details.blocks.title.title'))
                ->limit(1),
            Block::make('price', __('arcade::app.sections.product-details.blocks.price.title'))
                ->limit(1),
            Block::make('stock', __('arcade::app.sections.product-details.blocks.stock.title'))
                ->limit(1),
            Block::make('short_description', __('arcade::app.sections.product-details.blocks.short-description.title'))
                ->limit(1),
            Block::make('quantity_selector', __('arcade::app.sections.product-details.blocks.quantity-selector.title'))
                ->limit(1),
            Block::make('buy_buttons', __('arcade::app.sections.product-details.blocks.buy-buttons.title'))
                ->limit(1)
                ->settings([
                    CheckboxType::make('show_buy_now', __('arcade::app.sections.product-details.blocks.buy-buttons.show-buy-now'))
                        ->default(true),
                ]),
            Block::make('description', __('arcade::app.sections.product-details.blocks.description.title'))
                ->limit(1),
            Block::make('attributes', __('arcade::app.sections.product-details.blocks.attributes.title'))
                ->limit(1),
            Block::make('variant_picker', __('arcade::app.sections.product-details.blocks.variant-picker.title'))
                ->limit(1),
            Block::make('downloadable_options', __('arcade::app.sections.product-details.blocks.downloadable-options.title'))
                ->limit(1),
            Block::make('grouped_options', __('arcade::app.sections.product-details.blocks.grouped-products.title'))
                ->limit(1),
            Block::make('bundle_options', __('arcade::app.sections.product-details.blocks.bundle-options.title'))
                ->limit(1),
        ];
    }
}
