<?php

namespace EldoMagan\BagistoArcade\Actions\Checkout;

use EldoMagan\BagistoArcade\Exceptions\InvalidCartException;
use EldoMagan\BagistoArcade\Exceptions\InvalidGuestCheckoutException;
use Webkul\Checkout\Facades\Cart;

class StoreCustomerAddresses
{
    public function __invoke(array $data)
    {
        if (! auth()->guard('customer')->check() && ! Cart::getCart()->hasGuestCheckoutItems()) {
            throw new InvalidGuestCheckoutException();
        }

        if (isset($data['billing']['address1'])) {
            $data['billing']['address1'] = implode(PHP_EOL, array_filter($data['billing']['address1']));
        }

        if (isset($data['shipping']['address1'])) {
            $data['shipping']['address1'] = implode(PHP_EOL, array_filter($data['shipping']['address1']));
        }

        if (Cart::hasError() || ! Cart::saveCustomerAddress($data)) {
            throw new InvalidCartException();
        }

        $cart = Cart::getCart();

        Cart::collectTotals();
    }
}
