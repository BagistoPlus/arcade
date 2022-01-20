<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Checkout\Facades\Cart;

class CartSummary extends Component
{
    public function render()
    {
        return view('shop::components.cart-summary', [
            'cart' => Cart::getCart()
        ]);
    }
}
