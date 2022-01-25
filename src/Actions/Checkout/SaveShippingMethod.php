<?php

namespace EldoMagan\BagistoArcade\Actions\Checkout;

use EldoMagan\BagistoArcade\Exceptions\InvalidCartException;
use Webkul\Checkout\Facades\Cart;

class SaveShippingMethod
{
    public function __invoke(string $shippingMethod)
    {
        if (Cart::hasError() || ! $shippingMethod || ! Cart::saveShippingMethod($shippingMethod)) {
            throw new InvalidCartException();
        }

        Cart::collectTotals();
    }
}
