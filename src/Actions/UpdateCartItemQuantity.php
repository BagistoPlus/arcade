<?php

namespace EldoMagan\BagistoArcade\Actions;

use Webkul\Checkout\Facades\Cart;

class UpdateCartItemQuantity
{
    public function __invoke($itemId, $quantity)
    {
        $this->execute($itemId, $quantity);
    }

    public function execute($itemId, $quantity)
    {
        $data = [
            'qty' => [
                $itemId => $quantity,
            ],
        ];

        try {
            $result = Cart::updateItems($data);

            if ($result) {
                session()->flash('success', trans('shop::app.checkout.cart.quantity.success'));
            }
        } catch (\Exception $e) {
            session()->flash('error', trans($e->getMessage()));
        }
    }
}
