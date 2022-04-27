<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;

class AccountLayout extends Component
{
    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('shop::components.account-layout');
    }
}
