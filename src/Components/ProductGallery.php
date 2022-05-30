<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;

class ProductGallery extends Component
{
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('shop::components.product-gallery', [
            'images' => productimage()->getGalleryImages($this->product),
        ]);
    }
}
