<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;

class CheckoutAddressForm extends Component
{
    public $name = 'billing';
    public $newFormToggle = false;
    public $title = 'Billing Address';
    public $addresses = [];
    public $cart;

    public function __construct($name, $newFormToggle, $cart, $title, $addresses = [])
    {
        $this->name = $name;
        $this->title = $title;
        $this->cart = $cart;
        $this->addresses = $addresses;
        $this->newFormToggle = $newFormToggle;
    }

    public function render()
    {
        return view('shop::components.checkout-address-form');
    }
}
