<?php

namespace EldoMagan\BagistoArcade\Actions\Checkout;

use EldoMagan\BagistoArcade\Exceptions\InvalidCartException;
use Webkul\Checkout\Facades\Cart;

class SavePaymentMethod
{
    public function __invoke(string $paymentMethod)
    {
        if (
            Cart::hasError() ||
            !$paymentMethod ||
            !Cart::savePaymentMethod(['method' => $paymentMethod])
        ) {
            throw new InvalidCartException();
        }

        Cart::collectTotals();
    }
}
