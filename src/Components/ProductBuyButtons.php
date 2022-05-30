<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Product\Contracts\ProductFlat;
use Webkul\Product\Helpers\ProductType;

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

    public $productHasVariants;

    public function __construct(ProductFlat $product, $showBuyNowButton)
    {
        $this->product = $product;
        $this->showBuyNowButton = $showBuyNowButton;
        $this->productHasVariants = ProductType::hasVariants($this->product->type);
    }

    public function render()
    {
        return view('shop::components.product-buy-buttons');
    }
}
