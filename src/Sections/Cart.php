<?php

namespace EldoMagan\BagistoArcade\Sections;

use EldoMagan\BagistoArcade\Actions\UpdateCartItemQuantity;
use EldoMagan\BagistoArcade\Sections\Concerns\InteractsWithCart;

class Cart extends LivewireSection
{
    use InteractsWithCart;

    protected $listeners = [
        'couponApplied' => '$refresh'
    ];

    public function updateCartItemQuantity(UpdateCartItemQuantity $updateCartItemQuantity, $itemId, $quantity)
    {
        $updateCartItemQuantity->execute($itemId, $quantity);
    }

    public function removeItemFromCart($itemId)
    {
        $this->removeCartItem($itemId);
    }

    public function render()
    {
        return view('shop::sections.cart');
    }
}
