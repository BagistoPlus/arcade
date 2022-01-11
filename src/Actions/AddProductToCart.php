<?php

namespace EldoMagan\BagistoArcade\Actions;

use Webkul\Shop\Http\Controllers\CartController;

class AddProductToCart
{
    /**
     * @var \Webkul\Shop\Http\Controllers\CartController
     */
    protected $cartController;

    public function __construct(CartController $cartController)
    {
        $this->cartController = $cartController;
    }

    public function execute($product, $quantity)
    {
        request()->merge([
            'product_id' => $product->product_id,
            'quantity' => $quantity,
        ]);

        $this->cartController->add($product->product_id);
    }
}
