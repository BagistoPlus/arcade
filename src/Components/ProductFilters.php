<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;

class ProductFilters extends Component
{
    public $filters = [];

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function render()
    {
        return view('shop::components.product-filters');
    }
}
