<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Product\Contracts\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductsCarousel extends Component
{
    /**
     * @var Collection<Product>
     */
    public $products;

    public function __construct(Collection $products)
    {
        $this->products = $products;
    }

    public function render()
    {
        return view('shop::components.products-carousel');
    }
}
