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
            Block::make('title', 'Title')->limit(1),
            Block::make('price', 'Price')->limit(1),
            Block::make('stock', 'Stock')->limit(1),
            Block::make('short_description', 'Short Description')->limit(1),
            Block::make('quantity_selector', 'Quantity selector')->limit(1),
            Block::make('buy_buttons', 'Buy buttons')
                ->limit(1)
                ->settings([
                    CheckboxType::make('show_buy_now', 'Show buy now button')
                        ->default(true),
                ]),
            Block::make('description', 'Description')->limit(1),
            Block::make('attributes', 'Attributes')->limit(1),
            Block::make('variant_picker', 'Variant Picker')->limit(1),
            Block::make('downloadable_options', 'Downloadable options')->limit(1),
            Block::make('grouped_options', 'Grouped products')->limit(1),
        ];
    }
}
