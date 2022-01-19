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
        // We replace request body with $data to discard custom livewire inputs
        $originalRequestData = request()->request->all();
        request()->request->replace($data);

        $this->cartController->add($data['product_id']);

        // and then we restore livewire request data to prevent ignition crash
        // we should probably move this logic to some livewire middleware
        request()->request->replace($originalRequestData);
    }
}
