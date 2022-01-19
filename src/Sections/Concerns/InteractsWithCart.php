<?php

namespace EldoMagan\BagistoArcade\Sections\Concerns;

use Webkul\Checkout\Facades\Cart;
use Webkul\Tax\Helpers\Tax;

trait InteractsWithCart
{
    public function getCart()
    {
        return Cart::getCart();
    }

    public function getItemsCount()
    {
        return $this->getCart() ? $this->getCart()->items->count() : 0;
    }

    public function isCartEmpty()
    {
        return $this->getItemsCount() === 0;
    }

    public function getCartSubTotal()
    {
        return Tax::isTaxInclusive()
            ? $this->getCart()->base_grand_total
            : $this->getCart()->base_sub_total;
    }

    public function getCartItems()
    {
        if ($this->isCartEmpty()) {
            return [];
        }

        return $this->getCart()->items->map(function ($item) {
            $item->images = $item->product->getTypeInstance()->getBaseImage($item);
            $item->smallImage = $item->images['small_image_url'];
            $item->displayablePrice = Tax::isTaxInclusive()
                ? $item->base_total_with_tax
                : $item->base_total;

            return $item;
        });
    }

    public function removeCartItem($itemId)
    {
        return Cart::removeItem($itemId);
    }

    // For livewire components

    public function getCartProperty()
    {
        return $this->getCart();
    }

    public function getItemsCountProperty()
    {
        return $this->getItemsCount();
    }

    public function getIsCartEmptyProperty()
    {
        return $this->isCartEmpty();
    }

    public function getCartSubTotalProperty()
    {
        return $this->getCartSubTotal();
    }

    public function getCartItemsProperty()
    {
        return $this->getCartItems();
    }
}
