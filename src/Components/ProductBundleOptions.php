<?php

namespace EldoMagan\BagistoArcade\Components;

use Illuminate\View\Component;
use Webkul\Product\Helpers\BundleOption;

class ProductBundleOptions extends Component
{
    public $product;
    public $config;
    protected $livewire;

    public function __construct($product, $livewire, BundleOption $bundleOptionHelper)
    {
        $this->product = $product;
        $this->livewire = $livewire;
        $this->config = $bundleOptionHelper->getBundleConfig($product);

        $quantities = [];
        $bundleOptions = [];

        foreach ($this->config['options'] as $option) {
            $bundleOptions[$option['id']] = collect($option['products'])
                ->filter->is_default->map->id->toArray();

            if ($option['type'] == 'select' || $option['type'] == 'radio') {
                foreach ($option['products'] as $product) {
                    if ($product['is_default']) {
                        $quantities[$option['id']] = $product['qty'];

                        break;
                    }
                }
            }
        }

        $this->livewire->setData('bundle_option_qty', $quantities);
        $this->livewire->setData('bundle_options', $bundleOptions);
    }

    public function render()
    {
        return view('shop::components.product-bundle-options');
    }
}
