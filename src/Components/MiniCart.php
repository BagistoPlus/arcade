<?php

namespace EldoMagan\BagistoArcade\Components;

use Livewire\Component;
use Webkul\Checkout\Facades\Cart;
use Webkul\Tax\Helpers\Tax;

class MiniCart extends Component
{
    public $cart;

    public $expanded = false;

    protected $listeners = [
        'cartItemAdded' => 'onItemAdded',
    ];

    public function getItemsCountProperty()
    {
        return $this->cart ? $this->cart->items->count() : 0;
    }

    public function getCartEmptyProperty()
    {
        return ! $this->cart || $this->getItemsCountProperty() === 0;
    }

    public function getDisplayableTotalProperty()
    {
        return Tax::isTaxInclusive()
            ? $this->cart->base_grand_total
            : $this->cart->base_sub_total;
    }

    public function getCartItemsProperty()
    {
        return $this->cart->items->map(function ($item) {
            $item->images = $item->product->getTypeInstance()->getBaseImage($item);
            $item->smallImage = $item->images['small_image_url'];
            $item->displayablePrice = Tax::isTaxInclusive()
                ? $item->base_total_with_tax
                : $item->base_total;

            return $item;
        });
    }

    public function onItemAdded()
    {
        $this->expanded = true;
    }

    public function removeItemFromCart($itemId)
    {
        Cart::removeItem($itemId);
    }

    public function render()
    {
        $this->cart = Cart::getCart();

        return view('shop::components.mini-cart');
    }
}
