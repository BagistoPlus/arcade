<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Webkul\Product\Contracts\Product;

class ProductsGrid extends Component
{
    /**
     * @var Collection<Product>
     */
    public $products;

    public $layout;

    public function __construct(Collection $products, $layout = 'vertical')
    {
        $this->products = $products;
        $this->layout = $layout;
    }

    public function render()
    {
        return view('shop::components.products-grid');
    }
}
