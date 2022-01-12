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

    public function execute(array $data)
    {
        request()->merge($data);

        return $this->cartController->add($data['product_id']);
    }
}
