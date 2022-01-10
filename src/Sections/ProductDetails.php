<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Actions\AddProductToCart;
use EldoMagan\BagistoArcade\SettingTypes\CheckboxType;

class ProductDetails extends LivewireSection
{
    public $quantity = 1;

    public function addToCart(AddProductToCart $addProductToCart)
    {
        $addProductToCart->execute($this->context['product'], $this->quantity);
    }

    public function render()
    {
        return view('shop::sections.product-details');
    }

    public static function blocks()
    {
        return [
            Block::make('title', 'Title')->limit(1),
            Block::make('price', 'Price')->limit(1),
            Block::make('stock', 'Stock')->limit(1),
            Block::make('short_description', 'Short Description')->limit(1),
            Block::make('buy_buttons', 'Buy buttons')
                ->limit(1)
                ->settings([
                    CheckboxType::make('show_buy_now', 'Show buy now button')
                        ->default(true),
                ]),
        ];
    }
}
