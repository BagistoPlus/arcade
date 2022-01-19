<?php

namespace EldoMagan\BagistoArcade\Components;

use EldoMagan\BagistoArcade\Sections\Concerns\InteractsWithCart;
use Livewire\Component;

class MiniCart extends Component
{
    use InteractsWithCart;

    public $expanded = false;

    protected $listeners = [
        'cartItemAdded' => 'onItemAdded',
    ];

    public function onItemAdded()
    {
        $this->expanded = true;
    }

    public function removeItemFromCart($itemId)
    {
        $this->removeCartItem($itemId);
    }

    public function render()
    {
        return view('shop::components.mini-cart');
    }
}
