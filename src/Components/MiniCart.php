<?php

namespace EldoMagan\BagistoArcade\Components;

use Livewire\Component;

class MiniCart extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('shop::components.mini-cart');
    }
}
