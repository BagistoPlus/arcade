<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Product\Contracts\ProductFlat;

class ProductBuyButtons extends Component
{
    /**
     * @var ProductFlat
     */
    public $product;

    /**
     * Whether or not to show buy now button
     *
     * @var bool
     */
    public $showBuyNowButton;

    public function __construct(ProductFlat $product, $showBuyNowButton)
    {
        $this->product = $product;
        $this->showBuyNowButton = $showBuyNowButton;
    }

    public function render()
    {
        return view('shop::components.product-buy-buttons');
    }
}
