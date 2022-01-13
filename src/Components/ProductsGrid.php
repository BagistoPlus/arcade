<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Webkul\Product\Contracts\Product;

class ProductsGrid extends Component
{
    /**
     * @var Collection<Product>|LengthAwarePaginator<Product>
     */
    public $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function render()
    {
        return view('shop::components.products-grid');
    }
}
