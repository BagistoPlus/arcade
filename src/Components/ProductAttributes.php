<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Product\Helpers\View as ProductViewHelper;

class ProductAttributes extends Component
{
    protected $productViewHelper;

    public $product;

    public $customAttributes = [];

    public function __construct(ProductViewHelper $productViewHelper, $product)
    {
        $this->product = $product;
        $this->productViewHelper = $productViewHelper;

        $this->customAttributes = $productViewHelper->getAdditionalData($product);
    }

    public function hasCustomAttributes()
    {
        return ! empty($this->customAttributes);
    }

    public function render()
    {
        return view('shop::components.product-attributes');
    }
}
