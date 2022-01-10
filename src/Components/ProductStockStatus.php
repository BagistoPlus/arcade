<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;

class ProductStockStatus extends Component
{
    public $product;

    public $status;

    public $statusText;

    public function __construct($product)
    {
        $this->product = $product;

        $this->computedStatus();
    }

    public function computedStatus()
    {
        if ($this->product->haveSufficientQuantity(1) === true) {
            $this->status = 'in-stock';
        } elseif ($this->product->haveSufficientQuantity(1) > 0) {
            $this->status = 'available-for-order';
        } else {
            $this->status = 'out-of-stock';
        }

        $this->statusText = __('shop::app.products.' . $this->status);
    }

    public function render()
    {
        return view('shop::components.product-stock-status');
    }
}
